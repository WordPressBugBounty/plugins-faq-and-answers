<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('FaaPlugin')) {
    class FaaPlugin
    {
        public function __construct()
        {
            add_action('plugins_loaded', [$this, 'pluginsDependency']);
            add_action('admin_enqueue_scripts', [$this, 'adminEnqueueScripts']);
            add_shortcode('faq', [$this, 'faq_shortcode']);
        }

        public function pluginsDependency()
        {
            require_once AFAQ_DIR_PATH . 'includes/function.php';
            require_once AFAQ_DIR_PATH . 'faq-and-answers-block.php';
            require_once AFAQ_DIR_PATH . 'includes/class_faaAdmin.php';
            require_once AFAQ_DIR_PATH . 'includes/class_faaAjax.php';
            new FaaAjax();
            if (faa_is_premium() && AFAQ_HAS_PRO) {
                if (file_exists(AFAQ_DIR_PATH . 'includes/class_faaAnalysis.php')) {
                    require_once AFAQ_DIR_PATH . 'includes/class_faaAnalysis.php';
                }
                if (file_exists(AFAQ_DIR_PATH . 'includes/ai/class-afaq-block-ai.php')) {
                    require_once AFAQ_DIR_PATH . 'includes/ai/class-afaq-block-ai.php';
                    new AFAQ_Block_AI();
                }
                if (file_exists(AFAQ_DIR_PATH . 'includes/ai/class-afaq-ask-ai.php')) {
                    require_once AFAQ_DIR_PATH . 'includes/ai/class-afaq-ask-ai.php';
                    new AFAQ_Ask_AI();

                    if (is_admin() && file_exists(AFAQ_DIR_PATH . 'includes/ai/class-afaq-ask-ai-admin.php')) {
                        require_once AFAQ_DIR_PATH . 'includes/ai/class-afaq-ask-ai-icons.php';
                        require_once AFAQ_DIR_PATH . 'includes/ai/class-afaq-ask-ai-admin.php';
                        new AFAQ_Ask_AI_Admin();
                    }
                }
            } else {
                if (file_exists(AFAQ_DIR_PATH . 'includes/class-faa-freeAnalytics.php')) {
                    require_once AFAQ_DIR_PATH . 'includes/class-faa-freeAnalytics.php';
                }
                // Keeps the Ask AI menu item present on the free build, at the
                // slug the premium screen uses, so the feature can be looked at
                // before it is bought.
                if (is_admin() && file_exists(AFAQ_DIR_PATH . 'includes/class-faa-freeAskAi.php')) {
                    require_once AFAQ_DIR_PATH . 'includes/class-faa-freeAskAi.php';
                }
            }

        }

        public function adminEnqueueScripts($screen)
        {
            global $typenow;

            if ('faq_cpt' === $typenow) {
                wp_enqueue_script('shortcode-js', AFAQ_DIR_URL . '/build/shortcode.js', [], AFAQ_VERSION, true);
                wp_enqueue_style('shortcode-css', AFAQ_DIR_URL . '/build/shortcode.css', [], AFAQ_VERSION);
            }
            if ('faq_cpt_page_faq_Dashboard' === $screen) {
                $asset = include AFAQ_DIR_PATH . 'build/admin-dashboard.asset.php';
                wp_enqueue_script('vgb-admin-script', AFAQ_DIR_URL . 'build/admin-dashboard.js', array_merge($asset['dependencies'], ['wp-util']), AFAQ_VERSION, true);
                wp_enqueue_style('vgb-admin-style', AFAQ_DIR_URL . '/build/admin-dashboard.css', false, AFAQ_VERSION);
            }

        }
        public function faq_shortcode($atts)
        {

            if (isset($atts['id'])) {
                $faq_id = absint($atts['id']);
                $post = $faq_id ? get_post($faq_id) : null;

                if ($post) {
                    $post_meta = get_post_meta($faq_id, "ba_re_", true);
                    $font_color = get_post_meta($faq_id, 'ba_quest_font_color', true);
                    $font_size = get_post_meta($faq_id, 'ba_quest_font_size', true);
                    $ans_font_size = get_post_meta($faq_id, 'ba_ans_font_size', true);
                    $ans_font_color = get_post_meta($faq_id, 'ba_ans_font_color', true);

                    $blocks = array_filter(
                        parse_blocks($post->post_content),
                        function ($block) {
                            return !empty($block['blockName']);
                        }
                    );

                    if ($blocks) {
                        $output = '';
                        foreach ($blocks as $block) {
                            if ($block['blockName'] === 'faa/faq-and-answers') {
                                if (!isset($block['attrs'])) {
                                    $block['attrs'] = [];
                                }
                                $block['attrs']['faqTitle'] = $post->post_title;
                                $block['attrs']['faqId'] = $post->ID;
                            }
                            $output .= render_block($block);
                        }
                        return $output;
                    } else {
                        $block_type = get_block_type('faa/faq-and-answers');
                        $default_attrs = [];
                        if ($block_type && isset($block_type->attributes)) {
                            foreach ($block_type->attributes as $key => $attr) {
                                if (isset($attr['default'])) {
                                    $default_attrs[$key] = $attr['default'];
                                }
                            }
                        }

                        $attrs = $default_attrs;
                        $attrs['faqTitle'] = $post->post_title;
                        $attrs['faqId'] = $post->ID;

                        if (isset($attrs['Styles']['content']['question'])) {
                            $attrs['Styles']['content']['question']['colors']['color'] = $font_color;
                            $attrs['Styles']['content']['question']['typo']['fontSize'] = [
                                "desktop" => $font_size,
                                "tablet" => $font_size,
                                "mobile" => $font_size
                            ];
                        }
                        if (isset($attrs['Styles']['content']['answer'])) {
                            $attrs['Styles']['content']['answer']['colors']['color'] = $ans_font_color;
                            $attrs['Styles']['content']['answer']['typo']['fontSize']['desktop'] = $ans_font_size;
                        }
                        if (!empty($post_meta) && is_array($post_meta)) {
                            $attrs['faqData'] = [];
                            foreach ($post_meta as $item) {
                                $attrs['faqData'][] = [
                                    "categories" => "",
                                    "question" => isset($item['ba_re_text_field_id']) ? $item['ba_re_text_field_id'] : '',
                                    "answer" => isset($item['ba_re_textarea_field_id']) ? $item['ba_re_textarea_field_id'] : ''
                                ];
                            }
                        }

                        $render_block = [
                            "blockName" => "faa/faq-and-answers",
                            "attrs" => $attrs,
                            "innerBlocks" => [],
                            "innerHTML" => '',
                            "innerContent" => []
                        ];

                        return render_block($render_block);
                    }
                } else {
                    // Show the notice to editors only, never to site visitors.
                    if (current_user_can('edit_posts')) {
                        return '<p>' . sprintf(
                            /* translators: %s: FAQ post ID used in the shortcode. */
                            esc_html__('Error: Awesome FAQ with ID %s not found.', 'faq-and-answers'),
                            esc_html((string) $atts['id'])
                        ) . '</p>';
                    }

                    return '';
                }
            }
        }
    }
}
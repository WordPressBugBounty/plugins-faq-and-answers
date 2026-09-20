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
            require_once AFAQ_DIR_PATH . 'includes/class-afaq-style.php';
            require_once AFAQ_DIR_PATH . 'faq-and-answers-block.php';
            require_once AFAQ_DIR_PATH . 'includes/class_faaAdmin.php';
            require_once AFAQ_DIR_PATH . 'includes/class_faaAjax.php';
            new FaaAjax();

            // The editor's Template Library: five ready-made sections that ship
            // with the plugin, plus anything published for it on the template
            // server. Admin only — every endpoint it registers is wp_ajax_.
            if (is_admin()) {
                require_once AFAQ_DIR_PATH . 'includes/Templates/Templates.php';
                new \AFAQ\Templates\Templates();
            }
            if (faa_is_premium() && AFAQ_HAS_PRO) {
                // Questions visitors send in through the FAQ Form block, and
                // the screen they are read on. Loaded on the front end too:
                // the form posts to a public REST route.
                //
                // Premium only, and stripped from the free build by the
                // @fs_premium_only header — the FAQ Form block that feeds it is
                // premium as well, so on a free install there is nothing to
                // collect and nothing to read.
                if (file_exists(AFAQ_DIR_PATH . 'includes/submissions/class-afaq-submissions.php')) {
                    require_once AFAQ_DIR_PATH . 'includes/submissions/class-afaq-submissions.php';
                    AFAQ_Submissions::instance();
                }

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
                // Same for Form Submissions: the menu item stays, and the
                // screen behind it says what the feature does instead of
                // listing submissions this build cannot collect.
                if (is_admin() && file_exists(AFAQ_DIR_PATH . 'includes/class-faa-freeSubmissions.php')) {
                    require_once AFAQ_DIR_PATH . 'includes/class-faa-freeSubmissions.php';
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

        /**
         * A registered block type, by name.
         *
         * There is no get_block_type() in WordPress — that name belongs to
         * wp.blocks.getBlockType() in the editor's JavaScript. Called from PHP
         * it is a fatal, and because this shortcode runs inside the_content it
         * took the REST save response and the front end down with it. The
         * registry is what PHP has, and it is what the Ask AI and WooCommerce
         * halves of this plugin already ask.
         *
         * @param string $name Block name, e.g. faa/faq-and-answers.
         * @return WP_Block_Type|null
         */
        private function blockType($name)
        {
            if (!class_exists('WP_Block_Type_Registry')) {
                return null;
            }

            return WP_Block_Type_Registry::get_instance()->get_registered($name);
        }

        public function faq_shortcode($atts)
        {

            if (isset($atts['id'])) {
                $faq_id = absint($atts['id']);
                $post = $faq_id ? get_post($faq_id) : null;

                // An id that is not an FAQ is a typo, not something to render.
                // get_post() happily returns the page, the attachment or the
                // wp_global_styles row sitting on that id — on a fresh install
                // [faq id=6] is usually the last of those — and rendering it
                // produced an empty FAQ instead of saying the id was wrong.
                if ($post && 'faq_cpt' !== $post->post_type) {
                    $post = null;
                }

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
                            /*
                             * Tell the block which FAQ it is, whichever block it is.
                             *
                             * This used to name faa/faq-and-answers alone, so a CPT
                             * built with any other block rendered here without an
                             * identity — and Analytics filed its clicks under
                             * whatever page the shortcode happened to sit on,
                             * because render.php falls back to get_the_title().
                             *
                             * Asked of the block type rather than a list kept here:
                             * a block that declares the two attributes gets them,
                             * one that has no use for them (FAQ Form) is skipped,
                             * and a block added later needs nothing added here.
                             * WordPress strips undeclared attributes before render
                             * anyway, so a list would have gone stale silently.
                             */
                            $block_type = $this->blockType($block['blockName']);
                            $declared = $block_type && isset($block_type->attributes) ? $block_type->attributes : [];

                            if (isset($declared['faqTitle'], $declared['faqId'])) {
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
                        $block_type = $this->blockType('faa/faq-and-answers');
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
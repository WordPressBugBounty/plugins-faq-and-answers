<?php
// phpcs:disable

if (!defined('ABSPATH')) {
    exit; 
}
if (!class_exists('FAQBlock')) {
    class FAQBlock
    {
        /**
         * Blocks that live in build/blocks/*. The folder name is also the key
         * used in the afaq_disabled_blocks option and on the dashboard.
         */
        private $child_blocks = ['nested-faq', 'faq-item', 'faq-parent', 'ask-ai', 'bento-faq'];

        /**
         * Blocks in build/blocks/* that only register for premium users.
         * Their render.php enforces the same rule.
         *
         * These folders are stripped from the free build by the
         * @fs_premium_only header in faq-and-answers.php, so on a free install
         * the glob below never sees them. The check stays for the pro build
         * running without an active license.
         */
        private $premium_blocks = ['ask-ai', 'bento-faq', 'nested-faq', 'faq-parent', 'faq-item'];

        public function __construct()
        {
            add_action('init', [$this, 'onInit']);
            add_action('after_setup_theme', [$this, 'setupThemeSupports']);
            add_action('enqueue_block_editor_assets', [$this, "scbEnqueueEditorAssets"]);
            add_action('enqueue_block_assets', [$this, "scbEnqueueFrontendAssets"]);
            add_filter('block_categories_all', [$this, 'registerBlockCategory'], 10, 1);
        }

        /**
         * One inserter category that holds every block this plugin ships.
         */
        public function registerBlockCategory($categories)
        {
            foreach ($categories as $category) {
                if (isset($category['slug']) && 'awesome-faq' === $category['slug']) {
                    return $categories;
                }
            }

            array_unshift($categories, [
                'slug'  => 'awesome-faq',
                'title' => __('Awesome FAQ', 'faq-and-answers'),
                'icon'  => 'feedback',
            ]);

            return $categories;
        }
        public function setupThemeSupports()
        {
            add_theme_support('align-wide');
        }
        public function onInit()
        {
            $disabled_blocks = (array) get_option('afaq_disabled_blocks', []);

            // Main FAQ block — compiled to /build.
            if (!in_array('faq-and-answers', $disabled_blocks, true)) {
                register_block_type(__DIR__ . '/build');
            }

            // Child blocks — compiled to /build/blocks/*. Every child block is
            // premium, so nothing here registers on a free install; the FAQ
            // Builder picker is only placed into the CPT for premium users
            // (see FaaAdmin::afaq_create_post_type).
            $blocks_path = AFAQ_DIR_PATH . 'build/blocks/';

            if (is_dir($blocks_path)) {
                foreach ((array) glob($blocks_path . '*', GLOB_ONLYDIR) as $block_path) {
                    $block_name = basename($block_path);

                    if (in_array($block_name, $disabled_blocks, true)) {
                        continue;
                    }

                    if (in_array($block_name, $this->premium_blocks, true) && !faa_is_premium()) {
                        continue;
                    }

                    register_block_type($block_path);
                }
            }

            wp_set_script_translations('faa-faq-and-answers-editor-script', 'faq-and-answers', AFAQ_DIR_PATH . 'languages');

            add_action('rest_api_init', [$this, 'registerRestRoutes']);
        }
        public function registerRestRoutes()
        {
            register_rest_route(
                'afaq/v1',
                '/generate-answer',
                [
                    'methods' => 'POST',
                    'callback' => [$this, 'generateAnswer'],
                    'permission_callback' => function () {
                        return current_user_can('edit_posts');
                    },
                    'args' => [
                        'prompt' => [
                            'required' => true,
                            'type' => 'string',
                            'sanitize_callback' => 'sanitize_textarea_field',
                        ],
                    ],
                ]
            );
        }
        public function generateAnswer(WP_REST_Request $request)
        {
            $prompt = $request->get_param('prompt');
            if (!function_exists('wp_ai_client_prompt')) {
                return new WP_REST_Response(['error' => __('WordPress AI Client is not available.', 'faq-and-answers')], 500);
            }

            try {
                $ai_client_prompt = 'wp_ai_client_prompt';
                $builder = $ai_client_prompt($prompt);
                $builder->using_model_preference('claude-sonnet-4-6', 'gpt-4o', 'gemini-pro');
                $response = $builder->generate_text();

                if (is_wp_error($response)) {
                    return new WP_REST_Response(['error' => $response->get_error_message()], 500);
                }

                if (is_array($response)) {
                    $response = isset($response['content']) ? $response['content']
                        : (isset($response['text']) ? $response['text'] : wp_json_encode($response));
                }

                return new WP_REST_Response(['result' => $response], 200);
            } catch (Exception $e) {
                return new WP_REST_Response(['error' => $e->getMessage()], 500);
            }
        }

        public function scbEnqueueEditorAssets()
        {
            $flag = 'const scdIsPipeChecker = ' . wp_json_encode(faa_is_premium()) . ';';

            wp_add_inline_script('faa-faq-and-answers-editor-script', $flag, 'before');

            foreach ($this->child_blocks as $slug) {
                wp_add_inline_script("faa-{$slug}-editor-script", $flag, 'before');
            }

            global $wp_version;
            $is_wp7 = version_compare($wp_version, '7.0', '>=');
            $wp7_ai_ready = false;
            if ($is_wp7 && function_exists('wp_ai_client_prompt')) {
                if (class_exists('WordPress\AiClient\AiClient')) {
                    $registry = \WordPress\AiClient\AiClient::defaultRegistry();
                    if (method_exists($registry, 'getRegisteredProviderIds') && method_exists($registry, 'isProviderConfigured')) {
                        $registered_ids = $registry->getRegisteredProviderIds();
                        foreach ($registered_ids as $prov_id) {
                            if ($registry->isProviderConfigured($prov_id)) {
                                $wp7_ai_ready = true;
                                break;
                            }
                        }
                    }
                }
            }

            wp_add_inline_script(
                'faa-faq-and-answers-editor-script',
                'window.faaBlockAI = ' . wp_json_encode([
                    'isWp7' => $is_wp7,
                    'wp7AiAvailable' => $wp7_ai_ready,
                    'restUrl' => rest_url('afaq/v1/'),
                    'nonce' => wp_create_nonce('wp_rest'),
                    'setupUrl' => admin_url('/options-connectors.php'),
                ]) . ';',
                'before'
            );
        }
        public function scbEnqueueFrontendAssets()
        {
            $handles = array_merge(
                ['faa-faq-and-answers-view-script'],
                array_map(function ($slug) {
                    return "faa-{$slug}-view-script";
                }, $this->child_blocks)
            );

            foreach ($handles as $handle) {
                wp_add_inline_script(
                    $handle,
                    'const scdIsPipeChecker = ' . wp_json_encode(faa_is_premium()) . ';',
                    'before'
                );
                wp_add_inline_script(
                    $handle,
                    'window.faaAnalytics = ' . wp_json_encode([
                        'ajax_url' => admin_url('admin-ajax.php'),
                        'nonce' => wp_create_nonce('faa_analytics_nonce')
                    ]) . ';',
                    'before'
                );
            }
        }
    }
    new FAQBlock();
}

<?php
// phpcs:disable

if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('FAQBlock')) {
    class FAQBlock
    {
        public function __construct()
        {
            add_action('init', [$this, 'onInit']);
            add_action('after_setup_theme', [$this, 'setupThemeSupports']);
            add_action('enqueue_block_editor_assets', [$this, "scbEnqueueEditorAssets"]);
            add_action('enqueue_block_assets', [$this, "scbEnqueueFrontendAssets"]);
        }
        public function setupThemeSupports()
        {
            add_theme_support('align-wide');
        }
        public function onInit()
        {
            register_block_type(__DIR__ . '/build');
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
            wp_add_inline_script(
                'faa-faq-and-answers-editor-script',
                'const scdIsPipeChecker = ' . wp_json_encode(faa_is_premium()) . ';',
                'before'
            );

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
            wp_add_inline_script(
                'faa-faq-and-answers-view-script',
                'const scdIsPipeChecker = ' . wp_json_encode(faa_is_premium()) . ';',
                'before'
            );
            wp_add_inline_script(
                'faa-faq-and-answers-view-script',
                'window.faaAnalytics = ' . wp_json_encode([
                    'ajax_url' => admin_url('admin-ajax.php'),
                    'nonce' => wp_create_nonce('faa_analytics_nonce')
                ]) . ';',
                'before'
            );
        }
    }
    new FAQBlock();
}

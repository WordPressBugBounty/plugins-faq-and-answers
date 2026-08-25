<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('FaaAjax')) {
    /**
     * Ajax endpoints for the plugin dashboard.
     */
    class FaaAjax
    {
        public function __construct()
        {
            add_action('wp_ajax_afaq_get_blocks', [$this, 'afaq_get_blocks']);
        }

        /**
         * Read/write the list of disabled blocks.
         *
         * - Called with no `data` payload -> returns the saved list (read).
         * - Called with a `data` payload  -> saves the list (write).
         *
         * The list stores block keys: "faq-and-answers" for the main block and
         * the build/blocks/* folder name for every child block.
         */
        public function afaq_get_blocks()
        {
            $nonce = isset($_POST['_wpnonce']) ? sanitize_text_field(wp_unslash($_POST['_wpnonce'])) : '';

            if (!wp_verify_nonce($nonce, 'afaq_admin_nonce')) {
                wp_send_json_error('Invalid Request');
            }

            if (!current_user_can('manage_options')) {
                wp_send_json_error('Permission denied');
            }

            // Read path: no data posted -> return the currently disabled blocks.
            if (!isset($_POST['data'])) {
                wp_send_json_success((array) get_option('afaq_disabled_blocks', []));
            }

            $data = json_decode(sanitize_text_field(wp_unslash($_POST['data'])), true);

            if (!is_array($data)) {
                $data = [];
            }

            $data = array_values(array_map('sanitize_text_field', $data));

            update_option('afaq_disabled_blocks', $data);

            wp_send_json_success($data);
        }
    }
}

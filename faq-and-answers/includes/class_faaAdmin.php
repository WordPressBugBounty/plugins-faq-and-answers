<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('FaaAdmin')) {
    class FaaAdmin {
        public function __construct() {
            add_action('init', [$this, 'afaq_create_post_type']);
            add_action('admin_menu', [$this, 'faa_sub_Menu']);
            add_filter('manage_faq_cpt_posts_columns', [$this, 'sc_setCustomColumn_edit']);
            add_action('manage_faq_cpt_posts_custom_column', [$this, 'sc_manageCustomColumn'], 10, 2);
        }
        public function afaq_create_post_type(){
            register_post_type('faq_cpt', [
                'label' => 'Awesome FAQ',
                'description' => 'this is FAQ and seo friendly card',
                'labels' => [
                    'name' => __('Awesome FAQ', 'faq-and-answers'),
                    'singular_name' => __('FAQ', 'faq-and-answers'),
                    'add_new' => __('Add New ', 'faq-and-answers'),
                    'add_new_item' => __('Add New FAQ', 'faq-and-answers'),
                    'edit_item' => __('Edit FAQ', 'faq-and-answers'),
                    'new_item' => __('New FAQ', 'faq-and-answers'),
                    'view_item' => __('View FAQ', 'faq-and-answers'),
                    'search_items' => __('Search FAQ', 'faq-and-answers'),
                    'not_found' => __('Sorry, we couldn\'t find the ShortCode you are looking for.', 'faq-and-answers')
                ],
                'public' => true,
                "publicly_queryable" => false,
                'show_ui' => true,
                'show_in_menu' => true,
                'show_in_rest' => true,
                'menu_position' => 20,
                'menu_icon' => 'dashicons-feedback',
                'supports' => array('title', 'editor', 'revisions'),
                'template' => [['faa/faq-and-answers']],

            ]);
        }

        public function faa_sub_Menu() {
            add_submenu_page(
                'edit.php?post_type=faq_cpt',
                'Demo & Help',
                'Demo & Help',
                'manage_options',
                'faq_Dashboard',
                [$this, 'faq_Dashboard_page']
            );
        }
        public function faq_Dashboard_page() {
            ?>
            <div id='vgbDashboard' data-info='<?php echo esc_attr(wp_json_encode([
                'version' => AFAQ_VERSION,
                'isPremium' => faa_is_premium(),
                'hasPro' => AFAQ_HAS_PRO,
                'licenseActiveNonce' => wp_create_nonce('csbLicenseActive'),
                'adminUrl' => admin_url(),
            ])); ?>'></div>
            <?php
        }
        public function sc_setCustomColumn_edit($column) {
            unset($column['date']);
            $column['shortcode'] = 'ShortCode';
            $column['analytics'] = 'Analytics';
            $column['date'] = 'Date';
            return $column;
        }
        public function sc_manageCustomColumn($column_name, $post_id) {
            if ($column_name == 'shortcode') {
                echo '<div class="bPlAdminShortcode" id="bPlAdminShortcode-' . esc_attr($post_id) . '">
						<input value="[faq id=' . esc_attr($post_id) . ']" onclick="copyBPlAdminShortcode(\'' . esc_attr($post_id) . '\')" readonly>
						<span class="tooltip">Copy To Clipboard</span>
					  </div>';
            }
            if ($column_name == 'analytics') {
                $post = get_post($post_id);
                $url = admin_url('edit.php?post_type=faq_cpt&page=faq_analytics&faq_id=' . intval($post_id));
                echo '<a href="' . esc_url($url) . '" class="button button-secondary" style="background: #136EF5; color: #fff; border-color: #136EF5; border-radius: 6px;">View</a>';
            }
        }
    }
    new FaaAdmin();
}
<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('FaaAdmin')) {
    class FaaAdmin {
        public function __construct() {
            add_action('init', [$this, 'afaq_create_post_type']);
            add_action('admin_menu', [$this, 'faa_sub_Menu']);
            // Late, so it lands under every other item this plugin registers —
            // including the ones added by the premium screens.
            add_action('admin_menu', [$this, 'faa_upgrade_menu'], 999);
            add_action('admin_head', [$this, 'faa_upgrade_menu_style']);
            add_filter('manage_faq_cpt_posts_columns', [$this, 'sc_setCustomColumn_edit']);
            add_action('manage_faq_cpt_posts_custom_column', [$this, 'sc_manageCustomColumn'], 10, 2);
            add_filter('allowed_block_types_all', [$this, 'afaq_allowed_block_types'], 10, 2);
        }

        /**
         * Inside the FAQ CPT editor only this plugin's blocks are offered.
         * Premium users additionally get the FAQ Builder picker.
         */
        public function afaq_allowed_block_types($allowed_blocks, $editor_context)
        {
            if (empty($editor_context->post) || 'faq_cpt' !== $editor_context->post->post_type) {
                return $allowed_blocks;
            }

            // Core blocks stay allowed so a Nested FAQ answer can hold headings,
            // images, video, columns and groups like anywhere else.
            $blocks = ['faa/faq-and-answers'];

            $blocks = array_merge($blocks, [
                'core/paragraph',
                'core/heading',
                'core/list',
                'core/list-item',
                'core/image',
                'core/gallery',
                'core/video',
                'core/embed',
                'core/audio',
                'core/file',
                'core/table',
                'core/quote',
                'core/code',
                'core/buttons',
                'core/button',
                'core/columns',
                'core/column',
                'core/group',
                'core/separator',
                'core/spacer',
                'core/html',
                'core/shortcode',
            ]);

            // Every block the FAQ Builder picker can insert has to be listed
            // here as well, or the editor refuses the swap and the card looks
            // dead. These are all pro — on a free install they are not even
            // registered, so the list is simply never reached.
            if (function_exists('faa_is_premium') && faa_is_premium()) {
                $blocks = array_merge($blocks, [
                    'faa/nested-faq',
                    'faa/faq-item',
                    'faa/bento-faq',
                    'faa/ask-ai',
                    'faa/faq-parent',
                ]);
            }

            return $blocks;
        }

        public function afaq_create_post_type(){
            $is_premium = function_exists('faa_is_premium') ? faa_is_premium() : false;

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
                // Free users get the default FAQ block locked in and copy its
                // shortcode. Premium users get the FAQ Builder picker so they can
                // choose a block or a ready made template first.
                'template' => $is_premium ? [['faa/faq-parent']] : [['faa/faq-and-answers']],
                'template_lock' => 'all',

            ]);
        }

        public function faa_sub_Menu() {
            add_submenu_page(
                'edit.php?post_type=faq_cpt',
                __('Demo & Help', 'faq-and-answers'),
                // Tinted so it stands out from the plain items above it — this is
                // where somebody goes when they are stuck, and a row of identical
                // grey links is no help at that moment.
                '<span style="color:#e07c24;font-weight:600">' . esc_html__('Demo & Help', 'faq-and-answers') . '</span>',
                'manage_options',
                'faq_Dashboard',
                [$this, 'faq_Dashboard_page']
            );
        }

        /**
         * An Upgrade button pinned to the bottom of the submenu.
         *
         * Appended straight to the $submenu global rather than registered as a
         * page, because it is a link to the pricing view of an existing screen —
         * add_submenu_page() would insist on owning a page of its own and could
         * not carry the #/pricing route.
         *
         * Free installs only: there is nothing to sell somebody who has already
         * bought it.
         */
        public function faa_upgrade_menu() {
            if (!function_exists('faa_is_premium') || faa_is_premium()) {
                return;
            }

            global $submenu;

            $parent = 'edit.php?post_type=faq_cpt';

            if (!isset($submenu[$parent])) {
                return;
            }

            $submenu[$parent][] = [
                '<span class="afaq-upgrade-btn">' . esc_html__('Upgrade', 'faq-and-answers') . ' &#10148;</span>',
                'manage_options',
                admin_url('edit.php?post_type=faq_cpt&page=faq_Dashboard#/pricing'),
            ];
        }

        /**
         * Styles for the Upgrade button in the submenu.
         *
         * A stylesheet rather than an inline style on the span, for one reason:
         * the link around it keeps WordPress's own padding, which stacked on top
         * of the button's and left the item taller than every other row with
         * uneven space above and below. Only a rule on the anchor itself can
         * take that away, and an inline style cannot reach a parent.
         *
         * Printed only where the button is, so a premium install carries none of
         * it. The selector outranks WordPress's own without !important.
         */
        public function faa_upgrade_menu_style() {
            if (!function_exists('faa_is_premium') || faa_is_premium()) {
                return;
            }
            ?>
            <style>
                #adminmenu .wp-submenu a[href*="#/pricing"] {
                    padding: 0;
                }

                #adminmenu .wp-submenu a[href*="#/pricing"] .afaq-upgrade-btn {
                    display: block;
                    /* Even on every side — the button is its own block, so the
                       spacing above and below it has to match. */
                    margin: 7px 10px;
                    padding: 7px 10px;
                    border-radius: 3px;
                    background: #0f5fdb;
                    color: #fff;
                    font-weight: 600;
                    line-height: 1.4;
                    text-align: center;
                }

                #adminmenu .wp-submenu a[href*="#/pricing"]:hover .afaq-upgrade-btn,
                #adminmenu .wp-submenu a[href*="#/pricing"]:focus .afaq-upgrade-btn {
                    background: #0c4cae;
                    color: #fff;
                }
            </style>
            <?php
        }
        public function faq_Dashboard_page() {
            ?>
            <div id='vgbDashboard' data-info='<?php echo esc_attr(wp_json_encode([
                'version' => AFAQ_VERSION,
                'isPremium' => faa_is_premium(),
                'hasPro' => AFAQ_HAS_PRO,
                'licenseActiveNonce' => wp_create_nonce('csbLicenseActive'),
                'adminUrl' => admin_url(),
                'nonce' => wp_create_nonce('afaq_admin_nonce'),
                'action' => 'afaq_get_blocks',
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
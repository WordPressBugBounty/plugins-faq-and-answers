<?php
/**
 * The "All Product FAQs" menu item on a free install.
 *
 * The premium build registers the Product FAQ post type (woocommerce/) and
 * puts "All Product FAQs" right after Analytics. On a free install that folder
 * is stripped, so this class keeps the item in the same spot and shows a
 * locked preview of the list instead, the same way the free Analytics screen
 * does.
 *
 * @package Awesome_FAQ
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('FaaFreeProductFaq')) {
    class FaaFreeProductFaq
    {
        const PAGE_SLUG = 'afaq-product-faqs';

        public function __construct()
        {
            // Priority 20, after Analytics (10) exists, same as the premium menu.
            add_action('admin_menu', [$this, 'register_page'], 20);
        }

        public function register_page()
        {
            global $submenu;

            $parent   = 'edit.php?post_type=faq_cpt';
            $position = null;

            if (isset($submenu[$parent]) && is_array($submenu[$parent])) {
                $index = 0;
                foreach ($submenu[$parent] as $item) {
                    $index++;
                    if (isset($item[2]) && 'faq_analytics' === $item[2]) {
                        $position = $index; // Slot right after Analytics.
                        break;
                    }
                }
            }

            add_submenu_page(
                $parent,
                __('Product FAQs', 'faq-and-answers'),
                __('All Product FAQs', 'faq-and-answers'),
                'manage_options',
                self::PAGE_SLUG,
                [$this, 'render_page'],
                $position
            );
        }

        /**
         * Sample rows for the locked preview.
         *
         * @return array<int,array<string,string>>
         */
        private function sample_rows()
        {
            return [
                [
                    'title'    => __('Shipping & delivery', 'faq-and-answers'),
                    'applies'  => __('All products', 'faq-and-answers'),
                    'count'    => '6',
                    'date'     => __('2 days ago', 'faq-and-answers'),
                ],
                [
                    'title'    => __('Sizing guide questions', 'faq-and-answers'),
                    'applies'  => __('Category: Clothing', 'faq-and-answers'),
                    'count'    => '4',
                    'date'     => __('1 week ago', 'faq-and-answers'),
                ],
                [
                    'title'    => __('Warranty & returns', 'faq-and-answers'),
                    'applies'  => __('Category: Electronics', 'faq-and-answers'),
                    'count'    => '5',
                    'date'     => __('2 weeks ago', 'faq-and-answers'),
                ],
                [
                    'title'    => __('Care instructions', 'faq-and-answers'),
                    'applies'  => __('Tag: Handmade', 'faq-and-answers'),
                    'count'    => '3',
                    'date'     => __('3 weeks ago', 'faq-and-answers'),
                ],
                [
                    'title'    => __('Subscription box FAQ', 'faq-and-answers'),
                    'applies'  => __('Selected products', 'faq-and-answers'),
                    'count'    => '7',
                    'date'     => __('1 month ago', 'faq-and-answers'),
                ],
                [
                    'title'    => __('Gift cards', 'faq-and-answers'),
                    'applies'  => __('Selected products', 'faq-and-answers'),
                    'count'    => '2',
                    'date'     => __('1 month ago', 'faq-and-answers'),
                ],
            ];
        }

        public function render_page()
        {
            if (!current_user_can('manage_options')) {
                wp_die(esc_html__('You do not have permission to view product FAQs.', 'faq-and-answers'));
            }

            $pricing = admin_url('edit.php?post_type=faq_cpt&page=faq_Dashboard#/pricing');
            ?>
            <div class="wrap">
                <h1><?php esc_html_e('Product FAQs', 'faq-and-answers'); ?></h1>

                <div style="position:relative; overflow:hidden; border:1px solid #dcdcde; background:#fff; margin-top:16px; min-height:480px;">
                    <div aria-hidden="true" style="padding:12px 0; filter:blur(1.5px); opacity:.75; pointer-events:none; user-select:none;">
                        <table class="wp-list-table widefat fixed striped" style="border:0;">
                            <thead>
                                <tr>
                                    <th scope="col"><?php esc_html_e('Title', 'faq-and-answers'); ?></th>
                                    <th scope="col"><?php esc_html_e('Shows on', 'faq-and-answers'); ?></th>
                                    <th scope="col"><?php esc_html_e('Questions', 'faq-and-answers'); ?></th>
                                    <th scope="col"><?php esc_html_e('Date', 'faq-and-answers'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->sample_rows() as $row) : ?>
                                    <tr>
                                        <td><strong><?php echo esc_html($row['title']); ?></strong></td>
                                        <td><?php echo esc_html($row['applies']); ?></td>
                                        <td><?php echo esc_html($row['count']); ?></td>
                                        <td><?php echo esc_html($row['date']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div style="position:absolute; inset:0; box-sizing:border-box; display:flex; align-items:center; justify-content:center; padding:40px 32px; background:rgba(15,23,42,0.55);">
                        <div style="box-sizing:border-box; width:100%; max-width:520px; padding:36px 32px; background:#fff; border:1px solid #dcdcde; border-top:3px solid #2563eb; text-align:center;">
                            <h2 style="margin:0 0 12px; font-size:22px; font-weight:700; color:#0f172a;">
                                <?php esc_html_e('Product FAQs is a Pro feature', 'faq-and-answers'); ?>
                            </h2>
                            <p style="margin:0 0 24px; font-size:14px; line-height:1.7; color:#475569;">
                                <?php esc_html_e('Write an FAQ once and show it on every WooCommerce product, a category, a tag or just the products you pick.', 'faq-and-answers'); ?>
                            </p>
                            <a href="<?php echo esc_url($pricing); ?>"
                                style="display:inline-block; padding:11px 28px; background:#2563eb; border:1px solid #2563eb; color:#fff; font-size:15px; font-weight:600; text-decoration:none;">
                                <?php esc_html_e('Upgrade to Pro', 'faq-and-answers'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }

    new FaaFreeProductFaq();
}

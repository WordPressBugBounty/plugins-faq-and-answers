<?php
/**
 * The Analytics menu item on a free install.
 *
 * Keeps the screen present at the slug the premium version uses, showing what
 * the feature does rather than hiding it. Squared off to match the real
 * Analytics screen — nothing on either page has a rounded corner.
 *
 * @package Awesome_FAQ
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('FaaFreeAnalytics')) {
    class FaaFreeAnalytics
    {
        public function __construct()
        {
            add_action('admin_menu', [$this, 'faa_sub_Menu_analytics_free']);
        }

        public function faa_sub_Menu_analytics_free()
        {
            add_submenu_page(
                'edit.php?post_type=faq_cpt',
                __('Analytics', 'faq-and-answers'),
                __('Analytics', 'faq-and-answers'),
                'manage_options',
                'faq_analytics',
                [$this, 'faq_analytics_free_page']
            );
        }

        public function faq_analytics_free_page()
        {
            if (!current_user_can('manage_options')) {
                wp_die(esc_html__('You do not have permission to view FAQ analytics.', 'faq-and-answers'));
            }
            ?>
            <div class="wrap">
                <h1><?php esc_html_e('Analytics', 'faq-and-answers'); ?></h1>

                <div style="position:relative; overflow:hidden; border:1px solid #dcdcde; background:#fff; margin-top:16px;">
                    <img src="<?php echo esc_url(AFAQ_DIR_URL . 'assets/faq-analysis-dashboard.png'); ?>"
                        style="width:100%; display:block;" alt="<?php esc_attr_e('Preview of the Analytics screen', 'faq-and-answers'); ?>">

                    <?php
                    // The padding here is what keeps the card off the edges of
                    // the panel. border-box on both, or the padding is added to
                    // the widths and the card runs past the sides it is meant
                    // to be inset from.
                    ?>
                    <div style="position:absolute; inset:0; box-sizing:border-box; display:flex; align-items:center; justify-content:center; padding:40px 32px; background:rgba(15,23,42,0.55);">
                        <div style="box-sizing:border-box; width:100%; max-width:520px; padding:36px 32px; background:#fff; border:1px solid #dcdcde; border-top:3px solid #2563eb; text-align:center;">
                            <h2 style="margin:0 0 12px; font-size:22px; font-weight:700; color:#0f172a;">
                                <?php esc_html_e('Analytics is a Pro feature', 'faq-and-answers'); ?>
                            </h2>
                            <p style="margin:0 0 24px; font-size:14px; line-height:1.7; color:#475569;">
                                <?php esc_html_e('See which questions get clicked, how that changes day by day, which ones are trending, and export the whole thing as a CSV.', 'faq-and-answers'); ?>
                            </p>
                            <?php // "#/pricing", the dashboard's own route — "#pricing" matches nothing and lands on the dashboard's default view. ?>
                            <a href="<?php echo esc_url(admin_url('edit.php?post_type=faq_cpt&page=faq_Dashboard#/pricing')); ?>"
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

    new FaaFreeAnalytics();
}

<?php
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
                'Analytics',
                'Analytics',
                'manage_options',
                'faq_analytics',
                [$this, 'faq_analytics_free_page']
            );
        }

        public function faq_analytics_free_page()
        {
            ?>
            <div class="wrap">
                <div style="position: relative; border-radius: 12px; overflow: hidden; ">
                    <img src="<?php echo esc_url(AFAQ_DIR_URL . 'assets/faq-analysis-dashboard.png'); ?>" style="width: 100%; display: block;"
                        alt="Analytics Preview">
                    <div
                        style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center; color: #fff; width: 40%; line-height: 1.5;">
                        <div
                            style="background: rgba(0, 0, 0, 0.4); backdrop-filter: blur(5px); padding: 40px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.1);">
                            <div style="font-size: 50px; margin-bottom: 20px;">📊</div>
                            <h2 style="color: #fff; font-size: 28px; font-weight: 700; margin: 0 0 15px;">
                                <?php esc_html_e('Analytics is a Premium Feature', 'faq-and-answers'); ?></h2>
                            <p style="font-size: 16px; margin-bottom: 30px; opacity: 0.9;">
                                <?php esc_html_e('Unlock detailed insights into how your users interact with your FAQs. Track clicks, most popular questions, and export reports.', 'faq-and-answers'); ?>
                            </p>
                            <a href="<?php echo esc_url(admin_url('edit.php?post_type=faq_cpt&page=faq_Dashboard/#pricing')); ?>"
                                target="_blank" class="button button-primary button-large"
                                style="background: #6366f1; border: none; padding: 10px 30px; font-size: 18px; height: auto; border-radius: 8px; font-weight: 600; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);"><?php esc_html_e('Upgrade to Pro', 'faq-and-answers'); ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    new FaaFreeAnalytics();
}

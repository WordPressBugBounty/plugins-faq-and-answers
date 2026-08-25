<?php
/**
 * Ask AI — free build teaser screen.
 *
 * The pro build ships includes/ai/class-afaq-ask-ai-admin.php, which owns the
 * real Awesome FAQ › Ask AI screen. On a free install that whole folder is
 * stripped by the @fs_premium_only header, so the menu item disappears and a
 * free user never learns the feature exists.
 *
 * This class puts the menu item back on the free build only, at the very same
 * slug, and renders a React screen that mirrors the real dashboard: the same
 * sidebar, the same panels, and sample figures in place of live ones. Upgrading
 * then swaps this screen for the real one at the same URL, so nothing has to be
 * re-learned.
 *
 * Loaded from FaaPlugin::pluginsDependency, next to FaaFreeAnalytics, and
 * listed under @fs_free_only so it never reaches the premium build.
 */

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('FaaFreeAskAi')) {
    class FaaFreeAskAi
    {
        /**
         * Same slug the premium screen uses (AFAQ_Ask_AI_Admin::PAGE_SLUG), so
         * a bookmark made on the free build keeps working after upgrading.
         */
        const PAGE_SLUG = 'faq_ask_ai';

        public function __construct()
        {
            add_action('admin_menu', [$this, 'register_page']);
            add_action('admin_enqueue_scripts', [$this, 'enqueue_assets']);
        }

        /**
         * The menu item, carrying a small New badge.
         *
         * A padlock read as "you are not allowed in here", which is not what we
         * mean — the screen behind it is open to everybody. The badge markup is
         * shared with the premium screen through afaq_menu_badge(), so the item
         * looks identical before and after upgrading.
         */
        public function register_page()
        {
            $badge = function_exists('afaq_menu_badge')
                ? afaq_menu_badge(_x('New', 'admin menu badge', 'faq-and-answers'))
                : '';

            add_submenu_page(
                'edit.php?post_type=faq_cpt',
                __('Ask AI', 'faq-and-answers'),
                __('Ask AI', 'faq-and-answers') . $badge,
                'manage_options',
                self::PAGE_SLUG,
                [$this, 'render_page']
            );
        }

        /**
         * The React bundle, only on this screen.
         *
         * @param string $hook Current admin page hook.
         */
        public function enqueue_assets($hook)
        {
            if ('faq_cpt_page_' . self::PAGE_SLUG !== $hook) {
                return;
            }

            $asset_file = AFAQ_DIR_PATH . 'build/ask-ai-promo/index.asset.php';

            if (!file_exists($asset_file)) {
                return;
            }

            $asset = include $asset_file;

            wp_enqueue_script(
                'afaq-ask-ai-promo',
                AFAQ_DIR_URL . 'build/ask-ai-promo/index.js',
                $asset['dependencies'],
                $asset['version'],
                true
            );

            wp_enqueue_style(
                'afaq-ask-ai-promo',
                AFAQ_DIR_URL . 'build/ask-ai-promo/index.css',
                [],
                $asset['version']
            );

            wp_set_script_translations('afaq-ask-ai-promo', 'faq-and-answers', AFAQ_DIR_PATH . 'languages');
        }

        /**
         * The mount point. Everything the screen needs travels in one attribute
         * so no extra request is made.
         */
        public function render_page()
        {
            if (!current_user_can('manage_options')) {
                return;
            }

            // AFAQ_VERSION becomes a timestamp on localhost, so only pass it
            // through when it actually looks like a version number.
            $version = (defined('AFAQ_VERSION') && false !== strpos((string) AFAQ_VERSION, '.')) ? AFAQ_VERSION : '';

            $dashboard = admin_url('edit.php?post_type=faq_cpt&page=faq_Dashboard');

            $info = [
                'version'    => $version,
                'pricingUrl' => $dashboard . '#/pricing',
                'compareUrl' => $dashboard . '#/feature-comparison',
                'demoUrl'    => 'https://demo.bplugins.com/demo/faq-and-answers-ask-ai/',
                'docsUrl'    => 'https://bblockswp.com/docs/faq-and-answers',
                'supportUrl' => 'https://wordpress.org/support/plugin/faq-and-answers/',
            ];
            ?>
            <div class="wrap afaqp-page">
                <h1 class="screen-reader-text"><?php esc_html_e('Ask AI', 'faq-and-answers'); ?></h1>

                <div id="afaqAskAiPromo" data-info="<?php echo esc_attr(wp_json_encode($info)); ?>">
                    <noscript>
                        <p>
                            <?php esc_html_e('Ask AI is a Pro feature. It answers your visitors\' questions from your own FAQ content, and shows you which questions your FAQs do not cover yet.', 'faq-and-answers'); ?>
                        </p>
                        <p>
                            <a class="button button-primary" href="<?php echo esc_url($dashboard . '#/pricing'); ?>">
                                <?php esc_html_e('Upgrade to Pro', 'faq-and-answers'); ?>
                            </a>
                        </p>
                    </noscript>
                </div>
            </div>
            <?php
        }

    }

    new FaaFreeAskAi();
}

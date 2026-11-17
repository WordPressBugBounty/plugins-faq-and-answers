<?php

namespace AwesomeFAQ\Admin;

if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( __NAMESPACE__ . '\FAA_PromoBanner' ) ) {

    class FAA_PromoBanner {
        const DISMISSED_KEY   = 'faa_promo_banner_dismissed_permanent';
        const EXPIRATION_DATE = '2026-12-05 23:59:59';

        /** Target landing URL */
        const COUPON_URL      = 'https://bplugins.com/products/faq-and-answers/pricing/?utm_source=admin&utm_medium=dashboard&utm_campaign=bfcm2026';

        public function __construct() {
            add_action( 'admin_notices',                     [ $this, 'render' ] );
            add_action( 'admin_head',                        [ $this, 'enqueue_styles' ] );
            add_action( 'admin_footer',                      [ $this, 'enqueue_scripts' ] );
            add_action( 'wp_ajax_faa_dismiss_promo_banner', [ $this, 'ajax_dismiss' ] );
        }

        /* ------------------------------------------------------------------ */
        /*  Screen, Expiration, Dismissal & Pro Helpers                       */
        /* ------------------------------------------------------------------ */

        /**
         * Check if the current admin screen is one of the allowed Awesome FAQ screens:
         * 1. Awesome FAQ list (edit.php?post_type=faq_cpt)
         * 2. Demo & Help dashboard (edit.php?post_type=faq_cpt&page=faq_Dashboard)
         * 3. Form Submissions (edit.php?post_type=faq_cpt&page=afaq-form-submissions)
         * 4. Analytics (edit.php?post_type=faq_cpt&page=faq_analytics)
         * 5. Ask AI (edit.php?post_type=faq_cpt&page=faq_ask_ai)
         * Nowhere else (strictly excluded on post editor / post-new.php).
         */
        private function is_plugin_screen(): bool {
            $screen = get_current_screen();
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $page   = isset( $_GET['page'] ) ? sanitize_key( wp_unslash( $_GET['page'] ) ) : '';

            // Exclude post editor or add-new
            if ( $screen && in_array( $screen->base, [ 'post', 'post-new' ], true ) ) {
                return false;
            }
            global $pagenow;
            if ( 'post.php' === $pagenow || 'post-new.php' === $pagenow ) {
                return false;
            }

            // Allowed submenu pages
            $allowed_pages = [
                'faq_dashboard',
                'afaq-form-submissions',
                'faq_analytics',
                'faq_ask_ai',
            ];

            if ( in_array( strtolower( $page ), $allowed_pages, true ) ) {
                return true;
            }

            if ( $screen ) {
                // Check if screen ID matches any allowed subpage
                foreach ( $allowed_pages as $allowed ) {
                    if ( false !== stripos( $screen->id, $allowed ) ) {
                        return true;
                    }
                }

                // Awesome FAQ list table (edit.php?post_type=faq_cpt)
                if ( ( 'edit' === $screen->base || 'edit-faq_cpt' === $screen->id ) && 'faq_cpt' === $screen->post_type && empty( $page ) ) {
                    return true;
                }
            }

            // Fallback for list table
            // phpcs:ignore WordPress.Security.NonceVerification.Recommended
            $post_type = isset( $_GET['post_type'] ) ? sanitize_key( wp_unslash( $_GET['post_type'] ) ) : '';
            if ( 'edit.php' === $pagenow && 'faq_cpt' === $post_type && empty( $page ) ) {
                return true;
            }

            return false;
        }

        /**
         * Check if current date is past December 5, 2026
         */
        private function is_expired(): bool {
            $expiry_timestamp = strtotime( self::EXPIRATION_DATE );
            $current_time     = time();
            return ( $current_time > $expiry_timestamp );
        }

        /**
         * Check if current user has permanently dismissed the banner
         */
        private function is_dismissed(): bool {
            return (bool) get_user_meta( get_current_user_id(), self::DISMISSED_KEY, true );
        }

        /**
         * Determine if the banner should be omitted
         */
        private function should_skip(): bool {
            // 1. Only show inside Awesome FAQ admin menu / screens
            if ( ! $this->is_plugin_screen() ) {
                return true;
            }

            // 2. Automatically remove after Dec 5, 2026
            if ( $this->is_expired() ) {
                return true;
            }

            // 3. Never display again once dismissed by the user
            if ( $this->is_dismissed() ) {
                return true;
            }

            // 4. Hide when Pro version is active (Free version only!)
            if ( function_exists( 'faa_is_premium' ) && faa_is_premium() ) {
                return true;
            }
            if ( defined( 'FAA_PRO_ACTIVE' ) && FAA_PRO_ACTIVE ) {
                return true;
            }
            if ( function_exists( 'is_plugin_active' ) && ( is_plugin_active( 'faq-and-answers-pro/faq-and-answers.php' ) || is_plugin_active( 'faq-and-answers-pro/plugin.php' ) || is_plugin_active( 'faq-and-answers-pro/index.php' ) ) ) {
                return true;
            }

            return false;
        }

        /* ------------------------------------------------------------------ */
        /*  Pro CSS Styles (Design 5)                                         */
        /* ------------------------------------------------------------------ */

        public function enqueue_styles(): void {
            if ( $this->should_skip() ) { return; }
            ?>
            <style id="faa-promo-banner-css">
            #faa-promo-banner,
            div#faa-promo-banner.notice,
            div#faa-promo-banner.faa-promo-notice {
                --bpl-primary:        #146ef5;
                --bpl-primary-hover:  #0d5ecc;
                --bpl-secondary:      #ff7a00;
                --bpl-dark:           #070127;
                --bpl-text:           #1b2e4b;
                --bpl-muted:          #475569;

                background: #ffffff !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 8px !important;
                box-shadow: 0 3px 12px rgba(7, 1, 39, 0.05) !important;
                display: flex !important;
                align-items: stretch !important;
                min-height: 84px !important;
                overflow: hidden !important;
                position: relative !important;
                top: auto !important;
                left: auto !important;
                width: auto !important;
                height: auto !important;
                opacity: 1 !important;
                visibility: visible !important;
                margin: 14px 20px 16px 0 !important;
                padding: 0 !important;
                font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif !important;
                box-sizing: border-box !important;
                animation: faaBannerSlide .3s ease both;
                z-index: 99 !important;
            }
            @keyframes faaBannerSlide {
                from { opacity: 0; transform: translateY(-6px); }
                to   { opacity: 1; transform: translateY(0); }
            }

            /* Left Brand Ribbon Block */
            #faa-promo-banner .faa-brand-ribbon {
                width: 140px;
                min-width: 140px;
                background: linear-gradient(135deg, #ef5a2a 0%, var(--bpl-dark) 100%);
                color: #ffffff;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                padding: 12px 10px;
                gap: 6px;
                flex-shrink: 0;
            }
            #faa-promo-banner .faa-brand-ribbon img {
                width: 40px;
                height: 40px;
                object-fit: contain;
                filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.35));
            }
            #faa-promo-banner .faa-brand-ribbon .faa-ribbon-title {
                font-size: 10.5px;
                font-weight: 800;
                letter-spacing: .7px;
                text-transform: uppercase;
                color: #ffffff;
                text-align: center;
                line-height: 1.2;
            }

            /* Main Content Zone */
            #faa-promo-banner .faa-content-zone {
                flex: 1;
                padding: 14px 22px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 20px;
                flex-wrap: wrap;
                background: #ffffff;
            }

            /* Left Stack: Texts & Highlights */
            #faa-promo-banner .faa-text-stack {
                display: flex;
                flex-direction: column;
                gap: 5px;
                flex: 1;
                min-width: 290px;
            }

            /* Headline */
            #faa-promo-banner .faa-headline {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 10px;
                font-size: 16px;
                font-weight: 800;
                color: var(--bpl-dark);
                line-height: 1.25;
            }

            /* Subheadline */
            #faa-promo-banner .faa-subheadline {
                font-size: 12.5px;
                color: var(--bpl-muted);
                line-height: 1.45;
                max-width: 820px;
            }

            /* Micro Feature Chips */
            #faa-promo-banner .faa-feature-chips {
                display: flex;
                align-items: center;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 4px;
            }
            #faa-promo-banner .faa-feature-chips span {
                display: inline-flex;
                align-items: center;
                gap: 4px;
                font-size: 11.5px;
                font-weight: 600;
                color: #334155;
            }
            #faa-promo-banner .faa-feature-chips .check-icon {
                color: #10b981;
                font-weight: 800;
            }

            /* Right Action Zone: CTA Button */
            #faa-promo-banner .faa-btn-cta {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                gap: 6px;
                padding: 10px 22px;
                background: var(--bpl-primary);
                color: #ffffff !important;
                font-size: 13px;
                font-weight: 700;
                text-decoration: none !important;
                border-radius: 6px;
                white-space: nowrap;
                transition: all .2s ease;
                box-shadow: 0 2px 6px rgba(20, 110, 245, 0.25);
                flex-shrink: 0;
            }
            #faa-promo-banner .faa-btn-cta:hover {
                background: var(--bpl-primary-hover);
                transform: translateY(-1px);
                box-shadow: 0 4px 10px rgba(20, 110, 245, 0.35);
            }

            /* Dismiss Close Button */
            #faa-promo-banner .faa-banner-dismiss-btn {
                position: absolute;
                top: 8px;
                right: 8px;
                background: transparent;
                border: none;
                color: #94a3b8;
                cursor: pointer;
                font-size: 18px;
                line-height: 1;
                padding: 4px 6px;
                border-radius: 4px;
                transition: color .15s ease;
                z-index: 10;
            }
            #faa-promo-banner .faa-banner-dismiss-btn:hover {
                color: var(--bpl-dark);
            }

            /* Responsive */
            @media (max-width: 960px) {
                #faa-promo-banner .faa-brand-ribbon {
                    width: 110px;
                    min-width: 110px;
                }
            }
            @media (max-width: 782px) {
                #faa-promo-banner {
                    flex-direction: column;
                    align-items: stretch;
                }
                #faa-promo-banner .faa-brand-ribbon {
                    width: 100%;
                    flex-direction: row;
                    justify-content: flex-start;
                    padding: 8px 16px;
                }
                #faa-promo-banner .faa-content-zone {
                    flex-direction: column;
                    align-items: flex-start;
                    padding: 14px 16px;
                }
            }
            </style>
            <?php
        }

        /* ------------------------------------------------------------------ */
        /*  Permanent Dismiss Script (AJAX + Animation)                       */
        /* ------------------------------------------------------------------ */

        public function enqueue_scripts(): void {
            if ( $this->should_skip() ) { return; }
            $dismiss_nonce = wp_create_nonce( 'faa_dismiss_promo' );
            $ajax_url      = admin_url( 'admin-ajax.php' );
            ?>
            <script id="faa-promo-banner-js">
            (function () {
                var btn = document.getElementById('faa-banner-close');
                if (!btn) return;
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var banner = document.getElementById('faa-promo-banner');
                    if (banner) {
                        banner.style.transition = 'opacity .25s ease, transform .25s ease';
                        banner.style.opacity    = '0';
                        banner.style.transform  = 'translateY(-6px)';
                        setTimeout(function() { banner.remove(); }, 260);
                    }
                    var fd = new FormData();
                    fd.append('action', 'faa_dismiss_promo_banner');
                    fd.append('nonce',  '<?php echo esc_js( $dismiss_nonce ); ?>');
                    fetch('<?php echo esc_url( $ajax_url ); ?>', {
                        method: 'POST',
                        credentials: 'same-origin',
                        body: fd
                    });
                });
            })();
            </script>
            <?php
        }

        /* ------------------------------------------------------------------ */
        /*  Render Single Banner (Design 5)                                   */
        /* ------------------------------------------------------------------ */

        public function render(): void {
            if ( $this->should_skip() ) { return; }

            $coupon_url = esc_url( self::COUPON_URL );
            $icon_url   = esc_url( AFAQ_DIR_URL . 'assets/images/promo-icon.svg' );
            ?>
            <div id="faa-promo-banner" class="notice faa-promo-notice">

                <!-- Left Asymmetric Brand Ribbon -->
                <div class="faa-brand-ribbon">
                    <img src="<?php echo esc_url( $icon_url ); ?>" alt="<?php esc_attr_e( 'Awesome FAQ', 'faq-and-answers' ); ?>" />
                    <span class="faa-ribbon-title">Awesome FAQ</span>
                </div>

                <!-- Main Content Zone -->
                <div class="faa-content-zone">
                    <div class="faa-text-stack">
                        <div class="faa-headline">
                            <span><?php esc_html_e( 'Awesome FAQ Biggest Black Friday Sale is Live – Up to 45% OFF!', 'faq-and-answers' ); ?></span>
                        </div>
                        <div class="faa-subheadline">
                            <span><?php esc_html_e( 'Upgrade to Awesome FAQ Pro at an exclusive Black Friday price! Unlock AI-powered FAQ generation, WooCommerce product FAQs and advanced analytics!', 'faq-and-answers' ); ?></span>
                        </div>
                        <div class="faa-feature-chips">
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( 'AI-Powered FAQ Generation', 'faq-and-answers' ); ?></span>
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( 'WooCommerce Product FAQs', 'faq-and-answers' ); ?></span>
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( 'Nested & Bento FAQ Layouts', 'faq-and-answers' ); ?></span>
                            <span><strong class="check-icon">✓</strong> <?php esc_html_e( 'Analytics & Form Submissions', 'faq-and-answers' ); ?></span>
                        </div>
                    </div>

                    <!-- CTA Button -->
                    <a href="<?php echo esc_url( $coupon_url ); ?>" target="_blank" rel="noopener noreferrer" class="faa-btn-cta">
                        <?php esc_html_e( 'Unlock PRO Features →', 'faq-and-answers' ); ?>
                    </a>
                </div>

                <!-- Dismiss Button -->
                <button id="faa-banner-close"
                        class="faa-banner-dismiss-btn"
                        title="<?php esc_attr_e( 'Dismiss', 'faq-and-answers' ); ?>"
                        aria-label="<?php esc_attr_e( 'Dismiss banner', 'faq-and-answers' ); ?>">
                    &times;
                </button>

            </div>
            <?php
        }

        /* ------------------------------------------------------------------ */
        /*  AJAX Handler: Permanent Dismissal                                 */
        /* ------------------------------------------------------------------ */

        public function ajax_dismiss(): void {
            check_ajax_referer( 'faa_dismiss_promo', 'nonce' );
            update_user_meta( get_current_user_id(), self::DISMISSED_KEY, 1 );
            wp_send_json_success();
        }
    }

    new FAA_PromoBanner();
}

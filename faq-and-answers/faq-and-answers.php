<?php

/**
 * Plugin Name: Awesome FAQ – Modern Accordion, Tabs, Responsive & Super Fast FAQ Builder
 * Description: Create responsive, customizable FAQ sections with ready-made templates.Perfect for boosting clarity, trust, and user experience on any page. 
 * Version: 2.3.0
 * Author: bPlugins
 * Author URI: https://bplugins.com 
 * License: GPLv3 or later
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Text Domain: faq-and-answers
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( function_exists( 'faa_fs' ) ) {
    faa_fs()->set_basename( false, __FILE__ );
} else {
    define( 'AFAQ_VERSION', ( isset( $_SERVER['HTTP_HOST'] ) && 'localhost' === $_SERVER['HTTP_HOST'] ? time() : '2.3.0' ) );
    define( 'AFAQ_DIR_URL', plugin_dir_url( __FILE__ ) );
    define( 'AFAQ_DIR_PATH', plugin_dir_path( __FILE__ ) );
    define( 'AFAQ_HAS_PRO', file_exists( AFAQ_DIR_PATH . 'vendor/freemius/start.php' ) );
    if ( !function_exists( 'faa_fs' ) ) {
        function faa_fs() {
            global $faa_fs;
            if ( !isset( $faa_fs ) ) {
                $fsLitePath = AFAQ_DIR_PATH . 'vendor/freemius-lite/start.php';
                $fsPath = AFAQ_DIR_PATH . 'vendor/freemius/start.php';
                if ( AFAQ_HAS_PRO && file_exists( $fsPath ) ) {
                    require_once $fsPath;
                } else {
                    require_once $fsLitePath;
                }
                $config = array(
                    'id'                  => '21319',
                    'slug'                => 'faq-and-answers',
                    'premium_slug'        => 'faq-and-answers-pro',
                    'type'                => 'plugin',
                    'public_key'          => 'pk_2d82b77e5ff183b2a656c04d19840',
                    'is_premium'          => false,
                    'premium_suffix'      => 'Pro',
                    'has_premium_version' => true,
                    'has_addons'          => false,
                    'has_paid_plans'      => true,
                    'menu'                => array(
                        'slug'       => 'edit.php?post_type=faq_cpt',
                        'first-path' => 'edit.php?post_type=faq_cpt&page=faq_Dashboard',
                        'support'    => false,
                    ),
                );
                $faa_fs = ( AFAQ_HAS_PRO && file_exists( $fsPath ) ? fs_dynamic_init( $config ) : fs_lite_dynamic_init( $config ) );
            }
            return $faa_fs;
        }

        faa_fs();
        do_action( 'faa_fs_loaded' );
    }
    require_once AFAQ_DIR_PATH . 'includes/class_faaPlugin.php';
    new FaaPlugin();
    if ( AFAQ_HAS_PRO ) {
        require_once AFAQ_DIR_PATH . 'includes/LicenseActivation.php';
    }
    add_action( 'plugins_loaded', 'afaq_load_woocommerce_addon', 20 );
    function afaq_load_woocommerce_addon() {
        if ( !class_exists( 'WooCommerce' ) ) {
            return;
        }
        if ( !function_exists( 'faa_is_premium' ) || !faa_is_premium() ) {
            return;
        }
        if ( !defined( 'AFAQ_WP7_AI_AVAILABLE' ) ) {
            define( 'AFAQ_WP7_AI_AVAILABLE', function_exists( 'wp_ai_client_prompt' ) );
        }
        $wc_addon = AFAQ_DIR_PATH . 'woocommerce/class-afaq-woocommerce.php';
        if ( file_exists( $wc_addon ) ) {
            require_once $wc_addon;
            new AFAQ_WooCommerce();
        }
    }

}
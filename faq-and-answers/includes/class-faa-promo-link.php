<?php
/**
 * Promotional Link in Installed Plugins List
 *
 * This file handles the promotional / discount link shown under the plugin name
 * in the WordPress "Installed Plugins" list (wp-admin/plugins.php).
 *
 * To update for future campaigns (e.g. BFCM, New Year, Summer Sale):
 * - Change EXPIRATION_DATE (e.g. '2026-12-05 23:59:59')
 * - Change PROMO_URL (campaign landing page)
 * - Change PROMO_TEXT (discount text)
 * - Change PROMO_COLOR (text color)
 * - Set ENABLED to false to turn off anytime
 *
 * @package Awesome_FAQ
 */

namespace AwesomeFAQ\Admin;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( __NAMESPACE__ . '\FAA_PromoLink' ) ) {

	class FAA_PromoLink {

		/**
		 * ==============================================================
		 * CAMPAIGN CONFIGURATION (Easily edit here for future campaigns)
		 * ==============================================================
		 */

		/** Set to false to disable this promo link anytime */
		const ENABLED = true;

		/** Expiration date: Link will automatically stop showing after this date & time */
		const EXPIRATION_DATE = '2026-12-05 23:59:59';

		/** Landing page link with campaign parameters */
		const PROMO_URL = 'https://bplugins.com/products/faq-and-answers/pricing/?utm_source=admin&utm_medium=plugins&utm_campaign=bfcm2026';

		/** Promotional link text */
		const PROMO_TEXT = 'Black Friday Sale – Up to 45% OFF!';

		/** Highlight color matching promotional style */
		const PROMO_COLOR = '#ff7a00';

		/** Basename of this free plugin */
		private string $plugin_basename = '';

		public function __construct() {
			// 1. Hook specifically into this plugin's action links
			$this->plugin_basename = defined( 'AFAQ_PLUGIN_BASENAME' )
				? AFAQ_PLUGIN_BASENAME
				: ( defined( 'AFAQ_FILE' ) ? plugin_basename( AFAQ_FILE ) : plugin_basename( dirname( __DIR__ ) . '/faq-and-answers.php' ) );

			$normalized_basename = function_exists( 'wp_normalize_path' )
				? wp_normalize_path( $this->plugin_basename )
				: str_replace( '\\', '/', $this->plugin_basename );

			add_filter( 'plugin_action_links_' . $this->plugin_basename, [ $this, 'add_promo_action_link' ], 99 );
			add_filter( 'network_admin_plugin_action_links_' . $this->plugin_basename, [ $this, 'add_promo_action_link' ], 99 );

			if ( $normalized_basename !== $this->plugin_basename ) {
				add_filter( 'plugin_action_links_' . $normalized_basename, [ $this, 'add_promo_action_link' ], 99 );
				add_filter( 'network_admin_plugin_action_links_' . $normalized_basename, [ $this, 'add_promo_action_link' ], 99 );
			}

			// 2. Generic fallback hook to guarantee it matches this free plugin
			add_filter( 'plugin_action_links', [ $this, 'filter_generic_action_links' ], 99, 4 );
			add_filter( 'network_admin_plugin_action_links', [ $this, 'filter_generic_action_links' ], 99, 4 );
		}

		/**
		 * Check if promotion is currently active
		 *
		 * @return bool
		 */
		public function is_promo_active(): bool {
			if ( ! self::ENABLED ) {
				return false;
			}

			// Hide when Pro is active (Free version only!)
			if ( function_exists( 'faa_is_premium' ) && faa_is_premium() ) {
				return false;
			}
			if ( defined( 'FAA_PRO_ACTIVE' ) && FAA_PRO_ACTIVE ) {
				return false;
			}
			if ( function_exists( 'is_plugin_active' ) && ( is_plugin_active( 'faq-and-answers-pro/faq-and-answers.php' ) || is_plugin_active( 'faq-and-answers-pro/plugin.php' ) || is_plugin_active( 'faq-and-answers-pro/index.php' ) ) ) {
				return false;
			}

			// Expiration check: Automatically stops showing after December 5, 2026
			if ( ! empty( self::EXPIRATION_DATE ) ) {
				$expiry_timestamp = strtotime( self::EXPIRATION_DATE );
				$current_time     = time();

				if ( $expiry_timestamp && $current_time > $expiry_timestamp ) {
					return false;
				}
			}

			return true;
		}

		/**
		 * Build promo link HTML
		 *
		 * @return string
		 */
		private function get_promo_html(): string {
			return sprintf(
				'<a href="%1$s" target="_blank" rel="noopener noreferrer" style="color: %2$s; font-weight: bold;">%3$s</a>',
				esc_url( self::PROMO_URL ),
				esc_attr( self::PROMO_COLOR ),
				esc_html__( 'Black Friday Sale – Up to 45% OFF!', 'faq-and-answers' )
			);
		}

		/**
		 * Add promotional link to the specific plugin action links row
		 *
		 * @param array $links Existing plugin row action links.
		 * @return array
		 */
		public function add_promo_action_link( $links ): array {
			if ( ! is_array( $links ) ) {
				$links = [];
			}

			if ( ! $this->is_promo_active() ) {
				return $links;
			}

			if ( ! isset( $links['faa_bfcm_promo'] ) ) {
				$links['faa_bfcm_promo'] = $this->get_promo_html();
			}

			return $links;
		}

		/**
		 * Fallback filter: Inspects plugin rows and appends promo link ONLY for this Free plugin
		 *
		 * @param array  $actions     Current action links.
		 * @param string $plugin_file Current plugin basename (e.g. faq-and-answers/faq-and-answers.php).
		 * @param array  $plugin_data Plugin metadata.
		 * @param string $context     Plugin context.
		 * @return array
		 */
		public function filter_generic_action_links( $actions, $plugin_file = '', $plugin_data = null, $context = null ): array {
			if ( ! is_array( $actions ) ) {
				$actions = [];
			}

			if ( ! $this->is_promo_active() ) {
				return $actions;
			}

			// If already added, don't duplicate
			if ( isset( $actions['faa_bfcm_promo'] ) ) {
				return $actions;
			}

			// 1. NEVER add to the Pro / Premium plugin row!
			$plugin_name = $plugin_data['Name'] ?? '';
			if (
				false !== strpos( $plugin_name, ' Pro' ) ||
				false !== strpos( (string) $plugin_file, '-pro/' )
			) {
				return $actions;
			}

			// 2. Only add to THIS free plugin row
			$file_normalized = function_exists( 'wp_normalize_path' )
				? wp_normalize_path( (string) $plugin_file )
				: str_replace( '\\', '/', (string) $plugin_file );

			$basename_normalized = function_exists( 'wp_normalize_path' )
				? wp_normalize_path( $this->plugin_basename )
				: str_replace( '\\', '/', $this->plugin_basename );

			if (
				$file_normalized === $basename_normalized ||
				'faq-and-answers/faq-and-answers.php' === $file_normalized ||
				( ! empty( $plugin_data['TextDomain'] ) && 'faq-and-answers' === $plugin_data['TextDomain'] )
			) {
				$actions['faa_bfcm_promo'] = $this->get_promo_html();
			}

			return $actions;
		}
	}

	new FAA_PromoLink();
}

<?php
if (!defined('ABSPATH')) {
	exit;
}

/**
 * "Duplicate" on the Awesome FAQ list: copies a shortcode FAQ — its blocks,
 * design, settings and terms — into a new draft, so a finished FAQ can be
 * reused as the starting point for the next one.
 *
 * The content is copied as it is. faqId and faqTitle need no fixing: the
 * [faq] shortcode sets both from the post being shown every time it renders,
 * so analytics for the copy are filed under the copy.
 */
if (!class_exists('AFAQ_Duplicate')) {
	class AFAQ_Duplicate
	{
		const POST_TYPE = 'faq_cpt';
		const ACTION    = 'afaq_duplicate';

		/** Meta that belongs to the original post only. */
		const SKIP_META = ['_edit_lock', '_edit_last', '_wp_old_slug', '_wp_old_date', '_wp_trash_meta_status', '_wp_trash_meta_time'];

		public function __construct()
		{
			add_filter('post_row_actions', [$this, 'row_action'], 10, 2);
			add_action('admin_action_' . self::ACTION, [$this, 'duplicate']);
			add_action('admin_notices', [$this, 'notice']);
		}

		/** The link, placed straight after Quick Edit. */
		public function row_action($actions, $post)
		{
			if (self::POST_TYPE !== $post->post_type || 'trash' === $post->post_status || !current_user_can('edit_post', $post->ID)) {
				return $actions;
			}

			$url  = wp_nonce_url(admin_url('admin.php?action=' . self::ACTION . '&post=' . $post->ID), self::ACTION . '_' . $post->ID);
			/* translators: %s: FAQ title */
			$label = sprintf(__('Duplicate “%s”', 'faq-and-answers'), get_the_title($post));
			$link  = '<a href="' . esc_url($url) . '" aria-label="' . esc_attr($label) . '">' . esc_html__('Duplicate', 'faq-and-answers') . '</a>';

			$out = [];

			foreach ($actions as $key => $html) {
				$out[$key] = $html;

				if ('inline hide-if-no-js' === $key) {
					$out['afaq_duplicate'] = $link;
				}
			}

			// No Quick Edit on this row: add it at the end.
			if (!isset($out['afaq_duplicate'])) {
				$out['afaq_duplicate'] = $link;
			}

			return $out;
		}

		public function duplicate()
		{
			$source_id = isset($_GET['post']) ? absint($_GET['post']) : 0;

			check_admin_referer(self::ACTION . '_' . $source_id);

			$source = $source_id ? get_post($source_id) : null;
			$type   = get_post_type_object(self::POST_TYPE);

			if (!$source || self::POST_TYPE !== $source->post_type) {
				wp_die(esc_html__('This FAQ could not be found.', 'faq-and-answers'), '', ['response' => 404, 'back_link' => true]);
			}

			// Reading the original and creating a new FAQ are both needed.
			if (!current_user_can('edit_post', $source->ID) || !$type || !current_user_can($type->cap->create_posts)) {
				wp_die(esc_html__('You are not allowed to duplicate this FAQ.', 'faq-and-answers'), '', ['response' => 403, 'back_link' => true]);
			}

			// wp_insert_post() unslashes its input, so the content goes in
			// slashed, or escapes inside block attributes (\n, –) are lost.
			$new_id = wp_insert_post(wp_slash([
				'post_type'      => self::POST_TYPE,
				'post_status'    => 'draft',
				'post_author'    => get_current_user_id(),
				/* translators: %s: original FAQ title */
				'post_title'     => sprintf(__('%s (Copy)', 'faq-and-answers'), $source->post_title),
				'post_content'   => $source->post_content,
				'post_excerpt'   => $source->post_excerpt,
				'post_parent'    => $source->post_parent,
				'menu_order'     => $source->menu_order,
				'comment_status' => $source->comment_status,
				'ping_status'    => $source->ping_status,
			]), true);

			if (is_wp_error($new_id)) {
				wp_die(esc_html($new_id->get_error_message()), '', ['response' => 500, 'back_link' => true]);
			}

			foreach (get_post_meta($source->ID) as $key => $values) {
				if (in_array($key, self::SKIP_META, true)) {
					continue;
				}

				foreach ($values as $value) {
					add_post_meta($new_id, $key, wp_slash(maybe_unserialize($value)));
				}
			}

			foreach (get_object_taxonomies(self::POST_TYPE) as $taxonomy) {
				$terms = wp_get_object_terms($source->ID, $taxonomy, ['fields' => 'ids']);

				if (!is_wp_error($terms) && $terms) {
					wp_set_object_terms($new_id, $terms, $taxonomy);
				}
			}

			wp_safe_redirect(add_query_arg(['post_type' => self::POST_TYPE, 'afaq_duplicated' => $new_id], admin_url('edit.php')));
			exit;
		}

		public function notice()
		{
			$screen = function_exists('get_current_screen') ? get_current_screen() : null;

			if (!$screen || 'edit-' . self::POST_TYPE !== $screen->id || empty($_GET['afaq_duplicated'])) {
				return;
			}

			$new_id = absint($_GET['afaq_duplicated']);

			if (!$new_id || !current_user_can('edit_post', $new_id)) {
				return;
			}

			printf(
				'<div class="notice notice-success is-dismissible"><p>%s <a href="%s">%s</a></p></div>',
				esc_html__('FAQ duplicated as a draft.', 'faq-and-answers'),
				esc_url(get_edit_post_link($new_id)),
				esc_html__('Edit the copy', 'faq-and-answers')
			);
		}
	}
}

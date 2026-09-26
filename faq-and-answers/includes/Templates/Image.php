<?php
namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class Image
{
	private $already_imported_ids = array();

	private static $instance = null;

	public function __construct()
	{
	}

	public function maybe_import_images($content)
	{
		preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match);

		$all_links = array_unique($match[0]);

		if (empty($all_links)) {
			return $content;
		}

		$link_mapping = array();
		$image_links = array();
		$other_links = array();

		foreach ($all_links as $key => $link) {
			if ($this->is_valid_image($link)) {

				if (
					false === strpos($link, '-150x') &&
					false === strpos($link, '-300x') &&
					false === strpos($link, '-1024x')
				) {
					$image_links[] = $link;
				}
			} else {
				$other_links[] = $link;
			}
		}

		if (!empty($image_links)) {
			foreach ($image_links as $key => $image_url) {
				$image = array(
					'url' => $image_url,
					'id' => 0,
				);
				$downloaded_image = $this->import($image);

				$link_mapping[$image_url] = $downloaded_image['url'];
			}
		}

		foreach ($link_mapping as $old_url => $new_url) {
			$old_url = (string) $old_url;
			$content = str_replace($old_url, $new_url, $content);

			$old_url = str_replace('/', '/\\', $old_url);
			$new_url = str_replace('/', '/\\', $new_url);
			$content = str_replace($old_url, $new_url, $content);
		}
		return $content;
	}

	private function get_saved_image($attachment)
	{

		global $wpdb;

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Custom image hash metadata lookup.
		$post_id = $wpdb->get_var($wpdb->prepare('SELECT `post_id` FROM `' . $wpdb->postmeta . '` WHERE `meta_key` = \'_afaq_templates_image_hash\' AND `meta_value` = %s;', $this->get_hash_image($attachment['url'])));

		if (empty($post_id)) {
			$filename = basename($attachment['url']);
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching -- Media library attachment file path lookup.
			$post_id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key = '_wp_attached_file' AND meta_value LIKE %s", '%/' . $wpdb->esc_like($filename) . '%'));
		}

		if ($post_id) {
			$new_attachment = array(
				'id' => $post_id,
				'url' => wp_get_attachment_url($post_id),
			);
			$this->already_imported_ids[] = $post_id;

			return array(
				'status' => true,
				'attachment' => $new_attachment,
			);
		}

		return array(
			'status' => false,
			'attachment' => $attachment,
		);
	}

	public function import($attachment)
	{

		$saved_image = $this->get_saved_image($attachment);

		if ($saved_image['status']) {
			return $saved_image['attachment'];
		}

		$filename = basename($attachment['url']);

		if (isset($attachment['engine']) && 'unsplash' === $attachment['engine']) {
			$filename = 'unsplash-photo-' . $attachment['id'] . '.jpg';
		}

		$file_content = wp_remote_retrieve_body(
			wp_safe_remote_get(
				$attachment['url'],
				array(
					'timeout' => '60',
				)
			)
		);

		if (empty($file_content)) {
			return $attachment;
		}

		$upload = wp_upload_bits($filename, null, $file_content);

		// wp_upload_bits() answers with ['error' => …] and no 'file' key when
		// it refuses the write — a full disk, an unwritable uploads folder, or
		// a name whose extension the site does not allow. Reading $upload['file']
		// straight afterwards turned that into a notice and an attachment row
		// pointing at nothing.
		if (!empty($upload['error']) || empty($upload['file'])) {
			return $attachment;
		}

		// What was downloaded has to be an image, not merely named like one.
		// The URL came out of template markup, so its extension is the sender's
		// claim about the file; wp_getimagesize() reads the bytes instead.
		if (false === wp_getimagesize($upload['file'])) {
			wp_delete_file($upload['file']);

			return $attachment;
		}

		$info = wp_check_filetype($upload['file']);

		if (empty($info['type']) || 0 !== strpos($info['type'], 'image/')) {
			wp_delete_file($upload['file']);

			return $attachment;
		}

		$post = array(
			'post_title' => $filename,
			'guid' => $upload['url'],
			'post_mime_type' => $info['type'],
		);

		if (!function_exists('wp_generate_attachment_metadata')) {
			include ABSPATH . 'wp-admin/includes/image.php';
		}

		$post_id = wp_insert_attachment($post, $upload['file']);
		wp_update_attachment_metadata(
			$post_id,
			wp_generate_attachment_metadata($post_id, $upload['file'])
		);
		update_post_meta($post_id, '_afaq_templates_image_hash', $this->get_hash_image($attachment['url']));

		$new_attachment = array(
			'id' => $post_id,
			'url' => $upload['url'],
		);

		$this->already_imported_ids[] = $post_id;

		return $new_attachment;
	}

	public function get_hash_image($attachment_url)
	{
		return sha1($attachment_url);
	}

	public static function instance()
	{
		if (null === self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	public function is_valid_image($link = '')
	{
		return preg_match('/^((https?:\/\/)|(www\.))([a-z0-9-].?)+(:[0-9]+)?\/[\w\-]+\.(jpg|png|gif|jpeg)\/?$/i', $link);
	}
}

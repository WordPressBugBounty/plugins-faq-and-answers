<?php
/**
 * Template library — the endpoints behind the editor's Template Library button.
 *
 * Two sources, one contract. The templates that ship with the plugin are
 * answered from PHP (see BuiltIn), and anything published for this plugin on
 * the template server is appended after them. The library UI reads both through
 * the same shape and does not need to know which is which — so the built-ins
 * work offline and on day one, and remote templates arrive without a release.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

require_once AFAQ_DIR_PATH . 'includes/Templates/Image.php';
require_once AFAQ_DIR_PATH . 'includes/Templates/BuiltIn.php';

class Templates {

	/** The slug this plugin's templates are published under on the server. */
	const REMOTE_PLUGIN = 'faq-and-answers';

	/** Where the shared template server lives. */
	const REMOTE_ROOT = 'https://templates.bplugins.com/wp-json/gutenberg-templates/v1';

	/** Nonce action shared by every endpoint here. */
	const NONCE = 'afaq_template';

	/** How long a remote answer is reused before it is asked for again. */
	const CACHE_TTL = 6 * HOUR_IN_SECONDS;

	public function __construct() {
		add_action('enqueue_block_editor_assets', [$this, 'enqueue']);
		add_action('wp_ajax_afaq_templates_main', [$this, 'templates_main']);
		add_action('wp_ajax_afaq_templates', [$this, 'templates']);
		add_action('wp_ajax_afaq_template_import', [$this, 'template_import']);
		add_action('wp_ajax_afaq_template_counts', [$this, 'template_counts']);
		add_action('wp_ajax_afaq_template_favorites', [$this, 'template_favorites']);
	}

	/**
	 * The Template Library button, in the editor.
	 *
	 * The bundle only exists once bpl-tools ships the shared TemplateLibrary
	 * component — webpack.config.js leaves the entry out until then — so this
	 * checks for the built file rather than assuming it. The endpoints above
	 * work either way, which is what lets the front of it be added later.
	 *
	 * @return void
	 */
	public function enqueue() {
		if (!current_user_can('edit_posts')) {
			return;
		}

		$asset_path = AFAQ_DIR_PATH . 'build/template-library.asset.php';

		if (!file_exists($asset_path)) {
			return;
		}

		$asset = include $asset_path;

		wp_enqueue_script(
			'faa-template-library',
			AFAQ_DIR_URL . 'build/template-library.js',
			// wp-util is added by hand: the library talks to these endpoints
			// through wp.ajax, and @wordpress/scripts only detects @wordpress/*
			// imports when it writes the dependency list. Without it the shared
			// component logs "Please use wp-util as a dependency" and stops.
			array_merge($asset['dependencies'], ['wp-util']),
			$asset['version'],
			true
		);

		if (file_exists(AFAQ_DIR_PATH . 'build/template-library.css')) {
			wp_enqueue_style(
				'faa-template-library',
				AFAQ_DIR_URL . 'build/template-library.css',
				[],
				$asset['version']
			);
		}

		// One object on `window`, not two `const` declarations.
		//
		// Every block's editor script already prints `const scdIsPipeChecker`,
		// and classic scripts share a single global lexical scope — so a second
		// `const` of that name throws "Identifier has already been declared" and
		// takes the whole inline block down with it. The blocks get away with it
		// because each redeclaration sits alone in its own tag; anything sharing
		// a tag with it, such as the nonce, would simply never be defined, and
		// every request would then fail its nonce check with nothing to show for
		// it. A property assignment cannot collide and cannot throw.
		wp_add_inline_script(
			'faa-template-library',
			'window.afaqTemplateLibrary = ' . wp_json_encode(
				[
					'nonce'     => wp_create_nonce(self::NONCE),
					'isPremium' => function_exists('faa_is_premium') && faa_is_premium(),
				]
			) . ';',
			'before'
		);

		wp_set_script_translations('faa-template-library', 'faq-and-answers', AFAQ_DIR_PATH . 'languages');
	}

	/**
	 * Nonce and capability, checked the same way by every endpoint.
	 *
	 * Ends the request itself when either fails, so a caller that returns from
	 * this has already passed both.
	 *
	 * @return void
	 */
	private function guard() {
		$nonce = sanitize_text_field(wp_unslash($_POST['_wpnonce'] ?? ''));

		if (!wp_verify_nonce($nonce, self::NONCE)) {
			wp_send_json_error('Invalid Request');
		}

		if (!current_user_can('edit_posts')) {
			wp_send_json_error('Insufficient Permissions');
		}
	}

	/**
	 * @return string patterns|pages
	 */
	private function requested_type() {
		$type = sanitize_key(wp_unslash($_POST['type'] ?? 'patterns')); // phpcs:ignore WordPress.Security.NonceVerification.Missing -- guard() runs first in every caller.

		return 'pages' === $type ? 'pages' : 'patterns';
	}

	/**
	 * A GET against the template server, cached.
	 *
	 * The answer changes rarely and the editor asks for it on every open, so
	 * without this the library would wait on a round trip each time — and every
	 * failure would be paid for again immediately.
	 *
	 * @param string $path  Path under REMOTE_ROOT.
	 * @param array  $query Query arguments.
	 * @return object|array|null Decoded body, or null when the server could not be reached.
	 */
	private function remote($path, array $query = []) {
		$url = add_query_arg($query, self::REMOTE_ROOT . '/' . ltrim($path, '/'));
		$key = 'afaq_tpl_' . md5($url);

		$cached = get_transient($key);

		if (false !== $cached) {
			return $cached;
		}

		$response = wp_remote_get($url, ['timeout' => 12]);

		if (is_wp_error($response) || 200 !== (int) wp_remote_retrieve_response_code($response)) {
			// Remembered briefly so a server that is down is not asked again on
			// every keystroke, but not so long that a fix goes unnoticed.
			set_transient($key, null, MINUTE_IN_SECONDS * 5);

			return null;
		}

		$body = json_decode(wp_remote_retrieve_body($response));

		set_transient($key, $body, self::CACHE_TTL);

		return $body;
	}

	/* --------------------------------------------------------- endpoints */

	/**
	 * The category list for the sidebar.
	 *
	 * @return void
	 */
	public function templates_main() {
		$this->guard();

		$type        = $this->requested_type();
		$taxonomy    = 'patterns' === $type ? 'patterns-category' : 'pages-category';
		$categories  = 'patterns' === $type ? BuiltIn::categories() : [];
		$known_slugs = wp_list_pluck($categories, 'name');

		$body = $this->remote("taxonomy/taxonomies/plugin,type,{$taxonomy}");

		if ($body && isset($body->{$taxonomy}) && is_array($body->{$taxonomy})) {
			$remote_slugs = $this->remote_category_slugs($type);

			foreach ($body->{$taxonomy} as $category) {
				// Only categories that actually hold a template for this plugin,
				// and never a second copy of one the built-ins already offer.
				if (!isset($category->name) || in_array($category->name, $known_slugs, true) || !in_array($category->name, $remote_slugs, true)) {
					continue;
				}

				$categories[]  = $category;
				$known_slugs[] = $category->name;
			}
		}

		wp_send_json_success(
			(object) [
				$taxonomy => $categories,
				'source'  => $body ? 'built-in+remote' : 'built-in',
			]
		);
	}

	/**
	 * Which categories the server actually has templates in, for this plugin.
	 *
	 * @param string $type
	 * @return array
	 */
	private function remote_category_slugs($type) {
		$body = $this->remote(
			'blocks',
			[
				'type'   => $type,
				'plugin' => self::REMOTE_PLUGIN,
				'fields' => 'category',
				'start'  => 0,
				'end'    => 10000,
				'limit'  => 1000,
			]
		);

		if (!$body || !isset($body->patterns) || !is_array($body->patterns)) {
			return [];
		}

		$slugs = [];

		foreach ($body->patterns as $pattern) {
			if (isset($pattern->category) && is_array($pattern->category)) {
				$slugs = array_merge($slugs, $pattern->category);
			}
		}

		return array_values(array_unique($slugs));
	}

	/**
	 * One page of templates.
	 *
	 * The built-ins are answered on the first page only, and the remote list
	 * carries on paging beneath them. Interleaving two paginations properly
	 * would mean holding the whole remote catalogue in memory to sort it, which
	 * is a lot of work to reorder five cards.
	 *
	 * @return void
	 */
	public function templates() {
		$this->guard();

		$type     = $this->requested_type();
		$category = sanitize_text_field(wp_unslash($_POST['category'] ?? 'all'));
		$page     = max(1, absint(wp_unslash($_POST['pageNumber'] ?? 1)));
		$per_page = max(1, absint(wp_unslash($_POST['perPage'] ?? 12)));
		$search   = sanitize_text_field(wp_unslash($_POST['search'] ?? ''));

		$all_builtin = BuiltIn::query($type, $category, $search);
		$offset      = ($page - 1) * $per_page;
		$patterns    = array_slice($all_builtin, $offset, $per_page);

		$body = $this->remote(
			'blocks',
			[
				'type'     => $type,
				'start'    => $page - 1,
				'end'      => $page,
				'limit'    => $per_page,
				'plugin'   => self::REMOTE_PLUGIN,
				'category' => $category,
				'keywords' => $search,
				'fields'   => 'ID,category,keywords,original_content,thumbnail,title,type,url,preview_url',
			]
		);

		if ($body && isset($body->patterns) && is_array($body->patterns)) {
			$patterns = array_merge($patterns, $body->patterns);
		}

		$total = '' !== $search ? count($all_builtin) : $this->total_for($type, $category);

		// `count` is how many there are altogether, not how many are in this
		// page — the library divides it by the page size to decide whether to
		// offer Load More.
		wp_send_json_success(
			(object) [
				'patterns' => $patterns,
				'count'    => $total,
			]
		);
	}

	/**
	 * How many templates match a category, across both sources.
	 *
	 * @param string $type
	 * @param string $category
	 * @return int
	 */
	private function total_for($type, $category) {
		$counts = $this->all_counts($type);

		if ('' === $category || 'all' === $category) {
			return (int) $counts['all'];
		}

		if ('free' === $category || 'pro' === $category) {
			return (int) $counts[$category];
		}

		return (int) ($counts['categories'][$category]['total'] ?? 0);
	}

	/**
	 * How many templates there are, free and pro, overall and per category.
	 *
	 * @return void
	 */
	public function template_counts() {
		$this->guard();

		wp_send_json_success($this->all_counts($this->requested_type()));
	}

	/**
	 * Free and pro totals across both sources, overall and per category.
	 *
	 * Shared by the counts endpoint and by the template list, which needs the
	 * same figure to know whether there is another page to offer.
	 *
	 * @param string $type
	 * @return array
	 */
	private function all_counts($type) {
		$counts = 'patterns' === $type ? BuiltIn::counts() : ['all' => 0, 'free' => 0, 'pro' => 0, 'categories' => []];

		$body = $this->remote(
			'blocks',
			[
				'type'   => $type,
				'plugin' => self::REMOTE_PLUGIN,
				'fields' => 'ID,category',
				'limit'  => 10000,
				'start'  => 0,
				'end'    => 10000,
			]
		);

		if ($body && isset($body->patterns) && is_array($body->patterns)) {
			foreach ($body->patterns as $template) {
				$categories = isset($template->category) && is_array($template->category) ? $template->category : [];
				$is_pro     = in_array('pro', $categories, true);

				$counts['all']++;
				$counts[$is_pro ? 'pro' : 'free']++;

				foreach ($categories as $slug) {
					if ('free' === $slug || 'pro' === $slug) {
						continue;
					}

					if (!isset($counts['categories'][$slug])) {
						$counts['categories'][$slug] = ['total' => 0, 'free' => 0, 'pro' => 0];
					}

					$counts['categories'][$slug]['total']++;
					$counts['categories'][$slug][$is_pro ? 'pro' : 'free']++;
				}
			}
		}

		return $counts;
	}

	/**
	 * Turn a template's markup into something ready to insert.
	 *
	 * @return void
	 */
	public function template_import() {
		$this->guard();

		try {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- serialized block markup: kses strips HTML comments, which are the block delimiters, so sanitizing here would break every template. Gated by the nonce and capability checks in guard().
			$content = wp_unslash($_POST['original_content'] ?? '');

			// Sideloading copies the template's images into the media library, so
			// it is limited to users who may upload. Everyone else gets the
			// markup with its original image URLs, which still renders.
			$data = current_user_can('upload_files') ? Image::instance()->maybe_import_images($content) : $content;

			wp_send_json_success($data);
		} catch (\Throwable $th) {
			wp_send_json_error($th->getMessage());
		}
	}

	/**
	 * Read, and optionally write, this site's favourite templates.
	 *
	 * @return void
	 */
	public function template_favorites() {
		$this->guard();

		$prefix     = sanitize_key(wp_unslash($_POST['prefix'] ?? 'afaq'));
		$option_key = $prefix . 'FavoritesTemplates';

		if (isset($_POST['favorites'])) {
			// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- a JSON string, and every decoded value is hard-cast through absint() below.
			$raw = json_decode(wp_unslash($_POST['favorites']), true);

			update_option(
				$option_key,
				[
					'patterns' => array_values(array_unique(array_map('absint', (array) ($raw['patterns'] ?? [])))),
					'pages'    => array_values(array_unique(array_map('absint', (array) ($raw['pages'] ?? [])))),
				],
				false
			);
		}

		wp_send_json_success(get_option($option_key, ['patterns' => [], 'pages' => []]));
	}
}

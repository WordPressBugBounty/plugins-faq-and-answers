<?php
/**
 * The templates that ship with the plugin.
 *
 * Fifty-five ready-made sections across fifteen categories, defined here
 * rather than fetched, so the library has something in it on a fresh install,
 * offline, and on a staging site with no route to the template server.
 *
 * Six sets. CoreSet holds the FAQ patterns every site needs — a help centre,
 * a topic switcher, troubleshooting, a glossary, steps, a checklist, a
 * timeline, a comparison, a decision tree, a grid. ShowcaseSet holds one per
 * industry, for the pages a site sells with rather than supports with. ProSet
 * holds the two-column arrangements and the blocks that need a licence.
 * SectorSet gives each industry a second, deeper template for the questions
 * that follow the pitch, and DetailSet holds the pages written after launch —
 * status, security, procurement, migration, accessibility. DesignSet holds
 * the finished looks — six sections that arrive with a palette, an icon pair
 * and their spacing already decided, rather than with the colours left to the
 * site.
 *
 * What a template is made of decides whether it needs a licence: access() reads
 * that back out of the content, so a template cannot promise an install
 * something it cannot render. A set may additionally declare
 * `'access' => 'pro'` to gate a template built entirely on free parts, which
 * only ever withholds and never over-promises.
 *
 * Everything returned matches the shape the remote template API uses, because
 * the library UI reads both through the same code path and must not care which
 * one a template came from.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

require_once AFAQ_DIR_PATH . 'includes/Templates/Parts.php';
require_once AFAQ_DIR_PATH . 'includes/Templates/CoreSet.php';
require_once AFAQ_DIR_PATH . 'includes/Templates/ShowcaseSet.php';
require_once AFAQ_DIR_PATH . 'includes/Templates/ProSet.php';
require_once AFAQ_DIR_PATH . 'includes/Templates/SectorSet.php';
require_once AFAQ_DIR_PATH . 'includes/Templates/DetailSet.php';
require_once AFAQ_DIR_PATH . 'includes/Templates/DesignSet.php';

class BuiltIn {

	/**
	 * IDs start high so they cannot collide with a template coming back from
	 * the remote server, which is what lets favourites store both in one list.
	 */
	const ID_BASE = 900000;

	/**
	 * Where the built-in templates can be seen running.
	 *
	 * Each one's demo page is this base plus its own slug, so the Live Preview
	 * link is derived rather than written down once per template — fifty-odd
	 * hand-typed URLs is fifty-odd chances to point at a 404.
	 */
	const DEMO_BASE = 'https://demo.bplugins.com/demo/faq-and-answers-';

	/**
	 * The blocks that only register for premium users.
	 *
	 * Kept in step with $premium_blocks in faq-and-answers-block.php, which is
	 * the list that actually decides what gets registered. A template built on
	 * any of these has to be marked pro, or a free install offers an import
	 * that produces an invalid block.
	 */
	const PRO_BLOCKS = [
		'faa/ask-ai',
		'faa/bento-faq',
		'faa/nested-faq',
		'faa/faq-parent',
		'faa/faq-item',
		'faa/image-faq',
		'faa/post-faq',
		'faa/sidebar-tab-faq',
		'faa/faq-form',
	];

	/**
	 * The Awesome FAQ themes that are premium.
	 *
	 * From the isPro flags in src/utils/options.js. The block itself is free, so
	 * without this a template would look free and then import as a layout the
	 * install cannot render.
	 */
	const PRO_THEMES = [
		'themeFive',
		'themeSeven',
		'themeEight',
		'themeTwelve',
		'themeFourteen',
	];

	/**
	 * The categories, in the order the sidebar should list them.
	 *
	 * The field names are the library's, not ours: `name` is the slug templates
	 * are tagged with and what the sidebar keys the active category on, `label`
	 * is what it prints, and `count` is the badge beside it. Renaming any of
	 * them shows a category with no text on it.
	 *
	 * The counts are counted, not written down. They used to be literals, and a
	 * literal is wrong the moment a template is added — worse than wrong, since
	 * the shared sidebar hides any category whose count comes through as zero.
	 *
	 * @return array
	 */
	public static function categories() {
		$counts = self::counts();
		$out    = [];
		$index  = 0;

		foreach (self::category_labels() as $slug => $label) {
			$index++;

			$out[] = [
				'id'    => self::ID_BASE + $index,
				'name'  => $slug,
				'slug'  => $slug,
				'label' => $label,
				'count' => (int) ($counts['categories'][$slug]['total'] ?? 0),
			];
		}

		return $out;
	}

	/**
	 * Slug to printed name. The three general ones first, then the industry
	 * sets alphabetically — a list this long is easier to scan sorted than
	 * grouped by something only we can see.
	 *
	 * @return array
	 */
	private static function category_labels() {
		return [
			'support'    => __('Support pages', 'faq-and-answers'),
			'onboarding' => __('Getting started', 'faq-and-answers'),
			'sales'      => __('Sales pages', 'faq-and-answers'),

			'fashion'    => __('Fashion Lookbook', 'faq-and-answers'),
			'fitness'    => __('Fitness / Diet', 'faq-and-answers'),
			'food'       => __('Food Menu', 'faq-and-answers'),
			'health'     => __('Health', 'faq-and-answers'),
			'hotel'      => __('Hotel Suites', 'faq-and-answers'),
			'features'   => __('Product Features', 'faq-and-answers'),
			'portfolio'  => __('Projects / Portfolios', 'faq-and-answers'),
			'estate'     => __('Real Estate Zones', 'faq-and-answers'),
			'services'   => __('Services', 'faq-and-answers'),
			'speakers'   => __('Speakers & Performers', 'faq-and-answers'),
			'travel'     => __('Travel Destination', 'faq-and-answers'),
			'story'      => __('Visual Storytelling', 'faq-and-answers'),
		];
	}

	/**
	 * Whether a template needs a licence.
	 *
	 * Two things decide this, and they are not symmetrical.
	 *
	 * What the template is made of is read out of the content, and that answer
	 * can only ever raise the bar. A hand-written 'free' next to a template
	 * built on Bento FAQ is a promise the plugin cannot keep: the import
	 * succeeds, the block is not registered, and the author gets an invalid
	 * block where their FAQ should be. So content built on premium parts is pro
	 * whatever the set says, and no declaration can talk it back down.
	 *
	 * A set may still declare `'access' => 'pro'` on a template made entirely of
	 * free parts. That direction is safe — it gates a template that would have
	 * rendered perfectly well, which is a commercial decision rather than a
	 * technical one, and the worst it can do is withhold something. It is the
	 * only way to put a template behind a licence without rebuilding it on
	 * blocks it does not need.
	 *
	 * Anything other than the exact string 'pro' is ignored, so a typo reads as
	 * no declaration at all rather than as a claim of being free.
	 *
	 * @param string $content  Serialised block markup.
	 * @param string $declared Optional 'pro' to gate a template built on free parts.
	 * @return string free|pro
	 */
	public static function access($content, $declared = '') {
		if ('pro' === $declared) {
			return 'pro';
		}

		foreach (self::PRO_BLOCKS as $block) {
			if (false !== strpos($content, 'wp:' . $block . ' ')) {
				return 'pro';
			}
		}

		foreach (self::PRO_THEMES as $theme) {
			if (false !== strpos($content, '"theme":"' . $theme . '"')) {
				return 'pro';
			}
		}

		return 'free';
	}

	/**
	 * Every built-in template, in the shape the library expects.
	 *
	 * The sets describe themselves with `groups`, `thumbnail` and `content`;
	 * the ID, the thumbnail URL and the free/pro tag are added here so no
	 * template has to remember to do it.
	 *
	 * @return array
	 */
	public static function templates() {
		$defined = array_merge(
			CoreSet::all(),
			ShowcaseSet::all(),
			ProSet::all(),
			SectorSet::all(),
			DetailSet::all(),
			DesignSet::all()
		);
		$out     = [];
		$index   = 0;

		foreach ($defined as $template) {
			$index++;

			$content  = $template['content'];
			$declared = isset($template['access']) ? $template['access'] : '';

			$out[] = [
				'ID'               => self::ID_BASE + 100 + $index,
				'title'            => $template['title'],
				'type'             => 'patterns',
				'category'         => array_merge($template['groups'], [self::access($content, $declared)]),
				'keywords'         => $template['keywords'],
				'thumbnail'        => Parts::thumb($template['thumbnail']),
				'preview_url'      => self::preview($template),
				'original_content' => $content,
			];
		}

		return $out;
	}

	/**
	 * The demo page for a template.
	 *
	 * The slug is the title run through sanitize_title(), so "Pricing &
	 * Objections" points at .../faq-and-answers-pricing-objections/ and a
	 * template added to a set gets a working link without anyone editing a
	 * second list. A set can override it with its own `slug` where the demo
	 * page was published under a different name.
	 *
	 * Titles are translatable, and a translated title slugifies to a page the
	 * demo site does not have, so the slug is taken before translation: `title`
	 * arrives already translated, which is why `slug` exists as the way to pin
	 * the URL on a localised install.
	 *
	 * @param array $template One entry as a set defines it.
	 * @return string Absolute URL.
	 */
	private static function preview($template) {
		$slug = isset($template['slug']) ? $template['slug'] : sanitize_title($template['title']);

		return self::DEMO_BASE . $slug . '/';
	}

	/* ----------------------------------------------------------- queries */

	/**
	 * The built-in templates a request asks for.
	 *
	 * @param string $type     patterns|pages — built-ins are all patterns.
	 * @param string $category A category slug, "all", "free" or "pro".
	 * @param string $search   Free text matched against title and keywords.
	 * @return array
	 */
	public static function query($type = 'patterns', $category = 'all', $search = '') {
		if ('patterns' !== $type) {
			return [];
		}

		$category = strtolower(trim((string) $category));
		$search   = strtolower(trim((string) $search));

		return array_values(
			array_filter(
				self::templates(),
				static function ($template) use ($category, $search) {
					if ('' !== $category && 'all' !== $category && !in_array($category, $template['category'], true)) {
						return false;
					}

					if ('' === $search) {
						return true;
					}

					$haystack = strtolower($template['title'] . ' ' . implode(' ', $template['keywords']));

					return false !== strpos($haystack, $search);
				}
			)
		);
	}

	/**
	 * Free and pro totals, overall and per category, in the shape the counts
	 * endpoint returns.
	 *
	 * @return array
	 */
	public static function counts() {
		$counts = ['all' => 0, 'free' => 0, 'pro' => 0, 'categories' => []];

		foreach (self::templates() as $template) {
			$is_pro = in_array('pro', $template['category'], true);

			$counts['all']++;
			$counts[$is_pro ? 'pro' : 'free']++;

			foreach ($template['category'] as $slug) {
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

		return $counts;
	}
}

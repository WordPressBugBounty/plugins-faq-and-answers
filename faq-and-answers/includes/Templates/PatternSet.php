<?php
/**
 * The six Pro section patterns, as ready-made templates.
 *
 * Each one is the Interactive FAQ block (faa/interactive-faq) on one of its
 * patterns (src/utils/patterns.js). They are pro because of what they are made
 * of: the block is listed in BuiltIn::PRO_BLOCKS, so access() reads the
 * licence requirement straight out of the content.
 *
 * The Styles overrides below mirror PATTERN_STYLES in patterns.js and are laid
 * over the block's defaults by Parts::styles(), so every branch Style.js
 * destructures is present. Markup in answers uses single quotes only — see
 * Parts::icons() for why a double quote would break the import.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class PatternSet {

	/**
	 * @return array
	 */
	public static function all() {
		return [
			self::team(),
			self::showcase(),
			self::services(),
			self::cases(),
			self::media(),
			self::hero(),
			self::estate(),
			self::playful(),
			self::table(),
			self::panels(),
			self::synced(),
			self::search(),
			self::chat(),
			self::media_answers(),
			// Industry use cases on the same patterns, with their own content.
			self::bank_help(),
			self::law_practice(),
			self::car_service_chat(),
			self::gym_coaches(),
			self::holiday_villas(),
			self::cooking_class(),
			self::university_programmes(),
			self::summer_camp(),
		];
	}

	/* ---------------------------------------------------------- helpers */

	private static function img($id, $w = 900) {
		return 'https://images.unsplash.com/' . $id . '?auto=format&fit=crop&w=' . (int) $w . '&q=80';
	}

	private static function item($question, $answer, array $extra = []) {
		return array_merge(['categories' => '', 'question' => $question, 'answer' => $answer], $extra);
	}

	private static function box($t, $r, $b, $l) {
		return ['top' => $t . 'px', 'right' => $r . 'px', 'bottom' => $b . 'px', 'left' => $l . 'px'];
	}

	private static function pad(array $d, array $t, array $m) {
		return ['desktop' => self::box(...$d), 'tablet' => self::box(...$t), 'mobile' => self::box(...$m)];
	}

	private static function typo($weight, array $sizes, $line, $family = 'Inter', array $extra = []) {
		return array_merge(
			[
				'fontWeight' => $weight,
				'fontSize'   => ['desktop' => $sizes[0], 'tablet' => $sizes[1], 'mobile' => $sizes[2]],
				'lineHeight' => $line,
				'fontFamily' => $family,
			],
			$extra
		);
	}

	private static function no_border($radius = '0px') {
		return ['width' => '0px', 'style' => 'solid', 'color' => '', 'side' => 'all', 'radius' => $radius];
	}

	private static function zero() {
		return self::pad([0, 0, 0, 0], [0, 0, 0, 0], [0, 0, 0, 0]);
	}

	/**
	 * The parts of a pattern's Styles that differ from the block defaults.
	 *
	 * @param string $slug patternTeam|patternShowcase|…
	 * @return array
	 */
	public static function styles($slug) {
		$clear = ['color' => 'transparent'];

		$sets = [
			'patternTeam' => [
				'container' => ['background' => ['color' => '#ffffff'], 'padding' => self::pad([48, 40, 48, 40], [36, 28, 36, 28], [24, 16, 24, 16]), 'border' => self::no_border('24px')],
				'heading'   => [
					'title'    => ['typo' => self::typo(600, [64, 48, 38], 1.05), 'textAlign' => 'left', 'colors' => ['color' => '#1c1c1c']],
					'subTitle' => ['typo' => self::typo(400, [17, 16, 15], 1.6), 'textAlign' => 'left', 'colors' => ['color' => '#3f3f46']],
				],
				'content'   => [
					'question' => ['typo' => self::typo(600, [24, 21, 19], 1.2), 'colors' => ['color' => '#ffffff'], 'background' => $clear, 'padding' => self::zero()],
					'answer'   => ['typo' => self::typo(400, [14, 14, 13], 1.55), 'colors' => ['color' => '#f4f4f5'], 'background' => $clear, 'padding' => self::zero()],
					'icon'     => ['background' => $clear, 'size' => ['desktop' => '18px', 'tablet' => null, 'mobile' => null], 'colors' => ['color' => '#1c1c1c'], 'padding' => self::zero(), 'border' => self::no_border()],
				],
			],
			'patternShowcase' => [
				'container' => ['background' => ['color' => '#f4f3ef'], 'padding' => self::pad([56, 48, 56, 48], [40, 28, 40, 28], [24, 14, 24, 14]), 'border' => self::no_border('28px')],
				'heading'   => [
					'title'    => ['typo' => self::typo(500, [40, 32, 26], 1.15), 'textAlign' => 'left', 'colors' => ['color' => '#111111']],
					'subTitle' => ['typo' => self::typo(400, [15, 15, 14], 1.6), 'textAlign' => 'left', 'colors' => ['color' => '#57534e']],
				],
				'content'   => [
					'question' => ['typo' => self::typo(400, [40, 32, 24], 1.15), 'colors' => ['color' => '#111111'], 'background' => $clear, 'padding' => self::pad([16, 24, 16, 24], [14, 18, 14, 18], [12, 14, 12, 14])],
					'answer'   => ['typo' => self::typo(400, [15, 15, 14], 1.6), 'colors' => ['color' => '#57534e'], 'background' => $clear, 'padding' => self::pad([0, 90, 20, 82], [0, 70, 16, 70], [0, 14, 14, 54])],
					'icon'     => ['background' => $clear, 'size' => ['desktop' => '16px', 'tablet' => null, 'mobile' => null], 'colors' => ['color' => '#111111'], 'padding' => self::zero(), 'border' => self::no_border()],
				],
			],
			'patternServices' => [
				'container' => ['background' => ['color' => '#111111'], 'padding' => self::pad([56, 48, 40, 48], [40, 28, 28, 28], [28, 16, 20, 16]), 'border' => self::no_border('16px')],
				'heading'   => [
					'title'    => ['typo' => self::typo(500, [76, 56, 40], 1, 'Inter', ['textTransform' => 'uppercase']), 'textAlign' => 'left', 'colors' => ['color' => '#ffffff']],
					'subTitle' => ['typo' => self::typo(500, [13, 12, 12], 1.6, 'Inter', ['textTransform' => 'uppercase']), 'textAlign' => 'right', 'colors' => ['color' => '#a1a1aa']],
				],
				'content'   => [
					'question' => ['typo' => self::typo(500, [38, 28, 21], 1.15, 'Inter', ['textTransform' => 'uppercase']), 'colors' => ['color' => '#ffffff'], 'background' => $clear, 'padding' => self::pad([26, 0, 26, 0], [20, 0, 20, 0], [16, 0, 16, 0])],
					'answer'   => ['typo' => self::typo(400, [16, 15, 14], 1.7), 'colors' => ['color' => '#d4d4d8'], 'background' => $clear, 'padding' => self::pad([0, 0, 28, 60], [0, 0, 22, 46], [0, 0, 18, 0])],
					'icon'     => ['background' => $clear, 'size' => ['desktop' => '26px', 'tablet' => '22px', 'mobile' => '20px'], 'colors' => ['color' => '#ffffff'], 'padding' => self::zero(), 'border' => self::no_border()],
				],
			],
			'patternCases' => [
				'container' => ['background' => ['color' => '#ffffff'], 'padding' => self::pad([24, 40, 24, 40], [16, 24, 16, 24], [8, 14, 8, 14]), 'border' => self::no_border('16px')],
				'heading'   => [
					'title'    => ['typo' => self::typo(600, [40, 32, 26], 1.2), 'textAlign' => 'left', 'colors' => ['color' => '#18181b']],
					'subTitle' => ['typo' => self::typo(400, [16, 15, 14], 1.6), 'textAlign' => 'left', 'colors' => ['color' => '#52525b']],
				],
				'content'   => [
					'question' => ['typo' => self::typo(500, [24, 21, 19], 1.3), 'colors' => ['color' => '#18181b'], 'background' => $clear, 'padding' => self::zero()],
					'answer'   => ['typo' => self::typo(400, [15, 15, 14], 1.65), 'colors' => ['color' => '#52525b'], 'background' => $clear, 'padding' => self::zero()],
					'icon'     => ['background' => $clear, 'size' => ['desktop' => '16px', 'tablet' => null, 'mobile' => null], 'colors' => ['color' => '#ffffff'], 'padding' => self::zero(), 'border' => self::no_border()],
				],
			],
			'patternMedia' => [
				'container' => ['background' => ['color' => '#0c0c0d'], 'padding' => self::pad([40, 40, 40, 40], [28, 24, 28, 24], [18, 14, 18, 14]), 'border' => self::no_border('20px')],
				'heading'   => [
					'title'    => ['typo' => self::typo(600, [36, 30, 24], 1.2), 'textAlign' => 'left', 'colors' => ['color' => '#ffffff']],
					'subTitle' => ['typo' => self::typo(400, [16, 15, 14], 1.6), 'textAlign' => 'left', 'colors' => ['color' => '#a1a1aa']],
				],
				'content'   => [
					'question' => ['typo' => self::typo(600, [16, 15, 15], 1.4), 'colors' => ['color' => '#f4f4f5'], 'background' => $clear, 'padding' => self::pad([18, 20, 18, 20], [16, 18, 16, 18], [14, 16, 14, 16])],
					'answer'   => ['typo' => self::typo(400, [14, 14, 13], 1.7), 'colors' => ['color' => '#a1a1aa'], 'background' => $clear, 'padding' => self::pad([0, 20, 18, 20], [0, 18, 16, 18], [0, 16, 14, 16])],
					'icon'     => ['background' => $clear, 'size' => ['desktop' => '18px', 'tablet' => null, 'mobile' => null], 'colors' => ['color' => '#a1a1aa'], 'padding' => self::zero(), 'border' => self::no_border()],
				],
			],
			'patternHero' => [
				'container' => ['background' => ['color' => '#050608'], 'padding' => self::pad([64, 40, 64, 40], [48, 24, 48, 24], [36, 14, 36, 14]), 'border' => self::no_border('20px')],
				'heading'   => [
					'title'    => ['typo' => self::typo(400, [56, 44, 34], 1.1, 'Noto Serif'), 'textAlign' => 'center', 'colors' => ['color' => '#f5f5f5']],
					'subTitle' => ['typo' => self::typo(400, [16, 15, 14], 1.6), 'textAlign' => 'center', 'colors' => ['color' => '#9ca3af']],
				],
				'content'   => [
					'question' => ['typo' => self::typo(600, [15, 15, 14], 1.4), 'colors' => ['color' => '#f4f4f5'], 'background' => $clear, 'padding' => self::pad([18, 20, 18, 20], [16, 18, 16, 18], [14, 14, 14, 14])],
					'answer'   => ['typo' => self::typo(400, [14, 14, 13], 1.65), 'colors' => ['color' => '#9ca3af'], 'background' => $clear, 'padding' => self::pad([0, 20, 18, 20], [0, 18, 16, 18], [0, 14, 14, 14])],
					'icon'     => ['background' => ['color' => 'rgba(255,255,255,0.06)'], 'size' => ['desktop' => '22px', 'tablet' => null, 'mobile' => null], 'colors' => ['color' => '#9ca3af'], 'padding' => self::pad([3, 3, 3, 3], [3, 3, 3, 3], [2, 2, 2, 2]), 'border' => self::no_border('50%')],
				],
			],
		];

		$sets['patternEstate']  = self::simple('#ffffff', [24, 24, 24, 24], '0px', [600, [40, 32, 26], 1.2, '#111111'], [400, [15, 15, 14], 1.6, '#52525b'], [400, [30, 26, 20], 1.15, '#111111'], [400, [13, 13, 13], 1.6, '#3f3f46'], ['#111111', '20px']);
		$sets['patternPlayful'] = self::simple('#f9faf5', [56, 40, 56, 40], '0px', [700, [40, 32, 26], 1.2, '#1a1a1a'], [400, [16, 15, 14], 1.6, '#52525b'], [700, [28, 23, 19], 1.2, '#1a1a1a', ['letterSpacing' => '-0.5px']], [400, [16, 15, 14], 1.6, '#3f3f46'], ['#ffffff', '18px'], [[30, 28, 30, 28], [26, 24, 26, 24], [22, 18, 22, 18]]);
		$sets['patternTable']   = self::simple('#050505', [32, 32, 32, 32], '6px', [600, [14, 14, 13], 1.4, '#ffffff'], [400, [14, 14, 13], 1.6, '#a1a1aa'], [500, [16, 15, 15], 1.45, '#ffffff'], [400, [14, 14, 13], 1.6, '#a1a1aa'], ['#ffffff', '16px'], [[16, 0, 16, 0], [16, 0, 16, 0], [14, 0, 14, 0]]);
		$sets['patternPanels']  = self::simple('#eef0e6', [28, 28, 28, 28], '20px', [600, [40, 32, 26], 1.2, '#141414'], [400, [16, 15, 14], 1.6, '#3f3f46'], [500, [21, 19, 17], 1.2, '#141414'], [400, [16, 15, 14], 1.6, '#27272a'], ['#141414', '16px']);
		$sets['patternSynced']  = self::simple('#ffffff', [32, 32, 32, 32], '0px', [400, [44, 36, 28], 1.15, '#111111'], [400, [15, 15, 14], 1.6, '#52525b'], [500, [18, 17, 16], 1.2, '#ffffff'], [400, [15, 14, 14], 1.5, '#e4e4e7'], ['#ffffff', '16px']);
		$sets['patternSynced']['heading']['title']['textAlign']    = 'center';
		$sets['patternSynced']['heading']['subTitle']['textAlign'] = 'center';
		$sets['patternSearch']  = self::simple('#ffffff', [48, 56, 48, 56], '12px', [500, [32, 28, 24], 1.2, '#111111'], [400, [14, 14, 13], 1.6, '#71717a'], [500, [15, 15, 14], 1.4, '#18181b'], [400, [14, 14, 13], 1.65, '#52525b'], ['#18181b', '16px'], [[15, 16, 15, 16], [15, 16, 15, 16], [14, 14, 14, 14]]);
		$sets['patternChat']     = self::simple('#0b0b18', [56, 40, 56, 40], '20px', [600, [14, 14, 13], 1.4, '#ffffff'], [500, [12, 12, 12], 1.5, '#8b8ba7'], [500, [15, 15, 14], 1.4, '#f4f4f5'], [400, [15, 15, 14], 1.6, '#e4e4e7'], ['#a1a1aa', '14px'], [[10, 14, 10, 16], [10, 14, 10, 16], [9, 12, 9, 14]]);
		$sets['patternChat']['content']['question']['background'] = ['color' => '#1f1f33'];
		$sets['patternChat']['heading']['subTitle']['textAlign']   = 'center';
		$sets['patternMediaFaq'] = self::simple('#070b1f', [56, 40, 56, 40], '24px', [600, [36, 30, 24], 1.2, '#ffffff'], [400, [16, 15, 14], 1.6, '#a5b4fc'], [600, [16, 15, 15], 1.4, '#ffffff'], [400, [15, 14, 14], 1.65, '#cbd5e1'], ['#ffffff', '18px'], [[18, 20, 18, 20], [16, 18, 16, 18], [14, 16, 14, 16]]);
		$sets['patternMediaFaq']['heading']['title']['textAlign']    = 'center';
		$sets['patternMediaFaq']['heading']['subTitle']['textAlign'] = 'center';

		return isset($sets[$slug]) ? $sets[$slug] : [];
	}

	/**
	 * Mirror of simple() in src/utils/patterns.js: container, header, question,
	 * answer and a plain icon. Tablet and mobile padding scale down from desktop.
	 *
	 * Each text argument is [weight, [desktop, tablet, mobile], line-height, colour, extra typo].
	 */
	private static function simple($bg, array $padding, $radius, array $title, array $sub, array $question, array $answer, array $icon, $qpad = null) {
		$text = static function (array $t) {
			return ['typo' => self::typo($t[0], $t[1], $t[2], 'Inter', $t[4] ?? []), 'colors' => ['color' => $t[3]]];
		};
		list($p0, $p1, $p2, $p3) = $padding;
		$clear = ['color' => 'transparent'];

		return [
			'container' => [
				'background' => ['color' => $bg],
				'padding'    => self::pad($padding, [(int) round($p0 * 0.75), (int) round($p1 * 0.6), (int) round($p2 * 0.75), (int) round($p3 * 0.6)], [(int) round($p0 * 0.5), 14, (int) round($p2 * 0.5), 14]),
				'border'     => self::no_border($radius),
			],
			'heading'   => [
				'title'    => $text($title) + ['textAlign' => 'left'],
				'subTitle' => $text($sub) + ['textAlign' => 'left'],
			],
			'content'   => [
				'question' => $text($question) + ['background' => $clear, 'padding' => $qpad ? self::pad(...$qpad) : self::zero()],
				'answer'   => $text($answer) + ['background' => $clear, 'padding' => self::zero()],
				'icon'     => ['background' => $clear, 'size' => ['desktop' => $icon[1], 'tablet' => null, 'mobile' => null], 'colors' => ['color' => $icon[0]], 'padding' => self::zero(), 'border' => self::no_border()],
			],
		];
	}

	/** Stroke icons drawn with fill='none' on the shapes, so Style.js cannot fill them. */
	private static function icons($name) {
		$svg = static function ($inner) {
			return "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' height='1em' width='1em' fill='none' stroke='currentColor' stroke-width='1.8' stroke-linecap='round' stroke-linejoin='round'>" . $inner . '</svg>';
		};

		if ('arrow' === $name) {
			return [
				'open'  => $svg("<line x1='12' y1='19' x2='12' y2='5'/><polyline points='5 12 12 5 19 12'/>"),
				'close' => $svg("<line x1='12' y1='5' x2='12' y2='19'/><polyline points='19 12 12 19 5 12'/>"),
			];
		}

		return [
			'open'  => $svg("<polyline points='18 15 12 9 6 15'/>"),
			'close' => $svg("<polyline points='6 9 12 15 18 9'/>"),
		];
	}

	/**
	 * The block for one pattern.
	 */
	private static function block($theme, array $faqs, array $pattern, $icon = '', $active = 0) {
		$attrs = [
			'theme'       => $theme,
			'align'       => 'wide',
			'activeItem'  => $active,
			'faqData'     => $faqs,
			'pattern'     => $pattern,
			'maxFaqItems' => count($faqs),
			'Styles'      => Parts::styles(self::styles($theme)),
		];

		if ($icon) {
			$attrs['faqIcon'] = self::icons($icon);
		}

		return Parts::block('faa/interactive-faq', $attrs);
	}

	/* ------------------------------------------------------------ the six */

	private static function team() {
		$faqs = [
			self::item(__('Maya Okafor', 'faq-and-answers'), __('Turns rough ideas into calm, usable interfaces and keeps every screen honest.', 'faq-and-answers'), ['meta' => __('Design lead', 'faq-and-answers'), 'badge' => __('Design', 'faq-and-answers'), 'image' => self::img('photo-1494790108377-be9c29b29330', 700)]),
			self::item(__('Daniel Reyes', 'faq-and-answers'), __('Builds the systems behind the work, from prototypes to production launches.', 'faq-and-answers'), ['meta' => __('Head of engineering', 'faq-and-answers'), 'badge' => __('Engineering', 'faq-and-answers'), 'image' => self::img('photo-1507003211169-0a1dd7228f2d', 700)]),
			self::item(__('Priya Nair', 'faq-and-answers'), __('Connects customers, data and the roadmap so the team builds the right thing.', 'faq-and-answers'), ['meta' => __('Product manager', 'faq-and-answers'), 'badge' => __('Product', 'faq-and-answers'), 'image' => self::img('photo-1438761681033-6461ffad8d80', 700)]),
			self::item(__('Tom Lindqvist', 'faq-and-answers'), __('Shapes spaces that feel simple on day one and still work on day one thousand.', 'faq-and-answers'), ['meta' => __('Lead architect', 'faq-and-answers'), 'badge' => __('Architecture', 'faq-and-answers'), 'image' => self::img('photo-1500648767791-00dcc994a43e', 700)]),
			self::item(__('Aiko Tanaka', 'faq-and-answers'), __('Makes sure every client feels heard, from the first call to the final handover.', 'faq-and-answers'), ['meta' => __('Client success', 'faq-and-answers'), 'badge' => __('Success', 'faq-and-answers'), 'image' => self::img('photo-1544005313-94ddf0286df2', 700)]),
		];

		return [
			'title'     => __('Meet the Team — Expanding Cards', 'faq-and-answers'),
			'slug'      => 'meet-the-team-expanding-cards',
			'groups'    => ['speakers'],
			'keywords'  => ['team', 'people', 'cards', 'expanding', 'portrait', 'pattern', 'pro'],
			'thumbnail' => 'pattern-team.webp',
			'content'   => self::block('patternTeam', $faqs, [
				'eyebrow'     => __('The team', 'faq-and-answers'),
				'title'       => __('Meet The Team', 'faq-and-answers'),
				'description' => __('Our team of talented designers and architects brings fresh ideas, thoughtful design, and deep expertise to every project.', 'faq-and-answers'),
				'buttonText'  => __('Join our team', 'faq-and-answers'),
				'buttonUrl'   => '#',
				'hoverOpen'   => true,
				'grayscale'   => true,
			], '', 1),
		];
	}

	private static function showcase() {
		$faqs = [
			self::item(__('Foresight', 'faq-and-answers'), __('See what is coming before it arrives, with signals pulled from every corner of your work.', 'faq-and-answers'), ['image' => self::img('photo-1506744038136-46273834b3fb')]),
			self::item(__('Momentum', 'faq-and-answers'), __('Keep projects moving with gentle nudges, smart reminders and clear next steps.', 'faq-and-answers'), ['image' => self::img('photo-1501785888041-af3ef285b470')]),
			self::item(__('Harmony', 'faq-and-answers'), __('Bring every contributor into one shared space, in real time and in sync.', 'faq-and-answers'), ['image' => self::img('photo-1500534623283-312aade485b7')]),
			self::item(__('Clarity', 'faq-and-answers'), __('Turn noisy updates into one clean summary that anyone can read in a minute.', 'faq-and-answers'), ['image' => self::img('photo-1507525428034-b723cf961d3e')]),
			self::item(__('Resolve', 'faq-and-answers'), __('Close the loop on every decision, with owners, dates and a record of why.', 'faq-and-answers'), ['image' => self::img('photo-1470071459604-3b5ec3a7fe05')]),
		];

		return [
			'title'     => __('Feature Showcase with Image', 'faq-and-answers'),
			'slug'      => 'feature-showcase-with-image',
			'groups'    => ['features'],
			'keywords'  => ['features', 'showcase', 'image', 'numbered', 'tabs', 'pattern', 'pro'],
			'thumbnail' => 'pattern-showcase.webp',
			'content'   => self::block('patternShowcase', $faqs, ['eyebrow' => __('Features', 'faq-and-answers'), 'showNumbers' => true], '', 2),
		];
	}

	private static function services() {
		$faqs = [
			self::item(__('AI Solutions', 'faq-and-answers'), __('We build custom AI solutions that optimise business processes, accelerate decision-making and personalise user experiences. With deep expertise in LLM, RAG, NLP and recommendation engines, we give your business a competitive edge.', 'faq-and-answers')),
			self::item(__('SaaS Platform Development', 'faq-and-answers'), __('From the first prototype to a platform serving millions, we design, build and scale multi-tenant products with billing, analytics and security built in.', 'faq-and-answers')),
			self::item(__('Education Technology', 'faq-and-answers'), __('Learning platforms, assessment engines and classroom tools that teachers enjoy using and students actually finish.', 'faq-and-answers')),
			self::item(__('Mobile Applications', 'faq-and-answers'), __('Native and cross-platform apps with fast, offline-friendly experiences and the release pipeline to ship them every week.', 'faq-and-answers')),
		];

		return [
			'title'     => __('Numbered Services, Dark', 'faq-and-answers'),
			'slug'      => 'numbered-services-dark',
			'groups'    => ['services'],
			'keywords'  => ['services', 'dark', 'numbered', 'agency', 'uppercase', 'pattern', 'pro'],
			'thumbnail' => 'pattern-services.webp',
			'content'   => self::block('patternServices', $faqs, [
				'eyebrow'     => __('What we do?', 'faq-and-answers'),
				'title'       => __('Services', 'faq-and-answers'),
				'description' => __('Tailored solutions, built for the future of every business.', 'faq-and-answers'),
				'showNumbers' => true,
			], 'arrow'),
		];
	}

	private static function cases() {
		$faqs = [
			self::item(__('Turning Complexity Into Competitive', 'faq-and-answers'), __('By simplifying complex challenges, we delivered a clear roadmap that strengthened competitive positioning and improved business.', 'faq-and-answers'), ['image' => self::img('photo-1600880292203-757bb62b4baf', 800), 'meta' => '32%', 'metaLabel' => __('Faster time to market.', 'faq-and-answers'), 'linkText' => __('View More', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Guiding Leadership Through Change', 'faq-and-answers'), __('We supported leadership through a period of transformation, aligning teams, managing risk, and driving successful execution.', 'faq-and-answers'), ['image' => self::img('photo-1522071820081-009f0129c71c', 800), 'meta' => '45%', 'metaLabel' => __('Increased executive decision.', 'faq-and-answers'), 'linkText' => __('View More', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Building Operational Excellence That Drives', 'faq-and-answers'), __('We rebuilt the operating rhythm of the business, aligning teams around a small set of measures that everyone could act on.', 'faq-and-answers'), ['image' => self::img('photo-1552664730-d307ca884978', 800), 'meta' => '3x', 'metaLabel' => __('Throughput across teams.', 'faq-and-answers'), 'linkText' => __('View More', 'faq-and-answers'), 'linkUrl' => '#']),
		];

		return [
			'title'     => __('Case Study Rows', 'faq-and-answers'),
			'slug'      => 'case-study-rows',
			'groups'    => ['portfolio'],
			'keywords'  => ['case study', 'portfolio', 'rows', 'image', 'stats', 'pattern', 'pro'],
			'thumbnail' => 'pattern-cases.webp',
			'content'   => self::block('patternCases', $faqs, ['hoverOpen' => false], '', 1),
		];
	}

	private static function media() {
		$faqs = [
			self::item(__('What is your refund policy?', 'faq-and-answers'), __('You can request a full refund within 30 days of purchase. No forms, no questions — just reply to your receipt.', 'faq-and-answers')),
			self::item(__('How do I get started?', 'faq-and-answers'), __('Create an account, pick a template and invite your team. Most people are up and running in under ten minutes.', 'faq-and-answers')),
			self::item(__('Do you offer team plans?', 'faq-and-answers'), __("Yes! We have flexible <b>team plans</b> starting at 3 seats, with shared workspaces, admin controls and priority support. <a href='#'>Contact our sales team</a> for enterprise pricing.", 'faq-and-answers')),
			self::item(__('What integrations do you support?', 'faq-and-answers'), __('Slack, Google Workspace, Notion, GitHub and more than forty others, plus a REST API and webhooks for everything else.', 'faq-and-answers')),
			self::item(__('How secure is my data?', 'faq-and-answers'), __('Data is encrypted in transit and at rest, backed up daily, and you can export or delete it at any time.', 'faq-and-answers')),
		];

		return [
			'title'     => __('Dark FAQ with Side Image', 'faq-and-answers'),
			'slug'      => 'dark-faq-with-side-image',
			'groups'    => ['support'],
			'keywords'  => ['dark', 'image', 'split', 'cards', 'accordion', 'pattern', 'pro'],
			'thumbnail' => 'pattern-media.webp',
			'content'   => self::block('patternMedia', $faqs, ['sideImage' => self::img('photo-1522071820081-009f0129c71c', 1000)], 'chevron', 2),
		];
	}

	private static function hero() {
		$faqs = [
			self::item(__('How does the free trial work?', 'faq-and-answers'), __('You get every feature for 14 days. No card needed, and nothing is charged when the trial ends.', 'faq-and-answers')),
			self::item(__('Can I change plans later?', 'faq-and-answers'), __('Yes. Switch from account settings. Changes are prorated automatically.', 'faq-and-answers')),
			self::item(__('Do you offer refunds?', 'faq-and-answers'), __('Within 30 days of any payment, in full, with no questions asked.', 'faq-and-answers')),
			self::item(__('Is my data secure?', 'faq-and-answers'), __('Everything is encrypted, backed up daily and stored in the region you choose.', 'faq-and-answers')),
		];

		return [
			'title'     => __('Gradient Hero FAQ', 'faq-and-answers'),
			'slug'      => 'gradient-hero-faq',
			'groups'    => ['sales'],
			'keywords'  => ['dark', 'hero', 'gradient', 'serif', 'pricing', 'pattern', 'pro'],
			'thumbnail' => 'pattern-hero.webp',
			'content'   => self::block('patternHero', $faqs, [
				'eyebrow'     => __('Answers, not noise', 'faq-and-answers'),
				'title'       => __('Questions, closed.', 'faq-and-answers'),
				'titleAccent' => __('Keep the night quiet.', 'faq-and-answers'),
				'description' => __('Billing, plans, and data — folded into one desk. Open one note at a time.', 'faq-and-answers'),
			], 'chevron', 1),
		];
	}

	private static function estate() {
		$view = __('View project', 'faq-and-answers');
		$faqs = [
			self::item(__('Skyline Terrace Residence', 'faq-and-answers'), __('Light-filled corner homes with wraparound terraces and a rooftop garden shared by every resident.', 'faq-and-answers'), ['meta' => __('Midtown, Seattle, WA', 'faq-and-answers'), 'image' => self::img('photo-1545324418-cc1a3fa10c00', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('The Urban Horizon', 'faq-and-answers'), __('Bright and polished, The Urban Horizon is a move-in-ready residence featuring an open floor plan, oversized windows, and striking city views within a well-run mid-rise building.', 'faq-and-answers'), ['meta' => __('Pearl District, Portland, OR', 'faq-and-answers'), 'image' => self::img('photo-1486406146926-c627a92ad1ab', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('Willow Creek Residences', 'faq-and-answers'), __('Quiet family homes around a private pool and courtyard, ten minutes from the city centre.', 'faq-and-answers'), ['meta' => __('Austin, TX', 'faq-and-answers'), 'image' => self::img('photo-1512917774080-9991f1c4c750', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('The Meridian Loft', 'faq-and-answers'), __('Double-height lofts with exposed concrete, warm oak floors and a skyline view from every room.', 'faq-and-answers'), ['meta' => __('Downtown, Chicago, IL', 'faq-and-answers'), 'image' => self::img('photo-1460317442991-0ec209397118', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('Hollow Pine Flats', 'faq-and-answers'), __('Compact, efficient flats built around shared green space, bike storage and a co-working lounge.', 'faq-and-answers'), ['meta' => __('Boulder, CO', 'faq-and-answers'), 'image' => self::img('photo-1600596542815-ffad4c1539a9', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('Pearl Harbor Residences', 'faq-and-answers'), __('Waterfront homes with floor-to-ceiling glass, private balconies and a marina at the door.', 'faq-and-answers'), ['meta' => __('Honolulu, HI', 'faq-and-answers'), 'image' => self::img('photo-1600585154340-be6161a56a0c', 1200), 'linkText' => $view, 'linkUrl' => '#']),
		];

		return [
			'title'     => __('Property Gallery — Expanding Cards', 'faq-and-answers'),
			'slug'      => 'property-gallery-expanding-cards',
			'groups'    => ['estate'],
			'keywords'  => ['real estate', 'property', 'gallery', 'cards', 'projects', 'pattern', 'pro'],
			'thumbnail' => 'pattern-estate.webp',
			'content'   => self::block('patternEstate', $faqs, ['showNumbers' => true, 'hoverOpen' => false], '', 1),
		];
	}

	private static function playful() {
		$more = __('More Details', 'faq-and-answers');
		$faqs = [
			self::item(__('Can I really build it my way?', 'faq-and-answers'), __('Yes. Start from a blank canvas or a template, then shape every section, colour and font until it feels like yours.', 'faq-and-answers'), ['color' => '#ecf763', 'linkText' => $more, 'linkUrl' => '#']),
			self::item(__('Do I need to know how to code?', 'faq-and-answers'), __('Not at all. Build responsive pages visually, add interactions and publish when you are ready.', 'faq-and-answers'), ['color' => '#b8b8ff', 'linkText' => $more, 'linkUrl' => '#']),
			self::item(__('Will it look good on every screen?', 'faq-and-answers'), __('Every layout adapts to laptops, tablets and phones, and you can fine-tune each one separately.', 'faq-and-answers'), ['color' => '#ffa3d1', 'linkText' => $more, 'linkUrl' => '#']),
			self::item(__('Can I add playful interactions?', 'faq-and-answers'), __('Hover effects, scroll animations and click-to-open panels are all built in, no extra plugins needed.', 'faq-and-answers'), ['color' => '#a8e6d9', 'linkText' => $more, 'linkUrl' => '#']),
		];

		return [
			'title'     => __('Playful Colour FAQ', 'faq-and-answers'),
			'slug'      => 'playful-colour-faq',
			'groups'    => ['onboarding'],
			'keywords'  => ['playful', 'colourful', 'fun', 'pills', 'shapes', 'pattern', 'pro'],
			'thumbnail' => 'pattern-playful.webp',
			'content'   => self::block('patternPlayful', $faqs, ['showNumbers' => true], '', 1),
		];
	}

	private static function table() {
		$faqs = [
			self::item(__('What services does your agency offer?', 'faq-and-answers'), __('We help brands build strong digital experiences through web design, development, and branding.', 'faq-and-answers')),
			self::item(__('How long does a typical project take?', 'faq-and-answers'), __('Most websites take six to ten weeks from kickoff to launch, depending on scope and content.', 'faq-and-answers')),
			self::item(__('Can you work with an existing brand or website?', 'faq-and-answers'), __('Absolutely. We often refresh existing sites and extend brands that already have a strong foundation.', 'faq-and-answers')),
			self::item(__('Do you provide ongoing support after launch?', 'faq-and-answers'), __('Yes. Every project includes 30 days of support, and monthly care plans are available after that.', 'faq-and-answers')),
			self::item(__('Can you handle both design and development?', 'faq-and-answers'), __('Yes. Strategy, design and development all happen in-house, so nothing gets lost between teams.', 'faq-and-answers')),
		];

		return [
			'title'     => __('Minimal Dark FAQ List', 'faq-and-answers'),
			'slug'      => 'minimal-dark-faq-list',
			'groups'    => ['services'],
			'keywords'  => ['dark', 'minimal', 'agency', 'numbered', 'list', 'pattern', 'pro'],
			'thumbnail' => 'pattern-table.webp',
			'content'   => self::block('patternTable', $faqs, [
				'eyebrow'     => __('Frequently asked questions', 'faq-and-answers'),
				'showNumbers' => true,
				'openLabel'   => __('Open', 'faq-and-answers'),
				'closeLabel'  => __('Close', 'faq-and-answers'),
			]),
		];
	}

	private static function panels() {
		$faqs = [
			self::item(__('Strategy', 'faq-and-answers'), __('Clear goals, sharp positioning and a plan the whole team can follow.', 'faq-and-answers'), ['badge' => __('Research, Workshops, Roadmaps', 'faq-and-answers'), 'image' => self::img('photo-1558591710-4b4a1ae0f04d', 1200), 'linkText' => __('Explore strategy', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Identity', 'faq-and-answers'), __('A visual language that people recognise long before they read your name.', 'faq-and-answers'), ['badge' => __('Logo, Typography, Colour', 'faq-and-answers'), 'image' => self::img('photo-1557672172-298e090bd0f1', 1200), 'linkText' => __('Explore identity', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Digital', 'faq-and-answers'), __('Websites and products that feel fast, simple and unmistakably yours.', 'faq-and-answers'), ['badge' => __('Web, Product, UX', 'faq-and-answers'), 'image' => self::img('photo-1604079628040-94301bb21b91', 1200), 'linkText' => __('Explore digital', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Motion', 'faq-and-answers'), __('Small details, lasting impressions. Motion that guides attention and gives your brand its rhythm.', 'faq-and-answers'), ['badge' => __('Animation, Interaction, Prototyping', 'faq-and-answers'), 'image' => self::img('photo-1618005182384-a83a8bd57fbe', 1200), 'linkText' => __('Explore motion', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Growth', 'faq-and-answers'), __('Campaigns and content that keep the momentum going after launch.', 'faq-and-answers'), ['badge' => __('Content, Campaigns, Analytics', 'faq-and-answers'), 'image' => self::img('photo-1579546929518-9e396f3cc809', 1200), 'linkText' => __('Explore growth', 'faq-and-answers'), 'linkUrl' => '#']),
		];

		return [
			'title'     => __('Colour Panels — Services', 'faq-and-answers'),
			'slug'      => 'colour-panels-services',
			'groups'    => ['features'],
			'keywords'  => ['panels', 'colourful', 'services', 'agency', 'tags', 'pattern', 'pro'],
			'thumbnail' => 'pattern-panels.webp',
			'content'   => self::block('patternPanels', $faqs, ['showNumbers' => true, 'hoverOpen' => false], '', 3),
		];
	}

	private static function synced() {
		$faqs = [
			self::item(__('Golden Hour', 'faq-and-answers'), __('The savanna turns amber as the sun slips behind the acacias.', 'faq-and-answers'), ['badge' => __('Landscape', 'faq-and-answers'), 'image' => self::img('photo-1516426122078-c23e76319801', 1200)]),
			self::item(__('Tall Neighbor', 'faq-and-answers'), __('A giraffe looks down from above the treeline.', 'faq-and-answers'), ['badge' => __('Wildlife', 'faq-and-answers'), 'image' => self::img('photo-1547721064-da6cfb341d50', 1200)]),
			self::item(__('Bright Feathers', 'faq-and-answers'), __('A macaw shows off every colour it has.', 'faq-and-answers'), ['badge' => __('Birds', 'faq-and-answers'), 'image' => self::img('photo-1552728089-57bdde30beb3', 1200)]),
			self::item(__('Morning Walk', 'faq-and-answers'), __('A fox pads through the frost before the world wakes up.', 'faq-and-answers'), ['badge' => __('Wildlife', 'faq-and-answers'), 'image' => self::img('photo-1474511320723-9a56873867b5', 1200)]),
			self::item(__('Good Company', 'faq-and-answers'), __('A pug waits patiently for the next adventure.', 'faq-and-answers'), ['badge' => __('Pets', 'faq-and-answers'), 'image' => self::img('photo-1517849845537-4d257902454a', 1200)]),
		];

		return [
			'title'     => __('Synced Accordion — Autoplay Gallery', 'faq-and-answers'),
			'slug'      => 'synced-accordion-autoplay-gallery',
			'groups'    => ['story'],
			'keywords'  => ['gallery', 'autoplay', 'slider', 'progress', 'photos', 'pattern', 'pro'],
			'thumbnail' => 'pattern-synced.webp',
			'content'   => self::block('patternSynced', $faqs, [
				'title'       => __('Synced Accordion', 'faq-and-answers'),
				'showNumbers' => true,
				'autoplay'    => true,
				'interval'    => 5,
			], '', 1),
		];
	}

	private static function search() {
		$general = __('General', 'faq-and-answers');
		$pricing = __('Pricing', 'faq-and-answers');
		$faqs    = [
			self::item(__('What is this component and how does it work?', 'faq-and-answers'), __('It is a searchable FAQ section. Type in the box to filter questions, or pick a category to narrow the list.', 'faq-and-answers'), ['categories' => $general]),
			self::item(__('Can I customize colors and typography?', 'faq-and-answers'), __('Yes. Every colour, font and spacing value can be changed from the block style settings.', 'faq-and-answers'), ['categories' => $general]),
			self::item(__('Does it work on mobile and tablet?', 'faq-and-answers'), __('It is fully responsive. The search, filters and answers adapt to every screen size.', 'faq-and-answers'), ['categories' => $general]),
			self::item(__('How do I add or remove questions?', 'faq-and-answers'), __('Open the FAQ Item panel in the block settings to add, reorder or delete questions.', 'faq-and-answers'), ['categories' => $general]),
			self::item(__('Is there a free trial?', 'faq-and-answers'), __('Yes, every plan starts with a 14-day free trial. No card required.', 'faq-and-answers'), ['categories' => $pricing]),
			self::item(__('Can I switch plans later?', 'faq-and-answers'), __('Upgrade or downgrade at any time; changes are prorated automatically.', 'faq-and-answers'), ['categories' => $pricing]),
			self::item(__('Which tools can I connect?', 'faq-and-answers'), __('Slack, Zapier, Google Sheets and HubSpot work out of the box, plus a REST API for everything else.', 'faq-and-answers'), ['categories' => __('Integrations', 'faq-and-answers')]),
			self::item(__('How do I reach the support team?', 'faq-and-answers'), __("Use the Contact Support button below or email <a href='#'>our help desk</a>. We reply within one business day.", 'faq-and-answers'), ['categories' => __('Support', 'faq-and-answers')]),
		];

		return [
			'title'     => __('Searchable FAQ with Categories', 'faq-and-answers'),
			'slug'      => 'searchable-faq-with-categories',
			'groups'    => ['support'],
			'keywords'  => ['search', 'filter', 'categories', 'help centre', 'support', 'pattern', 'pro'],
			'thumbnail' => 'pattern-search.webp',
			'content'   => self::block('patternSearch', $faqs, [
				'eyebrow'           => __('FAQ', 'faq-and-answers'),
				'title'             => __('Frequently Asked Questions', 'faq-and-answers'),
				'description'       => __('Everything you need to know.', 'faq-and-answers'),
				'searchPlaceholder' => __('Search questions...', 'faq-and-answers'),
				'allLabel'          => __('All', 'faq-and-answers'),
				'emptyText'         => __('No questions match your search.', 'faq-and-answers'),
				'supportTitle'      => __('Still have questions?', 'faq-and-answers'),
				'supportText'       => __('We are here to help.', 'faq-and-answers'),
				'buttonText'        => __('Contact Support', 'faq-and-answers'),
				'buttonUrl'         => '#',
				'showNumbers'       => true,
			]),
		];
	}

	private static function chat() {
		$faqs = [
			self::item(__('What is this FAQ?', 'faq-and-answers'), __('A chat-style FAQ. Tap any question and the answer arrives like a real reply.', 'faq-and-answers')),
			self::item(__('Can I customise the look and feel?', 'faq-and-answers'), __('Yes. Bubble colours, corners, fonts and spacing all come from the block settings.', 'faq-and-answers')),
			self::item(__('Does it work on phones?', 'faq-and-answers'), __('It does. The conversation stacks neatly on every screen size.', 'faq-and-answers')),
			self::item(__('Do I need coding skills to edit it?', 'faq-and-answers'), __('No code at all. Questions and answers are edited right in the sidebar.', 'faq-and-answers')),
			self::item(__('Can I add my own avatar?', 'faq-and-answers'), __('Pick any image in Pattern Content and it appears next to every answer.', 'faq-and-answers')),
		];

		return [
			'title'     => __('Chat Conversation FAQ', 'faq-and-answers'),
			'slug'      => 'chat-conversation-faq',
			'groups'    => ['support'],
			'keywords'  => ['chat', 'conversation', 'messages', 'support', 'bubbles', 'pattern', 'pro'],
			'thumbnail' => 'pattern-chat.webp',
			'content'   => self::block('patternChat', $faqs, [
				'eyebrow'   => __('Today, 10:07 AM', 'faq-and-answers'),
				'title'     => __('Support team', 'faq-and-answers'),
				'sideImage' => self::img('photo-1544005313-94ddf0286df2', 160),
				'typing'    => true,
			]),
		];
	}

	private static function media_answers() {
		$faqs = [
			self::item(__('What is the return policy?', 'faq-and-answers'), __('Send anything back within 30 days in its original packaging. The label is printed from your order page.', 'faq-and-answers'), ['image' => self::img('photo-1600880292203-757bb62b4baf', 1000)]),
			self::item(__('How do I set it up?', 'faq-and-answers'), __('Plug it in, open the app and follow the three steps in this short clip.', 'faq-and-answers'), ['video' => 'https://interactive-examples.mdn.mozilla.net/media/cc0-videos/flower.mp4', 'image' => self::img('photo-1506744038136-46273834b3fb', 1000)]),
			self::item(__('Where do you ship?', 'faq-and-answers'), __('We ship to more than 40 countries. Delivery takes 3 to 7 working days.', 'faq-and-answers'), ['image' => self::img('photo-1501785888041-af3ef285b470', 1000)]),
			self::item(__('Can I talk to a person?', 'faq-and-answers'), __('Of course. Our team answers chat and email every weekday from 9 to 6.', 'faq-and-answers'), ['image' => self::img('photo-1522071820081-009f0129c71c', 1000)]),
		];

		return [
			'title'     => __('FAQ with Image & Video Answers', 'faq-and-answers'),
			'slug'      => 'faq-with-image-video-answers',
			'groups'    => ['features'],
			'keywords'  => ['video', 'image', 'media', 'tutorial', 'product', 'pattern', 'pro'],
			'thumbnail' => 'pattern-mediafaq.webp',
			'content'   => self::block('patternMediaFaq', $faqs, [
				'eyebrow'     => __('Help centre', 'faq-and-answers'),
				'title'       => __('Answers you can see', 'faq-and-answers'),
				'description' => __('Every answer comes with a picture or a short clip, so nobody has to guess.', 'faq-and-answers'),
			], 'chevron'),
		];
	}

	/* ------------------------------------------------- industry use cases */

	private static function bank_help() {
		$acc   = __('Accounts', 'faq-and-answers');
		$cards = __('Cards', 'faq-and-answers');
		$loans = __('Loans', 'faq-and-answers');
		$faqs  = [
			self::item(__('How do I open a current account online?', 'faq-and-answers'), __('Download the app, verify your ID with a selfie and your passport or national ID, and your account is ready in about ten minutes.', 'faq-and-answers'), ['categories' => $acc]),
			self::item(__('Is there a monthly account fee?', 'faq-and-answers'), __('The Everyday account is free. Premium costs 5 per month and adds travel insurance and fee-free cash abroad.', 'faq-and-answers'), ['categories' => $acc]),
			self::item(__('How do I update my address?', 'faq-and-answers'), __('Go to Profile, then Personal details. Changes are confirmed by SMS and apply straight away.', 'faq-and-answers'), ['categories' => $acc]),
			self::item(__('My card was lost or stolen. What should I do?', 'faq-and-answers'), __('Freeze the card in the app at once, then order a replacement. A new card arrives in 3 to 5 working days.', 'faq-and-answers'), ['categories' => $cards]),
			self::item(__('Can I use my card abroad?', 'faq-and-answers'), __('Yes. Card payments abroad have no foreign transaction fee, and you can set travel limits in the app.', 'faq-and-answers'), ['categories' => $cards]),
			self::item(__('How long does a personal loan decision take?', 'faq-and-answers'), __('Most applications get a decision in minutes. Approved money reaches your account the same working day.', 'faq-and-answers'), ['categories' => $loans]),
			self::item(__('Can I repay my loan early?', 'faq-and-answers'), __('Yes, at any time and without a penalty. You only pay interest for the months you used.', 'faq-and-answers'), ['categories' => $loans]),
			self::item(__('How do I report a suspicious transaction?', 'faq-and-answers'), __('Tap the transaction and choose Report. Our fraud team is available 24 hours a day on the number on your card.', 'faq-and-answers'), ['categories' => __('Security', 'faq-and-answers')]),
		];

		return [
			'title'     => __('Bank Help Desk — Searchable', 'faq-and-answers'),
			'slug'      => 'bank-help-desk-searchable',
			'groups'    => ['finance'],
			'keywords'  => ['bank', 'finance', 'fintech', 'accounts', 'cards', 'loans', 'search', 'pattern', 'pro'],
			'thumbnail' => 'pattern-bank-help-desk.webp',
			'content'   => self::block('patternSearch', $faqs, [
				'eyebrow'           => __('Help centre', 'faq-and-answers'),
				'title'             => __('Banking questions, answered', 'faq-and-answers'),
				'description'       => __('Search or pick a topic. Still stuck? Our team is one tap away.', 'faq-and-answers'),
				'searchPlaceholder' => __('Search accounts, cards, loans...', 'faq-and-answers'),
				'allLabel'          => __('All', 'faq-and-answers'),
				'emptyText'         => __('No questions match your search.', 'faq-and-answers'),
				'supportTitle'      => __('Need to talk to someone?', 'faq-and-answers'),
				'supportText'       => __('Our support team is available 24/7.', 'faq-and-answers'),
				'buttonText'        => __('Chat with us', 'faq-and-answers'),
				'buttonUrl'         => '#',
				'showNumbers'       => true,
			]),
		];
	}

	private static function law_practice() {
		$faqs = [
			self::item(__('Family Law', 'faq-and-answers'), __('Divorce, child arrangements and financial settlements, handled with care and a clear plan from the first meeting.', 'faq-and-answers')),
			self::item(__('Business & Contracts', 'faq-and-answers'), __('Company formation, shareholder agreements and contracts that protect you before a dispute ever starts.', 'faq-and-answers')),
			self::item(__('Property & Conveyancing', 'faq-and-answers'), __('Buying, selling and leasing homes or commercial space, with fixed fees and weekly updates.', 'faq-and-answers')),
			self::item(__('Employment Law', 'faq-and-answers'), __('Advice for employers and employees on contracts, dismissals, settlements and workplace policies.', 'faq-and-answers')),
		];

		return [
			'title'     => __('Law Firm Practice Areas, Dark', 'faq-and-answers'),
			'slug'      => 'law-firm-practice-areas-dark',
			'groups'    => ['finance'],
			'keywords'  => ['law', 'legal', 'lawyer', 'attorney', 'practice areas', 'dark', 'pattern', 'pro'],
			'thumbnail' => 'pattern-law-practice-areas.webp',
			'content'   => self::block('patternServices', $faqs, [
				'eyebrow'     => __('How we help', 'faq-and-answers'),
				'title'       => __('Practice areas', 'faq-and-answers'),
				'description' => __('Clear legal advice for families and businesses since 1998.', 'faq-and-answers'),
				'showNumbers' => true,
			], 'arrow'),
		];
	}

	private static function car_service_chat() {
		$faqs = [
			self::item(__('How long does a full service take?', 'faq-and-answers'), __('Usually 2 to 3 hours. Wait in our lounge with free Wi-Fi, or take a courtesy car.', 'faq-and-answers')),
			self::item(__('Do you service electric and hybrid cars?', 'faq-and-answers'), __('Yes. Our technicians are certified for EV and hybrid systems, including battery health checks.', 'faq-and-answers')),
			self::item(__('Will a service here affect my warranty?', 'faq-and-answers'), __('No. We use manufacturer-approved parts and stamp your digital service book, so your warranty stays valid.', 'faq-and-answers')),
			self::item(__('Can you collect my car from home?', 'faq-and-answers'), __('Yes. Free collection and delivery within 10 miles. Pick a slot when you book.', 'faq-and-answers')),
			self::item(__('How do I pay?', 'faq-and-answers'), __('Pay by card when you collect the car, or split the cost into three monthly payments.', 'faq-and-answers')),
		];

		return [
			'title'     => __('Car Service Centre — Chat FAQ', 'faq-and-answers'),
			'slug'      => 'car-service-centre-chat-faq',
			'groups'    => ['automotive'],
			'keywords'  => ['car', 'garage', 'auto', 'service', 'mechanic', 'chat', 'pattern', 'pro'],
			'thumbnail' => 'pattern-car-service-chat.webp',
			'content'   => self::block('patternChat', $faqs, [
				'eyebrow'   => __('Today, 9:41 AM', 'faq-and-answers'),
				'title'     => __('Service desk', 'faq-and-answers'),
				'sideImage' => self::img('photo-1517841905240-472988babdf9', 160),
				'typing'    => true,
			]),
		];
	}

	private static function gym_coaches() {
		$faqs = [
			self::item(__('Sara Lindholm', 'faq-and-answers'), __('Builds strength programmes that fit around real life, from first-timers to competitive lifters.', 'faq-and-answers'), ['meta' => __('Head strength coach', 'faq-and-answers'), 'badge' => __('Strength', 'faq-and-answers'), 'image' => self::img('photo-1594381898411-846e7d193883', 700)]),
			self::item(__('Marcus Bell', 'faq-and-answers'), __('Runs our HIIT and conditioning classes, and keeps every session hard, fun and safe.', 'faq-and-answers'), ['meta' => __('Conditioning coach', 'faq-and-answers'), 'badge' => __('HIIT', 'faq-and-answers'), 'image' => self::img('photo-1567013127542-490d757e51fc', 700)]),
			self::item(__('Leah Moreno', 'faq-and-answers'), __('Teaches mobility and yoga so you move better, recover faster and stay injury free.', 'faq-and-answers'), ['meta' => __('Yoga & mobility', 'faq-and-answers'), 'badge' => __('Yoga', 'faq-and-answers'), 'image' => self::img('photo-1518611012118-696072aa579a', 700)]),
			self::item(__('Dev Patel', 'faq-and-answers'), __('Pairs training with simple nutrition plans that people actually stick to.', 'faq-and-answers'), ['meta' => __('Nutrition coach', 'faq-and-answers'), 'badge' => __('Nutrition', 'faq-and-answers'), 'image' => self::img('photo-1583454110551-21f2fa2afe61', 700)]),
			self::item(__('Nina Brooks', 'faq-and-answers'), __('Leads our beginner programme and makes the first month in the gym feel easy.', 'faq-and-answers'), ['meta' => __('Personal trainer', 'faq-and-answers'), 'badge' => __('Beginners', 'faq-and-answers'), 'image' => self::img('photo-1571019613454-1cb2f99b2d8b', 700)]),
		];

		return [
			'title'     => __('Gym Coaches — Expanding Cards', 'faq-and-answers'),
			'slug'      => 'gym-coaches-expanding-cards',
			'groups'    => ['fitness'],
			'keywords'  => ['gym', 'fitness', 'coaches', 'trainers', 'team', 'cards', 'pattern', 'pro'],
			'thumbnail' => 'pattern-gym-coaches.webp',
			'content'   => self::block('patternTeam', $faqs, [
				'eyebrow'     => __('Our coaches', 'faq-and-answers'),
				'title'       => __('Train With The Best', 'faq-and-answers'),
				'description' => __('Certified coaches for strength, conditioning, yoga and nutrition. Hover a card to meet them.', 'faq-and-answers'),
				'buttonText'  => __('Book a free session', 'faq-and-answers'),
				'buttonUrl'   => '#',
				'hoverOpen'   => true,
				'grayscale'   => true,
			], '', 1),
		];
	}

	private static function holiday_villas() {
		$view = __('See the villa', 'faq-and-answers');
		$faqs = [
			self::item(__('Villa Azure', 'faq-and-answers'), __('Four bedrooms, an infinity pool and a private path down to a quiet cove. Sleeps eight.', 'faq-and-answers'), ['meta' => __('Santorini, Greece', 'faq-and-answers'), 'image' => self::img('photo-1520250497591-112f2f40a3f4', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('Palm Court Retreat', 'faq-and-answers'), __('A garden villa with a shaded pool, outdoor kitchen and daily breakfast served on the terrace.', 'faq-and-answers'), ['meta' => __('Bali, Indonesia', 'faq-and-answers'), 'image' => self::img('photo-1582719478250-c89cae4dc85b', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('The Cliff House', 'faq-and-answers'), __('Floor-to-ceiling glass over the ocean, a hot tub on the deck and sunsets from every room.', 'faq-and-answers'), ['meta' => __('Big Sur, California', 'faq-and-answers'), 'image' => self::img('photo-1566073771259-6a8506099945', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('Beach Hut No. 7', 'faq-and-answers'), __('A barefoot cabin steps from the sand, with a hammock, outdoor shower and kayaks to borrow.', 'faq-and-answers'), ['meta' => __('Tulum, Mexico', 'faq-and-answers'), 'image' => self::img('photo-1499793983690-e29da59ef1c2', 1200), 'linkText' => $view, 'linkUrl' => '#']),
			self::item(__('Grand Harbour Suites', 'faq-and-answers'), __('City-centre suites with harbour views, a rooftop pool and a concierge who books the best tables.', 'faq-and-answers'), ['meta' => __('Valletta, Malta', 'faq-and-answers'), 'image' => self::img('photo-1571896349842-33c89424de2d', 1200), 'linkText' => $view, 'linkUrl' => '#']),
		];

		return [
			'title'     => __('Holiday Villas — Expanding Gallery', 'faq-and-answers'),
			'slug'      => 'holiday-villas-expanding-gallery',
			'groups'    => ['travel'],
			'keywords'  => ['villa', 'holiday', 'rental', 'travel', 'resort', 'gallery', 'pattern', 'pro'],
			'thumbnail' => 'pattern-holiday-villas.webp',
			'content'   => self::block('patternEstate', $faqs, ['showNumbers' => true, 'hoverOpen' => false], '', 2),
		];
	}

	private static function cooking_class() {
		$faqs = [
			self::item(__('Do I need any cooking experience?', 'faq-and-answers'), __('None at all. Every class starts with knife skills and the chef cooks each step with you.', 'faq-and-answers'), ['image' => self::img('photo-1556910103-1c02745aae4d', 1000)]),
			self::item(__('What will we cook?', 'faq-and-answers'), __('Three courses from the menu of the week: a starter, fresh pasta and a dessert. You eat everything you make.', 'faq-and-answers'), ['image' => self::img('photo-1504674900247-0877df9cc836', 1000)]),
			self::item(__('Are ingredients and aprons included?', 'faq-and-answers'), __('Yes. Ingredients, aprons, recipe cards and a glass of wine are all included in the price.', 'faq-and-answers'), ['image' => self::img('photo-1556909114-f6e7ad7d3136', 1000)]),
			self::item(__('Can you cater for allergies?', 'faq-and-answers'), __('Tell us when you book. We adapt every recipe for vegetarian, vegan and gluten-free cooks.', 'faq-and-answers'), ['image' => self::img('photo-1495521821757-a1efb6729352', 1000)]),
		];

		return [
			'title'     => __('Cooking Class FAQ with Photos', 'faq-and-answers'),
			'slug'      => 'cooking-class-faq-with-photos',
			'groups'    => ['food'],
			'keywords'  => ['cooking', 'class', 'chef', 'restaurant', 'workshop', 'image', 'pattern', 'pro'],
			'thumbnail' => 'pattern-cooking-class.webp',
			'content'   => self::block('patternMediaFaq', $faqs, [
				'eyebrow'     => __('Cooking classes', 'faq-and-answers'),
				'title'       => __('Before you put the apron on', 'faq-and-answers'),
				'description' => __('Everything first-time cooks ask us, with a look inside the kitchen.', 'faq-and-answers'),
			], 'chevron'),
		];
	}

	private static function university_programmes() {
		$faqs = [
			self::item(__('Business', 'faq-and-answers'), __('Finance, marketing and leadership, taught through live projects with partner companies.', 'faq-and-answers'), ['badge' => __('BSc, MBA, Evening courses', 'faq-and-answers'), 'image' => self::img('photo-1522202176988-66273c2fd55f', 1200), 'linkText' => __('Explore business', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Computer Science', 'faq-and-answers'), __('Software, data and AI, with a year in industry and labs open around the clock.', 'faq-and-answers'), ['badge' => __('BSc, MSc, Bootcamps', 'faq-and-answers'), 'image' => self::img('photo-1513258496099-48168024aec0', 1200), 'linkText' => __('Explore computing', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Design', 'faq-and-answers'), __('Graphic, product and interaction design in studios built for making things.', 'faq-and-answers'), ['badge' => __('BA, MA, Short courses', 'faq-and-answers'), 'image' => self::img('photo-1503676260728-1c00da094a0b', 1200), 'linkText' => __('Explore design', 'faq-and-answers'), 'linkUrl' => '#']),
			self::item(__('Education', 'faq-and-answers'), __('Teacher training with classroom placements from the very first term.', 'faq-and-answers'), ['badge' => __('BEd, PGCE, CPD', 'faq-and-answers'), 'image' => self::img('photo-1509062522246-3755977927d7', 1200), 'linkText' => __('Explore education', 'faq-and-answers'), 'linkUrl' => '#']),
		];

		return [
			'title'     => __('University Programmes — Colour Panels', 'faq-and-answers'),
			'slug'      => 'university-programmes-colour-panels',
			'groups'    => ['education'],
			'keywords'  => ['university', 'college', 'courses', 'programmes', 'education', 'panels', 'pattern', 'pro'],
			'thumbnail' => 'pattern-university-programmes.webp',
			'content'   => self::block('patternPanels', $faqs, ['showNumbers' => true, 'hoverOpen' => false], '', 1),
		];
	}

	private static function summer_camp() {
		$more = __('Read more', 'faq-and-answers');
		$faqs = [
			self::item(__('What ages is the camp for?', 'faq-and-answers'), __('Children aged 6 to 14, grouped by age so every activity feels just right.', 'faq-and-answers'), ['color' => '#ffd166', 'linkText' => $more, 'linkUrl' => '#']),
			self::item(__('What does a normal day look like?', 'faq-and-answers'), __('Drop-off at 8:30, then sports, science, art and a swim, with lunch and snacks included. Pick-up is at 4.', 'faq-and-answers'), ['color' => '#a0e7e5', 'linkText' => $more, 'linkUrl' => '#']),
			self::item(__('Who looks after the children?', 'faq-and-answers'), __('Qualified, background-checked staff, with one adult for every eight campers and a first-aider on site.', 'faq-and-answers'), ['color' => '#ffaebc', 'linkText' => $more, 'linkUrl' => '#']),
			self::item(__('Can I book single days?', 'faq-and-answers'), __('Yes. Book full weeks for the best price, or single days whenever you need them.', 'faq-and-answers'), ['color' => '#b4f8c8', 'linkText' => $more, 'linkUrl' => '#']),
		];

		return [
			'title'     => __('Kids Summer Camp — Playful FAQ', 'faq-and-answers'),
			'slug'      => 'kids-summer-camp-playful-faq',
			'groups'    => ['education'],
			'keywords'  => ['kids', 'camp', 'school', 'children', 'playful', 'colourful', 'pattern', 'pro'],
			'thumbnail' => 'pattern-summer-camp.webp',
			'content'   => self::block('patternPlayful', $faqs, ['showNumbers' => true], '', 1),
		];
	}
}

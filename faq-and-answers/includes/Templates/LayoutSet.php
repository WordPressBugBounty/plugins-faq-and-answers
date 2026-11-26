<?php
/**
 * Free layout templates — core blocks around the free Awesome FAQ block.
 *
 * Twelve finished sections modelled on common FAQ layouts: a gradient contact
 * card beside the questions, a sticky heading column, ruled editorial lists,
 * numbered rows, cards on a tinted page. Everything is built from core blocks
 * (group, columns, heading, paragraph, buttons) and the free FAQ block on its
 * free themes, so every template here is free and imports on any install.
 *
 * Two things keep them light:
 * - typography uses the theme's font ('Default' family), so the FAQ block adds
 *   no Google Fonts request; the one serif look uses Georgia, a system font;
 * - item shapes (cards, hairlines, accent bars, numbers) come from the opt-in
 *   skin classes in src/skins.scss, applied through the block's Additional CSS
 *   class, instead of extra blocks or inline markup.
 *
 * Text contains no double quotes — see Parts::icons() for why.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class LayoutSet {

	/**
	 * @return array
	 */
	public static function all() {
		return [
			self::skincare_contact_card(),
			self::saas_sticky_heading(),
			self::cleaning_service(),
			self::app_any_questions(),
			self::insurance_editorial(),
			self::fintech_contact_pill(),
			self::crm_getting_started(),
			// Inspired by free accordion components on the Framer marketplace.
			self::minimal_studio(),
			self::process_steps(),
			self::swatch_pastel(),
			self::expand_cards_travel(),
			self::dark_developer(),
			// Modern looks on the free themes.
			self::glass_subscription(),
			self::brutalist_creator(),
			self::ai_glow(),
			self::answer_grid(),
		];
	}

	/* ---------------------------------------------------------- helpers */

	private static function sizes($d, $t, $m) {
		return ['desktop' => $d, 'tablet' => $t, 'mobile' => $m];
	}

	private static function box($t, $r, $b, $l) {
		return ['top' => $t . 'px', 'right' => $r . 'px', 'bottom' => $b . 'px', 'left' => $l . 'px'];
	}

	/** Same padding on desktop, a little tighter on tablet and phone. */
	private static function pad($t, $r, $b, $l) {
		$k = static function ($v, $f) {
			return (int) round($v * $f);
		};

		return [
			'desktop' => self::box($t, $r, $b, $l),
			'tablet'  => self::box($k($t, .85), $k($r, .85), $k($b, .85), $k($l, .85)),
			'mobile'  => self::box($k($t, .75), $k($r, .7), $k($b, .75), $k($l, .7)),
		];
	}

	private static function typo($weight, array $size, $line, $serif = false) {
		$t = ['fontWeight' => $weight, 'fontSize' => self::sizes($size[0], $size[1], $size[2]), 'lineHeight' => $line];

		// 'Default' inherits the theme font and loads nothing. Georgia is a
		// system font, so isUploadFont=false keeps the Google Fonts link off.
		return $serif
			? $t + ['fontFamily' => 'Georgia', 'fontCategory' => 'serif', 'isUploadFont' => false]
			: $t + ['fontFamily' => 'Default'];
	}

	/**
	 * A complete Styles object from a small palette.
	 *
	 * @param array $o q, qBg, a, aBg, i, iBg, plus optional qSize, qWeight,
	 *                 iSize, iRadius, iPad, qPad, aPad, serif.
	 */
	private static function styles(array $o) {
		$serif = !empty($o['serif']);
		$ip    = $o['iPad'] ?? 6;

		// 'extra' carries branches outside content, e.g. container (the card
		// look of the Multi-Column theme) or heading.title (its big numbers).
		return Parts::styles(array_replace_recursive([
			'content' => [
				'question' => [
					'background' => ['color' => $o['qBg']],
					'colors'     => ['color' => $o['q']],
					'typo'       => self::typo($o['qWeight'] ?? 600, $o['qSize'] ?? [17, 16, 15], 1.45, $serif),
					'padding'    => $o['qPad'] ?? self::pad(20, 24, 20, 24),
				],
				'answer'   => [
					'background' => ['color' => $o['aBg']],
					'colors'     => ['color' => $o['a']],
					'typo'       => self::typo(400, $o['aSize'] ?? [15, 15, 14], 1.7, false),
					'padding'    => $o['aPad'] ?? self::pad(0, 24, 22, 24),
				],
				'icon'     => [
					'background' => ['color' => $o['iBg']],
					'colors'     => ['color' => $o['i']],
					// The size box includes the padding (border-box), so add it to the glyph.
					'size'       => ['desktop' => ((int) ($o['iSize'] ?? 16) + 2 * $ip) . 'px', 'tablet' => null, 'mobile' => null],
					'padding'    => self::pad($ip, $ip, $ip, $ip),
					'border'     => ['width' => '0px', 'style' => 'solid', 'color' => '', 'side' => 'all', 'radius' => $o['iRadius'] ?? '50%'],
				],
			],
		], $o['extra'] ?? []));
	}

	/** The FAQ block itself. $more adds attributes such as align and column. */
	private static function faq(array $faqs, array $styles, $skin, $icon = 'minus-plus', $theme = 'themeOne', array $more = []) {
		return Parts::block('faa/faq-and-answers', array_merge([
			'theme'       => $theme,
			'faqData'     => $faqs,
			'faqIcon'     => Parts::icons($icon),
			'maxFaqItems' => count($faqs),
			'activeItem'  => 0,
			'Styles'      => $styles,
			'className'   => $skin,
		], $more));
	}

	/** Question/answer pairs to faqData rows. */
	private static function rows($category, array $pairs) {
		return array_map(static function ($p) use ($category) {
			return Parts::faq($category, $p[0], $p[1]);
		}, $pairs);
	}

	private static function eyebrow($text, $colour, $align = 'center') {
		return Parts::paragraph(function_exists('mb_strtoupper') ? mb_strtoupper($text) : strtoupper($text), $align, $colour, 'small');
	}

	/* ------------------------------------------------- from the screenshots */

	/** Gradient contact card on the left, soft green questions on the right. */
	private static function skincare_contact_card() {
		$faqs = self::rows(__('Products', 'faq-and-answers'), [
			[__('Are your products natural or chemical-based?', 'faq-and-answers'), __('Our skincare products are made mainly from natural ingredients. They are gentle on the skin and dermatologically tested.', 'faq-and-answers')],
			[__('How long will it take to see results?', 'faq-and-answers'), __('Most people see a brighter, calmer complexion within two to four weeks of daily use.', 'faq-and-answers')],
			[__('Which product is best for my skin type?', 'faq-and-answers'), __('Take our two-minute skin quiz and we will suggest a routine for dry, oily, combination or sensitive skin.', 'faq-and-answers')],
			[__('Which age group are your products suitable for?', 'faq-and-answers'), __('Everyone from 16 upwards. Our gentle range is also safe for teenage and mature skin.', 'faq-and-answers')],
			[__('Do you test on animals?', 'faq-and-answers'), __('Never. Every product is certified cruelty free and most of the range is vegan.', 'faq-and-answers')],
		]);

		$card = Parts::section(
			Parts::paragraph('💬', 'center', '#ffffff', 'xx-large')
			. Parts::heading(__('Do you have more questions?', 'faq-and-answers'), 3, '#ffffff', 'large')
			. Parts::paragraph(__('Our skin experts reply within a day, with advice for your own routine.', 'faq-and-answers'), 'center', '#e6f4ec', 'small')
			. Parts::button(__('Direct Mail', 'faq-and-answers'), '#', '#ffffff', '#0f5f5c', '999px', 'center'),
			'linear-gradient(165deg,#0e5c5a 0%,#2f8a68 55%,#8cc152 100%)',
			'22px'
		);

		$styles = self::styles(['q' => '#24352b', 'qBg' => '#f3f7ee', 'a' => '#5b6b60', 'aBg' => '#f3f7ee', 'i' => '#3c6e4f', 'iBg' => 'transparent', 'iSize' => '18px', 'iPad' => 2]);

		return [
			'title'     => __('Skincare FAQ with Contact Card', 'faq-and-answers'),
			'slug'      => 'skincare-faq-with-contact-card',
			'groups'    => ['health'],
			'keywords'  => ['skincare', 'beauty', 'wellness', 'contact card', 'gradient', 'two column', 'free'],
			'thumbnail' => 'layout-skincare-contact-card.webp',
			'content'   => Parts::section_wide(
				Parts::heading(__('Frequently Ask any Questions', 'faq-and-answers'), 2, '#1f6b54', 'xx-large')
				. Parts::paragraph(__('Rejuvenate with soothing therapies crafted to bring harmony, peace and natural balance.', 'faq-and-answers'), 'center', '#6b7a70')
				. Parts::columns([
					['width' => '36%', 'inner' => $card],
					['width' => '64%', 'inner' => self::faq($faqs, $styles, 'afaq-skin-cards')],
				], 'top'),
				'#ffffff',
				'18px',
				'wide'
			),
		];
	}

	/** Heading column on the left, numbered rows on the right. */
	private static function saas_sticky_heading() {
		$faqs = self::rows(__('Plans', 'faq-and-answers'), [
			[__('Is there a free plan available?', 'faq-and-answers'), __('Yes. The free plan covers one project and three teammates, forever.', 'faq-and-answers')],
			[__('Can I invite my team members?', 'faq-and-answers'), __('Absolutely. Invite teammates, assign roles and collaborate in real time from a shared workspace.', 'faq-and-answers')],
			[__('Does it integrate with other tools?', 'faq-and-answers'), __('Slack, Google Drive, Notion, GitHub and more than forty others connect in a couple of clicks.', 'faq-and-answers')],
			[__('Can I upgrade or downgrade my plan anytime?', 'faq-and-answers'), __('Yes. Changes apply straight away and billing is prorated to the day.', 'faq-and-answers')],
			[__('Is my project data secure?', 'faq-and-answers'), __('Data is encrypted in transit and at rest, backed up daily and hosted in the region you choose.', 'faq-and-answers')],
		]);

		$left = self::eyebrow(__('• FAQ', 'faq-and-answers'), '#6d4aff', 'left')
			. Parts::heading(__('Frequently Asked Questions', 'faq-and-answers'), 2, '#2a1e5c', 'xx-large', 'left')
			. Parts::subheading(__('Still have a question?', 'faq-and-answers'), 4, '#2a1e5c')
			. Parts::paragraph(__('Do not worry, we are here for you. Book a free consultation with our team.', 'faq-and-answers'), 'left', '#6b6880', 'small')
			. Parts::button(__('Contact Us', 'faq-and-answers'), '#', '#6d4aff', '#ffffff', '10px');

		$styles = self::styles(['q' => '#1f1a3d', 'qBg' => '#f6f5fb', 'a' => '#6b6880', 'aBg' => '#f6f5fb', 'i' => '#1f1a3d', 'iBg' => 'transparent', 'iSize' => '18px', 'iPad' => 2]);

		return [
			'title'     => __('SaaS FAQ with Heading Column', 'faq-and-answers'),
			'slug'      => 'saas-faq-with-heading-column',
			'groups'    => ['sales'],
			'keywords'  => ['saas', 'software', 'pricing', 'numbered', 'two column', 'purple', 'free'],
			'thumbnail' => 'layout-saas-heading-column.webp',
			'content'   => Parts::section_wide(
				Parts::columns([
					['width' => '38%', 'inner' => $left],
					['width' => '62%', 'inner' => self::faq($faqs, $styles, 'afaq-skin-cards afaq-skin-numbered')],
				], 'top'),
				'#ffffff',
				'18px',
				'wide'
			),
		];
	}

	/** Lavender rows with an accent bar and round chevrons. */
	private static function cleaning_service() {
		$faqs = self::rows(__('Cleaning', 'faq-and-answers'), [
			[__('What types of cleaning services do you offer?', 'faq-and-answers'), __('Regular home cleaning, deep cleaning, move-in and move-out cleaning, and seasonal deep cleans.', 'faq-and-answers')],
			[__('Are your cleaning products eco-friendly?', 'faq-and-answers'), __('Yes. We use plant-based products that are safe for children, pets and the planet.', 'faq-and-answers')],
			[__('How do I schedule a cleaning service?', 'faq-and-answers'), __('Book online in under a minute. Pick a date, a time and the rooms you want cleaned.', 'faq-and-answers')],
			[__('Do I need to be home during the cleaning?', 'faq-and-answers'), __('No. Many clients leave a key or a door code. Every cleaner is vetted and insured.', 'faq-and-answers')],
			[__('What if I am not satisfied with the cleaning?', 'faq-and-answers'), __('Tell us within 24 hours and we will come back and re-clean the area for free.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#1d1b4b', 'qBg' => '#f1effd', 'a' => '#5c5a7a', 'aBg' => '#f1effd', 'i' => '#ffffff', 'iBg' => '#5b4fe9', 'iSize' => '14px', 'iPad' => 6, 'qPad' => self::pad(20, 24, 20, 28), 'aPad' => self::pad(0, 24, 22, 28)]);

		return [
			'title'     => __('Cleaning Service FAQ', 'faq-and-answers'),
			'slug'      => 'cleaning-service-faq',
			'groups'    => ['services'],
			'keywords'  => ['cleaning', 'home service', 'booking', 'accent', 'lavender', 'free'],
			'thumbnail' => 'layout-cleaning-service.webp',
			'content'   => Parts::section_wide(
				self::eyebrow(__('Spotless • Home solution', 'faq-and-answers'), '#5b4fe9')
				. Parts::heading(__('Frequently Asked Questions', 'faq-and-answers'), 2, '#1d1b4b', 'xx-large')
				. self::faq($faqs, $styles, 'afaq-skin-accent', 'chevron'),
				'#ffffff',
				'18px',
				'wide'
			),
		];
	}

	/** Bold heading on the left, a quiet ruled list on the right. */
	private static function app_any_questions() {
		$faqs = self::rows(__('App', 'faq-and-answers'), [
			[__('How does this work?', 'faq-and-answers'), __('Create an account, connect your bank and the app sorts your spending into simple categories automatically.', 'faq-and-answers')],
			[__('Are there any additional fees?', 'faq-and-answers'), __('No hidden fees. The basic plan is free, and Plus is one flat monthly price.', 'faq-and-answers')],
			[__('How can I get the app?', 'faq-and-answers'), __('Download it from the App Store or Google Play, or use it in any browser.', 'faq-and-answers')],
			[__('What features do you offer?', 'faq-and-answers'), __('Budgets, bill reminders, savings goals and shared accounts for couples and families.', 'faq-and-answers')],
		]);

		$left = Parts::heading(__('Any questions? We got you.', 'faq-and-answers'), 2, '#111111', 'xx-large', 'left')
			. Parts::paragraph(__('Everything you need to know about the app, billing and your data, in plain words.', 'faq-and-answers'), 'left', '#555555')
			. Parts::paragraph(__('More FAQs →', 'faq-and-answers'), 'left', '#5b4fe9');

		$styles = self::styles(['q' => '#111111', 'qBg' => 'transparent', 'a' => '#555555', 'aBg' => 'transparent', 'i' => '#111111', 'iBg' => 'transparent', 'iSize' => '18px', 'iPad' => 0, 'qSize' => [16, 15, 15], 'qPad' => self::pad(20, 18, 20, 18), 'aPad' => self::pad(0, 18, 20, 18)]);

		return [
			'title'     => __('Any Questions? We Got You', 'faq-and-answers'),
			'slug'      => 'any-questions-we-got-you',
			'groups'    => ['onboarding'],
			'keywords'  => ['app', 'minimal', 'lines', 'two column', 'clean', 'free'],
			'thumbnail' => 'layout-any-questions.webp',
			'content'   => Parts::section_wide(
				Parts::columns([
					['width' => '42%', 'inner' => $left],
					['width' => '58%', 'inner' => self::faq($faqs, $styles, 'afaq-skin-lines afaq-skin-no-top')],
				], 'center'),
				'#ffffff',
				'18px',
				'wide'
			),
		];
	}

	/** Warm paper background, serif questions, a contact box under the heading. */
	private static function insurance_editorial() {
		$faqs = self::rows(__('Insurance', 'faq-and-answers'), [
			[__('What types of coverage do you offer?', 'faq-and-answers'), __('Liability, full coverage and comprehensive plans. Each one can be tailored to what you need.', 'faq-and-answers')],
			[__('How do I file a claim?', 'faq-and-answers'), __('Report it in the app or call us 24/7. Most claims are settled within ten days.', 'faq-and-answers')],
			[__('Can I change my policy?', 'faq-and-answers'), __('Yes, at any time. Changes take effect from the next day with no admin fee.', 'faq-and-answers')],
			[__('What is a deductible?', 'faq-and-answers'), __('The amount you pay towards a claim before your insurance covers the rest.', 'faq-and-answers')],
			[__('How can I save on my premium?', 'faq-and-answers'), __('Bundle home and car, pay yearly, or add a safe-driver discount.', 'faq-and-answers')],
		]);

		$box = Parts::section(
			Parts::subheading(__('Still have questions?', 'faq-and-answers'), 4, '#2b2722')
			. Parts::paragraph(__('We are here to help you.', 'faq-and-answers'), 'left', '#6f675d', 'small')
			. Parts::button(__('Contact Us', 'faq-and-answers'), '#', '#111111', '#ffffff', '6px'),
			'#ece6db',
			'6px'
		);

		$left = self::eyebrow(__('FAQs', 'faq-and-answers'), '#6f675d', 'left')
			. Parts::heading(__('Frequently asked questions', 'faq-and-answers'), 2, '#2b2722', 'xx-large', 'left')
			. Parts::paragraph(__('Find answers to your questions about our insurance coverage options.', 'faq-and-answers'), 'left', '#6f675d')
			. $box;

		$styles = self::styles(['q' => '#2b2722', 'qBg' => 'transparent', 'a' => '#6f675d', 'aBg' => 'transparent', 'i' => '#2b2722', 'iBg' => 'transparent', 'iSize' => '18px', 'iPad' => 0, 'serif' => true, 'qWeight' => 400, 'qSize' => [19, 18, 17], 'qPad' => self::pad(20, 18, 20, 18), 'aPad' => self::pad(0, 18, 20, 18)]);

		return [
			'title'     => __('Insurance FAQ, Editorial', 'faq-and-answers'),
			'slug'      => 'insurance-faq-editorial',
			'groups'    => ['finance'],
			'keywords'  => ['insurance', 'finance', 'serif', 'editorial', 'beige', 'two column', 'free'],
			'thumbnail' => 'layout-insurance-editorial.webp',
			'content'   => Parts::section_wide(
				Parts::columns([
					['width' => '42%', 'inner' => $left],
					['width' => '58%', 'inner' => self::faq($faqs, $styles, 'afaq-skin-lines', 'minus-plus')],
				], 'top'),
				'#f7f3ec',
				'18px',
				'wide'
			),
		];
	}

	/** Big centred heading, black pill button, ruled rows with dark round icons. */
	private static function fintech_contact_pill() {
		$faqs = self::rows(__('Platform', 'faq-and-answers'), [
			[__('Stay connected to your financial data', 'faq-and-answers'), __('Bank-grade encryption and industry-standard security keep your data safe and always in sync.', 'faq-and-answers')],
			[__('What makes your platform different from others?', 'faq-and-answers'), __('Real-time insights, a clean interface and reports you can tailor to the way your team works.', 'faq-and-answers')],
			[__('Can I integrate the platform with my existing tools?', 'faq-and-answers'), __('Yes. Connect your accounting software, payroll and banks in a few clicks.', 'faq-and-answers')],
			[__('Is there a limit to the number of users or accounts?', 'faq-and-answers'), __('No. Every plan includes unlimited users and connected accounts.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#14281d', 'qBg' => 'transparent', 'a' => '#4b5b52', 'aBg' => 'transparent', 'i' => '#c6f432', 'iBg' => '#14281d', 'iSize' => '14px', 'iPad' => 6, 'qSize' => [18, 17, 16], 'qPad' => self::pad(22, 18, 22, 18), 'aPad' => self::pad(0, 18, 22, 18)]);

		return [
			'title'     => __('Fintech FAQ with Contact Pill', 'faq-and-answers'),
			'slug'      => 'fintech-faq-with-contact-pill',
			'groups'    => ['finance'],
			'keywords'  => ['fintech', 'saas', 'finance', 'lines', 'lime', 'centred', 'free'],
			'thumbnail' => 'layout-fintech-contact-pill.webp',
			'content'   => Parts::section_wide(
				Parts::heading(__('Frequently asked questions', 'faq-and-answers'), 2, '#14281d', 'xx-large')
				. Parts::button(__('Contact us', 'faq-and-answers'), '#', '#14281d', '#c6f432', '999px', 'center')
				. self::faq($faqs, $styles, 'afaq-skin-lines afaq-skin-no-top'),
				'#ffffff',
				'18px',
				'wide'
			),
		];
	}

	/** Lavender page, centred heading and white bordered cards. */
	private static function crm_getting_started() {
		$faqs = self::rows(__('Getting started', 'faq-and-answers'), [
			[__('How can I access the team dashboard?', 'faq-and-answers'), __('Sign in and choose Team from the left menu. Admins see every workspace; members see their own.', 'faq-and-answers')],
			[__('Where can I find help using the dashboard?', 'faq-and-answers'), __('Open the Help menu for short guides, or start the two-minute product tour.', 'faq-and-answers')],
			[__('How do I add team members to the dashboard?', 'faq-and-answers'), __('Go to Settings, then Team, and invite people by email or with a shareable link.', 'faq-and-answers')],
			[__('How can I upgrade to a higher plan?', 'faq-and-answers'), __('Open Billing and pick a plan. New features unlock straight away.', 'faq-and-answers')],
			[__('How can I contact the support team?', 'faq-and-answers'), __('Chat with us from any page, or email support. We reply within a few hours.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#1f1d3a', 'qBg' => '#ffffff', 'a' => '#64627d', 'aBg' => '#ffffff', 'i' => '#1f1d3a', 'iBg' => 'transparent', 'iSize' => '16px', 'iPad' => 2, 'qSize' => [16, 15, 15]]);

		return [
			'title'     => __('CRM Getting Started FAQ', 'faq-and-answers'),
			'slug'      => 'crm-getting-started-faq',
			'groups'    => ['onboarding'],
			'keywords'  => ['crm', 'onboarding', 'dashboard', 'cards', 'lavender', 'centred', 'free'],
			'thumbnail' => 'layout-crm-getting-started.webp',
			'content'   => Parts::section_wide(
				self::eyebrow(__('Frequently asked questions', 'faq-and-answers'), '#6d4aff')
				. Parts::heading(__('Getting Started: Your Essential Questions Answered', 'faq-and-answers'), 2, '#1f1d3a', 'xx-large')
				. Parts::paragraph(__('Quick answers to help you get started with the CRM effortlessly.', 'faq-and-answers'), 'center', '#64627d')
				. self::faq($faqs, $styles, 'afaq-skin-cards', 'minus-plus'),
				'#f1f0fb',
				'18px',
				'wide'
			),
		];
	}

	/* ------------------------------------------- Framer-inspired layouts */

	/** Minimal Accordion: large type, hairlines, arrows. */
	private static function minimal_studio() {
		$faqs = self::rows(__('Studio', 'faq-and-answers'), [
			[__('What does a project cost?', 'faq-and-answers'), __('Most brand and website projects start from a fixed fee agreed after a short discovery call.', 'faq-and-answers')],
			[__('How long does a project take?', 'faq-and-answers'), __('Six to ten weeks from kickoff to launch, depending on scope.', 'faq-and-answers')],
			[__('Do you work with startups?', 'faq-and-answers'), __('Yes. About half of our clients are early-stage teams preparing to launch or raise.', 'faq-and-answers')],
			[__('What happens after launch?', 'faq-and-answers'), __('Thirty days of support are included, with monthly care plans after that.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#0a0a0a', 'qBg' => 'transparent', 'a' => '#525252', 'aBg' => 'transparent', 'i' => '#0a0a0a', 'iBg' => 'transparent', 'iSize' => '22px', 'iPad' => 0, 'qWeight' => 500, 'qSize' => [28, 24, 20], 'aSize' => [16, 15, 15], 'qPad' => self::pad(26, 18, 26, 18), 'aPad' => self::pad(0, 18, 26, 18)]);

		return [
			'title'     => __('Minimal Studio FAQ', 'faq-and-answers'),
			'slug'      => 'minimal-studio-faq',
			'groups'    => ['portfolio'],
			'keywords'  => ['minimal', 'studio', 'agency', 'large type', 'lines', 'arrow', 'free'],
			'thumbnail' => 'layout-minimal-studio.webp',
			'content'   => Parts::section_wide(
				Parts::heading(__('Questions, answered.', 'faq-and-answers'), 2, '#0a0a0a', 'xx-large', 'left')
				. self::faq($faqs, $styles, 'afaq-skin-lines', 'arrow'),
				'#ffffff',
				'18px',
				'wide'
			),
		];
	}

	/** Processes Accordion: numbered steps of a service. */
	private static function process_steps() {
		$faqs = self::rows(__('Process', 'faq-and-answers'), [
			[__('Discovery call', 'faq-and-answers'), __('A 30-minute call to understand your goals, audience and timeline. No cost, no commitment.', 'faq-and-answers')],
			[__('Proposal and plan', 'faq-and-answers'), __('Within three days you get a clear scope, a fixed price and a week-by-week plan.', 'faq-and-answers')],
			[__('Design and build', 'faq-and-answers'), __('Weekly check-ins and a live preview link, so you see progress as it happens.', 'faq-and-answers')],
			[__('Launch and handover', 'faq-and-answers'), __('We launch together, train your team and hand over everything you need to grow.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#0b3b2e', 'qBg' => '#ffffff', 'a' => '#4f6b61', 'aBg' => '#ffffff', 'i' => '#ffffff', 'iBg' => '#0f766e', 'iSize' => '14px', 'iPad' => 6, 'qSize' => [19, 18, 16], 'qPad' => self::pad(22, 24, 22, 24)]);

		return [
			'title'     => __('Our Process — Numbered Steps', 'faq-and-answers'),
			'slug'      => 'our-process-numbered-steps',
			'groups'    => ['services'],
			'keywords'  => ['process', 'steps', 'how it works', 'numbered', 'services', 'teal', 'free'],
			'thumbnail' => 'layout-process-steps.webp',
			'content'   => Parts::section_wide(
				self::eyebrow(__('How it works', 'faq-and-answers'), '#0f766e')
				. Parts::heading(__('Four steps from idea to launch', 'faq-and-answers'), 2, '#0b3b2e', 'xx-large')
				. self::faq($faqs, $styles, 'afaq-skin-cards afaq-skin-numbered', 'minus-plus'),
				'#ecf6f3',
				'18px',
				'wide'
			),
		];
	}

	/** Swatch Accordion: pastel pills on a warm gradient. */
	private static function swatch_pastel() {
		$faqs = self::rows(__('Shop', 'faq-and-answers'), [
			[__('Which colours are in stock?', 'faq-and-answers'), __('All twelve seasonal colours are in stock now. Sold-out shades come back every Friday.', 'faq-and-answers')],
			[__('Can I order a swatch first?', 'faq-and-answers'), __('Yes. Pick up to five fabric swatches for free, delivered in two days.', 'faq-and-answers')],
			[__('Is the dye safe for kids?', 'faq-and-answers'), __('Every colour is certified non-toxic and safe for children and sensitive skin.', 'faq-and-answers')],
			[__('Do colours fade in the wash?', 'faq-and-answers'), __('Wash cold and inside out and the colour stays bright for years.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#3a1d2e', 'qBg' => 'rgba(255,255,255,0.72)', 'a' => '#6b4a5c', 'aBg' => 'rgba(255,255,255,0.72)', 'i' => '#ffffff', 'iBg' => '#e2557d', 'iSize' => '14px', 'iPad' => 6, 'qPad' => self::pad(20, 26, 20, 26), 'aPad' => self::pad(0, 26, 22, 26)]);

		return [
			'title'     => __('Colour Swatch FAQ', 'faq-and-answers'),
			'slug'      => 'colour-swatch-faq',
			'groups'    => ['fashion'],
			'keywords'  => ['pastel', 'colourful', 'shop', 'pill', 'gradient', 'playful', 'free'],
			'thumbnail' => 'layout-swatch-pastel.webp',
			'content'   => Parts::section_wide(
				Parts::heading(__('Good questions, colourful answers', 'faq-and-answers'), 2, '#3a1d2e', 'xx-large')
				. Parts::paragraph(__('Everything about colours, swatches and care.', 'faq-and-answers'), 'center', '#6b4a5c')
				. self::faq($faqs, $styles, 'afaq-skin-pill'),
				'linear-gradient(135deg,#ffd6e0 0%,#ffe7c2 50%,#d9f2ff 100%)',
				'24px',
				'wide'
			),
		];
	}

	/** Expand Image Cards: the free Vertical Tabs theme, panels widening on click. */
	private static function expand_cards_travel() {
		$faqs = self::rows(__('Trips', 'faq-and-answers'), [
			[__('When is the best time to go?', 'faq-and-answers'), __('Spring and early autumn bring warm days, fewer crowds and the best prices on flights and hotels.', 'faq-and-answers')],
			[__('What is included in the tour?', 'faq-and-answers'), __('Hotels, breakfast, a local guide and all transfers. Flights can be added at checkout.', 'faq-and-answers')],
			[__('How big are the groups?', 'faq-and-answers'), __('Never more than twelve travellers, so every day feels relaxed and personal.', 'faq-and-answers')],
			[__('Can I change my dates?', 'faq-and-answers'), __('Free date changes up to 30 days before departure.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#ffffff', 'qBg' => '#1d4e5f', 'a' => '#2d3b40', 'aBg' => '#ffffff', 'i' => '#1d4e5f', 'iBg' => '#ffffff', 'iSize' => '14px', 'iPad' => 6, 'qPad' => self::pad(20, 16, 20, 16), 'aPad' => self::pad(26, 28, 26, 28), 'aSize' => [16, 15, 14]]);

		return [
			'title'     => __('Travel FAQ — Expanding Panels', 'faq-and-answers'),
			'slug'      => 'travel-faq-expanding-panels',
			'groups'    => ['travel'],
			'keywords'  => ['travel', 'tours', 'expanding', 'vertical tabs', 'panels', 'teal', 'free'],
			'thumbnail' => 'layout-expand-travel.webp',
			'content'   => Parts::section_wide(
				Parts::heading(__('Before you pack', 'faq-and-answers'), 2, '#123842', 'xx-large')
				. Parts::paragraph(__('Tap a panel to open it.', 'faq-and-answers'), 'center', '#4c6a72')
				. self::faq($faqs, $styles, 'afaq-skin-pill', 'minus-plus', 'themeThree'),
				'#eef5f6',
				'18px',
				'wide'
			),
		];
	}

	/** Animated Accordion: dark panel with soft glass cards. */
	private static function dark_developer() {
		$faqs = self::rows(__('API', 'faq-and-answers'), [
			[__('How do I get an API key?', 'faq-and-answers'), __('Open the dashboard, go to Developers and create a key. Test and live keys are kept separate.', 'faq-and-answers')],
			[__('What are the rate limits?', 'faq-and-answers'), __('One hundred requests per second on every paid plan, with bursts allowed.', 'faq-and-answers')],
			[__('Do you have SDKs?', 'faq-and-answers'), __('Official SDKs for JavaScript, Python, PHP and Go, all open source.', 'faq-and-answers')],
			[__('Is there a sandbox?', 'faq-and-answers'), __('Yes. Every account includes a free sandbox with sample data.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#f1f5f9', 'qBg' => 'rgba(255,255,255,0.05)', 'a' => '#94a3b8', 'aBg' => 'rgba(255,255,255,0.05)', 'i' => '#0b1020', 'iBg' => '#a5b4fc', 'iSize' => '14px', 'iPad' => 6]);

		return [
			'title'     => __('Developer FAQ, Dark', 'faq-and-answers'),
			'slug'      => 'developer-faq-dark',
			'groups'    => ['features'],
			'keywords'  => ['dark', 'developer', 'api', 'saas', 'glass', 'gradient', 'free'],
			'thumbnail' => 'layout-dark-developer.webp',
			'content'   => Parts::section_wide(
				self::eyebrow(__('Developers', 'faq-and-answers'), '#a5b4fc')
				. Parts::heading(__('Build with confidence', 'faq-and-answers'), 2, '#f8fafc', 'xx-large')
				. Parts::paragraph(__('Answers for engineers integrating the API.', 'faq-and-answers'), 'center', '#94a3b8')
				. self::faq($faqs, $styles, 'afaq-skin-cards afaq-skin-dark', 'chevron'),
				'radial-gradient(120% 90% at 20% 0%,#312e81 0%,#0b1020 55%,#05070f 100%)',
				'24px',
				'wide'
			),
		];
	}

	/* ------------------------------- modern looks (market-trend layouts) */

	/** Theme One: glass cards on a vivid gradient, round plus on the left. */
	private static function glass_subscription() {
		$faqs = self::rows(__('Subscription', 'faq-and-answers'), [
			[__('What services do you offer?', 'faq-and-answers'), __('Design, development and growth marketing, bundled into one monthly subscription with no long contracts.', 'faq-and-answers')],
			[__('How can I contact customer support?', 'faq-and-answers'), __('Chat with us from your dashboard or email support. Real people reply within two hours on weekdays.', 'faq-and-answers')],
			[__('How do I create an account?', 'faq-and-answers'), __('Click Get started, enter your email and pick a plan. Your workspace is ready in under a minute.', 'faq-and-answers')],
			[__('How can I reset my password?', 'faq-and-answers'), __('Use Forgot password on the sign-in page and follow the link we email you.', 'faq-and-answers')],
			[__('What payment methods do you accept?', 'faq-and-answers'), __('All major cards, PayPal and bank transfer for annual plans.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#ffffff', 'qBg' => 'rgba(255,255,255,0.12)', 'a' => '#e0e7ff', 'aBg' => 'rgba(255,255,255,0.12)', 'i' => '#4f46e5', 'iBg' => '#ffffff', 'iSize' => 14, 'iPad' => 7, 'qSize' => [18, 17, 16], 'qPad' => self::pad(20, 24, 20, 20), 'aPad' => self::pad(0, 24, 22, 64)]);

		return [
			'title'     => __('Glass Cards on Gradient', 'faq-and-answers'),
			'slug'      => 'glass-cards-on-gradient',
			'groups'    => ['sales'],
			'keywords'  => ['glass', 'glassmorphism', 'gradient', 'modern', 'theme one', 'saas', 'free'],
			'thumbnail' => 'layout-glass-gradient.webp',
			'content'   => Parts::section_wide(
				self::eyebrow(__('Support', 'faq-and-answers'), '#c7d2fe')
				. Parts::heading(__('Everything you want to know', 'faq-and-answers'), 2, '#ffffff', 'xx-large')
				. Parts::paragraph(__('Short answers to the questions we hear most.', 'faq-and-answers'), 'center', '#e0e7ff')
				. self::faq($faqs, $styles, 'afaq-skin-cards afaq-skin-glass', 'minus-plus', 'themeThirteen'),
				'linear-gradient(135deg,#4f46e5 0%,#7c3aed 45%,#db2777 100%)',
				'28px',
				'wide'
			),
		];
	}

	/** Default theme: neo-brutalist cards with thick borders and offset shadows. */
	private static function brutalist_creator() {
		$faqs = self::rows(__('Course', 'faq-and-answers'), [
			[__('Who is this course for?', 'faq-and-answers'), __('Creators who want to turn a hobby into a paid newsletter, from zero subscribers to the first thousand.', 'faq-and-answers')],
			[__('How long do I get access?', 'faq-and-answers'), __('Forever. Every future update is included at no extra cost.', 'faq-and-answers')],
			[__('Is there a community?', 'faq-and-answers'), __('Yes. A private community with weekly live Q&A calls and feedback on your work.', 'faq-and-answers')],
			[__('What if it is not for me?', 'faq-and-answers'), __('Ask for a refund within 30 days. No questions, no forms.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#111111', 'qBg' => '#ffffff', 'a' => '#333333', 'aBg' => '#ffffff', 'i' => '#111111', 'iBg' => '#a3e635', 'iSize' => 14, 'iPad' => 7, 'iRadius' => '8px', 'qWeight' => 700, 'qSize' => [19, 18, 16], 'qPad' => self::pad(20, 22, 20, 20), 'aPad' => self::pad(0, 22, 22, 66)]);

		return [
			'title'     => __('Neo-Brutalist FAQ', 'faq-and-answers'),
			'slug'      => 'neo-brutalist-faq',
			'groups'    => ['onboarding'],
			'keywords'  => ['brutalist', 'bold', 'yellow', 'creator', 'course', 'shadow', 'modern', 'free'],
			'thumbnail' => 'layout-neo-brutalist.webp',
			'content'   => Parts::section_wide(
				Parts::heading(__('Got questions? Good.', 'faq-and-answers'), 2, '#111111', 'xx-large')
				. Parts::paragraph(__('The honest answers about the course, before you join.', 'faq-and-answers'), 'center', '#333333')
				. self::faq($faqs, $styles, 'afaq-skin-brutal', 'minus-plus', 'default'),
				'#fde047',
				'24px',
				'wide'
			),
		];
	}

	/** Theme Three: dark AI-product section with glowing gradient borders. */
	private static function ai_glow() {
		$faqs = self::rows(__('AI', 'faq-and-answers'), [
			[__('How does the AI writer work?', 'faq-and-answers'), __('Describe what you need in a sentence. The assistant drafts it in your brand voice and you edit from there.', 'faq-and-answers')],
			[__('Is my data used to train models?', 'faq-and-answers'), __('Never. Your prompts and documents stay private and are deleted when you remove them.', 'faq-and-answers')],
			[__('Which languages are supported?', 'faq-and-answers'), __('More than 30 languages, with automatic detection and translation.', 'faq-and-answers')],
			[__('Can my team share prompts?', 'faq-and-answers'), __('Yes. Save prompts to a shared library so everyone gets the same quality.', 'faq-and-answers')],
		]);

		$styles = self::styles(['q' => '#f8fafc', 'qBg' => 'transparent', 'a' => '#a5b4fc', 'aBg' => 'transparent', 'i' => '#0b1020', 'iBg' => '#22d3ee', 'iSize' => 14, 'iPad' => 6, 'qSize' => [18, 17, 16], 'qPad' => self::pad(22, 24, 22, 24), 'aPad' => self::pad(0, 24, 24, 24)]);

		return [
			'title'     => __('AI Product FAQ — Glow', 'faq-and-answers'),
			'slug'      => 'ai-product-faq-glow',
			'groups'    => ['features'],
			'keywords'  => ['ai', 'dark', 'glow', 'gradient border', 'saas', 'modern', 'theme three', 'free'],
			'thumbnail' => 'layout-ai-glow.webp',
			'content'   => Parts::section_wide(
				self::eyebrow(__('✦ AI assistant', 'faq-and-answers'), '#22d3ee')
				. Parts::heading(__('Questions about the AI?', 'faq-and-answers'), 2, '#f8fafc', 'xx-large')
				. Parts::paragraph(__('How it works, what it costs and how your data is kept safe.', 'faq-and-answers'), 'center', '#94a3b8')
				. self::faq($faqs, $styles, 'afaq-skin-glow', 'chevron', 'themeOne'),
				'radial-gradient(90% 70% at 50% 0%,#1e1b4b 0%,#0b1020 60%,#05070f 100%)',
				'28px',
				'wide'
			),
		];
	}

	/** Multi-Column theme: a two-column grid of answer cards with big numbers. */
	private static function answer_grid() {
		$faqs = self::rows(__('Store', 'faq-and-answers'), [
			[__('How fast is shipping?', 'faq-and-answers'), __('Orders leave our warehouse within 24 hours and arrive in 2 to 4 working days.', 'faq-and-answers')],
			[__('Can I return an item?', 'faq-and-answers'), __('Yes. Free returns within 30 days, straight from your order page.', 'faq-and-answers')],
			[__('Do you ship worldwide?', 'faq-and-answers'), __('We ship to more than 60 countries with duties shown at checkout.', 'faq-and-answers')],
			[__('Is my payment secure?', 'faq-and-answers'), __('Every payment is encrypted and processed by a certified payment provider.', 'faq-and-answers')],
		]);

		$styles = self::styles([
			'q' => '#0f172a', 'qBg' => 'transparent', 'a' => '#475569', 'aBg' => 'transparent', 'i' => '#0f172a', 'iBg' => 'transparent',
			'qWeight' => 700, 'qSize' => [19, 18, 17], 'qPad' => self::pad(4, 0, 8, 0), 'aPad' => self::pad(0, 0, 4, 0),
			'extra' => [
				'container' => [
					'background' => ['color' => '#ffffff'],
					'padding'    => self::pad(28, 28, 28, 28),
					'border'     => ['width' => '1px', 'style' => 'solid', 'color' => '#e2e8f0', 'side' => 'all', 'radius' => '18px'],
				],
				'heading'   => ['title' => ['typo' => self::typo(800, [34, 30, 26], 1), 'colors' => ['color' => '#f97316']]],
			],
		]);

		return [
			'title'     => __('Answer Card Grid', 'faq-and-answers'),
			'slug'      => 'answer-card-grid',
			'groups'    => ['support'],
			'keywords'  => ['grid', 'cards', 'two column', 'numbers', 'store', 'modern', 'multi column', 'free'],
			'thumbnail' => 'layout-answer-grid.webp',
			'content'   => Parts::section_wide(
				self::eyebrow(__('Quick answers', 'faq-and-answers'), '#f97316')
				. Parts::heading(__('Shopping with us', 'faq-and-answers'), 2, '#0f172a', 'xx-large')
				. self::faq($faqs, $styles, 'afaq-skin-grid', 'minus-plus', 'themeTwo', [
					'align'  => 'wide',
					'column' => ['desktop' => 2, 'tablet' => 2, 'mobile' => 1, 'gapX' => '20px', 'gapY' => '20px'],
				]),
				'#f8fafc',
				'24px',
				'wide'
			),
		];
	}
}

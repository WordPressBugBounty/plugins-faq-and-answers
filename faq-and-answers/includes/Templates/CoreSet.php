<?php
/**
 * The FAQ patterns every site needs: support, onboarding and sales.
 *
 * Each one sits in a tinted section so it looks like a designed block of the
 * page rather than a bare list dropped into it, and the blocks that expose flat
 * colour attributes get a palette to match. The Awesome FAQ block is given its
 * theme and nothing else on purpose — see Parts::section() for why its style
 * object is left alone.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class CoreSet
{

	/**
	 * @return array
	 */
	public static function all()
	{
		return [
			// Support pages.
			self::help_centre(),
			self::browse_by_topic(),
			self::troubleshooting(),
			self::support_articles(),
			self::from_the_blog(),
			self::ask_a_question(),

			// Getting started.
			self::step_by_step(),
			self::launch_checklist(),
			self::what_happens_next(),

			// Sales pages.
			self::pricing_objections(),
			self::faq_grid(),
			self::service_spotlight(),
		];
	}

	/* ------------------------------------------------------ support pages */

	/**
	 * The plain one. Categorised questions in an accordion — what most sites
	 * mean when they say "FAQ page".
	 *
	 * @return array
	 */
	private static function help_centre()
	{
		$faqs = [
			Parts::faq(
				__('Getting started', 'faq-and-answers'),
				__('How long does setup take?', 'faq-and-answers'),
				__('Most people are finished in under ten minutes. Install the plugin, drop a block on a page and start typing — there is nothing to configure first.', 'faq-and-answers')
			),
			Parts::faq(
				__('Getting started', 'faq-and-answers'),
				__('Will it match my theme?', 'faq-and-answers'),
				__('Yes. Every block inherits your theme\'s colours and typography to begin with, and each of those can be overridden per block if you want something different.', 'faq-and-answers')
			),
			Parts::faq(
				__('Getting started', 'faq-and-answers'),
				__('Can I put the same questions on more than one page?', 'faq-and-answers'),
				__('Save the block as a synced pattern and place it wherever you need it. Editing the pattern updates every page carrying it, so nothing has to be kept in step by hand.', 'faq-and-answers')
			),
			Parts::faq(
				__('Billing', 'faq-and-answers'),
				__('Can I change plan later?', 'faq-and-answers'),
				__('Any time, in either direction. Upgrades take effect immediately and you only pay the difference for the rest of the term.', 'faq-and-answers')
			),
			Parts::faq(
				__('Billing', 'faq-and-answers'),
				__('What is your refund policy?', 'faq-and-answers'),
				__('Thirty days, no questions asked. Write to support and the money goes back the way it came.', 'faq-and-answers')
			),
		];

		return [
			'title' => __('Help Centre', 'faq-and-answers'),
			'groups' => ['support'],
			'keywords' => ['faq', 'help', 'support', 'accordion'],
			'thumbnail' => 'help-centre.svg',
			'content' => Parts::section(
				Parts::heading(__('How can we help?', 'faq-and-answers'))
				. Parts::paragraph(__('The questions we are asked most often, answered.', 'faq-and-answers'))
				. Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'default']),
				'#f5f8fc'
			),
		];
	}

	/**
	 * Tabs down one side, the answer beside them. The shape support sites reach
	 * for once there are more topics than fit in one readable list.
	 *
	 * @return array
	 */
	private static function browse_by_topic()
	{
		return [
			'title' => __('Browse by Topic', 'faq-and-answers'),
			// Built on free blocks, sold with a licence. Declared rather
			// than derived — see BuiltIn::access().
			'access' => 'pro',
			'groups' => ['support'],
			'keywords' => ['tabs', 'vertical tabs', 'topics', 'sidebar', 'knowledge base'],
			'thumbnail' => 'browse-by-topic.svg',
			'content' => Parts::section(
				Parts::heading(__('Browse by topic', 'faq-and-answers'))
				. Parts::paragraph(__('Pick a subject on the left and the answer opens beside it.', 'faq-and-answers'))
				. Parts::block(
					'faa/sidebar-tab-faq',
					[
						'layout' => 'bordered',
						'sidebarPosition' => 'left',
						'maxPosts' => 8,
						'activateOn' => 'click',
						'mobileMode' => 'accordion',
						'showTabThumb' => true,
						'showPanelThumb' => true,
						'showPanelTitle' => true,
						'showTabNumber' => true,
						'contentSource' => 'excerpt',
						'excerptWords' => 60,
						'showReadMore' => true,
						'accent' => '#2563eb',
						'tabActiveColor' => '#1d4ed8',
						'navBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'tabActiveBg' => ['type' => 'solid', 'color' => '#eff4ff'],
						'panelBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'buttonColor' => '#2563eb',
						'buttonTextColor' => '#ffffff',
						'thumbSize' => '44px',
						'thumbRadius' => '8px',
						'panelThumbHeight' => '240px',
					]
				),
				'#eef3fb'
			),
		];
	}

	/**
	 * Symptom, then cause. A troubleshooting list is read differently from a
	 * FAQ — nobody browses it, they arrive with one thing broken — so the
	 * questions are phrased as the symptom the reader already has.
	 *
	 * @return array
	 */
	private static function troubleshooting()
	{
		$faqs = [
			Parts::faq(
				__('Display', 'faq-and-answers'),
				__('The block shows nothing on the page', 'faq-and-answers'),
				__('Nine times in ten the page is cached. Clear the cache, then reload with a hard refresh. If it is still empty, check the block is not set to a category that has no questions in it.', 'faq-and-answers')
			),
			Parts::faq(
				__('Display', 'faq-and-answers'),
				__('My colours are being ignored', 'faq-and-answers'),
				__('Something in the theme is winning on specificity. Open the block, set the colour you want, and if it still does not take, look for an !important rule in the theme\'s stylesheet against the same element.', 'faq-and-answers')
			),
			Parts::faq(
				__('Behaviour', 'faq-and-answers'),
				__('Questions will not open when clicked', 'faq-and-answers'),
				__('A JavaScript error elsewhere on the page stops every script after it, including this one. Open the browser console and fix whatever is reported first — it is rarely this plugin.', 'faq-and-answers')
			),
			Parts::faq(
				__('Behaviour', 'faq-and-answers'),
				__('The layout breaks on mobile only', 'faq-and-answers'),
				__('Check the width you set for the block. A fixed pixel width wider than a phone screen cannot fold, so use a percentage or leave it unset and let the block fill its column.', 'faq-and-answers')
			),
			Parts::faq(
				__('Search engines', 'faq-and-answers'),
				__('Google is not showing my FAQ rich result', 'faq-and-answers'),
				__('The markup is only half of it. Keep FAQ schema on one block per page, make sure the questions are visible without clicking, and give Search Console a few weeks — rich results are never guaranteed.', 'faq-and-answers')
			),
			Parts::faq(
				__('Search engines', 'faq-and-answers'),
				__('Two FAQ blocks on one page, which one wins?', 'faq-and-answers'),
				__('Neither reliably. Pick the block a search engine should read, and switch the schema off on the other one in its settings.', 'faq-and-answers')
			),
		];

		$subtitle = '<!-- wp:paragraph {"align":"center","style":{"color":{"text":"#cbd5e1"}}} -->'
			. '<p class="has-text-align-center has-text-color" style="color:#cbd5e1;">'
			. esc_html(__('Find the symptom, then the fix. Most of these take under a minute.', 'faq-and-answers'))
			. '</p>'
			. '<!-- /wp:paragraph -->';

		$styles = [
			'heading'   => ['title' => [], 'subTitle' => [], 'button' => []],
			'container' => [],
			'content'   => [
				'question' => [
					'background' => ['color' => '#5F27CE'],
					'colors'     => ['color' => '#ffffff'],
					'padding'    => [
						'desktop' => ['top' => '18px', 'right' => '24px', 'bottom' => '18px', 'left' => '24px'],
					],
					'typo'       => [
						'fontSize'   => ['desktop' => '17px', 'tablet' => '16px', 'mobile' => '15px'],
						'fontWeight' => '600',
					],
				],
				'answer'   => [
					'background' => ['color' => '#4c1fa8'],
					'colors'     => ['color' => '#ffffff'],
					'padding'    => [
						'desktop' => ['top' => '18px', 'right' => '24px', 'bottom' => '22px', 'left' => '24px'],
					],
					'typo'       => [
						'fontSize'   => ['desktop' => '15px', 'tablet' => '14px', 'mobile' => '14px'],
					],
				],
				'icon'     => [
					'size'       => ['desktop' => '56px', 'tablet' => '48px', 'mobile' => '42px'],
					'background' => ['color' => 'linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%)'],
					'colors'     => ['color' => '#ffffff'],
				],
			],
		];

		return [
			'title' => __('Troubleshooting', 'faq-and-answers'),
			'groups' => ['support'],
			'keywords' => ['troubleshooting', 'fix', 'problem', 'errors', 'support', 'diagnose'],
			'thumbnail' => 'troubleshooting.svg',
			'content' => Parts::section(
				Parts::heading(__('Something not working?', 'faq-and-answers'), 2, '#ffffff')
				. $subtitle
				. Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeNine', 'Styles' => $styles]),
				'#172a3a'
			),
		];
	}



	/**
	 * The posts you have already written, as an FAQ. Compact layout, because a
	 * support index is a list to scan rather than a page to read.
	 *
	 * @return array
	 */
	private static function support_articles()
	{
		return [
			'title' => __('Support Articles', 'faq-and-answers'),
			// Built on free blocks, sold with a licence. Declared rather
			// than derived — see BuiltIn::access().
			'access' => 'pro',
			'groups' => ['support'],
			'keywords' => ['articles', 'docs', 'documentation', 'knowledge base', 'compact'],
			'thumbnail' => 'support-articles.svg',
			'content' => Parts::section(
				Parts::heading(__('Support articles', 'faq-and-answers'))
				. Parts::paragraph(__('Everything we have written down, newest first. Open one to read the summary.', 'faq-and-answers'))
				. Parts::block(
					'faa/post-faq',
					[
						'layout' => 'compact',
						'postType' => 'post',
						'orderBy' => 'modified',
						'order' => 'desc',
						'batchSize' => 6,
						'maxPosts' => 24,
						'showThumb' => true,
						'showAuthor' => false,
						'showCategory' => true,
						'showDate' => true,
						'showReadTime' => true,
						'excerptWords' => 35,
						'closeOthers' => true,
						'enableLoadMore' => true,
						'loadMoreText' => __('Show more articles', 'faq-and-answers'),
						'accent' => '#0f766e',
						'headerBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'headerActiveBg' => ['type' => 'solid', 'color' => '#effaf8'],
						'bodyBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'buttonColor' => '#0f766e',
						'buttonTextColor' => '#ffffff',
						'itemBorder' => ['width' => '1px', 'style' => 'solid', 'color' => '#d7e8e5', 'side' => 'all', 'radius' => '10px'],
					]
				),
				'#eff7f6'
			),
		];
	}

	/**
	 * @return array
	 */
	private static function from_the_blog()
	{
		return [
			'title' => __('Answers From the Blog', 'faq-and-answers'),
			// Built on free blocks, sold with a licence. Declared rather
			// than derived — see BuiltIn::access().
			'access' => 'pro',
			'groups' => ['support'],
			'keywords' => ['posts', 'blog', 'articles', 'knowledge base'],
			'thumbnail' => 'from-the-blog.svg',
			'content' => Parts::section(
				Parts::heading(__('Read up on it', 'faq-and-answers'))
				. Parts::paragraph(__('Longer answers, pulled straight from what we have already written.', 'faq-and-answers'))
				. Parts::block(
					'faa/post-faq',
					[
						'layout' => 'classic',
						'postType' => 'post',
						'orderBy' => 'date',
						'order' => 'desc',
						'batchSize' => 5,
						'maxPosts' => 15,
						'openFirst' => true,
						'activateOn' => 'hover',
						'showThumb' => true,
						'showAuthor' => false,
						'showDate' => true,
						'showReadTime' => true,
						'excerptWords' => 45,
						'showClose' => true,
						'enableLoadMore' => true,
						'accent' => '#e94b4b',
						'headerBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'headerActiveBg' => ['type' => 'solid', 'color' => '#fdf1f1'],
						'bodyBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'buttonColor' => '#1f2937',
						'buttonTextColor' => '#ffffff',
						'itemBorder' => ['width' => '1px', 'style' => 'solid', 'color' => '#e7e4e2', 'side' => 'all', 'radius' => '10px'],
						'thumbRadius' => '8px',
					]
				),
				''
			),
		];
	}

	/**
	 * @return array
	 */
	private static function ask_a_question()
	{
		return [
			'title' => __('Ask a Question', 'faq-and-answers'),
			// Built on free blocks, sold with a licence. Declared rather
			// than derived — see BuiltIn::access().
			'access' => 'pro',
			'groups' => ['support'],
			'keywords' => ['form', 'contact', 'submit', 'question'],
			'thumbnail' => 'ask-a-question.svg',
			'content' => Parts::section(
				Parts::block(
					'faa/faq-form',
					[
						'showHeading' => false,
						'showSubheading' => false,
						'heading' => '',
						'subheading' => '',
						'showAnswer' => true,
						'accent' => '#2563eb',
						'buttonHoverBg' => '#1d4ed8',
						'cardBg' => '#ffffff',
						'labelColor' => '#4b5563',
						'inputColor' => '#111827',
						'inputBorder' => ['width' => '1px', 'style' => 'solid', 'color' => '#d8dee9', 'side' => 'all', 'radius' => '8px'],
						'inputFocusBorderColor' => '#2563eb',
						'radius' => 14,
					]
				),
				''
			),
		];
	}

	/* ----------------------------------------------------- getting started */

	/**
	 * Numbered steps in order. The questions are deliberately not questions —
	 * a first-run guide is a sequence, and phrasing step three as "How do I…"
	 * invites reading it out of order.
	 *
	 * @return array
	 */
	private static function step_by_step()
	{
		$faqs = [
			Parts::faq(
				__('Projects', 'faq-and-answers'),
				__('Brand Identity Design', 'faq-and-answers'),
				__('Comprehensive visual identity system including logo design, color palette, typography guidelines, and brand assets.', 'faq-and-answers')
			),
			Parts::faq(
				__('Projects', 'faq-and-answers'),
				__('Website Design & Development', 'faq-and-answers'),
				__('Custom responsive WordPress website crafted with modern UI/UX principles, high performance, and SEO optimization.', 'faq-and-answers')
			),
			Parts::faq(
				__('Projects', 'faq-and-answers'),
				__('E-commerce Product Showcase', 'faq-and-answers'),
				__('Conversion-focused online store experience with seamless checkout, product filtering, and mobile optimization.', 'faq-and-answers')
			),
			Parts::faq(
				__('Projects', 'faq-and-answers'),
				__('Mobile App Interface Design', 'faq-and-answers'),
				__('User-centric iOS and Android mobile app UI design focused on intuitive navigation and seamless user journeys.', 'faq-and-answers')
			),
			Parts::faq(
				__('Projects', 'faq-and-answers'),
				__('Marketing Campaign Visuals', 'faq-and-answers'),
				__('High-converting social media templates, ad banners, and promotional graphics tailored for your target audience.', 'faq-and-answers')
			),
			Parts::faq(
				__('Projects', 'faq-and-answers'),
				__('Corporate Presentation Design', 'faq-and-answers'),
				__('Professional pitch deck and slide presentation design that effectively communicates your business story and metrics.', 'faq-and-answers')
			),
		];

		$left = Parts::subheading(__('Projects and Case Studies', 'faq-and-answers'), 2, '#111827')
			. Parts::paragraph(__('This section highlights a selection of projects I\'ve worked on, showing how I approach different challenges and deliver practical, well-crafted solutions for clients.', 'faq-and-answers'), 'left', '#4b5563')
			. Parts::button(__('Let\'s Work Together', 'faq-and-answers'), '#', '#0f172a', '#ffffff');

		$right = Parts::block('faa/faq-and-answers', [
			'faqData' => $faqs,
			'theme'   => 'themeOne',
			'Styles'  => [
				'heading'   => ['title' => [], 'subTitle' => [], 'button' => []],
				'container' => [],
				'content'   => [
					'question' => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#111827'],
						'padding'    => [
							'desktop' => ['top' => '16px', 'right' => '20px', 'bottom' => '16px', 'left' => '20px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#f9fafb'],
						'colors'     => ['color' => '#4b5563'],
						'padding'    => [
							'desktop' => ['top' => '16px', 'right' => '20px', 'bottom' => '20px', 'left' => '20px'],
						],
					],
					'icon'     => [
						'size' => [
							'desktop' => '30px',
							'tablet'  => '26px',
							'mobile'  => '24px',
						],
					],
				],
			],
		]);

		return [
			'title' => __('Getting Started', 'faq-and-answers'),
			'groups' => ['onboarding'],
			'keywords' => ['step by step', 'steps', 'onboarding', 'setup', 'guide', 'how to', 'projects', 'case studies'],
			'thumbnail' => 'step-by-step.svg',
			'content' => Parts::section(
				Parts::columns([
					['width' => '44%', 'vertical' => 'center', 'inner' => $left],
					['width' => '56%', 'vertical' => 'center', 'inner' => $right],
				], 'center'),
				'#ffffff'
			),
		];
	}

	/**
	 * Things to tick off before going live. Each entry is an action, not a
	 * question, and the answer says how to tell it is done.
	 *
	 * @return array
	 */
	private static function launch_checklist()
	{
		$faqs = [
			Parts::faq(
				__('Content', 'faq-and-answers'),
				__('Every question has an answer', 'faq-and-answers'),
				__('Read the section end to end before publishing. A question with nothing under it is worse than no question at all — it tells a visitor you knew to ask it and stopped there.', 'faq-and-answers')
			),
			Parts::faq(
				__('Content', 'faq-and-answers'),
				__('The answers say what happens next', 'faq-and-answers'),
				__('An answer that stops at “yes” leaves the reader where they started. Finish each one with the link or the step they need.', 'faq-and-answers')
			),
			Parts::faq(
				__('Technical', 'faq-and-answers'),
				__('Only one block carries FAQ schema', 'faq-and-answers'),
				__('Two sets of FAQ markup on one page compete with each other. Pick the block a search engine should read and switch schema off on the rest.', 'faq-and-answers')
			),
			Parts::faq(
				__('Technical', 'faq-and-answers'),
				__('It reads correctly on a phone', 'faq-and-answers'),
				__('Open the page on an actual phone, not just a narrow window. Check the tap targets, the font size, and that nothing scrolls sideways.', 'faq-and-answers')
			),
		];

		$left = Parts::block('faa/faq-and-answers', [
			'faqData' => $faqs,
			'theme'   => 'themeOne',
			'Styles'  => [
				'heading'   => ['title' => [], 'subTitle' => [], 'button' => []],
				'container' => [],
				'content'   => [
					'question' => [
						'background' => ['color' => '#1e293b'],
						'colors'     => ['color' => '#ffffff'],
						'padding'    => [
							'desktop' => ['top' => '16px', 'right' => '20px', 'bottom' => '16px', 'left' => '20px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#0f172a'],
						'colors'     => ['color' => '#cbd5e1'],
						'padding'    => [
							'desktop' => ['top' => '16px', 'right' => '20px', 'bottom' => '20px', 'left' => '20px'],
						],
					],
					'icon'     => [
						'size'   => [
							'desktop' => '30px',
							'tablet'  => '26px',
							'mobile'  => '24px',
						],
						'colors' => ['color' => '#ffffff'],
					],
				],
			],
		]);

		$right = Parts::subheading(__('Before You Go Live', 'faq-and-answers'), 2, '#ffffff')
			. Parts::paragraph(__('Four essential things worth checking before publishing your site. Open each checklist item for guidance on completing your pre-launch audit.', 'faq-and-answers'), 'left', '#cbd5e1')
			. Parts::button(__('Start Pre-Launch Audit', 'faq-and-answers'), '#', '#6366f1', '#ffffff');

		return [
			'title' => __('Launch Checklist', 'faq-and-answers'),
			'groups' => ['onboarding'],
			'keywords' => ['checklist', 'launch', 'pre-launch', 'audit', 'go live'],
			'thumbnail' => 'launch-checklist.svg',
			'content' => Parts::section(
				Parts::columns([
					['width' => '56%', 'vertical' => 'center', 'inner' => $left],
					['width' => '44%', 'vertical' => 'center', 'inner' => $right],
				], 'center'),
				'#0f172a'
			),
		];
	}

	/**
	 * What happens, and when. The pattern every "after you order" and "after
	 * you apply" page needs, where the reader's real question is how long.
	 *
	 * @return array
	 */
	private static function what_happens_next()
	{
		$faqs = [
			Parts::faq(
				__('Straight away', 'faq-and-answers'),
				__('Today — you get a confirmation', 'faq-and-answers'),
				__('An email with your order number arrives within a few minutes. If it has not, check the spam folder before writing to us — that is where it is nine times out of ten.', 'faq-and-answers')
			),
			Parts::faq(
				__('This week', 'faq-and-answers'),
				__('Day 1 to 2 — we get in touch', 'faq-and-answers'),
				__('Someone reads what you sent and replies with either the answer or the one question we need to get started. Always a person, never a form response.', 'faq-and-answers')
			),
			Parts::faq(
				__('This week', 'faq-and-answers'),
				__('Day 3 to 5 — the work starts', 'faq-and-answers'),
				__('You get access to a shared board where you can see what is being worked on and what is waiting on you. No status meetings.', 'faq-and-answers')
			),
			Parts::faq(
				__('Later', 'faq-and-answers'),
				__('Week 2 — first thing to look at', 'faq-and-answers'),
				__('Something real, on a staging site, that you can click. We would rather show you early and be wrong than show you late and be close.', 'faq-and-answers')
			),
			Parts::faq(
				__('Later', 'faq-and-answers'),
				__('Week 4 — handover', 'faq-and-answers'),
				__('Everything live, plus the recording and notes on how to change it yourself. Support carries on after that whether or not you need it.', 'faq-and-answers')
			),
		];

		return [
			'title' => __('What Happens Next', 'faq-and-answers'),
			'groups' => ['onboarding'],
			'keywords' => ['timeline', 'process', 'what happens next', 'onboarding', 'stages'],
			'thumbnail' => 'what-happens-next.svg',
			'content' => Parts::section(
				Parts::heading(__('What happens next', 'faq-and-answers'), 2, '#ffffff')
				. Parts::paragraph(__('From the moment you order to the day it is yours.', 'faq-and-answers'), 'center', '#cbd5e1')
				. Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeThree']),
				'#0f172a'
			),
		];
	}

	/* -------------------------------------------------------- sales pages */

	/**
	 * The questions people ask in the last minute before they buy, and the form
	 * that catches whatever is left. Free, so it is usable on any install — a
	 * pricing page is the one page every site has.
	 *
	 * @return array
	 */
	private static function pricing_objections()
	{
		$faqs = [
			Parts::faq(
				__('Buying', 'faq-and-answers'),
				__('Which plan is right for me?', 'faq-and-answers'),
				__('Start on the smallest one that covers the sites you have today. Upgrading takes a click and you only pay the difference for the rest of the term, so there is nothing to lose by starting small.', 'faq-and-answers')
			),
			Parts::faq(
				__('Buying', 'faq-and-answers'),
				__('What happens when my licence expires?', 'faq-and-answers'),
				__('Nothing on your site stops working. You keep the version you have and everything built with it — what lapses is access to updates and support until you renew.', 'faq-and-answers')
			),
			Parts::faq(
				__('Buying', 'faq-and-answers'),
				__('Can I use one licence on client sites?', 'faq-and-answers'),
				__('Yes, up to the number of sites your plan covers, and it does not matter who owns them. Agencies usually take the highest tier for exactly this reason.', 'faq-and-answers')
			),
			Parts::faq(
				__('Risk', 'faq-and-answers'),
				__('What if it does not work for me?', 'faq-and-answers'),
				__('Ask for a refund within 30 days and you get the money back, no questions and no form to fill in. We would rather you spent it somewhere that fits.', 'faq-and-answers')
			),
			Parts::faq(
				__('Risk', 'faq-and-answers'),
				__('Will this slow my site down?', 'faq-and-answers'),
				__('Each block loads only its own styles and script, and only on pages that use it. A page with no FAQ on it loads nothing at all from this plugin.', 'faq-and-answers')
			),
		];

		$leftFaq = Parts::block('faa/faq-and-answers', [
			'faqData' => $faqs,
			'theme'   => 'themeFourteen',
			'Styles'  => [
				'content' => [
					'question' => [
						'padding' => [
							'desktop' => [
								'top'    => '0px',
								'right'  => '0px',
								'bottom' => '0px',
								'left'   => '0px',
							],
							'tablet'  => [
								'top'    => '0px',
								'right'  => '0px',
								'bottom' => '0px',
								'left'   => '0px',
							],
							'mobile'  => [
								'top'    => '0px',
								'right'  => '0px',
								'bottom' => '0px',
								'left'   => '0px',
							],
						],
					],
					'icon' => [
						'background' => [
							'color' => '#9ca052',
						],
					],
				],
			],
		]);

		$rightForm = Parts::block(
			'faa/faq-form',
			[
				'showHeading' => false,
				'showSubheading' => false,
				'showName' => false,
				'showDetails' => false,
				'showAnswer' => true,
				'accent' => '#0d7a5f',
				'buttonHoverBg' => '#095744',
				'cardBg' => '#ffffff',
				'inputBorder' => ['width' => '1px', 'style' => 'solid', 'color' => '#e2e8f0', 'side' => 'all', 'radius' => '8px'],
				'inputFocusBorderColor' => '#0d7a5f',
				'radius' => 14,
			]
		);

		return [
			'title' => __('Pricing & Objections', 'faq-and-answers'),
			'groups' => ['sales'],
			'keywords' => ['pricing', 'sales', 'objections', 'buy', 'checkout', 'conversion'],
			'thumbnail' => 'pricing-objections.svg',
			'content' => Parts::section(
				Parts::heading(__('Questions before you buy', 'faq-and-answers'))
				. Parts::paragraph(__('The things people ask us most in the last minute before they decide.', 'faq-and-answers'))
				. Parts::columns([
					['width' => '56%', 'vertical' => 'top', 'inner' => $leftFaq],
					['width' => '44%', 'vertical' => 'top', 'inner' => $rightForm],
				], 'top'),
				'#ffffff'
			),
		];
	}


	/**
	 * A grid rather than a list. Every answer visible at once, which is what a
	 * landing page wants — nobody clicks four accordions on the way to a
	 * pricing table.
	 *
	 * @return array
	 */
	private static function faq_grid()
	{
		$items = [
			Parts::card(
				'⚡',
				__('How fast can we start?', 'faq-and-answers'),
				__('Same day. Install it, drop a block on a page, and you are running — there is no setup call and nothing to migrate.', 'faq-and-answers'),
				'large',
				__('Popular', 'faq-and-answers')
			),
			Parts::card(
				'🔒',
				__('Where does my data live?', 'faq-and-answers'),
				__('In your own database, on your own hosting. Nothing is sent anywhere else, and there is no account to create.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'🎨',
				__('Will it match our brand?', 'faq-and-answers'),
				__('Colours, type and spacing are all yours to set, per block. It inherits the theme first, so it looks right before you touch anything.', 'faq-and-answers'),
				'normal'
			),
			Parts::card(
				'📱',
				__('Does it work on mobile?', 'faq-and-answers'),
				__('Every layout folds down on its own — columns become one, tabs become an accordion, and images stack above their text.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'🔍',
				__('Will Google pick it up?', 'faq-and-answers'),
				__('FAQ schema is printed for you on whichever block you choose. Keep it to one block per page and the markup is valid.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'💬',
				__('What if we get stuck?', 'faq-and-answers'),
				__('Write to us. Replies come from the people who wrote it, usually within a working day.', 'faq-and-answers'),
				'normal'
			),
		];

		return [
			'title' => __('FAQ Grid', 'faq-and-answers'),
			'groups' => ['sales'],
			'keywords' => ['grid', 'bento', 'cards', 'landing page', 'table'],
			'thumbnail' => 'faq-grid.svg',
			'content' => Parts::section(
				Parts::heading(__('Everything you might be wondering', 'faq-and-answers'), 2, '#ffffff')
				. Parts::paragraph(__('No clicking required — it is all on the page.', 'faq-and-answers'), 'center', '#ffffff')
				. Parts::block(
					'faa/bento-faq',
					[
						'items' => $items,
						'openMode' => 'modal',
						'columns' => ['desktop' => 4, 'tablet' => 2, 'mobile' => 1],
						'showIcons' => true,
						'showExcerpt' => true,
						'accent' => '#7c3aed',
						'cardBg' => '#ffffff',
						'cardBorder' => '#e7e1fa',
						'cardRadius' => '18px',
					]
				),
				'#0693e3'
			),
		];
	}

	/**
	 * @return array
	 */
	private static function service_spotlight()
	{
		// Deliberately a different set of pictures from the ones a fresh Image
		// FAQ block starts with, so dropping this template in does not produce
		// something identical to what the block already showed.
		$panels = [
			Parts::panel(
				'city.svg',
				__('A city skyline at blue hour', 'faq-and-answers'),
				__('Web Development', 'faq-and-answers'),
				__('Sites built to load fast and stay easy to change, with no framework you will have to pay someone to understand later.', 'faq-and-answers')
			),
			Parts::panel(
				'coast.svg',
				__('A lighthouse above a turquoise coast', 'faq-and-answers'),
				__('UI & UX Design', 'faq-and-answers'),
				__('Interfaces designed around what people are actually trying to do, then tested with them before a line is written.', 'faq-and-answers')
			),
			Parts::panel(
				'forest.svg',
				__('Pines in morning mist', 'faq-and-answers'),
				__('SEO Optimisation', 'faq-and-answers'),
				__('Technical fixes and content work that compound, measured against traffic you can trace to a page.', 'faq-and-answers')
			),
			Parts::panel(
				'desert.svg',
				__('Rolling dunes under a low sun', 'faq-and-answers'),
				__('E-commerce Solutions', 'faq-and-answers'),
				__('Product management, secure payments and a checkout short enough that people finish it.', 'faq-and-answers')
			),
			Parts::panel(
				'peaks.svg',
				__('Snow-capped peaks at sunrise', 'faq-and-answers'),
				__('Support & Maintenance', 'faq-and-answers'),
				__('Updates, backups and someone who answers when something breaks at an inconvenient hour.', 'faq-and-answers')
			),
		];

		return [
			'title' => __('Service Spotlight', 'faq-and-answers'),
			'groups' => ['sales'],
			'keywords' => ['image', 'accordion', 'services', 'showcase'],
			'thumbnail' => 'service-spotlight.svg',
			'content' => Parts::section(
				Parts::heading(__('What we do', 'faq-and-answers'), 2, '#111827', 'x-large')
				. Parts::block(
					'faa/image-faq',
					[
						'template' => 'spotlight',
						'items' => $panels,
						'activateOn' => 'click',
						'overlayBg' => ['type' => 'solid', 'color' => 'rgba(0,0,0,0.55)'],
						'useScrim' => false,
						'titleColor' => '#ffffff',
						'descColor' => 'rgba(255,255,255,0.88)',
						'buttonBg' => 'rgba(255,255,255,0.16)',
						'buttonColor' => '#ffffff',
					]
				),
				''
			),
		];
	}
}

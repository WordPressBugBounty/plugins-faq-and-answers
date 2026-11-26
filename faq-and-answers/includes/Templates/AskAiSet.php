<?php
/**
 * Ask AI theme templates — an Ask AI block in one of its design themes, with a
 * Tabbed FAQ underneath for visitors who would rather browse than ask.
 *
 * The Ask AI block only gets the theme and its text: colours and sizes are
 * left to the theme on purpose (see src/blocks/ask-ai/utils/themes.js), so the
 * sidebar starts from the theme rather than from hard-coded values. The Tabbed
 * FAQ reuses TabbedSet's preset builder and is tinted to match.
 *
 * Both blocks are in BuiltIn::PRO_BLOCKS, so these templates are pro.
 * Text contains no double quotes — see Parts::icons() for why.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class AskAiSet {

	/**
	 * @return array
	 */
	public static function all() {
		return [
			self::spotlight_help_centre(),
			self::nebula_product_help(),
		];
	}

	/* ------------------------------------------------- Spotlight theme */

	private static function spotlight_help_centre() {
		$ask = Parts::block(
			'faa/ask-ai',
			[
				'askTheme'     => 'spotlight',
				'align'        => 'wide',
				'heading'      => __('How can we help?', 'faq-and-answers'),
				'subheading'   => __('Ask in your own words and get an instant answer from our help centre.', 'faq-and-answers'),
				'placeholders' => [
					__('Where is my order?', 'faq-and-answers'),
					__('How do I return an item?', 'faq-and-answers'),
					__('Do you ship internationally?', 'faq-and-answers'),
				],
				'suggestions'  => [
					__('Where is my order?', 'faq-and-answers'),
					__('How do I return an item?', 'faq-and-answers'),
					__('Which payment methods do you accept?', 'faq-and-answers'),
				],
				'fallbackText' => __('Still stuck? Talk to our team', 'faq-and-answers'),
			]
		);

		$tabs = [
			TabbedSet::tab(__('Orders & Shipping', 'faq-and-answers'), [
				TabbedSet::q(__('How long does delivery take?', 'faq-and-answers'), __('Orders leave our warehouse within one working day. Standard delivery takes 2 to 4 working days and express arrives the next day.', 'faq-and-answers')),
				TabbedSet::q(__('How do I track my order?', 'faq-and-answers'), __('A tracking link is emailed as soon as your parcel ships. You can also follow it from My Account under Orders.', 'faq-and-answers')),
				TabbedSet::q(__('Do you ship internationally?', 'faq-and-answers'), __('We ship to more than 40 countries. Duties and delivery times are shown at checkout before you pay.', 'faq-and-answers')),
				TabbedSet::q(__('Can I change my delivery address?', 'faq-and-answers'), __('Yes, until the order ships. Open the order in My Account and choose Change address.', 'faq-and-answers')),
			], __('Orders and shipping', 'faq-and-answers')),
			TabbedSet::tab(__('Returns & Refunds', 'faq-and-answers'), [
				TabbedSet::q(__('What is your return policy?', 'faq-and-answers'), __('Return any unused item within 30 days for a full refund. Return shipping is free for exchanges.', 'faq-and-answers')),
				TabbedSet::q(__('When will I get my refund?', 'faq-and-answers'), __('Refunds go back to your original payment method within 3 to 5 working days of the return arriving.', 'faq-and-answers')),
				TabbedSet::q(__('Can I exchange for another size?', 'faq-and-answers'), __('Yes. Choose Exchange when you start the return and we send the new size as soon as the old one is scanned.', 'faq-and-answers')),
			]),
			TabbedSet::tab(__('Payments', 'faq-and-answers'), [
				TabbedSet::q(__('Which payment methods do you accept?', 'faq-and-answers'), __('All major cards, PayPal, Apple Pay and Google Pay. Every payment is encrypted end to end.', 'faq-and-answers')),
				TabbedSet::q(__('Can I pay in instalments?', 'faq-and-answers'), __('Orders over 50 can be split into three interest free payments at checkout.', 'faq-and-answers')),
			]),
			TabbedSet::tab(__('Account', 'faq-and-answers'), [
				TabbedSet::q(__('Do I need an account to order?', 'faq-and-answers'), __('No. Guest checkout works for every order. An account just makes tracking and returns faster.', 'faq-and-answers')),
				TabbedSet::q(__('How do I reset my password?', 'faq-and-answers'), __('Choose Forgot password on the sign in page and we email you a reset link that works for one hour.', 'faq-and-answers')),
			]),
		];

		$tabbed = TabbedSet::block('pills', $tabs, [
			'openFirst'             => true,
			'containerBg'           => ['type' => 'solid', 'color' => '#faf8ff'],
			'tabActiveBg'           => '#7c3aed',
			'tabActiveBorderColor'  => '#7c3aed',
			'questionActiveColor'   => '#7c3aed',
			'iconColor'             => '#7c3aed',
			'cardActiveBorderColor' => '#ddd6fe',
		]);

		return [
			'title'     => __('AI Help Centre — Spotlight + Tabbed FAQ', 'faq-and-answers'),
			'slug'      => 'ai-help-centre-spotlight-tabbed-faq',
			'groups'    => ['support'],
			'keywords'  => ['ask ai', 'ai', 'spotlight', 'search', 'help centre', 'tabs', 'tabbed', 'store', 'support', 'pro'],
			'thumbnail' => 'ai-help-centre-spotlight.webp',
			'content'   => Parts::section_wide($ask . $tabbed),
		];
	}

	/* ---------------------------------------------------- Nebula theme */

	private static function nebula_product_help() {
		$ask = Parts::block(
			'faa/ask-ai',
			[
				'askTheme'     => 'nebula',
				'align'        => 'wide',
				'heading'      => __('Ask the product expert', 'faq-and-answers'),
				'subheading'   => __('Instant answers about setup, billing and integrations, straight from our docs.', 'faq-and-answers'),
				'placeholders' => [
					__('How do I connect Slack?', 'faq-and-answers'),
					__('Can I change my plan later?', 'faq-and-answers'),
					__('Is my data encrypted?', 'faq-and-answers'),
				],
				'suggestions'  => [
					__('How do I get started?', 'faq-and-answers'),
					__('Can I change my plan later?', 'faq-and-answers'),
				],
				'fallbackText' => __('Book a call with support', 'faq-and-answers'),
			]
		);

		$tabs = [
			TabbedSet::tab(__('Getting Started', 'faq-and-answers'), [
				TabbedSet::q(__('How long does setup take?', 'faq-and-answers'), __('Most teams are live in under ten minutes. Connect your workspace, invite your team and import your first project.', 'faq-and-answers')),
				TabbedSet::q(__('Is there a free trial?', 'faq-and-answers'), __('Every plan starts with a 14 day free trial. No card is needed to begin.', 'faq-and-answers')),
				TabbedSet::q(__('Can I import from another tool?', 'faq-and-answers'), __('Yes. One click importers bring in projects, tasks and comments from the most popular tools.', 'faq-and-answers')),
			], __('Getting started', 'faq-and-answers')),
			TabbedSet::tab(__('Billing', 'faq-and-answers'), [
				TabbedSet::q(__('Can I change my plan later?', 'faq-and-answers'), __('Upgrade or downgrade at any time from Settings. The difference is prorated to the day.', 'faq-and-answers')),
				TabbedSet::q(__('Do you offer annual billing?', 'faq-and-answers'), __('Annual plans are billed once a year and cost two months less than paying monthly.', 'faq-and-answers')),
			]),
			TabbedSet::tab(__('Integrations', 'faq-and-answers'), [
				TabbedSet::q(__('Which apps do you integrate with?', 'faq-and-answers'), __('Slack, Google Drive, GitHub, Zapier and more than 60 others, plus an open API for anything else.', 'faq-and-answers')),
				TabbedSet::q(__('Is there an API?', 'faq-and-answers'), __('A full REST API and webhooks are included on every paid plan, with keys managed per workspace.', 'faq-and-answers')),
			]),
			TabbedSet::tab(__('Security', 'faq-and-answers'), [
				TabbedSet::q(__('Is my data encrypted?', 'faq-and-answers'), __('Data is encrypted in transit with TLS 1.3 and at rest with AES 256. Backups are encrypted too.', 'faq-and-answers')),
				TabbedSet::q(__('Do you support single sign on?', 'faq-and-answers'), __('SAML single sign on and SCIM provisioning are available on the Business plan.', 'faq-and-answers')),
			]),
		];

		// A dark Tabbed FAQ to sit under the dark Nebula card.
		$tabbed = TabbedSet::block('pills', $tabs, [
			'openFirst'             => true,
			'containerBg'           => ['type' => 'solid', 'color' => '#12102a'],
			'containerBorder'       => ['width' => '1px', 'style' => 'solid', 'color' => '#24213f', 'side' => 'all', 'radius' => '22px'],
			'tabColor'              => '#c4c1dd',
			'tabBg'                 => '#1a1736',
			'tabBorder'             => ['width' => '1px', 'style' => 'solid', 'color' => '#2c2850', 'side' => 'all', 'radius' => '999px'],
			'tabActiveColor'        => '#ffffff',
			'tabActiveBg'           => '#7c3aed',
			'tabActiveBorderColor'  => '#7c3aed',
			'headingColor'          => '#ffffff',
			'cardBg'                => '#17142f',
			'cardActiveBg'          => '#1c1838',
			'cardBorder'            => ['width' => '1px', 'style' => 'solid', 'color' => '#2a2647', 'side' => 'all', 'radius' => '14px'],
			'cardActiveBorderColor' => '#7c3aed',
			'cardShadow'            => false,
			'questionColor'         => '#eeecf8',
			'questionActiveColor'   => '#c4b5fd',
			'answerColor'           => '#a9a5c6',
			'iconColor'             => '#a78bfa',
		]);

		return [
			'title'     => __('AI Product Help — Nebula + Tabbed FAQ', 'faq-and-answers'),
			'slug'      => 'ai-product-help-nebula-tabbed-faq',
			'groups'    => ['support'],
			'keywords'  => ['ask ai', 'ai', 'nebula', 'dark', 'saas', 'software', 'tabs', 'tabbed', 'support', 'pro'],
			'thumbnail' => 'ai-product-help-nebula.webp',
			'content'   => Parts::section_wide($ask . $tabbed, '#0a0918'),
		];
	}
}

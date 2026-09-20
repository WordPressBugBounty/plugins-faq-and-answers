<?php
/**
 * Two-column arrangements, and the blocks that only come with a licence.
 *
 * Everything here is pro, but not because it says so — BuiltIn::access() reads
 * the content and finds either a premium block (Nested FAQ, Ask AI) or one of
 * the premium Awesome FAQ themes. That is the point of deriving it: these
 * templates are pro because of what they are built from, and if one were
 * rewritten onto free parts tomorrow it would start showing as free on its own.
 *
 * The columns stack below 782px without any help, which is what makes it safe
 * to put a form beside an FAQ. The text column is always the narrower one:
 * questions need the room, and a column of prose at half width reads better
 * short.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class ProSet {

	/**
	 * @return array
	 */
	public static function all() {
		return [
			self::pitch_beside_answers(),
			self::ask_while_you_read(),
			self::search_then_ask(),
			self::documentation_tree(),
			self::knowledge_hub(),
			self::ai_answer_desk(),
			self::plan_details(),
			self::feature_tour(),
		];
	}

	/* ------------------------------------------- left content, right FAQ */

	/**
	 * The pitch on the left, the objections on the right. What a landing page
	 * wants: the reason to buy stays on screen while the doubts are answered
	 * beside it, rather than the reader scrolling away from one to reach the
	 * other.
	 *
	 * @return array
	 */
	private static function pitch_beside_answers() {
		$faqs = [
			Parts::faq(
				__('Before you buy', 'faq-and-answers'),
				__('Is there a trial?', 'faq-and-answers'),
				__('There is a thirty-day refund instead, which amounts to the same thing without a card timer running. Install it, use it properly, and decide.', 'faq-and-answers')
			),
			Parts::faq(
				__('Before you buy', 'faq-and-answers'),
				__('How long until we are set up?', 'faq-and-answers'),
				__('An afternoon for most teams. There is nothing to migrate and no onboarding call to book — the first page can go live the same day.', 'faq-and-answers')
			),
			Parts::faq(
				__('Before you buy', 'faq-and-answers'),
				__('What if we outgrow the plan?', 'faq-and-answers'),
				__('Move up whenever you like and pay only the difference for the rest of the term. Nobody is ever charged for a plan they have stopped using.', 'faq-and-answers')
			),
			Parts::faq(
				__('Afterwards', 'faq-and-answers'),
				__('Who do we talk to when something breaks?', 'faq-and-answers'),
				__('The people who wrote it. Replies usually come within a working day, and there is no tier of support you have to pay extra to reach.', 'faq-and-answers')
			),
		];

		$left = Parts::subheading(__('Everything in one place', 'faq-and-answers'), 3)
			. Parts::text(__('One library of questions, ten ways to show it, and a form that turns what people ask into the next answer on the page.', 'faq-and-answers'))
			. Parts::bullets(
				[
					__('Ten layouts, from a plain accordion to a grid', 'faq-and-answers'),
					__('One library, reused across every page', 'faq-and-answers'),
					__('FAQ schema handled for you', 'faq-and-answers'),
					__('Thirty-day refund, no questions', 'faq-and-answers'),
				]
			)
			. Parts::button(__('See the plans', 'faq-and-answers'), '#', '#2563eb');

		$right = Parts::block('faa/faq-and-answers', [
			'faqData' => $faqs,
			'theme'   => 'themeFourteen',
			'Styles'  => [
				'heading'   => ['title' => [], 'subTitle' => [], 'button' => []],
				'container' => [],
				'content'   => [
					'question' => [
						'background' => ['color' => '#000000'],
						'colors'     => ['color' => '#ffffff'],
						'padding'    => [
							'desktop' => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
						],
					],
				],
			],
		]);

		$leftBannerContent = '<!-- wp:paragraph {"style":{"color":{"text":"#ffffff"}}} -->'
			. '<p class="wp-block-paragraph has-text-color" style="color:#ffffff;"><span style="display:inline-block;padding:4px 12px;border-radius:6px;font-size:12px;font-weight:600;letter-spacing:0.5px;background-color:rgba(255,255,255,0.18);color:#ffffff;">'
			. esc_html__('FAQ', 'faq-and-answers')
			. '</span></p>'
			. '<!-- /wp:paragraph -->'
			. Parts::heading(__('Answers to Frequently Asked Questions.', 'faq-and-answers'), 2, '#ffffff', 'XL', 'left')
			. Parts::paragraph(__('In our FAQ, you\'ll find concise answers to common questions about our service, Booking Steps. If you still have questions, feel free to reach out to us.', 'faq-and-answers'), 'left', '#e0e7ff', 'M');

		$rightBannerImage = '<!-- wp:group {"style":{"border":{"radius":"18px"},"color":{"background":"#ffffff"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->'
			. '<div class="wp-block-group has-background" style="border-radius:18px;background-color:#ffffff;padding:24px;text-align:center;">'
			. '<img src="' . esc_url(Parts::thumb('pitch-beside-answers.svg')) . '" alt="' . esc_attr__('FAQ Illustration', 'faq-and-answers') . '" style="max-width:100%;height:auto;border-radius:10px;" />'
			. '</div>'
			. '<!-- /wp:group -->';

		$banner = Parts::section(
			Parts::columns([
				['width' => '54%', 'vertical' => 'center', 'inner' => $leftBannerContent],
				['width' => '46%', 'vertical' => 'center', 'inner' => $rightBannerImage],
			]),
			'#ff6900',
			'20px'
		);

		$currentSection = Parts::heading(__('Why teams choose us', 'faq-and-answers'), 2, '#0f172a', 'L')
			. Parts::columns(
				[
					['width' => '42%', 'inner' => $left],
					['width' => '58%', 'inner' => $right],
				]
			);

		return [
			'title'     => __('Pitch Beside Answers', 'faq-and-answers'),
			'groups'    => ['sales'],
			'keywords'  => ['two column', 'left content right faq', 'landing page', 'objections', 'columns', 'banner'],
			'thumbnail' => 'pitch-beside-answers.svg',
			'content'   => Parts::section(
				$banner
					. '<!-- wp:spacer {"height":"36px"} --><div style="height:36px" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->'
					. $currentSection,
				''
			),
		];
	}

	/**
	 * Plan detail on the left, the small print as a tree on the right. Pricing
	 * questions nest — "what counts as a site" sits under "how is it licensed"
	 * — so the answers do too.
	 *
	 * @return array
	 */
	private static function plan_details() {
		$licensing = [
			Parts::faq_item(
				__('What counts as one site?', 'faq-and-answers'),
				__('One live installation. Staging and local copies of the same site are free and do not come out of your total.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Can I move a licence between sites?', 'faq-and-answers'),
				__('Yes, as often as you like. Deactivate it on the old site and it is immediately available on the next one.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Do client sites need their own?', 'faq-and-answers'),
				__('No. Your licence covers whatever you install it on, whoever owns the site, up to the number of sites on your plan.', 'faq-and-answers'),
				1
			),
		];

		$renewals = [
			Parts::faq_item(
				__('What happens if I do not renew?', 'faq-and-answers'),
				__('Everything on your site keeps working. What stops is updates and support, until you renew again.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Does the price go up at renewal?', 'faq-and-answers'),
				__('Not for you. The rate you buy at is the rate you renew at for as long as the licence stays active.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('How is it licensed?', 'faq-and-answers'),
			__('Per site, per year. Open this for what that means in the cases people actually ask about.', 'faq-and-answers'),
			0,
			$licensing,
			true
		)
			. Parts::faq_item(
				__('Renewals and lapses', 'faq-and-answers'),
				__('Nothing here is designed to catch you out, so it is all written down.', 'faq-and-answers'),
				0,
				$renewals
			)
			. Parts::faq_item(
				__('Invoices and VAT', 'faq-and-answers'),
				__('Every payment produces a proper invoice with your company details and VAT number on it, available from your account the moment it clears.', 'faq-and-answers'),
				0
			);

		$left = Parts::subheading(__('What you are buying', 'faq-and-answers'), 3)
			. Parts::text(__('One price, every feature, for a year of updates and support. There is no tier that unlocks the block you actually wanted.', 'faq-and-answers'))
			. Parts::bullets(
				[
					__('Every block and every theme included', 'faq-and-answers'),
					__('Unlimited questions and groups', 'faq-and-answers'),
					__('A year of updates and replies', 'faq-and-answers'),
					__('Use it on staging for free', 'faq-and-answers'),
				]
			)
			. Parts::button(__('Choose a plan', 'faq-and-answers'), '#', '#7c3aed');

		return [
			'title'     => __('Plan Details', 'faq-and-answers'),
			'groups'    => ['sales'],
			'keywords'  => ['pricing', 'licensing', 'nested', 'two column', 'small print', 'plans'],
			'thumbnail' => 'plan-details.svg',
			'content'   => Parts::section(
				Parts::heading(__('The details, before you ask', 'faq-and-answers'))
					. Parts::columns(
						[
							['width' => '40%', 'inner' => $left],
							[
								'width' => '60%',
								'inner' => Parts::wrap(
									'faa/nested-faq',
									[
										'template'            => 'default',
										'openFirst'           => true,
										'allowMultiple'       => false,
										'iconType'            => 'plus',
										'iconPosition'        => 'right',
										'questionColor'       => '#ffffff',
										'questionBg'          => ['type' => 'solid', 'color' => '#7c3aed'],
										'questionOpenColor'   => '#ffffff',
										'questionOpenBg'      => ['type' => 'solid', 'color' => '#6d28d9'],
										'nestedQuestionColor' => '#3b2a63',
										'nestedQuestionBg'    => ['type' => 'solid', 'color' => '#f3effe'],
										'answerColor'         => '#4b5563',
										'answerBg'            => ['type' => 'solid', 'color' => '#ffffff'],
										'itemBorder'          => ['width' => '0px', 'style' => 'solid', 'color' => '#e5e7eb', 'side' => 'all', 'radius' => '12px'],
									],
									$tree
								),
							],
						]
					),
				'#f4f0fd'
			),
		];
	}

	/* ---------------------------------------------- left form, right FAQ */

	/**
	 * The form on the left, the answers on the right.
	 *
	 * Deliberately this way round: somebody who has decided to write to you
	 * should not have to scroll past forty questions to find the box, and
	 * somebody still browsing gets the list at eye level either way.
	 *
	 * @return array
	 */
	private static function ask_while_you_read() {
		$faqs = [
			Parts::faq(
				__('Before you write', 'faq-and-answers'),
				__('How quickly will I hear back?', 'faq-and-answers'),
				__('One working day for almost everything. If it is going to take longer than that, you get a message saying so rather than silence.', 'faq-and-answers')
			),
			Parts::faq(
				__('Before you write', 'faq-and-answers'),
				__('What should I include?', 'faq-and-answers'),
				__('The page it happens on, what you expected, and what happened instead. A screenshot saves a whole exchange.', 'faq-and-answers')
			),
			Parts::faq(
				__('Before you write', 'faq-and-answers'),
				__('Can I attach a file?', 'faq-and-answers'),
				__('Not to this form. Send the question first and reply to the email that comes back with anything you need to attach.', 'faq-and-answers')
			),
			Parts::faq(
				__('After you write', 'faq-and-answers'),
				__('Will my question end up on this page?', 'faq-and-answers'),
				__('Possibly, if it is one other people will have too — reworded, and never with your name or email on it.', 'faq-and-answers')
			),
			Parts::faq(
				__('After you write', 'faq-and-answers'),
				__('Who reads it?', 'faq-and-answers'),
				__('The support team, and every one gets read. There is no queue you can be dropped from without a reply.', 'faq-and-answers')
			),
		];

		$form = Parts::block(
			'faa/faq-form',
			[
				'heading'               => __('Ask us directly', 'faq-and-answers'),
				'subheading'            => __('One working day, and a person on the other end.', 'faq-and-answers'),
				'showName'              => false,
				'showAnswer'            => false,
				'accent'                => '#0f766e',
				'buttonHoverBg'         => '#0b5d56',
				'cardBg'                => '#ffffff',
				'labelColor'            => '#4b5563',
				'inputColor'            => '#111827',
				'inputBorder'           => ['width' => '1px', 'style' => 'solid', 'color' => '#d7e8e5', 'side' => 'all', 'radius' => '8px'],
				'inputFocusBorderColor' => '#0f766e',
				'radius'                => 14,
				'maxWidth'              => 520,
			]
		);

		$rightFaq = Parts::block('faa/faq-and-answers', [
			'faqData' => $faqs,
			'theme'   => 'themeFourteen',
			'Styles'  => [
				'heading'   => ['title' => [], 'subTitle' => [], 'button' => []],
				'container' => [],
				'content'   => [
					'question' => [
						'padding' => [
							'desktop' => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
						],
					],
				],
			],
		]);

		return [
			'title'     => __('Ask While You Read', 'faq-and-answers'),
			'groups'    => ['support'],
			'keywords'  => ['form', 'two column', 'left form right faq', 'contact', 'columns'],
			'thumbnail' => 'ask-while-you-read.svg',
			'content'   => Parts::section(
				Parts::heading(__('Cannot find it? Ask.', 'faq-and-answers'))
					. Parts::paragraph(__('The form is on the left. The answers most people were looking for are on the right.', 'faq-and-answers'))
					. Parts::columns(
						[
							['width' => '44%', 'inner' => $form],
							['width' => '56%', 'inner' => $rightFaq],
						]
					),
				'#eff7f6'
			),
		];
	}

	/* ---------------------------------------------- left FAQ, right content */

	/**
	 * A searchable list on the left, and the ways to reach a person on the
	 * right. The search theme earns the left column because that is where the
	 * eye starts, and the contact card stays visible while you search.
	 *
	 * @return array
	 */
	private static function search_then_ask() {
		$faqs = [
			Parts::faq(
				__('Account', 'faq-and-answers'),
				__('How do I reset my password?', 'faq-and-answers'),
				__('Use the forgotten-password link on the sign-in page. The email arrives within a minute and the link is good for an hour.', 'faq-and-answers')
			),
			Parts::faq(
				__('Account', 'faq-and-answers'),
				__('Can I change the email on my account?', 'faq-and-answers'),
				__('Yes, from Account settings. You will need to confirm it from the new address before it takes effect.', 'faq-and-answers')
			),
			Parts::faq(
				__('Account', 'faq-and-answers'),
				__('How do I add someone to my team?', 'faq-and-answers'),
				__('Invite them by email from the Team page. They get their own sign-in and you decide what they can change.', 'faq-and-answers')
			),
			Parts::faq(
				__('Orders', 'faq-and-answers'),
				__('Where is my licence key?', 'faq-and-answers'),
				__('On the order confirmation and in your account under Purchases. It never expires, even if the licence lapses.', 'faq-and-answers')
			),
			Parts::faq(
				__('Orders', 'faq-and-answers'),
				__('Can I get a VAT invoice?', 'faq-and-answers'),
				__('Every order produces one automatically. Add your company details before paying and they will be on it.', 'faq-and-answers')
			),
			Parts::faq(
				__('Technical', 'faq-and-answers'),
				__('Which PHP versions are supported?', 'faq-and-answers'),
				__('7.4 and above, and we test on the two most recent. Anything older will run but stops getting security fixes from us.', 'faq-and-answers')
			),
		];

		$right = Parts::subheading(__('Still stuck?', 'faq-and-answers'), 3)
			. Parts::text(__('Search is faster than we are, but if it is not in there we would rather hear from you than have you give up.', 'faq-and-answers'))
			. Parts::bullets(
				[
					__('Replies within one working day', 'faq-and-answers'),
					__('Monday to Friday, 09:00 to 17:00 UTC', 'faq-and-answers'),
					__('Answered by the people who built it', 'faq-and-answers'),
				]
			)
			. Parts::button(__('Contact support', 'faq-and-answers'), '#', '#111827');

		return [
			'title'     => __('Search Then Ask', 'faq-and-answers'),
			'groups'    => ['support'],
			'keywords'  => ['search', 'two column', 'left faq right content', 'help centre', 'columns'],
			'thumbnail' => 'search-then-ask.svg',
			'content'   => Parts::section(
				Parts::columns(
					[
						['width' => '62%', 'inner' => Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeSeven'])],
						['width' => '38%', 'inner' => $right],
					]
				),
				'#f4f6fa'
			),
		];
	}

	/**
	 * The docs page: a tree on the left, and a short note on the right saying
	 * how to read it. Nested questions are unusual enough that a line of
	 * explanation saves people clicking every branch to find out.
	 *
	 * @return array
	 */
	private static function documentation_tree() {
		$install = [
			Parts::faq_item(
				__('From the WordPress dashboard', 'faq-and-answers'),
				__('Plugins, Add New, search for it, Install, Activate. Nothing appears on your pages until you place a block.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('By uploading the zip', 'faq-and-answers'),
				__('Plugins, Add New, Upload Plugin. If an older copy is already there, deactivate it first — your questions are kept either way.', 'faq-and-answers'),
				1
			),
		];

		$first = [
			Parts::faq_item(
				__('Placing your first block', 'faq-and-answers'),
				__('Open a page, add the FAQ block, type a question. The answer box appears underneath and can be left for later.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Reusing questions across pages', 'faq-and-answers'),
				__('Save the block as a synced pattern, then place it. One edit updates every page carrying it.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Using it inside a page builder', 'faq-and-answers'),
				__('Copy the shortcode from the group and paste it into any text widget the builder gives you.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('Installing', 'faq-and-answers'),
			__('Two ways in, both about a minute.', 'faq-and-answers'),
			0,
			$install,
			true
		)
			. Parts::faq_item(
				__('Your first FAQ', 'faq-and-answers'),
				__('From an empty page to something published.', 'faq-and-answers'),
				0,
				$first
			)
			. Parts::faq_item(
				__('Search engines and schema', 'faq-and-answers'),
				__('Keep FAQ markup on one block per page. More than one set competes with itself and neither is reliably read.', 'faq-and-answers'),
				0
			)
			. Parts::faq_item(
				__('Getting help', 'faq-and-answers'),
				__('The form on the support page reaches the people who wrote this. Include the page and what you expected to happen.', 'faq-and-answers'),
				0
			);

		$right = Parts::subheading(__('How to read this', 'faq-and-answers'), 3)
			. Parts::text(__('Each heading opens into the specific cases underneath it, so you can stay at the top level until something matches.', 'faq-and-answers'))
			. Parts::bullets(
				[
					__('Start at the top and work down', 'faq-and-answers'),
					__('One branch open at a time, so nothing scrolls away', 'faq-and-answers'),
					__('Everything here also works from search', 'faq-and-answers'),
				]
			)
			. Parts::button(__('Full documentation', 'faq-and-answers'), '#', '#4338ca');

		return [
			'title'     => __('Documentation Tree', 'faq-and-answers'),
			'groups'    => ['support'],
			'keywords'  => ['docs', 'nested', 'documentation', 'two column', 'tree', 'columns'],
			'thumbnail' => 'documentation-tree.svg',
			'content'   => Parts::section(
				Parts::heading(__('Documentation', 'faq-and-answers'))
					. Parts::columns(
						[
							[
								'width' => '62%',
								'inner' => Parts::wrap(
									'faa/nested-faq',
									[
										'template'            => 'default',
										'openFirst'           => true,
										'allowMultiple'       => false,
										'iconType'            => 'chevron',
										'iconPosition'        => 'left',
										'questionColor'       => '#1e1b4b',
										'questionBg'          => ['type' => 'solid', 'color' => '#e7e5fb'],
										'questionOpenColor'   => '#ffffff',
										'questionOpenBg'      => ['type' => 'solid', 'color' => '#4338ca'],
										'nestedQuestionColor' => '#312e81',
										'nestedQuestionBg'    => ['type' => 'solid', 'color' => '#f5f4ff'],
										'answerColor'         => '#4b5563',
										'answerBg'            => ['type' => 'solid', 'color' => '#ffffff'],
										'itemBorder'          => ['width' => '1px', 'style' => 'solid', 'color' => '#ddd9fa', 'side' => 'all', 'radius' => '10px'],
									],
									$tree
								),
							],
							['width' => '38%', 'inner' => $right],
						]
					),
				'#f2f2fc'
			),
		];
	}

	/**
	 * Category-wise questions on the left, the feature they belong to on the
	 * right. For a features page, where the question is usually "yes, but does
	 * it do the specific thing I need".
	 *
	 * @return array
	 */
	private static function feature_tour() {
		$faqs = [
			Parts::faq(
				__('Layouts', 'faq-and-answers'),
				__('Can I use more than one layout on a page?', 'faq-and-answers'),
				__('Yes, as many as you like. Keep FAQ schema switched on for only one of them so the markup stays valid.', 'faq-and-answers')
			),
			Parts::faq(
				__('Layouts', 'faq-and-answers'),
				__('Do the layouts share their questions?', 'faq-and-answers'),
				__('If you point them at the same group, yes. Editing the group updates every block showing it, in whatever layout.', 'faq-and-answers')
			),
			Parts::faq(
				__('Styling', 'faq-and-answers'),
				__('How much can I change?', 'faq-and-answers'),
				__('Colours, type, spacing, borders and behaviour, per block. It inherits your theme first, so it looks right before you touch anything.', 'faq-and-answers')
			),
			Parts::faq(
				__('Styling', 'faq-and-answers'),
				__('Will an update overwrite my styling?', 'faq-and-answers'),
				__('No. Everything you set is stored with the block in your post content, not in the plugin.', 'faq-and-answers')
			),
			Parts::faq(
				__('Content', 'faq-and-answers'),
				__('Can questions come from my posts?', 'faq-and-answers'),
				__('Post FAQ turns any post type into an FAQ list, using the title as the question and the excerpt as the answer.', 'faq-and-answers')
			),
			Parts::faq(
				__('Content', 'faq-and-answers'),
				__('What happens to questions visitors send?', 'faq-and-answers'),
				__('They arrive under Form Submissions, where you can read each one, reply by email and mark it answered once it is handled.', 'faq-and-answers')
			),
		];

		$right = Parts::subheading(__('Built to be lived in', 'faq-and-answers'), 3)
			. Parts::text(__('The parts that matter after the first week: one library behind every block, styling that survives updates, and somewhere for the questions you did not think of.', 'faq-and-answers'))
			. Parts::bullets(
				[
					__('One library, every layout', 'faq-and-answers'),
					__('Per-block styling, stored with your content', 'faq-and-answers'),
					__('Submissions become answers in a click', 'faq-and-answers'),
					__('Schema handled, on the block you choose', 'faq-and-answers'),
				]
			)
			. Parts::button(__('See every feature', 'faq-and-answers'), '#', '#2563eb');

		$leftFaq = Parts::block('faa/faq-and-answers', [
			'faqData'    => $faqs,
			'theme'      => 'themeFive',
			'faqOptions' => [
				'displayHeadingTitle'       => false,
				'displayHeadingDescription' => false,
				'displayFaqTitle'           => true,
			],
		]);

		return [
			'title'     => __('Feature Tour', 'faq-and-answers'),
			'groups'    => ['features'],
			'keywords'  => ['features', 'category', 'two column', 'left faq right content', 'product'],
			'thumbnail' => 'feature-tour.svg',
			'content'   => Parts::section(
				Parts::heading(__('What it does, in detail', 'faq-and-answers'))
					. Parts::columns(
						[
							['width' => '60%', 'inner' => $leftFaq],
							['width' => '40%', 'inner' => $right],
						]
					),
				'#eff4fd'
			),
		];
	}

	/* -------------------------------------------------- post FAQ and Ask AI */

	/**
	 * The articles you have written on one side, and something that can answer
	 * in words on the other. Between them they cover both ways people look for
	 * an answer: browsing a list, or typing the question.
	 *
	 * @return array
	 */
	private static function knowledge_hub() {
		return [
			'title'     => __('Knowledge Hub', 'faq-and-answers'),
			'groups'    => ['support'],
			'keywords'  => ['post faq', 'ask ai', 'articles', 'two column', 'knowledge base', 'search'],
			'thumbnail' => 'knowledge-hub.svg',
			'content'   => Parts::section(
				Parts::heading(__('Find it, or just ask', 'faq-and-answers'))
					. Parts::paragraph(__('Browse what we have written, or type the question and let it find the answer for you.', 'faq-and-answers'))
					. Parts::columns(
						[
							[
								'width' => '58%',
								'inner' => Parts::subheading(__('Recent articles', 'faq-and-answers'), 3)
									. Parts::block(
										'faa/post-faq',
										[
											'layout'          => 'compact',
											'postType'        => 'post',
											'orderBy'         => 'modified',
											'order'           => 'desc',
											'batchSize'       => 5,
											'maxPosts'        => 20,
											'showThumb'       => true,
											'showAuthor'      => false,
											'showCategory'    => true,
											'showDate'        => true,
											'showReadTime'    => true,
											'excerptWords'    => 30,
											'closeOthers'     => true,
											'enableLoadMore'  => true,
											'loadMoreText'    => __('More articles', 'faq-and-answers'),
											'accent'          => '#7c3aed',
											'headerBg'        => ['type' => 'solid', 'color' => '#ffffff'],
											'headerActiveBg'  => ['type' => 'solid', 'color' => '#f6f3ff'],
											'bodyBg'          => ['type' => 'solid', 'color' => '#ffffff'],
											'buttonColor'     => '#7c3aed',
											'buttonTextColor' => '#ffffff',
											'itemBorder'      => ['width' => '1px', 'style' => 'solid', 'color' => '#e7e1fa', 'side' => 'all', 'radius' => '10px'],
											'thumbRadius'     => '8px',
										]
									),
							],
							[
								'width' => '42%',
								'inner' => Parts::subheading(__('Ask a question', 'faq-and-answers'), 3)
									. Parts::block(
										'faa/ask-ai',
										[
											'heading'        => __('What do you need to know?', 'faq-and-answers'),
											'subheading'     => __('Answered from the articles beside this, with links to the ones it used.', 'faq-and-answers'),
											'buttonText'     => __('Ask', 'faq-and-answers'),
											'showSources'    => true,
											'showFeedback'   => true,
											'fallbackText'   => __('Still need a person?', 'faq-and-answers'),
											'accent'         => '#7c3aed',
											'boxBg'          => ['type' => 'solid', 'color' => '#ffffff'],
											'answerBg'       => ['type' => 'solid', 'color' => '#f8f6ff'],
											'suggestions'    => [
												__('How do I reuse questions across pages?', 'faq-and-answers'),
												__('Which layout is best for a pricing page?', 'faq-and-answers'),
												__('How do I add FAQ schema?', 'faq-and-answers'),
											],
											'border'         => ['width' => '1px', 'style' => 'solid', 'color' => '#e7e1fa', 'side' => 'all', 'radius' => '16px'],
										]
									),
							],
						]
					),
				'#f6f3ff'
			),
		];
	}

	/**
	 * Ask AI across the top, the categorised list underneath.
	 *
	 * The box goes first because typing a question is faster than finding it,
	 * and the list stays because an answer written by a person is still worth
	 * more than one assembled on the spot.
	 *
	 * @return array
	 */
	private static function ai_answer_desk() {
		$faqs = [
			Parts::faq(
				__('Getting started', 'faq-and-answers'),
				__('Where do I begin?', 'faq-and-answers'),
				__('Add one block to one page and write one question. Everything else in here is something you can come back for.', 'faq-and-answers')
			),
			Parts::faq(
				__('Getting started', 'faq-and-answers'),
				__('Do I need to configure anything first?', 'faq-and-answers'),
				__('No. There is no settings page you have to visit before the first block works.', 'faq-and-answers')
			),
			Parts::faq(
				__('Using it', 'faq-and-answers'),
				__('How do I change how it looks?', 'faq-and-answers'),
				__('Select the block and use the Style tab. Themes change the whole layout; the controls under them change one thing at a time.', 'faq-and-answers')
			),
			Parts::faq(
				__('Using it', 'faq-and-answers'),
				__('Can two pages share the same questions?', 'faq-and-answers'),
				__('Save them as a group and place the group on both. One edit reaches every page carrying it.', 'faq-and-answers')
			),
			Parts::faq(
				__('Troubleshooting', 'faq-and-answers'),
				__('Nothing shows on the page', 'faq-and-answers'),
				__('Clear the cache and hard refresh first — that is nine times in ten. After that, check the block is not filtered to an empty category.', 'faq-and-answers')
			),
			Parts::faq(
				__('Troubleshooting', 'faq-and-answers'),
				__('The AI answer was wrong', 'faq-and-answers'),
				__('Mark it unhelpful and it is logged with the question. It answers from your own FAQs, so a wrong answer usually means one of them needs rewording.', 'faq-and-answers')
			),
		];

		return [
			'title'     => __('AI Answer Desk', 'faq-and-answers'),
			'groups'    => ['support'],
			'keywords'  => ['ask ai', 'ai', 'search', 'help desk', 'instant answer', 'support'],
			'thumbnail' => 'ai-answer-desk.svg',
			'content'   => Parts::section(
				Parts::heading(__('Ask, and read on', 'faq-and-answers'))
					. Parts::paragraph(__('Type the question. If the answer is already written, this finds it and says where it came from.', 'faq-and-answers'))
					. Parts::block(
						'faa/ask-ai',
						[
							'align'           => 'wide',
							'heading'         => __('Ask us anything', 'faq-and-answers'),
							'subheading'      => __('An instant answer from our own FAQs, with the sources it used.', 'faq-and-answers'),
							'headingAlign'    => 'center',
							'subheadingAlign' => 'center',
							'buttonText'      => __('Ask', 'faq-and-answers'),
							'showSources'     => true,
							'showFeedback'    => true,
							'fallbackText'    => __('Still need help? Write to us.', 'faq-and-answers'),
							'accent'          => '#2563eb',
							'boxBg'           => ['type' => 'solid', 'color' => '#ffffff'],
							'answerBg'        => ['type' => 'solid', 'color' => '#f4f8ff'],
							'suggestions'     => [
								__('How long does setup take?', 'faq-and-answers'),
								__('Can I use it on client sites?', 'faq-and-answers'),
								__('What is the refund policy?', 'faq-and-answers'),
							],
							'border'          => ['width' => '1px', 'style' => 'solid', 'color' => '#dde6f7', 'side' => 'all', 'radius' => '16px'],
						]
					)
					. Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'default']),
				'#eff4fd'
			),
		];
	}
}

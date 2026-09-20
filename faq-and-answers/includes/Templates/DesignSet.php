<?php
/**
 * Six designed sections, all on the free Awesome FAQ block.
 *
 * The other sets choose a theme and leave the colours to the site. These do the
 * opposite: each one is a finished look — a palette, an icon pair and the
 * spacing to go with it — so dropping one in gives a section that is already
 * designed rather than one that needs designing.
 *
 * Every template here is free, and stays free because of what it is made of:
 * BuiltIn::access() reads the content back, and the only theme values used are
 * the seven that ship without a licence. Which is also why the colours are set
 * the way they are — see the note on the Styles object below.
 *
 * Two things are worth knowing before changing any of these.
 *
 * The first is that `Styles.container` is not the container. Style.js points it
 * at `.faa-section-main`, and that element exists in exactly one theme — the
 * premium Hero Category theme. On every free theme the visible background comes
 * from three places instead: the question row, the answer panel, and the core
 * group these templates are wrapped in. So a design here paints the rows and
 * lets Parts::section() paint what is behind them.
 *
 * The second is that the Styles object is always complete. Parts::styles()
 * merges these overrides over the block's own defaults rather than replacing
 * them, because Style.js walks the tree with plain destructuring and a branch
 * that arrives half-built reaches a property on undefined. The overrides below
 * are therefore only what differs from the default — that is the whole point of
 * them, not an omission.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class DesignSet {

	/**
	 * @return array
	 */
	public static function all() {
		return [
			self::event_tickets(),
			self::home_service_booking(),
			self::business_services(),
			self::gallery_questions(),
			self::materials_and_care(),
			self::questions_answered(),
		];
	}

	/* -------------------------------------------------------------- one */

	/**
	 * Questions laid out sideways, the open one widening to make room.
	 *
	 * The Vertical Tabs theme turns each question on its side and gives the
	 * open one the rest of the row, which suits a short list of long answers —
	 * a ticketing page, where there are five things to say and each takes a
	 * paragraph. Below 768px the theme lays itself out as a normal stack, so
	 * nothing here has to think about it.
	 *
	 * @return array
	 */
	private static function event_tickets() {
		$faqs = [
			Parts::faq(
				__('Tickets', 'faq-and-answers'),
				__('How do I download my e-tickets?', 'faq-and-answers'),
				__('Once your purchase is confirmed your electronic tickets are generated straight away and sent to your registered email address as a PDF attachment. You can also reach them at any time from the My Orders section of your dashboard. For a faster entry, save the QR codes to your phone wallet and let the staff on the door scan them from your screen.', 'faq-and-answers')
			),
			Parts::faq(
				__('Tickets', 'faq-and-answers'),
				__('Are the tickets fully refundable?', 'faq-and-answers'),
				__('Refunds are available up to seventy-two hours before the doors open, less the booking fee. Inside that window the ticket can still be transferred to somebody else, which most people find easier than asking for the money back.', 'faq-and-answers')
			),
			Parts::faq(
				__('Tickets', 'faq-and-answers'),
				__('Can I change the attendee name?', 'faq-and-answers'),
				__('Yes, and free of charge, right up until the morning of the event. Open the order, choose Edit attendee, and a fresh ticket is issued to the new name while the old one is voided.', 'faq-and-answers')
			),
			Parts::faq(
				__('Event', 'faq-and-answers'),
				__('What if the event is cancelled?', 'faq-and-answers'),
				__('Everybody who bought a ticket is refunded in full, booking fee included, to the card that paid. You do not need to ask — the money goes back automatically within five working days and we write to tell you it has.', 'faq-and-answers')
			),
		];

		$styles = Parts::styles(
			[
				'content' => [
					'question' => [
						'background' => ['color' => '#e3efe7'],
						'colors'     => ['color' => '#1e4d35'],
						'typo'       => [
							'fontWeight' => 600,
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 17, 'tablet' => 15, 'mobile' => 14],
						],
						'padding'    => [
							'desktop' => ['top' => '22px', 'right' => '18px', 'bottom' => '22px', 'left' => '18px'],
							'tablet'  => ['top' => '18px', 'right' => '16px', 'bottom' => '18px', 'left' => '16px'],
							'mobile'  => ['top' => '14px', 'right' => '14px', 'bottom' => '14px', 'left' => '14px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#4a5c6a'],
						'typo'       => [
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 16, 'tablet' => 15, 'mobile' => 14],
							'lineHeight' => 1.75,
						],
						'padding'    => [
							'desktop' => ['top' => '26px', 'right' => '28px', 'bottom' => '26px', 'left' => '28px'],
							'tablet'  => ['top' => '20px', 'right' => '22px', 'bottom' => '20px', 'left' => '22px'],
							'mobile'  => ['top' => '16px', 'right' => '16px', 'bottom' => '16px', 'left' => '16px'],
						],
					],
					'icon'     => [
						'background' => ['color' => '#1e4d35'],
						'colors'     => ['color' => '#ffffff'],
						'size'       => ['desktop' => '26px', 'tablet' => '24px', 'mobile' => '22px'],
						'border'     => ['width' => '0px', 'style' => 'solid', 'color' => '', 'side' => 'all', 'radius' => '50%'],
						'padding'    => [
							'desktop' => ['top' => '6px', 'right' => '6px', 'bottom' => '6px', 'left' => '6px'],
							'tablet'  => ['top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px'],
							'mobile'  => ['top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px'],
						],
					],
				],
			]
		);

		return [
			'title'     => __('Event Ticket Booking', 'faq-and-answers'),
			'groups'    => ['speakers'],
			'keywords'  => ['event', 'tickets', 'booking', 'vertical tabs', 'horizontal', 'green'],
			'thumbnail' => 'event-tickets.svg',
			'content'   => Parts::section(
				Parts::heading(__('Event Ticket Booking FAQ', 'faq-and-answers'), 2, '#24303c', 'x-large')
					. Parts::block(
						'faa/faq-and-answers',
						[
							'theme'       => 'themeThree',
							'faqData'     => $faqs,
							'faqIcon'     => Parts::icons('minus-plus'),
							'maxFaqItems' => count($faqs),
							'Styles'      => $styles,
						]
					),
				'#ffffff'
			),
		];
	}

	/* -------------------------------------------------------------- two */

	/**
	 * A deep blue panel with the questions banded across it.
	 *
	 * The heading is left on the page and the colour starts at the block, so
	 * the section reads as a panel dropped into the page rather than a page
	 * that has changed colour — which is what a booking flow wants sitting in
	 * the middle of a white service page.
	 *
	 * @return array
	 */
	private static function home_service_booking() {
		$faqs = [
			Parts::faq(
				__('Booking', 'faq-and-answers'),
				__('How do I book a home service?', 'faq-and-answers'),
				__('Pick the service you need, choose a time that suits you, add your address and confirm. The booking is accepted straight away and matched to a verified professional working in your area — there is no callback to wait for.', 'faq-and-answers')
			),
			Parts::faq(
				__('Booking', 'faq-and-answers'),
				__('What happens after booking confirmation?', 'faq-and-answers'),
				__('You get a confirmation with the name and photograph of the professional assigned to you, and a message on the morning of the visit with a narrower arrival window. Both also appear under Bookings in your account.', 'faq-and-answers')
			),
			Parts::faq(
				__('Booking', 'faq-and-answers'),
				__('Can I reschedule my booking easily?', 'faq-and-answers'),
				__('Up to four hours before the slot, yes, and as many times as you need. Open the booking, choose a new slot, and the professional is notified for you. Inside four hours it counts as a late change and a small fee applies.', 'faq-and-answers')
			),
			Parts::faq(
				__('Service', 'faq-and-answers'),
				__('How are service professionals assigned?', 'faq-and-answers'),
				__('By trade, by distance and by rating, in that order. Everybody on the platform is background checked and carries their own insurance, and anyone whose rating falls below four stars stops receiving new work until it recovers.', 'faq-and-answers')
			),
			Parts::faq(
				__('Payment', 'faq-and-answers'),
				__('What payment methods are available?', 'faq-and-answers'),
				__('Card, bank transfer and the usual digital wallets. Nothing is taken until the job is marked complete, so a visit that does not happen is never a visit you have paid for.', 'faq-and-answers')
			),
			Parts::faq(
				__('Service', 'faq-and-answers'),
				__('How is service quality ensured?', 'faq-and-answers'),
				__('Every job is rated, and every rating is read. Work that falls short is put right at our expense within seven days — you do not pay twice to have something finished properly.', 'faq-and-answers')
			),
		];

		$styles = Parts::styles(
			[
				'content' => [
					'question' => [
						'background' => ['color' => 'linear-gradient(90deg, #2d62a6 0%, #3f7ec2 100%)'],
						'colors'     => ['color' => '#ffffff'],
						'typo'       => [
							'fontWeight' => 600,
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 17, 'tablet' => 15, 'mobile' => 14],
						],
						'padding'    => [
							'desktop' => ['top' => '20px', 'right' => '24px', 'bottom' => '20px', 'left' => '18px'],
							'tablet'  => ['top' => '16px', 'right' => '18px', 'bottom' => '16px', 'left' => '16px'],
							'mobile'  => ['top' => '14px', 'right' => '14px', 'bottom' => '14px', 'left' => '14px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#17457f'],
						'colors'     => ['color' => '#cfe0f2'],
						'typo'       => [
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 15, 'tablet' => 14, 'mobile' => 13],
							'lineHeight' => 1.75,
						],
						'padding'    => [
							'desktop' => ['top' => '20px', 'right' => '28px', 'bottom' => '24px', 'left' => '28px'],
							'tablet'  => ['top' => '16px', 'right' => '22px', 'bottom' => '18px', 'left' => '22px'],
							'mobile'  => ['top' => '14px', 'right' => '16px', 'bottom' => '16px', 'left' => '16px'],
						],
					],
					'icon'     => [
						'background' => ['color' => 'rgba(255,255,255,0.16)'],
						'colors'     => ['color' => '#ffffff'],
						'size'       => ['desktop' => '28px', 'tablet' => '26px', 'mobile' => '24px'],
						'border'     => ['width' => '0px', 'style' => 'solid', 'color' => '', 'side' => 'all', 'radius' => '6px'],
						'padding'    => [
							'desktop' => ['top' => '6px', 'right' => '6px', 'bottom' => '6px', 'left' => '6px'],
							'tablet'  => ['top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px'],
							'mobile'  => ['top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px'],
						],
					],
				],
			]
		);

		$panel = Parts::section(
			Parts::block(
				'faa/faq-and-answers',
				[
					'theme'       => 'default',
					'faqData'     => $faqs,
					'faqIcon'     => Parts::icons('minus-plus'),
					'maxFaqItems' => count($faqs),
					'Styles'      => $styles,
				]
			),
			'linear-gradient(160deg, #1b4f96 0%, #2a6bb5 100%)',
			'14px'
		);

		return [
			'title'     => __('Home Service Booking', 'faq-and-answers'),
			'groups'    => ['services'],
			'keywords'  => ['services', 'booking', 'blue', 'gradient', 'accordion', 'home service'],
			'thumbnail' => 'home-service-booking.svg',
			'content'   => Parts::section(
				Parts::heading(__('Easy Home Service Booking Guide', 'faq-and-answers'), 2, '#2b3440', 'xx-large')
					. $panel,
				'#ffffff'
			),
		];
	}

	/* ------------------------------------------------------------ three */

	/**
	 * A label down the left, the questions in the rest of the width.
	 *
	 * Editorial rather than decorative: no fills, no badges, a rule between
	 * each question and the heading given the room to be a real heading. It is
	 * the arrangement a documentation page or a consultancy site reaches for,
	 * and it is the one that survives being put on a page that already has a
	 * strong design of its own.
	 *
	 * The columns stack below 782px without help, so the label ends up above
	 * the questions on a phone rather than squeezed beside them.
	 *
	 * @return array
	 */
	private static function business_services() {
		$faqs = [
			Parts::faq(
				__('Consulting', 'faq-and-answers'),
				__('How can business consulting improve company growth?', 'faq-and-answers'),
				__('Consulting helps an organisation see where the opportunities actually are, work through the operational problems holding it back, and put a plan behind the answer. The value is rarely the advice on its own — it is having someone whose whole job that week is the decision you have been putting off.', 'faq-and-answers')
			),
			Parts::faq(
				__('Support', 'faq-and-answers'),
				__('Why is professional IT support important?', 'faq-and-answers'),
				__('Because the cost of an outage is almost never the outage. Monitored systems, tested backups and somebody who answers out of hours turn a day lost into an hour lost, and that difference compounds across a year.', 'faq-and-answers')
			),
			Parts::faq(
				__('Marketing', 'faq-and-answers'),
				__('What benefits does digital marketing provide?', 'faq-and-answers'),
				__('Reach you can measure and spend you can stop. Every channel reports what it returned, which means the budget moves towards what is working rather than towards what was agreed in January.', 'faq-and-answers')
			),
			Parts::faq(
				__('Delivery', 'faq-and-answers'),
				__('How does project management ensure success?', 'faq-and-answers'),
				__('By making scope, owner and date visible to everyone at once. Most projects do not fail on capability — they fail because two people held different versions of the same deadline for six weeks.', 'faq-and-answers')
			),
			Parts::faq(
				__('Support', 'faq-and-answers'),
				__('Why invest in customer support services?', 'faq-and-answers'),
				__('Support is where a customer finds out whether the promise was real. It is also the cheapest research a company can buy: the same three questions arriving every week are a product decision waiting to be made.', 'faq-and-answers')
			),
		];

		$styles = Parts::styles(
			[
				'content' => [
					'question' => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#1f2937'],
						'typo'       => [
							'fontWeight' => 500,
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 17, 'tablet' => 16, 'mobile' => 15],
						],
						'padding'    => [
							'desktop' => ['top' => '24px', 'right' => '8px', 'bottom' => '24px', 'left' => '8px'],
							'tablet'  => ['top' => '20px', 'right' => '8px', 'bottom' => '20px', 'left' => '8px'],
							'mobile'  => ['top' => '16px', 'right' => '4px', 'bottom' => '16px', 'left' => '4px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#6b7280'],
						'typo'       => [
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 15, 'tablet' => 14, 'mobile' => 14],
							'lineHeight' => 1.8,
						],
						'padding'    => [
							'desktop' => ['top' => '0px', 'right' => '48px', 'bottom' => '24px', 'left' => '8px'],
							'tablet'  => ['top' => '0px', 'right' => '32px', 'bottom' => '20px', 'left' => '8px'],
							'mobile'  => ['top' => '0px', 'right' => '8px', 'bottom' => '16px', 'left' => '4px'],
						],
					],
					'icon'     => [
						'background' => ['color' => 'transparent'],
						'colors'     => ['color' => '#111827'],
						'size'       => ['desktop' => '18px', 'tablet' => '18px', 'mobile' => '16px'],
						'border'     => ['width' => '0px', 'style' => 'solid', 'color' => '', 'side' => 'all', 'radius' => '0px'],
						'padding'    => [
							'desktop' => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
							'tablet'  => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
							'mobile'  => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
						],
					],
				],
			]
		);

		$label = Parts::heading(__('FAQs', 'faq-and-answers'), 3, '#111827', 'large', 'left');

		$body = Parts::subheading(__('Frequently Asked Questions About Business Services', 'faq-and-answers'), 2, '#111827')
			. Parts::block(
				'faa/faq-and-answers',
				[
					'theme'       => 'themeOne',
					'faqData'     => $faqs,
					'faqIcon'     => Parts::icons('chevron'),
					'maxFaqItems' => count($faqs),
					'Styles'      => $styles,
				]
			);

		return [
			'title'     => __('Business Services', 'faq-and-answers'),
			'groups'    => ['services'],
			'keywords'  => ['business', 'services', 'minimal', 'editorial', 'two column', 'consulting'],
			'thumbnail' => 'business-services.svg',
			'content'   => Parts::section(
				Parts::columns(
					[
						['width' => '18%', 'inner' => $label, 'vertical' => 'top'],
						['width' => '82%', 'inner' => $body, 'vertical' => 'top'],
					],
					'top'
				),
				'#ffffff',
				''
			),
		];
	}

	/* ------------------------------------------------------------- four */

	/**
	 * A picture beside every answer.
	 *
	 * Theme Four is the only free theme that renders the `image` on a row, so
	 * this is the one template where filling that field in is the point rather
	 * than an extra. The pictures are the SVGs that ship with the plugin, which
	 * means the template looks right offline and on a fresh install, before
	 * anybody has put anything in the media library.
	 *
	 * The questions are near-black bars with white text, and the answers open
	 * white underneath them. That is the way round it has to be: the row is
	 * carrying a photograph, and a picture on a dark panel has to fight the
	 * panel, while the same picture on white does not. So the weight sits on
	 * the closed rows and lifts off the moment one is opened.
	 *
	 * @return array
	 */
	private static function gallery_questions() {
		$faqs = [
			Parts::faq(
				__('Styles', 'faq-and-answers'),
				__('What makes bold abstract art so visually powerful?', 'faq-and-answers'),
				__('Abstract work gives up the job of depicting something, and gets colour, form and texture back in exchange. Nothing in the frame tells you what to think about it, so the reading is yours — which is why two people can stand in front of the same canvas and describe two different paintings.', 'faq-and-answers'),
				Parts::asset('story-1.svg')
			),
			Parts::faq(
				__('Styles', 'faq-and-answers'),
				__('How does minimalist line art say so much with so little?', 'faq-and-answers'),
				__('By trusting the eye to finish the sentence. A single continuous line describing a shoulder reads as a whole figure because we supply the rest without noticing, and the restraint is what makes the gesture land.', 'faq-and-answers'),
				Parts::asset('story-2.svg')
			),
			Parts::faq(
				__('Medium', 'faq-and-answers'),
				__('Can digital tools replace canvas and paintbrush?', 'faq-and-answers'),
				__('They replace some of the constraints, not the practice. Undo, layers and infinite colour change what is easy, but they do not change what is worth making — and plenty of painters work in both without feeling they have swapped one for the other.', 'faq-and-answers'),
				Parts::asset('story-3.svg')
			),
			Parts::faq(
				__('Medium', 'faq-and-answers'),
				__('Why is mixed media considered the most expressive form?', 'faq-and-answers'),
				__('Because the materials argue with each other. Paper against paint against thread gives a surface with real depth and real accident in it, and the places where two materials refuse to sit together are usually the places the eye goes first.', 'faq-and-answers'),
				Parts::asset('story-4.svg')
			),
		];

		$styles = Parts::styles(
			[
				'content' => [
					'question' => [
						'background' => ['color' => '#111827'],
						'colors'     => ['color' => '#ffffff'],
						'typo'       => [
							'fontWeight' => 500,
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 17, 'tablet' => 16, 'mobile' => 15],
						],
						'padding'    => [
							'desktop' => ['top' => '22px', 'right' => '18px', 'bottom' => '22px', 'left' => '18px'],
							'tablet'  => ['top' => '18px', 'right' => '16px', 'bottom' => '18px', 'left' => '16px'],
							'mobile'  => ['top' => '15px', 'right' => '12px', 'bottom' => '15px', 'left' => '12px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#6b7280'],
						'typo'       => [
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 15, 'tablet' => 14, 'mobile' => 14],
							'lineHeight' => 1.8,
						],
						'padding'    => [
							'desktop' => ['top' => '4px', 'right' => '18px', 'bottom' => '22px', 'left' => '18px'],
							'tablet'  => ['top' => '4px', 'right' => '16px', 'bottom' => '18px', 'left' => '16px'],
							'mobile'  => ['top' => '4px', 'right' => '12px', 'bottom' => '15px', 'left' => '12px'],
						],
					],
					// White, and on a tint of its own. The icon used to be near
					// black with no background, which was right while the
					// question row was white and is invisible now that it is
					// not — an icon the same colour as the bar behind it is not
					// a subtle icon, it is a missing one.
					'icon'     => [
						'background' => ['color' => 'rgba(255,255,255,0.12)'],
						'colors'     => ['color' => '#ffffff'],
						'size'       => ['desktop' => '26px', 'tablet' => '24px', 'mobile' => '22px'],
						'border'     => ['width' => '0px', 'style' => 'solid', 'color' => '', 'side' => 'all', 'radius' => '8px'],
						'padding'    => [
							'desktop' => ['top' => '6px', 'right' => '6px', 'bottom' => '6px', 'left' => '6px'],
							'tablet'  => ['top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px'],
							'mobile'  => ['top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px'],
						],
					],
				],
			]
		);

		return [
			'title'     => __('Gallery Questions', 'faq-and-answers'),
			'groups'    => ['story'],
			'keywords'  => ['gallery', 'art', 'image', 'picture', 'accordion', 'portfolio'],
			'thumbnail' => 'gallery-questions.svg',
			'content'   => Parts::section(
				Parts::heading(__('About the Work', 'faq-and-answers'), 2, '#111827', 'x-large')
					. Parts::paragraph(__('What people ask most often about the pieces on show.', 'faq-and-answers'), 'center', '#6b7280')
					. Parts::block(
						'faa/faq-and-answers',
						[
							'theme'       => 'themeFour',
							'faqData'     => $faqs,
							'faqIcon'     => Parts::icons('minus-plus'),
							'maxFaqItems' => count($faqs),
							'Styles'      => $styles,
						]
					),
				'#ffffff'
			),
		];
	}

	/* ------------------------------------------------------------- five */

	/**
	 * Solid gradient bars, a white panel underneath the open one.
	 *
	 * The loudest of the six, and the one for a product page rather than a
	 * support page — every question is a bar you can see from the top of the
	 * screen. The tick and cross icon pair is deliberate: on a row this heavy a
	 * plus sign disappears, and a cross reads as "close this" at a glance.
	 *
	 * @return array
	 */
	private static function materials_and_care() {
		$faqs = [
			Parts::faq(
				__('Products', 'faq-and-answers'),
				__('What materials do you use?', 'faq-and-answers'),
				__('Solid North American oak, top-grain leather and recycled fabric, and nothing that needs an asterisk. Every piece is built the way furniture was built before veneer became the default, which is the reason we are comfortable quoting decades rather than years.', 'faq-and-answers')
			),
			Parts::faq(
				__('Products', 'faq-and-answers'),
				__('Is assembly required for items?', 'faq-and-answers'),
				__('Most pieces arrive assembled. The few that do not — beds, and the larger dining tables — take two people about twenty minutes with the tool included in the box, and there is nothing to buy separately.', 'faq-and-answers')
			),
			Parts::faq(
				__('Orders', 'faq-and-answers'),
				__('Do you offer custom sizes?', 'faq-and-answers'),
				__('On tables, shelving and beds, yes. Send the measurements you need and you will have a quote and a lead time within two working days. Custom pieces carry the same guarantee as everything else.', 'faq-and-answers')
			),
			Parts::faq(
				__('Orders', 'faq-and-answers'),
				__('What is your shipping cost?', 'faq-and-answers'),
				__('Free above the order threshold, a flat rate below it, and no surcharge for a piece being heavy or awkward. Delivery is to the room of your choice, not to the kerb.', 'faq-and-answers')
			),
			Parts::faq(
				__('Orders', 'faq-and-answers'),
				__('Can I order fabric samples?', 'faq-and-answers'),
				__('Up to five swatches, posted free. Colour on a screen is a promise nobody can keep, so we would much rather you held the fabric next to your floor before deciding.', 'faq-and-answers')
			),
		];

		$styles = Parts::styles(
			[
				'content' => [
					'question' => [
						'background' => ['color' => 'linear-gradient(90deg, #2563eb 0%, #7c3aed 100%)'],
						'colors'     => ['color' => '#ffffff'],
						'typo'       => [
							'fontWeight' => 600,
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 16, 'tablet' => 15, 'mobile' => 14],
						],
						'padding'    => [
							'desktop' => ['top' => '20px', 'right' => '22px', 'bottom' => '20px', 'left' => '22px'],
							'tablet'  => ['top' => '17px', 'right' => '18px', 'bottom' => '17px', 'left' => '18px'],
							'mobile'  => ['top' => '14px', 'right' => '14px', 'bottom' => '14px', 'left' => '14px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#4b5563'],
						'typo'       => [
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 15, 'tablet' => 14, 'mobile' => 14],
							'lineHeight' => 1.8,
						],
						'padding'    => [
							'desktop' => ['top' => '24px', 'right' => '26px', 'bottom' => '24px', 'left' => '26px'],
							'tablet'  => ['top' => '20px', 'right' => '20px', 'bottom' => '20px', 'left' => '20px'],
							'mobile'  => ['top' => '16px', 'right' => '16px', 'bottom' => '16px', 'left' => '16px'],
						],
					],
					'icon'     => [
						'background' => ['color' => 'transparent'],
						'colors'     => ['color' => '#ffffff'],
						'size'       => ['desktop' => '18px', 'tablet' => '17px', 'mobile' => '16px'],
						'border'     => ['width' => '0px', 'style' => 'solid', 'color' => '', 'side' => 'all', 'radius' => '0px'],
						'padding'    => [
							'desktop' => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
							'tablet'  => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
							'mobile'  => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
						],
					],
				],
			]
		);

		return [
			'title'     => __('Materials & Care', 'faq-and-answers'),
			'groups'    => ['sales'],
			'keywords'  => ['product', 'gradient', 'bold', 'shop', 'furniture', 'materials'],
			'thumbnail' => 'materials-and-care.svg',
			'content'   => Parts::section(
				Parts::heading(__('Before You Order', 'faq-and-answers'), 2, '#111827', 'x-large')
					. Parts::block(
						'faa/faq-and-answers',
						[
							'theme'       => 'themeOne',
							'faqData'     => $faqs,
							'faqIcon'     => Parts::icons('cross-check'),
							'maxFaqItems' => count($faqs),
							'Styles'      => $styles,
						]
					),
				'#ffffff'
			),
		];
	}

	/* -------------------------------------------------------------- six */

	/**
	 * White cards on black, with somewhere to go when the list runs out.
	 *
	 * The left column is the part most FAQ sections are missing: every list of
	 * answers eventually fails somebody, and the page should say what that
	 * person does next rather than ending. Putting it beside the questions
	 * instead of underneath them means it is still on screen while they read.
	 *
	 * @return array
	 */
	private static function questions_answered() {
		$faqs = [
			Parts::faq(
				__('Products', 'faq-and-answers'),
				__('What materials do you use?', 'faq-and-answers'),
				__('Solid oak, top-grain leather and recycled fabric throughout. The specification for every piece is published on its own page, down to the finish and the hardware, because a material list nobody can check is just a adjective.', 'faq-and-answers')
			),
			Parts::faq(
				__('Products', 'faq-and-answers'),
				__('Is assembly required for items?', 'faq-and-answers'),
				__('Rarely. Most pieces arrive built; the few that do not come with the tool and a single sheet of instructions, and take two people about twenty minutes.', 'faq-and-answers')
			),
			Parts::faq(
				__('Orders', 'faq-and-answers'),
				__('Do you offer custom sizes?', 'faq-and-answers'),
				__('On tables, shelving and beds. Send your measurements and a quote comes back within two working days, with the same guarantee as a stock piece.', 'faq-and-answers')
			),
			Parts::faq(
				__('Orders', 'faq-and-answers'),
				__('What is your shipping cost?', 'faq-and-answers'),
				__('Free above the order threshold and a flat rate below it, delivered to the room you want it in rather than left at the door.', 'faq-and-answers')
			),
			Parts::faq(
				__('Orders', 'faq-and-answers'),
				__('Can I order fabric samples?', 'faq-and-answers'),
				__('Five swatches, posted free, no order required. Screens lie about colour and we would rather you found that out before the sofa arrives.', 'faq-and-answers')
			),
		];

		$styles = Parts::styles(
			[
				'content' => [
					'question' => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#111827'],
						'typo'       => [
							'fontWeight' => 600,
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 16, 'tablet' => 15, 'mobile' => 14],
						],
						'padding'    => [
							'desktop' => ['top' => '20px', 'right' => '22px', 'bottom' => '20px', 'left' => '22px'],
							'tablet'  => ['top' => '17px', 'right' => '18px', 'bottom' => '17px', 'left' => '18px'],
							'mobile'  => ['top' => '14px', 'right' => '14px', 'bottom' => '14px', 'left' => '14px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#6b7280'],
						'typo'       => [
							'fontFamily' => 'Inter, sans-serif',
							'fontSize'   => ['desktop' => 15, 'tablet' => 14, 'mobile' => 14],
							'lineHeight' => 1.8,
						],
						'padding'    => [
							'desktop' => ['top' => '0px', 'right' => '22px', 'bottom' => '22px', 'left' => '22px'],
							'tablet'  => ['top' => '0px', 'right' => '18px', 'bottom' => '18px', 'left' => '18px'],
							'mobile'  => ['top' => '0px', 'right' => '14px', 'bottom' => '14px', 'left' => '14px'],
						],
					],
					'icon'     => [
						'background' => ['color' => '#ec4899'],
						'colors'     => ['color' => '#ffffff'],
						'size'       => ['desktop' => '26px', 'tablet' => '24px', 'mobile' => '22px'],
						'border'     => ['width' => '0px', 'style' => 'solid', 'color' => '', 'side' => 'all', 'radius' => '50%'],
						'padding'    => [
							'desktop' => ['top' => '6px', 'right' => '6px', 'bottom' => '6px', 'left' => '6px'],
							'tablet'  => ['top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px'],
							'mobile'  => ['top' => '5px', 'right' => '5px', 'bottom' => '5px', 'left' => '5px'],
						],
					],
				],
			]
		);

		$aside = Parts::section(
			Parts::paragraph(__('If your question is not listed here, reach out and we will help.', 'faq-and-answers'), 'left', '#d4d4d8')
				. Parts::button(__('Contact Us', 'faq-and-answers'), '#', '#ec4899', '#ffffff', '999px'),
			'#1c1c1e',
			'16px'
		);

		$left = Parts::subheading(__('Your Questions, Answered', 'faq-and-answers'), 2, '#ffffff') . $aside;

		$right = Parts::block(
			'faa/faq-and-answers',
			[
				'theme'       => 'themeOne',
				'faqData'     => $faqs,
				'faqIcon'     => Parts::icons('minus-plus'),
				'maxFaqItems' => count($faqs),
				'Styles'      => $styles,
			]
		);

		return [
			'title'     => __('Questions Answered', 'faq-and-answers'),
			'groups'    => ['support'],
			'keywords'  => ['dark', 'black', 'two column', 'contact', 'cards', 'support'],
			'thumbnail' => 'questions-answered.svg',
			'content'   => Parts::section(
				Parts::columns(
					[
						['width' => '38%', 'inner' => $left, 'vertical' => 'top'],
						['width' => '62%', 'inner' => $right, 'vertical' => 'top'],
					],
					'top'
				),
				'#0a0a0a',
				'24px'
			),
		];
	}
}

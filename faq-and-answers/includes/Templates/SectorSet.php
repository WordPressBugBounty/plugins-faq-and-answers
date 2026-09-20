<?php
/**
 * A second template for each industry category.
 *
 * The showcase set sells; this set answers. Every category already had one
 * picture-led template for the top of a page, and nothing for the questions
 * that follow — sizing, allergens, check-in times, what a visa needs. Those
 * are the ones that decide whether somebody buys, and they are the reason
 * anybody opens an FAQ in the first place.
 *
 * Shapes are chosen for how the questions are actually related. Where an
 * answer only makes sense underneath another one — an allergen inside a
 * course, a treatment inside a condition — it is a Nested FAQ. Where every
 * answer stands alone and wants to be visible at once, it is a grid.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class SectorSet {

	/**
	 * @return array
	 */
	public static function all() {
		return [
			self::size_and_fit(),
			self::allergens(),
			self::treatment_explorer(),
			self::booking_and_stay(),
			self::buying_process(),
			self::before_you_travel(),
			self::working_with_us(),
			self::scope_and_pricing(),
			self::programme_explorer(),
		];
	}

	/* ------------------------------------------------------------- grids */

	/**
	 * Sizing, in a grid. Nobody clicks four accordions while deciding between
	 * a medium and a large — the answers have to be on the page at once.
	 *
	 * @return array
	 */
	private static function size_and_fit() {
		$items = [
			Parts::card(
				'📏',
				__('Which size am I?', 'faq-and-answers'),
				__('Measure your chest and waist and read them off the chart, rather than going by the size you usually take. Ours run a little generous through the shoulder.', 'faq-and-answers'),
				'normal',
				__('Start here', 'faq-and-answers')
			),
			Parts::card(
				'↔️',
				__('Between two sizes?', 'faq-and-answers'),
				__('Take the smaller one in knitwear and the larger in outerwear. Knits relax with wear; a coat has to close over a jumper.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'🧵',
				__('Will it shrink?', 'faq-and-answers'),
				__('Everything is pre-washed, so no more than a percent or so. Wash cool and dry flat and it will hold its shape.', 'faq-and-answers'),
				'normal'
			),
			Parts::card(
				'🔁',
				__('What if it does not fit?', 'faq-and-answers'),
				__('Send it back within thirty days, unworn, and we pay the postage. Exchanges for a different size ship the same day we receive it.', 'faq-and-answers'),
				'normal'
			),
			Parts::card(
				'✂️',
				__('Do you alter?', 'faq-and-answers'),
				__('Trousers and jackets, free, in any of our shops. Allow three working days, or a week in December.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'🌍',
				__('Are the sizes UK or EU?', 'faq-and-answers'),
				__('UK on the label, with EU and US on the chart. If you are ordering from outside the UK, go by the measurements.', 'faq-and-answers'),
				'normal'
			),
		];

		return [
			'title'     => __('Size & Fit Guide', 'faq-and-answers'),
			'groups'    => ['fashion'],
			'keywords'  => ['size', 'fit', 'sizing', 'measurements', 'fashion', 'returns', 'grid'],
			'thumbnail' => 'size-and-fit.svg',
			'content'   => Parts::section(
				Parts::heading(__('Size and fit', 'faq-and-answers'))
					. Parts::paragraph(__('The six things people ask before ordering. All of it on the page — no clicking.', 'faq-and-answers'))
					. Parts::block(
						'faa/bento-faq',
						[
							'items'       => $items,
							'openMode'    => 'modal',
							'columns'     => ['desktop' => 4, 'tablet' => 2, 'mobile' => 1],
							'showIcons'   => true,
							'showExcerpt' => true,
							'accent'      => '#b0455f',
							'cardBg'      => '#ffffff',
							'cardBorder'  => '#f0dae0',
							'cardRadius'  => '18px',
						]
					),
				'#fdf3f6'
			),
		];
	}

	/**
	 * What a traveller has to sort out before leaving. Independent errands, so
	 * a grid rather than a list — nobody reads these in order.
	 *
	 * @return array
	 */
	private static function before_you_travel() {
		$items = [
			Parts::card(
				'🛂',
				__('Do I need a visa?', 'faq-and-answers'),
				__('It depends on your passport, not on us. We send the requirement for your nationality with the booking confirmation, and again a month before you fly.', 'faq-and-answers'),
				'large',
				__('Check first', 'faq-and-answers')
			),
			Parts::card(
				'💉',
				__('Any vaccinations?', 'faq-and-answers'),
				__('None are compulsory on any of our trips. Two are recommended for the desert itinerary — ask your GP eight weeks ahead, not two.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'💳',
				__('Cash or card?', 'faq-and-answers'),
				__('Cards work in the cities and nowhere else on three of the four trips. Bring enough cash for a week and top up when you can.', 'faq-and-answers'),
				'small'
			),
			Parts::card(
				'🎒',
				__('How much can I bring?', 'faq-and-answers'),
				__('One bag of twenty kilos and a daypack. On the walking trips a porter carries the large bag, so weight matters more than size.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'☂️',
				__('What is the weather like?', 'faq-and-answers'),
				__('Each itinerary lists the average high, low and rainfall by month. We only run trips in the months that read well.', 'faq-and-answers'),
				'small'
			),
			Parts::card(
				'🏥',
				__('Is insurance included?', 'faq-and-answers'),
				__('No, and you cannot travel with us without it. Medical cover and repatriation are the two parts we check.', 'faq-and-answers'),
				'wide'
			),
		];

		return [
			'title'     => __('Before You Travel', 'faq-and-answers'),
			'groups'    => ['travel'],
			'keywords'  => ['travel', 'visa', 'insurance', 'packing', 'preparation', 'grid'],
			'thumbnail' => 'before-you-travel.svg',
			'content'   => Parts::section(
				Parts::heading(__('Before you travel', 'faq-and-answers'))
					. Parts::paragraph(__('The paperwork and the packing, in the order people worry about them.', 'faq-and-answers'))
					. Parts::block(
						'faa/bento-faq',
						[
							'items'       => $items,
							'openMode'    => 'modal',
							'columns'     => ['desktop' => 4, 'tablet' => 2, 'mobile' => 1],
							'showIcons'   => true,
							'showExcerpt' => true,
							'accent'      => '#1f6f8b',
							'cardBg'      => '#ffffff',
							'cardBorder'  => '#d7e6ec',
							'cardRadius'  => '18px',
						]
					),
				'#eef6f9'
			),
		];
	}


	/* ------------------------------------------------------------- trees */

	/**
	 * Allergens belong inside dishes, so the answers nest. A flat list would
	 * make somebody with an allergy read the whole menu to find the two lines
	 * that matter to them.
	 *
	 * @return array
	 */
	private static function allergens() {
		$nuts = [
			Parts::faq_item(
				__('Which dishes contain nuts?', 'faq-and-answers'),
				__('Three on the current menu, all marked. The kitchen is not nut free, so we will not tell you that traces are impossible — we will tell you exactly which surfaces and pans are shared.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Can a dish be made without them?', 'faq-and-answers'),
				__('Two of the three, yes, and it is cooked separately. The third is built on a nut base and we would rather say no than serve you something risky.', 'faq-and-answers'),
				1
			),
		];

		$gluten = [
			Parts::faq_item(
				__('What is gluten free as it comes?', 'faq-and-answers'),
				__('Eleven dishes, marked on the menu. The bread and two of the puddings are the only things that cannot be adapted.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Is it coeliac safe?', 'faq-and-answers'),
				__('We use a separate fryer and separate boards, and flour is handled at the other end of the kitchen. Tell your server it is coeliac rather than a preference and the ticket is flagged.', 'faq-and-answers'),
				1
			),
		];

		$plant = [
			Parts::faq_item(
				__('How many dishes are vegan?', 'faq-and-answers'),
				__('Nine, and six of them are on the menu because they are good rather than because they are vegan. The small plates section is almost entirely plant based.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Is the wine list vegan?', 'faq-and-answers'),
				__('Most of it. The list marks the four that are not, all of them fined with egg white.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('Nuts', 'faq-and-answers'),
			__('The kitchen is not nut free. Here is exactly where they appear.', 'faq-and-answers'),
			0,
			$nuts,
			true
		)
			. Parts::faq_item(
				__('Gluten', 'faq-and-answers'),
				__('What is safe as it comes, and what we can adapt.', 'faq-and-answers'),
				0,
				$gluten
			)
			. Parts::faq_item(
				__('Vegan and vegetarian', 'faq-and-answers'),
				__('Nine vegan dishes, and an honest note about the wine.', 'faq-and-answers'),
				0,
				$plant
			)
			. Parts::faq_item(
				__('Something else', 'faq-and-answers'),
				__('Ring us before you book rather than asking on the night. The kitchen can plan around almost anything with a day\'s notice.', 'faq-and-answers'),
				0
			);

		$leftBannerContent = Parts::heading(__('Answers to Frequently Asked Questions.', 'faq-and-answers'), 2, '#111827', 'XL', 'left')
			. Parts::paragraph(__('In our FAQ, you\'ll find concise answers to common questions about our service, Booking Steps. If you still have questions, feel free to reach out to us.', 'faq-and-answers'), 'left', '#6b7280', 'M');

		$rightBannerImage = '<!-- wp:group {"style":{"border":{"radius":"18px"},"color":{"background":"#ffffff"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->'
			. '<div class="wp-block-group has-background" style="border-radius:18px;background-color:#ffffff;padding:24px;text-align:center;">'
			. '<img src="' . esc_url(Parts::thumb('allergens-dietary.svg')) . '" alt="' . esc_attr__('FAQ Illustration', 'faq-and-answers') . '" style="max-width:100%;height:auto;border-radius:10px;" />'
			. '</div>'
			. '<!-- /wp:group -->';

		$banner = Parts::section(
			Parts::columns([
				['width' => '54%', 'vertical' => 'center', 'inner' => $leftBannerContent],
				['width' => '46%', 'vertical' => 'center', 'inner' => $rightBannerImage],
			]),
			'#f8f6f0',
			'20px'
		);

		return [
			'title'     => __('Allergens & Dietary', 'faq-and-answers'),
			'groups'    => ['food'],
			'keywords'  => ['allergens', 'dietary', 'vegan', 'gluten', 'nuts', 'restaurant', 'nested', 'banner'],
			'thumbnail' => 'allergens-dietary.svg',
			'content'   => Parts::section(
				$banner
					. '<!-- wp:spacer {"height":"36px"} --><div style="height:36px" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->'
					. Parts::wrap(
						'faa/nested-faq',
						[
							'template'            => 'default',
							'openFirst'           => true,
							'allowMultiple'       => false,
							'iconType'            => 'plus',
							'iconPosition'        => 'right',
							'questionColor'       => '#ffffff',
							'questionBg'          => ['type' => 'solid', 'color' => '#b45309'],
							'questionOpenColor'   => '#ffffff',
							'questionOpenBg'      => ['type' => 'solid', 'color' => '#92400e'],
							'nestedQuestionColor' => '#5c3416',
							'nestedQuestionBg'    => ['type' => 'solid', 'color' => '#fdf3e7'],
							'answerColor'         => '#4b5563',
							'answerBg'            => ['type' => 'solid', 'color' => '#ffffff'],
							'itemBorder'          => ['width' => '0px', 'style' => 'solid', 'color' => '#eadfd0', 'side' => 'all', 'radius' => '12px'],
						],
						$tree
					),
				''
			),
		];
	}

	/**
	 * Condition, then treatment. Medical questions are the clearest case for
	 * nesting: nobody wants the answer about knees while asking about backs.
	 *
	 * @return array
	 */
	private static function treatment_explorer() {
		$back = [
			Parts::faq_item(
				__('How many sessions will I need?', 'faq-and-answers'),
				__('Four to six for most people, spread over a couple of months. You should feel a difference by the second — if you do not, we will say so and refer you on.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Do I need a scan first?', 'faq-and-answers'),
				__('Usually not. Imaging changes the plan in fewer than one case in ten, and an unnecessary scan tends to find something harmless that then worries you.', 'faq-and-answers'),
				1
			),
		];

		$joints = [
			Parts::faq_item(
				__('Is it worth it if I am older?', 'faq-and-answers'),
				__('Age is not the deciding factor — how much you move already is. Our oldest patient last year was eighty-four and finished the programme.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Will I need surgery eventually?', 'faq-and-answers'),
				__('Sometimes, and we will tell you when we think so rather than selling you sessions first. Getting stronger beforehand improves the outcome either way.', 'faq-and-answers'),
				1
			),
		];

		$sport = [
			Parts::faq_item(
				__('How soon can I train again?', 'faq-and-answers'),
				__('Something on the first day, almost always — modified, not nothing. Complete rest is the slowest way back for most injuries.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Do you work with my coach?', 'faq-and-answers'),
				__('Gladly, with your permission. The programmes that hold are the ones where the coach knows what we have asked for.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('Back and neck', 'faq-and-answers'),
			__('The most common reason people come to us, and the one with the most myths attached.', 'faq-and-answers'),
			0,
			$back,
			true
		)
			. Parts::faq_item(
				__('Joints and arthritis', 'faq-and-answers'),
				__('What is realistic, and when we would send you elsewhere.', 'faq-and-answers'),
				0,
				$joints
			)
			. Parts::faq_item(
				__('Sports injuries', 'faq-and-answers'),
				__('Getting back to it, sooner than resting would allow.', 'faq-and-answers'),
				0,
				$sport
			)
			. Parts::faq_item(
				__('Not sure which applies', 'faq-and-answers'),
				__('Book a fifteen-minute call. It is free, it is with a clinician rather than a receptionist, and it often ends with us telling you that you do not need us.', 'faq-and-answers'),
				0
			);

		$leftBannerContent = '<!-- wp:paragraph {"style":{"color":{"text":"#ffffff"}}} -->'
			. '<p class="wp-block-paragraph has-text-color" style="color:#ffffff;"><span style="display:inline-block;padding:4px 12px;border-radius:6px;font-size:12px;font-weight:600;letter-spacing:0.5px;background-color:rgba(255,255,255,0.18);color:#ffffff;">'
			. esc_html__('FAQ', 'faq-and-answers')
			. '</span></p>'
			. '<!-- /wp:paragraph -->'
			. Parts::heading(__('Answers to Frequently Asked Questions.', 'faq-and-answers'), 2, '#ffffff', 'XL', 'left')
			. Parts::paragraph(__('In our FAQ, you\'ll find concise answers to common questions about our service, Booking Steps. If you still have questions, feel free to reach out to us.', 'faq-and-answers'), 'left', '#e0e7ff', 'M');

		$rightBannerImage = '<!-- wp:group {"style":{"border":{"radius":"18px"},"color":{"background":"#ffffff"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->'
			. '<div class="wp-block-group has-background" style="border-radius:18px;background-color:#ffffff;padding:24px;text-align:center;">'
			. '<img src="' . esc_url(Parts::thumb('treatment-explorer.svg')) . '" alt="' . esc_attr__('FAQ Illustration', 'faq-and-answers') . '" style="max-width:100%;height:auto;border-radius:10px;" />'
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

		return [
			'title'     => __('Treatment Explorer', 'faq-and-answers'),
			'groups'    => ['health'],
			'keywords'  => ['health', 'treatment', 'clinic', 'conditions', 'nested', 'patients', 'banner'],
			'thumbnail' => 'treatment-explorer.svg',
			'content'   => Parts::section(
				$banner
					. '<!-- wp:spacer {"height":"36px"} --><div style="height:36px" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->'
					. Parts::wrap(
						'faa/nested-faq',
						[
							'template'            => 'default',
							'openFirst'           => true,
							'allowMultiple'       => false,
							'iconType'            => 'chevron',
							'iconPosition'        => 'right',
							'questionColor'       => '#ffffff',
							'questionBg'          => ['type' => 'solid', 'color' => '#0e7490'],
							'questionOpenColor'   => '#ffffff',
							'questionOpenBg'      => ['type' => 'solid', 'color' => '#155e75'],
							'nestedQuestionColor' => '#164e63',
							'nestedQuestionBg'    => ['type' => 'solid', 'color' => '#effafc'],
							'answerColor'         => '#4b5563',
							'answerBg'            => ['type' => 'solid', 'color' => '#ffffff'],
							'itemBorder'          => ['width' => '0px', 'style' => 'solid', 'color' => '#d5e9ee', 'side' => 'all', 'radius' => '12px'],
						],
						$tree
					),
				''
			),
		];
	}

	/**
	 * A programme chosen by what you are training for. The goal is the branch
	 * and the detail hangs off it, which is how anybody picks one.
	 *
	 * @return array
	 */
	private static function programme_explorer() {
		$strength = [
			Parts::faq_item(
				__('How often, and for how long?', 'faq-and-answers'),
				__('Three sessions a week for twelve weeks, forty-five minutes each. Missing one is fine; missing a fortnight means starting the block again.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Do I need a gym?', 'faq-and-answers'),
				__('From week five, yes, or a barbell at home. The first four weeks need a floor and a pair of bands.', 'faq-and-answers'),
				1
			),
		];

		$weight = [
			Parts::faq_item(
				__('How fast will I lose weight?', 'faq-and-answers'),
				__('Half a kilo a week is the honest answer and the one that lasts. Anything faster is mostly water and comes back.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Do I have to count calories?', 'faq-and-answers'),
				__('Only if it suits you. Most people do better on portion habits and stop tracking within a month either way.', 'faq-and-answers'),
				1
			),
		];

		$endurance = [
			Parts::faq_item(
				__('I have never run before', 'faq-and-answers'),
				__('Then start on the walk-run weeks rather than skipping them. Everyone who gets injured in the first month skipped them.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Can I train for a specific race?', 'faq-and-answers'),
				__('Yes — give us the date and the distance and the block is built backwards from it, with a taper that actually tapers.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('I want to get stronger', 'faq-and-answers'),
			__('Twelve weeks, three sessions a week, measurable at the end.', 'faq-and-answers'),
			0,
			$strength,
			true
		)
			. Parts::faq_item(
				__('I want to lose weight', 'faq-and-answers'),
				__('Slower than the internet promises, and it stays off.', 'faq-and-answers'),
				0,
				$weight
			)
			. Parts::faq_item(
				__('I want to run further', 'faq-and-answers'),
				__('From nothing to a distance, or from a distance to a faster one.', 'faq-and-answers'),
				0,
				$endurance
			)
			. Parts::faq_item(
				__('I do not know yet', 'faq-and-answers'),
				__('Come in for an assessment. It costs nothing, takes half an hour, and ends with a recommendation you can take elsewhere if you want to.', 'faq-and-answers'),
				0
			);

		return [
			'title'     => __('Programme Explorer', 'faq-and-answers'),
			'groups'    => ['fitness'],
			'keywords'  => ['fitness', 'programme', 'training', 'goals', 'nested', 'coaching'],
			'thumbnail' => 'programme-explorer.svg',
			'content'   => Parts::section(
				Parts::heading(__('What are you training for?', 'faq-and-answers'))
					. Parts::paragraph(__('Pick the goal and the programme underneath it explains itself.', 'faq-and-answers'))
					. Parts::wrap(
						'faa/nested-faq',
						[
							'template'            => 'default',
							'openFirst'           => true,
							'allowMultiple'       => false,
							'iconType'            => 'arrow',
							'iconPosition'        => 'right',
							'questionColor'       => '#ffffff',
							'questionBg'          => ['type' => 'solid', 'color' => '#15803d'],
							'questionOpenColor'   => '#ffffff',
							'questionOpenBg'      => ['type' => 'solid', 'color' => '#166534'],
							'nestedQuestionColor' => '#14532d',
							'nestedQuestionBg'    => ['type' => 'solid', 'color' => '#eefaf1'],
							'answerColor'         => '#4b5563',
							'answerBg'            => ['type' => 'solid', 'color' => '#ffffff'],
							'itemBorder'          => ['width' => '0px', 'style' => 'solid', 'color' => '#d6ecdd', 'side' => 'all', 'radius' => '12px'],
						],
						$tree
					),
				'#eff9f2'
			),
		];
	}

	/**
	 * Scope, change and what a project costs, as a tree. Every one of these
	 * has a "yes, but in which case" underneath it, which is exactly what
	 * nesting is for.
	 *
	 * @return array
	 */
	private static function scope_and_pricing() {
		$pricing = [
			Parts::faq_item(
				__('Fixed price or day rate?', 'faq-and-answers'),
				__('Fixed, wherever the work can be described. Day rate only for open-ended discovery, and we will tell you which one applies before you ask.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('What is the smallest project you take?', 'faq-and-answers'),
				__('About a week. Below that the writing-it-down costs more than the work, and you are better off with someone hourly.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('When do we pay?', 'faq-and-answers'),
				__('A third to start, a third at the halfway review, a third on handover. No invoice arrives before the thing it covers exists.', 'faq-and-answers'),
				1
			),
		];

		$change = [
			Parts::faq_item(
				__('What counts as a change?', 'faq-and-answers'),
				__('Anything that moves the date or the price. Reworded copy and a different shade of blue do not; a new page does.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('How is it agreed?', 'faq-and-answers'),
				__('A note saying what it is, what it costs and what it moves, and your reply. Nothing is started on a verbal yes in a meeting.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('How you charge', 'faq-and-answers'),
			__('Fixed price against a written scope, in three payments.', 'faq-and-answers'),
			0,
			$pricing,
			true
		)
			. Parts::faq_item(
				__('When things change', 'faq-and-answers'),
				__('They will. Here is what happens when they do.', 'faq-and-answers'),
				0,
				$change
			)
			. Parts::faq_item(
				__('What we need from you', 'faq-and-answers'),
				__('One person who can decide, and content by the date we agree. Late content is the single most common reason a project slips.', 'faq-and-answers'),
				0
			)
			. Parts::faq_item(
				__('Who owns the work', 'faq-and-answers'),
				__('You do, including the source, from the moment the final invoice clears. There is no licence to renew and nothing held back as leverage.', 'faq-and-answers'),
				0
			);

		return [
			'title'     => __('Scope & Pricing', 'faq-and-answers'),
			'groups'    => ['services'],
			'keywords'  => ['scope', 'pricing', 'agency', 'contract', 'change', 'nested'],
			'thumbnail' => 'scope-and-pricing.svg',
			'content'   => Parts::section(
				Parts::heading(__('Scope, change and cost', 'faq-and-answers'))
					. Parts::paragraph(__('The commercial questions, answered before you have to ask them twice.', 'faq-and-answers'))
					. Parts::wrap(
						'faa/nested-faq',
						[
							'template'            => 'default',
							'openFirst'           => true,
							'allowMultiple'       => false,
							'iconType'            => 'plus',
							'iconPosition'        => 'right',
							'questionColor'       => '#ffffff',
							'questionBg'          => ['type' => 'solid', 'color' => '#334155'],
							'questionOpenColor'   => '#ffffff',
							'questionOpenBg'      => ['type' => 'solid', 'color' => '#1e293b'],
							'nestedQuestionColor' => '#1e293b',
							'nestedQuestionBg'    => ['type' => 'solid', 'color' => '#f1f5f9'],
							'answerColor'         => '#475569',
							'answerBg'            => ['type' => 'solid', 'color' => '#ffffff'],
							'itemBorder'          => ['width' => '0px', 'style' => 'solid', 'color' => '#e2e8f0', 'side' => 'all', 'radius' => '12px'],
						],
						$tree
					),
				'#f3f5f9'
			),
		];
	}

	/* ------------------------------------------------------- two columns */

	/**
	 * Check-in times and house rules on the left, the rest of the questions on
	 * the right. The practical detail stays on screen while somebody reads
	 * around it, which is the whole argument for two columns.
	 *
	 * @return array
	 */
	private static function booking_and_stay() {
		$faqs = [
			Parts::faq(
				__('Booking', 'faq-and-answers'),
				__('Can I cancel?', 'faq-and-answers'),
				__('Free up to seven days before arrival. Inside seven days it is one night, and we would rather move your dates than take it.', 'faq-and-answers')
			),
			Parts::faq(
				__('Booking', 'faq-and-answers'),
				__('Do you take a deposit?', 'faq-and-answers'),
				__('One night, taken at booking and counted against the bill. Nothing else is charged until you leave.', 'faq-and-answers')
			),
			Parts::faq(
				__('Staying', 'faq-and-answers'),
				__('Is breakfast included?', 'faq-and-answers'),
				__('In every room but the Courtyard Double, where it is nine pounds and worth it. Served until eleven, and later at weekends.', 'faq-and-answers')
			),
			Parts::faq(
				__('Staying', 'faq-and-answers'),
				__('Can I bring a dog?', 'faq-and-answers'),
				__('In the Garden Rooms, two at most, no charge. They can be anywhere on the ground floor including the bar.', 'faq-and-answers')
			),
			Parts::faq(
				__('Getting here', 'faq-and-answers'),
				__('Is there parking?', 'faq-and-answers'),
				__('Six spaces behind the building, free, first come. The car park on Mill Street is two minutes away and never full.', 'faq-and-answers')
			),
		];

		$left = Parts::subheading(__('The practical bits', 'faq-and-answers'), 3)
			. Parts::text(__('Everything that decides whether a stay goes smoothly, in one place rather than in the confirmation email.', 'faq-and-answers'))
			. Parts::bullets(
				[
					__('Check in from 15:00, out by 11:00', 'faq-and-answers'),
					__('Late arrival any time — tell us and the door code follows', 'faq-and-answers'),
					__('Luggage held before and after, no charge', 'faq-and-answers'),
					__('Quiet hours from 22:30', 'faq-and-answers'),
				]
			)
			. Parts::button(__('Check availability', 'faq-and-answers'), '#', '#0f766e');

		return [
			'title'     => __('Booking & Stay', 'faq-and-answers'),
			'groups'    => ['hotel'],
			'keywords'  => ['hotel', 'booking', 'check-in', 'cancellation', 'two column', 'stay'],
			'thumbnail' => 'booking-and-stay.svg',
			'content'   => Parts::section(
				Parts::heading(__('Booking and your stay', 'faq-and-answers'))
					. Parts::columns(
						[
							['width' => '38%', 'inner' => $left],
							['width' => '62%', 'inner' => Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeThree'])],
						]
					),
				'#eff7f6'
			),
		];
	}

	/**
	 * Buying a house generates more questions than any other purchase, so this
	 * one gets the searchable theme with the stages listed beside it.
	 *
	 * @return array
	 */
	private static function buying_process() {
		$faqs = [
			Parts::faq(
				__('Offers', 'faq-and-answers'),
				__('How much below asking should I offer?', 'faq-and-answers'),
				__('There is no rule, and anyone who gives you one is guessing. We will tell you what similar houses on that street actually sold for, which is the only useful number.', 'faq-and-answers')
			),
			Parts::faq(
				__('Offers', 'faq-and-answers'),
				__('What makes an offer stronger than a higher one?', 'faq-and-answers'),
				__('Being ready. A mortgage in principle, a solicitor instructed and no chain beats several thousand pounds more from someone who has none of those.', 'faq-and-answers')
			),
			Parts::faq(
				__('Surveys', 'faq-and-answers'),
				__('Which survey do I need?', 'faq-and-answers'),
				__('A homebuyer report for anything built after 1950 and in normal condition. Older or altered, pay for the full building survey — it is the cheapest money you will spend.', 'faq-and-answers')
			),
			Parts::faq(
				__('Surveys', 'faq-and-answers'),
				__('The survey found something. Now what?', 'faq-and-answers'),
				__('Get a quote for the work, then decide whether to renegotiate or walk. Most findings are ordinary maintenance dressed in alarming language.', 'faq-and-answers')
			),
			Parts::faq(
				__('Timing', 'faq-and-answers'),
				__('How long does it take?', 'faq-and-answers'),
				__('Eight to twelve weeks from accepted offer to keys, if the chain behaves. Nobody can promise a date, and we will not pretend otherwise.', 'faq-and-answers')
			),
			Parts::faq(
				__('Timing', 'faq-and-answers'),
				__('What usually causes delays?', 'faq-and-answers'),
				__('Searches with slow councils, and one solicitor in the chain who does not reply. Both are worth chasing weekly rather than waiting on.', 'faq-and-answers')
			),
		];

		$right = Parts::subheading(__('The five stages', 'faq-and-answers'), 3)
			. Parts::bullets(
				[
					__('1. Mortgage in principle', 'faq-and-answers'),
					__('2. Offer and acceptance', 'faq-and-answers'),
					__('3. Survey and searches', 'faq-and-answers'),
					__('4. Exchange of contracts', 'faq-and-answers'),
					__('5. Completion, and the keys', 'faq-and-answers'),
				]
			)
			. Parts::text(__('You will hear from us at every one of them, whether or not there is news.', 'faq-and-answers'))
			. Parts::button(__('Talk to an agent', 'faq-and-answers'), '#', '#15803d');

		return [
			'title'     => __('Buying Process', 'faq-and-answers'),
			'groups'    => ['estate'],
			'keywords'  => ['property', 'buying', 'offers', 'survey', 'conveyancing', 'search'],
			'thumbnail' => 'buying-process.svg',
			'content'   => Parts::section(
				Parts::heading(__('Buying a home', 'faq-and-answers'))
					. Parts::columns(
						[
							['width' => '50%', 'inner' => Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeSeven'])],
							['width' => '50%', 'inner' => $right],
						]
					),
				'#f0f7f2'
			),
		];
	}

	/**
	 * How a studio actually engages, with the box for the question that is not
	 * on the list. A portfolio wins the interest; this is what loses or keeps
	 * it.
	 *
	 * @return array
	 */
	private static function working_with_us() {
		$faqs = [
			Parts::faq(
				__('Starting', 'faq-and-answers'),
				__('What does the first conversation cover?', 'faq-and-answers'),
				'<p>' . __('The initial conversation is designed to understand your goals, current challenges, and project requirements. We focus on identifying what you want to achieve and what solutions have already been attempted.', 'faq-and-answers') . '</p>'
					. '<p><strong>' . __('Key topics covered during the call:', 'faq-and-answers') . '</strong></p>'
					. '<ul>'
					. '<li>' . __('Project scope, vision, and core business objectives', 'faq-and-answers') . '</li>'
					. '<li>' . __('Existing technical stack and design assets', 'faq-and-answers') . '</li>'
					. '<li>' . __('Timeline expectations and key milestones', 'faq-and-answers') . '</li>'
					. '<li>' . __('Budget allocation and team alignment', 'faq-and-answers') . '</li>'
					. '</ul>'
					. '<p>' . __('This 30-minute discovery session helps determine whether our expertise aligns with your needs without any high-pressure pitch decks.', 'faq-and-answers') . '</p>'
			),
			Parts::faq(
				__('Starting', 'faq-and-answers'),
				__('Do you pitch for work?', 'faq-and-answers'),
				'<p>' . __('We do not participate in unpaid speculative design competitions or uncompensated pitch decks. Instead, we demonstrate our capabilities through relevant past case studies, transparent methodologies, and direct client references.', 'faq-and-answers') . '</p>'
					. '<p><strong>' . __('Our collaborative process involves:', 'faq-and-answers') . '</strong></p>'
					. '<ul>'
					. '<li>' . __('Reviewing similar portfolio projects and verified outcomes', 'faq-and-answers') . '</li>'
					. '<li>' . __('Discussing strategic design and technical approaches', 'faq-and-answers') . '</li>'
					. '<li>' . __('Providing fixed-scope estimates prior to project kickoff', 'faq-and-answers') . '</li>'
					. '</ul>'
					. '<p>' . __('This ensures every project receives dedicated craftsmanship from senior specialists right from day one.', 'faq-and-answers') . '</p>'
			),
			Parts::faq(
				__('During', 'faq-and-answers'),
				__('How often will we hear from you?', 'faq-and-answers'),
				'<p>' . __('Communication is continuous, transparent, and structured so you always know exactly what progress is being made without waiting for monthly status reports.', 'faq-and-answers') . '</p>'
					. '<p><strong>' . __('How we keep you updated:', 'faq-and-answers') . '</strong></p>'
					. '<ul>'
					. '<li>' . __('Weekly working demos with interactive previews', 'faq-and-answers') . '</li>'
					. '<li>' . __('Shared task board accessible anytime for real-time tracking', 'faq-and-answers') . '</li>'
					. '<li>' . __('Direct asynchronous messaging for quick questions', 'faq-and-answers') . '</li>'
					. '<li>' . __('Milestone review sessions at every major release', 'faq-and-answers') . '</li>'
					. '</ul>'
					. '<p>' . __('This approach eliminates surprises and keeps feedback loops fast and productive.', 'faq-and-answers') . '</p>'
			),
			Parts::faq(
				__('During', 'faq-and-answers'),
				__('Who is actually doing the work?', 'faq-and-answers'),
				'<p>' . __('Your project is handled directly by senior designers and developers—the exact team members you speak with during initial discussions. We do not pass work down to unmonitored juniors or third-party contractors.', 'faq-and-answers') . '</p>'
					. '<p><strong>' . __('Steps to ensure quality delivery:', 'faq-and-answers') . '</strong></p>'
					. '<ul>'
					. '<li>' . __('Dedicated senior lead assigned to your project', 'faq-and-answers') . '</li>'
					. '<li>' . __('Continuous code review and quality assurance', 'faq-and-answers') . '</li>'
					. '<li>' . __('Direct communication with the creators building your application', 'faq-and-answers') . '</li>'
					. '</ul>'
					. '<p>' . __('This guarantees consistent high quality, accountability, and seamless execution throughout the engagement.', 'faq-and-answers') . '</p>'
			),
			Parts::faq(
				__('After', 'faq-and-answers'),
				__('Can our own team take it on?', 'faq-and-answers'),
				'<p>' . __('Yes, smooth handoff and complete team empowerment are core objectives of our engagement model. Once the project is complete, we transfer full ownership and complete source assets to your internal team.', 'faq-and-answers') . '</p>'
					. '<p><strong>' . __('What is included in the handover package:', 'faq-and-answers') . '</strong></p>'
					. '<ul>'
					. '<li>' . __('Full clean source code, repositories, and design system files', 'faq-and-answers') . '</li>'
					. '<li>' . __('Comprehensive documentation and architectural decision logs', 'faq-and-answers') . '</li>'
					. '<li>' . __('Recorded video walkthroughs covering setup and maintenance', 'faq-and-answers') . '</li>'
					. '<li>' . __('30 days of post-launch support and guidance at no extra charge', 'faq-and-answers') . '</li>'
					. '</ul>'
					. '<p>' . __('Your internal team will be fully equipped to maintain and extend the system independently.', 'faq-and-answers') . '</p>'
			),
		];

		$leftFaq = Parts::block('faa/faq-and-answers', [
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

		$askAiBlock = Parts::block(
			'faa/ask-ai',
			[
				'align'           => 'wide',
				'showHeading'     => false,
				'showSubheading'  => false,
				'headingAlign'    => 'center',
				'subheadingAlign' => 'center',
				'buttonText'      => __('Ask', 'faq-and-answers'),
				'showSources'     => true,
				'showFeedback'    => true,
				'fallbackText'    => __('Rather talk to a person?', 'faq-and-answers'),
				'accent'          => '#4338ca',
				'boxBg'           => ['type' => 'solid', 'color' => '#ffffff'],
				'answerBg'        => ['type' => 'solid', 'color' => '#f5f4ff'],
				'suggestions'     => [
					__('How long does a typical project take?', 'faq-and-answers'),
					__('Do you work with in-house teams?', 'faq-and-answers'),
					__('What does it cost to start?', 'faq-and-answers'),
				],
				'border'          => ['width' => '1px', 'style' => 'solid', 'color' => '#ddd9fa', 'side' => 'all', 'radius' => '16px'],
			]
		);

		return [
			'title'     => __('Working With Us', 'faq-and-answers'),
			'groups'    => ['portfolio'],
			'keywords'  => ['studio', 'process', 'engagement', 'ask ai', 'agency', 'portfolio'],
			'thumbnail' => 'working-with-us.svg',
			'content'   => Parts::section(
				Parts::heading(__('Ask something else', 'faq-and-answers'), 3, '', '', 'center')
					. $askAiBlock
					. '<!-- wp:spacer {"height":"36px"} --><div style="height:36px" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->'
					. $leftFaq,
				'#f2f2fc'
			),
		];
	}
}

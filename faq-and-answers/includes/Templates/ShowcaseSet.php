<?php
/**
 * The use-case sets: one template per industry category.
 *
 * These are the shapes a site sells with rather than supports with — rooms,
 * dishes, garments, listings, sessions — so most of them are picture-led and
 * sit on the Image FAQ block. Where a free block does the job as well, it is
 * used instead, so that a free install is not left with a category full of
 * padlocks: Fitness, Health, Services and Projects all run on the Awesome FAQ
 * block.
 *
 * The pictures ship with the plugin. They are deliberately abstract — a
 * gradient and one line glyph reads as artwork meant to be replaced with the
 * author's own photograph, which a convincing fake of a hotel room does not.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class ShowcaseSet {

	/**
	 * @return array
	 */
	public static function all() {
		return [
			self::fashion_lookbook(),
			self::fitness_diet(),
			self::food_menu(),
			self::health(),
			self::hotel_suites(),
			self::product_features(),
			self::projects(),
			self::real_estate(),
			self::services(),
			self::speakers(),
			self::travel(),
			self::visual_storytelling(),
		];
	}

	/**
	 * Shared shape for the picture-led ones: a dark section, a light heading,
	 * and the Image FAQ block set to whichever template suits the subject.
	 *
	 * @param array  $args title, groups, keywords, thumbnail, heading, intro,
	 *                     background, template, panels, position.
	 * @return array
	 */
	private static function showcase(array $args) {
		$intro        = !empty($args['intro']) ? Parts::paragraph($args['intro']) : '';
		$fontSize     = isset($args['headingFontSize']) ? $args['headingFontSize'] : 'XL';
		$headingColor = isset($args['headingColor']) ? $args['headingColor'] : ('' !== $args['background'] ? '#ffffff' : '#0f172a');
		$headingAlign = isset($args['headingAlign']) ? $args['headingAlign'] : 'center';

		return [
			'title'     => $args['title'],
			'groups'    => $args['groups'],
			'keywords'  => $args['keywords'],
			'thumbnail' => $args['thumbnail'],
			'content'   => Parts::section(
				Parts::heading($args['heading'], 2, $headingColor, $fontSize, $headingAlign)
					. $intro
					. Parts::block(
						'faa/image-faq',
						[
							'template'        => $args['template'],
							'items'           => $args['panels'],
							'activateOn'      => 'click',
							'contentPosition' => $args['position'],
							'useScrim'        => true,
							'overlayBg'       => ['type' => 'solid', 'color' => 'transparent'],
							'titleColor'      => '#ffffff',
							'descColor'       => 'rgba(255,255,255,0.88)',
							'buttonBg'        => 'rgba(255,255,255,0.18)',
							'buttonColor'     => '#ffffff',
							'buttonHoverBg'   => 'rgba(255,255,255,0.34)',
						]
					),
				$args['background']
			),
		];
	}

	/* ------------------------------------------------------ picture-led */

	/**
	 * @return array
	 */
	private static function fashion_lookbook() {
		return self::showcase(
			[
				'title'      => __('Fashion Lookbook', 'faq-and-answers'),
				'groups'     => ['fashion'],
				'keywords'   => ['fashion', 'lookbook', 'clothing', 'collection', 'style', 'boutique'],
				'thumbnail'  => 'fashion-lookbook.svg',
				'heading'      => __('The new collection', 'faq-and-answers'),
				'intro'        => __('Four looks, and what each one is made of. Tap a panel to read it.', 'faq-and-answers'),
				'headingColor' => '#000000',
				'background'   => '',
				'template'   => 'caption',
				'position'   => 'bottomLeft',
				'panels'     => [
					Parts::panel(
						'fashion-1.svg',
						__('Abstract artwork for a tailoring look', 'faq-and-answers'),
						__('Tailoring', 'faq-and-answers'),
						__('Wool-blend suiting cut for movement, half-lined so it wears through a warm afternoon. Sizes 6 to 22, with alterations included in store.', 'faq-and-answers'),
						__('See the look', 'faq-and-answers')
					),
					Parts::panel(
						'fashion-2.svg',
						__('Abstract artwork for a knitwear look', 'faq-and-answers'),
						__('Knitwear', 'faq-and-answers'),
						__('Merino from a mill we have used for nine years. It softens rather than pills, and every piece is machine washable on cool.', 'faq-and-answers'),
						__('See the look', 'faq-and-answers')
					),
					Parts::panel(
						'fashion-3.svg',
						__('Abstract artwork for an outerwear look', 'faq-and-answers'),
						__('Outerwear', 'faq-and-answers'),
						__('Recycled shell, taped seams, and pockets deep enough for a phone that will not fall out on a bus. Weatherproof to a proper downpour.', 'faq-and-answers'),
						__('See the look', 'faq-and-answers')
					),
					Parts::panel(
						'fashion-4.svg',
						__('Abstract artwork for an accessories look', 'faq-and-answers'),
						__('Accessories', 'faq-and-answers'),
						__('Vegetable-tanned leather and solid brass, made to be repaired rather than replaced. Belts and bags carry a ten-year guarantee.', 'faq-and-answers'),
						__('See the look', 'faq-and-answers')
					),
				],
			]
		);
	}

	/**
	 * @return array
	 */
	private static function food_menu() {
		return self::showcase(
			[
				'title'      => __('Food Menu', 'faq-and-answers'),
				'groups'     => ['food'],
				'keywords'   => ['food', 'menu', 'restaurant', 'cafe', 'dishes', 'kitchen'],
				'thumbnail'  => 'food-menu.svg',
				'heading'    => __('On the menu', 'faq-and-answers'),
				'intro'      => '',
				'background' => '#1d1208',
				'template'   => 'caption',
				'position'   => 'bottomLeft',
				'panels'     => [
					Parts::panel(
						'food-1.svg',
						__('Abstract artwork for the small plates course', 'faq-and-answers'),
						__('Small plates', 'faq-and-answers'),
						__('Six to share between two, or four if you are hungry. Everything here is vegetarian and three of the six are vegan without changing anything.', 'faq-and-answers'),
						__('See the dishes', 'faq-and-answers')
					),
					Parts::panel(
						'food-2.svg',
						__('Abstract artwork for the main courses', 'faq-and-answers'),
						__('From the grill', 'faq-and-answers'),
						__('Cooked over charcoal, so nothing comes out well done — tell us if that matters and we will steer you elsewhere on the menu.', 'faq-and-answers'),
						__('See the dishes', 'faq-and-answers')
					),
					Parts::panel(
						'food-3.svg',
						__('Abstract artwork for the sides', 'faq-and-answers'),
						__('Sides', 'faq-and-answers'),
						__('Grown within forty miles for most of the year. The menu changes on Tuesdays when the delivery arrives, so this is where it moves most.', 'faq-and-answers'),
						__('See the dishes', 'faq-and-answers')
					),
					Parts::panel(
						'food-4.svg',
						__('Abstract artwork for the desserts', 'faq-and-answers'),
						__('Puddings', 'faq-and-answers'),
						__('Made here each morning, which is why they run out. Ask what is left before you plan around one.', 'faq-and-answers'),
						__('See the dishes', 'faq-and-answers')
					),
				],
			]
		);
	}

	/**
	 * @return array
	 */
	private static function hotel_suites() {
		$panels = [
			Parts::panel(
				'hotel-1.svg',
				__('Abstract artwork for the garden room', 'faq-and-answers'),
				__('Garden Room', 'faq-and-answers'),
				__('Twenty-six square metres on the ground floor, doors onto the walled garden. Quietest rooms we have, and the only ones a dog can stay in.', 'faq-and-answers'),
				__('Check dates', 'faq-and-answers')
			),
			Parts::panel(
				'hotel-2.svg',
				__('Abstract artwork for the harbour suite', 'faq-and-answers'),
				__('Harbour Suite', 'faq-and-answers'),
				__('Corner room on the second floor with windows on two sides. Breakfast is included and served until eleven, later at weekends.', 'faq-and-answers'),
				__('Check dates', 'faq-and-answers')
			),
			Parts::panel(
				'hotel-3.svg',
				__('Abstract artwork for the loft suite', 'faq-and-answers'),
				__('The Loft', 'faq-and-answers'),
				__('The whole top floor, with a separate sitting room and a bath under the skylight. Sleeps four; the second bedroom has no window, so we say so plainly.', 'faq-and-answers'),
				__('Check dates', 'faq-and-answers')
			),
			Parts::panel(
				'hotel-4.svg',
				__('Abstract artwork for the courtyard double', 'faq-and-answers'),
				__('Courtyard Double', 'faq-and-answers'),
				__('Our smallest and least expensive, eighteen square metres, shower rather than a bath. Everything else is exactly the same as the rest.', 'faq-and-answers'),
				__('Check dates', 'faq-and-answers')
			),
		];

		$headerColumns = Parts::columns(
			[
				[
					'width'    => '65%',
					'vertical' => 'center',
					'inner'    => Parts::heading(__('Where you will be staying', 'faq-and-answers'), 2, '#ffffff', 'XL', 'left'),
				],
				[
					'width'    => '35%',
					'vertical' => 'center',
					'inner'    => Parts::button(__('Check Availability', 'faq-and-answers'), '#', '#ffffff', '#0c1a22', '8px', 'right'),
				],
			],
			'center'
		);

		return [
			'title'     => __('Hotel Suites', 'faq-and-answers'),
			'groups'    => ['hotel'],
			'keywords'  => ['hotel', 'suites', 'rooms', 'booking', 'hospitality', 'stay'],
			'thumbnail' => 'hotel-suites.svg',
			'content'   => Parts::section(
				$headerColumns
					. Parts::block(
						'faa/image-faq',
						[
							'template'        => 'spotlight',
							'items'           => $panels,
							'activateOn'      => 'click',
							'contentPosition' => 'bottomLeft',
							'useScrim'        => true,
							'overlayBg'       => ['type' => 'solid', 'color' => 'transparent'],
							'titleColor'      => '#ffffff',
							'descColor'       => 'rgba(255,255,255,0.88)',
							'buttonBg'        => 'rgba(255,255,255,0.18)',
							'buttonColor'     => '#ffffff',
							'buttonHoverBg'   => 'rgba(255,255,255,0.34)',
						]
					),
				'#0c1a22'
			),
		];
	}

	/**
	 * @return array
	 */
	private static function projects() {
		$panels = [
			Parts::panel(
				'portfolio-1.svg',
				__('Abstract artwork for a rebuild project', 'faq-and-answers'),
				__('Checkout rebuild', 'faq-and-answers'),
				__('A five-step checkout became two. Abandonment fell by a third over the following quarter, and support stopped fielding “where is my order” entirely.', 'faq-and-answers'),
				__('Read the case study', 'faq-and-answers')
			),
			Parts::panel(
				'portfolio-2.svg',
				__('Abstract artwork for a migration project', 'faq-and-answers'),
				__('Platform migration', 'faq-and-answers'),
				__('Eleven years of content moved with every URL intact. Traffic dipped for nine days and then came back above where it started.', 'faq-and-answers'),
				__('Read the case study', 'faq-and-answers')
			),
			Parts::panel(
				'portfolio-3.svg',
				__('Abstract artwork for a design system project', 'faq-and-answers'),
				__('Design system', 'faq-and-answers'),
				__('One set of components replacing four. New pages that took a fortnight now take an afternoon, and they look like each other.', 'faq-and-answers'),
				__('Read the case study', 'faq-and-answers')
			),
			Parts::panel(
				'portfolio-4.svg',
				__('Abstract artwork for a performance project', 'faq-and-answers'),
				__('Performance work', 'faq-and-answers'),
				__('Largest Contentful Paint from 4.1s to 1.3s on a mid-range phone, without dropping a single feature from the page.', 'faq-and-answers'),
				__('Read the case study', 'faq-and-answers')
			),
		];

		return [
			'title'     => __('Projects & Portfolio', 'faq-and-answers'),
			'groups'    => ['portfolio'],
			'keywords'  => ['portfolio', 'projects', 'case studies', 'work', 'agency', 'gallery'],
			'thumbnail' => 'projects-portfolio.svg',
			'content'   => Parts::section(
				Parts::heading(__('Selected work', 'faq-and-answers'), 2, '#0f172a', 'XL', 'left')
					. Parts::paragraph(__('Four projects, with what the problem actually was and what changed.', 'faq-and-answers'), 'left', '#64748b')
					. Parts::block(
						'faa/image-faq',
						[
							'template'        => 'caption',
							'items'           => $panels,
							'activateOn'      => 'click',
							'contentPosition' => 'bottomLeft',
							'useScrim'        => true,
							'overlayBg'       => ['type' => 'solid', 'color' => 'transparent'],
							'titleColor'      => '#ffffff',
							'descColor'       => 'rgba(255,255,255,0.88)',
							'buttonBg'        => 'rgba(255,255,255,0.18)',
							'buttonColor'     => '#ffffff',
							'buttonHoverBg'   => 'rgba(255,255,255,0.34)',
						]
					)
					. Parts::button(__('See More', 'faq-and-answers'), '#', '#0f172a', '#ffffff', '8px', 'center'),
				'#ffffff'
			),
		];
	}

	/**
	 * @return array
	 */
	private static function real_estate() {
		$faqs = [
			Parts::faq(
				__('Wall Art', 'faq-and-answers'),
				__('How do I choose the right art size for my space?', 'faq-and-answers'),
				__('A good rule of thumb is to choose artwork that fills 60% to 75% of available wall space. Over furniture like a sofa, aim for a width of about two-thirds the furniture\'s length.', 'faq-and-answers')
			),
			Parts::faq(
				__('Framing', 'faq-and-answers'),
				__('What materials and framing options are available?', 'faq-and-answers'),
				__('We offer handcrafted solid wood frames, modern metal finishes, and gallery canvas wraps using museum-grade archival paper and UV-resistant glass.', 'faq-and-answers')
			),
			Parts::faq(
				__('Custom Orders', 'faq-and-answers'),
				__('Can I request custom sizes or personalized prints?', 'faq-and-answers'),
				__('Yes, bespoke dimensions and custom framing are available across our collection. Simply reach out to our curation team with your room dimensions.', 'faq-and-answers')
			),
			Parts::faq(
				__('Care & Hanging', 'faq-and-answers'),
				__('How should I hang and care for my artwork?', 'faq-and-answers'),
				__('Hang artwork at standard eye level (roughly 57 to 60 inches from floor to center). Dust gently with a soft microfiber cloth and avoid hanging in direct, harsh sunlight.', 'faq-and-answers')
			),
		];

		$leftContent = Parts::block('faa/faq-and-answers', [
			'faqData' => $faqs,
			'theme'   => 'themeOne',
			'Styles'  => [
				'heading'   => ['title' => [], 'subTitle' => [], 'button' => []],
				'container' => [],
				'content'   => [
					'question' => [
						'background' => ['color' => '#ffffff'],
						'colors'     => ['color' => '#1e293b'],
						'padding'    => [
							'desktop' => ['top' => '16px', 'right' => '20px', 'bottom' => '16px', 'left' => '20px'],
						],
					],
					'answer'   => [
						'background' => ['color' => '#f8fafc'],
						'colors'     => ['color' => '#475569'],
						'padding'    => [
							'desktop' => ['top' => '16px', 'right' => '20px', 'bottom' => '20px', 'left' => '20px'],
						],
					],
					'icon'     => [
						'size'   => [
							'desktop' => '22px',
							'tablet'  => '20px',
							'mobile'  => '18px',
						],
						'colors' => ['color' => '#0f172a'],
					],
				],
			],
		]);

		$rightContent = Parts::heading(__('Wall Art & Decoration', 'faq-and-answers'), 2, '#1e293b', 'L', 'left')
			. Parts::paragraph(__('Enhance your home walls with creative artwork, framed photos, and modern decorative pieces that reflect your personality.', 'faq-and-answers'), 'left', '#64748b')
			. Parts::button(__('Explore Now', 'faq-and-answers'), '#', '#0f172a', '#ffffff', '8px', 'left');

		return [
			'title'     => __('Real Estate Zones', 'faq-and-answers'),
			'groups'    => ['estate'],
			'keywords'  => ['real estate', 'property', 'zones', 'wall art', 'decoration', 'interior', 'two column', 'home'],
			'thumbnail' => 'real-estate-zones.svg',
			'content'   => Parts::section(
				Parts::columns(
					[
						['width' => '58%', 'vertical' => 'center', 'inner' => $leftContent],
						['width' => '42%', 'vertical' => 'center', 'inner' => $rightContent],
					],
					'center'
				),
				'#ffffff'
			),
		];
	}

	/**
	 * @return array
	 */
	private static function speakers() {
		return self::showcase(
			[
				'title'      => __('Speakers & Performers', 'faq-and-answers'),
				'groups'     => ['speakers'],
				'keywords'   => ['speakers', 'performers', 'lineup', 'conference', 'event', 'festival'],
				'thumbnail'  => 'speakers-performers.svg',
				'heading'      => __('This year\'s line-up', 'faq-and-answers'),
				'headingAlign' => 'left',
				'intro'        => '',
				'background' => '',
				'template'   => 'caption',
				'position'   => 'bottomCenter',
				'panels'     => [
					Parts::panel(
						'speakers-1.svg',
						__('Abstract artwork for the opening keynote', 'faq-and-answers'),
						__('Opening keynote', 'faq-and-answers'),
						__('Thursday, 09:30, Main Hall. Forty minutes on what a decade of shipping accessible interfaces actually taught them, with the failures left in.', 'faq-and-answers'),
						__('See the session', 'faq-and-answers')
					),
					Parts::panel(
						'speakers-2.svg',
						__('Abstract artwork for the workshop track', 'faq-and-answers'),
						__('Workshop track', 'faq-and-answers'),
						__('Thursday afternoon, Studio 2. Bring a laptop. Capped at thirty people and it does fill up, so sign up when you collect your badge.', 'faq-and-answers'),
						__('See the session', 'faq-and-answers')
					),
					Parts::panel(
						'speakers-3.svg',
						__('Abstract artwork for the panel discussion', 'faq-and-answers'),
						__('Panel discussion', 'faq-and-answers'),
						__('Friday, 14:00, Main Hall. Four people who disagree, and half the hour kept for questions from the floor rather than from us.', 'faq-and-answers'),
						__('See the session', 'faq-and-answers')
					),
					Parts::panel(
						'speakers-4.svg',
						__('Abstract artwork for the closing performance', 'faq-and-answers'),
						__('Closing performance', 'faq-and-answers'),
						__('Friday, 19:00, Courtyard Stage. Outdoors, so dress for it. Included with any ticket and open to guests as well.', 'faq-and-answers'),
						__('See the session', 'faq-and-answers')
					),
				],
			]
		);
	}

	/**
	 * @return array
	 */
	private static function travel() {
		$panels = [
			Parts::panel(
				'travel-1.svg',
				__('Abstract artwork for a coastal trip', 'faq-and-answers'),
				__('The coast road', 'faq-and-answers'),
				__('Nine days, April to June, easy pace. Small hotels and a driver, so nobody has to take the wheel on the switchbacks.', 'faq-and-answers'),
				__('See the itinerary', 'faq-and-answers')
			),
			Parts::panel(
				'travel-2.svg',
				__('Abstract artwork for a mountain trip', 'faq-and-answers'),
				__('High passes', 'faq-and-answers'),
				__('Twelve days, July to September, demanding. Five hours of walking most days at altitude — we will be honest with you about fitness.', 'faq-and-answers'),
				__('See the itinerary', 'faq-and-answers')
			),
			Parts::panel(
				'travel-3.svg',
				__('Abstract artwork for a desert trip', 'faq-and-answers'),
				__('Desert nights', 'faq-and-answers'),
				__('Seven days, October to March only. Two nights under canvas with no signal, which is the point rather than the compromise.', 'faq-and-answers'),
				__('See the itinerary', 'faq-and-answers')
			),
			Parts::panel(
				'travel-4.svg',
				__('Abstract artwork for a city trip', 'faq-and-answers'),
				__('Three cities', 'faq-and-answers'),
				__('Ten days by rail, any month. The most walking of the four and the best food; the least rest, if that matters to you.', 'faq-and-answers'),
				__('See the itinerary', 'faq-and-answers')
			),
		];

		$leftContent = Parts::heading(__('Travel Destinations', 'faq-and-answers'), 2, '#0f172a', 'XL', 'left')
			. Parts::paragraph(__('Discover unforgettable journeys, breathtaking landscapes, and handcrafted travel itineraries designed for every adventure.', 'faq-and-answers'), 'left', '#64748b')
			. Parts::button(__('Explore Trips', 'faq-and-answers'), '#', '#0f172a', '#ffffff', '8px', 'left');

		$rightContent = Parts::block(
			'faa/image-faq',
			[
				'template'        => 'spotlight',
				'items'           => $panels,
				'activateOn'      => 'click',
				'contentPosition' => 'bottomLeft',
				'useScrim'        => true,
				'overlayBg'       => ['type' => 'solid', 'color' => 'transparent'],
				'titleColor'      => '#ffffff',
				'descColor'       => 'rgba(255,255,255,0.88)',
				'buttonBg'        => 'rgba(255,255,255,0.18)',
				'buttonColor'     => '#ffffff',
				'buttonHoverBg'   => 'rgba(255,255,255,0.34)',
			]
		);

		return [
			'title'     => __('Travel Destinations', 'faq-and-answers'),
			'groups'    => ['travel'],
			'keywords'  => ['travel', 'destinations', 'tours', 'trips', 'holiday', 'itinerary', 'two column', 'image faq'],
			'thumbnail' => 'travel-destinations.svg',
			'content'   => Parts::section(
				Parts::columns(
					[
						['width' => '42%', 'vertical' => 'center', 'inner' => $leftContent],
						['width' => '58%', 'vertical' => 'center', 'inner' => $rightContent],
					],
					'center'
				),
				'#ffffff'
			),
		];
	}

	/**
	 * @return array
	 */
	private static function visual_storytelling() {
		return self::showcase(
			[
				'title'           => __('Visual Storytelling', 'faq-and-answers'),
				'groups'          => ['story'],
				'keywords'        => ['storytelling', 'visual', 'chapters', 'narrative', 'editorial', 'scroll'],
				'thumbnail'       => 'visual-storytelling.svg',
				'heading'         => __('The story so far', 'faq-and-answers'),
				'headingFontSize' => 'XL',
				'headingAlign'    => 'right',
				'intro'           => '',
				'background'      => '#4f3cb4',
				'template'        => 'spotlight',
				'position'        => 'bottomCenter',
				'panels'          => [
					Parts::panel(
						'story-1.svg',
						__('Abstract artwork for chapter one', 'faq-and-answers'),
						__('One — where it started', 'faq-and-answers'),
						__('A workshop, two people and a problem nobody else seemed to think was a problem. It took four years to find out they were right.', 'faq-and-answers'),
						__('Read the chapter', 'faq-and-answers')
					),
					Parts::panel(
						'story-2.svg',
						__('Abstract artwork for chapter two', 'faq-and-answers'),
						__('Two — the wrong turn', 'faq-and-answers'),
						__('Eighteen months building the thing customers asked for instead of the thing they needed. Worth telling, because it is the part everyone skips.', 'faq-and-answers'),
						__('Read the chapter', 'faq-and-answers')
					),
					Parts::panel(
						'story-3.svg',
						__('Abstract artwork for chapter three', 'faq-and-answers'),
						__('Three — what changed', 'faq-and-answers'),
						__('One decision, taken over a weekend, that meant throwing away most of the code. It is the only reason any of the rest exists.', 'faq-and-answers'),
						__('Read the chapter', 'faq-and-answers')
					),
					Parts::panel(
						'story-4.svg',
						__('Abstract artwork for chapter four', 'faq-and-answers'),
						__('Four — now', 'faq-and-answers'),
						__('Where things stand, what we are still getting wrong, and what the next year looks like from here.', 'faq-and-answers'),
						__('Read the chapter', 'faq-and-answers')
					),
				],
			]
		);
	}

	/* ------------------------------------------------- free alternatives */

	/**
	 * @return array
	 */
	private static function fitness_diet() {
		$faqs = [
			Parts::faq(
				__('Nutrition', 'faq-and-answers'),
				__('Why Is Protein Breakfast Important Daily?', 'faq-and-answers'),
				__('Starting your day with protein stabilizes blood sugar, reduces mid-morning cravings, and provides essential amino acids to rebuild muscle tissue and maintain steady energy levels throughout the morning.', 'faq-and-answers')
			),
			Parts::faq(
				__('Nutrition', 'faq-and-answers'),
				__('What Defines A Balanced Healthy Lunch?', 'faq-and-answers'),
				__('A balanced lunch combines lean protein, complex carbohydrates, healthy fats, and fiber-rich vegetables to sustain mental clarity and prevent afternoon energy slumps.', 'faq-and-answers')
			),
			Parts::faq(
				__('Nutrition', 'faq-and-answers'),
				__('How Should Light Dinners Be Structured?', 'faq-and-answers'),
				__('Evening meals should focus on easily digestible proteins and green vegetables while reducing heavy refined carbs, promoting restful sleep and night-time recovery.', 'faq-and-answers')
			),
			Parts::faq(
				__('Nutrition', 'faq-and-answers'),
				__('Which Healthy Snacks Maintain Stable Energy?', 'faq-and-answers'),
				__('Nut-based snacks, Greek yogurt, fresh berries, or hummus with raw vegetables provide a smooth balance of macronutrients without spiking insulin.', 'faq-and-answers')
			),
			Parts::faq(
				__('Hydration', 'faq-and-answers'),
				__('How Much Water Should I Drink?', 'faq-and-answers'),
				__('Most adults need eight to ten glasses of water daily, though this varies by body weight, activity level, and climate. Staying well hydrated improves skin clarity, boosts energy, supports kidney function, and helps control appetite throughout the day effectively.', 'faq-and-answers')
			),
		];

		$styles = [
			'content' => [
				'question' => [
					'background' => ['color' => '#1e293b'],
					'colors'     => ['color' => '#ffffff'],
					'padding'    => [
						'desktop' => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
						'tablet'  => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
						'mobile'  => ['top' => '0px', 'right' => '0px', 'bottom' => '0px', 'left' => '0px'],
					],
				],
			],
		];

		$leftContent = Parts::paragraph(__('FAQS SECTION', 'faq-and-answers'), 'left', '#2563eb')
			. Parts::subheading(__('Healthy Living Questions Answered For Everyday Wellness', 'faq-and-answers'), 2, '#0f172a')
			. Parts::paragraph(__('Still have a question in mind? Contact us directly!', 'faq-and-answers'), 'left', '#64748b')
			. Parts::button(__('Contact Us', 'faq-and-answers'), '#', '#000000', '#ffffff', '50px');

		$rightContent = Parts::block('faa/faq-and-answers', [
			'faqData' => $faqs,
			'theme'   => 'themeFourteen',
			'Styles'  => $styles,
		]);

		return [
			'title'     => __('Fitness & Diet', 'faq-and-answers'),
			'groups'    => ['fitness'],
			'keywords'  => ['fitness', 'diet', 'training', 'nutrition', 'gym', 'coaching', 'badge'],
			'thumbnail' => 'fitness-diet.svg',
			'content'   => Parts::section(
				Parts::columns([
					['width' => '42%', 'vertical' => 'center', 'inner' => $leftContent],
					['width' => '58%', 'vertical' => 'center', 'inner' => $rightContent],
				]),
				'#ffffff'
			),
		];
	}

	/**
	 * @return array
	 */
	private static function health() {
		$faqs = [
			Parts::faq(
				__('Appointments', 'faq-and-answers'),
				__('How soon can I be seen?', 'faq-and-answers'),
				__('Routine appointments are usually within five working days. Keep an eye on the same-day list from eight in the morning if you need something sooner.', 'faq-and-answers')
			),
			Parts::faq(
				__('Appointments', 'faq-and-answers'),
				__('Can I be seen by video instead?', 'faq-and-answers'),
				__('For most follow-ups, yes, and it is often quicker. Anything that needs an examination has to be in person, and we will tell you which when you book.', 'faq-and-answers')
			),
			Parts::faq(
				__('Appointments', 'faq-and-answers'),
				__('What should I bring?', 'faq-and-answers'),
				__('A list of anything you take, including things bought over the counter, and the dates of anything relevant that has already been done elsewhere.', 'faq-and-answers')
			),
			Parts::faq(
				__('Cost & cover', 'faq-and-answers'),
				__('Do you take my insurance?', 'faq-and-answers'),
				__('We work with the main providers. Bring your membership number and we will confirm cover before anything is booked, not after.', 'faq-and-answers')
			),
			Parts::faq(
				__('Cost & cover', 'faq-and-answers'),
				__('What if I am paying myself?', 'faq-and-answers'),
				__('Every price is on the fees page, including the ones people forget to ask about. You will get the full figure in writing before you agree to it.', 'faq-and-answers')
			),
			Parts::faq(
				__('Records', 'faq-and-answers'),
				__('Who can see my notes?', 'faq-and-answers'),
				__('Only the clinicians involved in your care, unless you ask us in writing to share them. You can request a copy of everything we hold at any time.', 'faq-and-answers')
			),
		];

		return [
			'title'     => __('Health & Clinic', 'faq-and-answers'),
			'groups'    => ['health'],
			'keywords'  => ['health', 'clinic', 'patients', 'medical', 'appointments', 'care'],
			'thumbnail' => 'health-clinic.svg',
			'content'   => Parts::section(
				Parts::heading(__('Patient questions', 'faq-and-answers'), 2, '#000000', 'XL')
					. Parts::paragraph(__('Appointments, cost and cover, and what happens to your records.', 'faq-and-answers'), 'center', '#000000', 'M')
					. Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeTwelve']),
				''
			),
		];
	}

	/**
	 * @return array
	 */
	private static function services() {
		$faqs = [
			Parts::faq(
				__('Working together', 'faq-and-answers'),
				__('How do projects usually start?', 'faq-and-answers'),
				__('A call, then a short written scope with a fixed price against it. Nothing begins until you have that in front of you and have said yes to it.', 'faq-and-answers')
			),
			Parts::faq(
				__('Working together', 'faq-and-answers'),
				__('Who will I actually be dealing with?', 'faq-and-answers'),
				__('The people doing the work. There is no account manager in between, which is faster and occasionally less polished.', 'faq-and-answers')
			),
			Parts::faq(
				__('Working together', 'faq-and-answers'),
				__('What do you need from us?', 'faq-and-answers'),
				__('One person who can make decisions, and content by the date we agree. Late content is the single most common reason a project slips.', 'faq-and-answers')
			),
			Parts::faq(
				__('Scope & change', 'faq-and-answers'),
				__('What if we want to change something halfway?', 'faq-and-answers'),
				__('Small things are absorbed. Anything that moves the date or the price comes back to you as a written change before it is started, never after.', 'faq-and-answers')
			),
			Parts::faq(
				__('Scope & change', 'faq-and-answers'),
				__('Do you work with our existing team?', 'faq-and-answers'),
				__('Often, and it usually goes well. Tell us early who owns what, so we are not quietly rebuilding something your developer already maintains.', 'faq-and-answers')
			),
			Parts::faq(
				__('Afterwards', 'faq-and-answers'),
				__('What happens when it is finished?', 'faq-and-answers'),
				__('You own everything, including the source. Support is available monthly but is not a condition of anything, and you can leave whenever you like.', 'faq-and-answers')
			),
		];

		return [
			'title'     => __('Services & Engagement', 'faq-and-answers'),
			'groups'    => ['services'],
			'keywords'  => ['services', 'agency', 'consulting', 'engagement', 'scope', 'process'],
			'thumbnail' => 'services-engagement.svg',
			'content'   => Parts::section(
				Parts::heading(__('How we work', 'faq-and-answers'))
					. Parts::paragraph(__('What a project looks like from your side of it.', 'faq-and-answers'))
					. Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeThree']),
				'#f2f4fa'
			),
		];
	}

	/* ------------------------------------------------------------ a grid */

	/**
	 * @return array
	 */
	private static function product_features() {
		$leftContent = '<!-- wp:paragraph {"style":{"color":{"text":"#ffffff"}}} -->'
			. '<p class="wp-block-paragraph has-text-color" style="color:#ffffff;"><span style="display:inline-block;padding:4px 12px;border-radius:6px;font-size:12px;font-weight:600;letter-spacing:0.5px;background-color:rgba(255,255,255,0.18);color:#ffffff;">'
			. esc_html__('FAQ', 'faq-and-answers')
			. '</span></p>'
			. '<!-- /wp:paragraph -->'
			. Parts::heading(__('Answers to Frequently Asked Questions.', 'faq-and-answers'), 2, '#ffffff', 'XL', 'left')
			. Parts::paragraph(__('In our FAQ, you\'ll find concise answers to common questions about our service, Booking Steps. If you still have questions, feel free to reach out to us.', 'faq-and-answers'), 'left', '#e0e7ff', 'M');

		$rightImage = '<!-- wp:group {"style":{"border":{"radius":"18px"},"color":{"background":"#ffffff"}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->'
			. '<div class="wp-block-group has-background" style="border-radius:18px;background-color:#ffffff;padding:24px;text-align:center;">'
			. '<img src="' . esc_url(Parts::thumb('product-features.svg')) . '" alt="' . esc_attr__('FAQ Illustration', 'faq-and-answers') . '" style="max-width:100%;height:auto;border-radius:10px;" />'
			. '</div>'
			. '<!-- /wp:group -->';

		$banner = Parts::section(
			Parts::columns([
				['width' => '54%', 'vertical' => 'center', 'inner' => $leftContent],
				['width' => '46%', 'vertical' => 'center', 'inner' => $rightImage],
			]),
			'#ff6900',
			'20px'
		);

		$items = [
			Parts::card(
				'🧩',
				__('What is actually included?', 'faq-and-answers'),
				__('Every layout, the shared library behind them, the submission form, and updates. No feature is held back for a higher tier.', 'faq-and-answers'),
				'wide',
				__('Start here', 'faq-and-answers')
			),
			Parts::card(
				'🔌',
				__('Does it work with my page builder?', 'faq-and-answers'),
				__('Yes, through the shortcode where a builder will not give you a block. The block editor needs nothing extra.', 'faq-and-answers'),
				'normal'
			),
			Parts::card(
				'♿',
				__('Is it accessible?', 'faq-and-answers'),
				__('Every question is a real button, reachable by keyboard, with focus you can see and state a screen reader announces.', 'faq-and-answers'),
				'normal'
			),
			Parts::card(
				'⚙️',
				__('How much can I change?', 'faq-and-answers'),
				__('Colours, type, spacing, borders and behaviour, per block. It inherits your theme first so it looks right untouched.', 'faq-and-answers'),
				'normal'
			),
			Parts::card(
				'🌍',
				__('Is it translation ready?', 'faq-and-answers'),
				__('Every string goes through the translation functions, and the templates are translated with the plugin.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'📈',
				__('Can I see what people ask?', 'faq-and-answers'),
				__('Submissions land on the Form Submissions screen, where you can read every question visitors sent and mark what you have handled.', 'faq-and-answers'),
				'normal'
			),
		];

		return [
			'title'     => __('Product Features', 'faq-and-answers'),
			'groups'    => ['features'],
			'keywords'  => ['product', 'features', 'grid', 'bento', 'landing page', 'saas', 'banner'],
			'thumbnail' => 'product-features.svg',
			'content'   => Parts::section(
				$banner
					. '<!-- wp:spacer {"height":"36px"} --><div style="height:36px" aria-hidden="true" class="wp-block-spacer"></div><!-- /wp:spacer -->'
					. Parts::block(
						'faa/bento-faq',
						[
							'items'       => $items,
							'openMode'    => 'modal',
							'columns'     => ['desktop' => 4, 'tablet' => 2, 'mobile' => 1],
							'showIcons'   => true,
							'showExcerpt' => true,
							'accent'      => '#362186',
							'cardBg'      => '#ffffff',
							'cardBorder'  => '#dde6f7',
							'cardRadius'  => '18px',
						]
					),
				''
			),
		];
	}
}

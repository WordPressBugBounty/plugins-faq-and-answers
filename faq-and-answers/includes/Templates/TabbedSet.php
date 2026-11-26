<?php
/**
 * Tabbed FAQ templates — two use cases for each of the three designs.
 *
 * Each template is the Tabbed FAQ block (faa/tabbed-faq) with its design's full
 * style preset written into the attributes, so the inspector shows the real
 * values from the first click. The presets are the same file render.php and the
 * editor read: assets/data/tabbed-faq-presets.json.
 *
 * The block is listed in BuiltIn::PRO_BLOCKS, so every template here is pro.
 * Text contains no double quotes — see Parts::icons() for why.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class TabbedSet {

	/**
	 * @return array
	 */
	public static function all() {
		return [
			self::gift_store(),
			self::event_venue(),
			self::saas_help(),
			self::online_course(),
			self::hotel_guest(),
			self::clinic(),
			self::car_dealer(),
			self::admissions(),
			self::charity(),
			self::fashion_store(),
		];
	}

	/* ------------------------------------------------- more use cases */

	private static function car_dealer() {
		$tabs = [
			self::tab(__('Buying a Car', 'faq-and-answers'), [
				self::q(__('Can I book a test drive online?', 'faq-and-answers'), __('Yes. Pick the car and a time slot, and bring your driving licence. Test drives last about 30 minutes.', 'faq-and-answers')),
				self::q(__('Are your used cars inspected?', 'faq-and-answers'), __('Every used car passes a 150-point inspection and comes with a full service history report.', 'faq-and-answers')),
				self::q(__('Do you deliver cars to my home?', 'faq-and-answers'), __('Yes. Free delivery within 50 miles, or collect it from the showroom with a full handover.', 'faq-and-answers')),
				self::q(__('Can I reserve a car before I visit?', 'faq-and-answers'), __('A refundable deposit holds any car for 72 hours while you decide.', 'faq-and-answers')),
			], __('Buying a car', 'faq-and-answers')),
			self::tab(__('Finance', 'faq-and-answers'), [
				self::q(__('What finance options do you offer?', 'faq-and-answers'), __('Hire purchase, PCP and personal contract hire, with quotes from several lenders in one place.', 'faq-and-answers')),
				self::q(__('Will checking my eligibility affect my credit score?', 'faq-and-answers'), __('No. Our eligibility check is a soft search and is not visible to other lenders.', 'faq-and-answers')),
				self::q(__('Can I pay off my finance early?', 'faq-and-answers'), __('Yes. Ask for a settlement figure at any time. Early repayment usually reduces the interest you pay.', 'faq-and-answers')),
			]),
			self::tab(__('Part Exchange', 'faq-and-answers'), [
				self::q(__('How do you value my current car?', 'faq-and-answers'), __('Enter your registration and mileage for an instant online valuation, confirmed by a quick inspection on the day.', 'faq-and-answers')),
				self::q(__('Can I part exchange a car with finance left on it?', 'faq-and-answers'), __('Yes. We settle the remaining finance with your lender and take it off the price of your next car.', 'faq-and-answers')),
			]),
			self::tab(__('Warranty & Service', 'faq-and-answers'), [
				self::q(__('What warranty comes with a used car?', 'faq-and-answers'), __('Twelve months of warranty and breakdown cover, extendable up to three years.', 'faq-and-answers')),
				self::q(__('Where can I get my car serviced?', 'faq-and-answers'), __('At our own service centre, with a courtesy car and a video health check sent to your phone.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — Car Dealership (Boxed)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-car-dealership-boxed',
			'groups'    => ['automotive'],
			'keywords'  => ['tabs', 'car', 'dealership', 'auto', 'finance', 'test drive', 'boxed', 'pro'],
			'thumbnail' => 'tabbed-car-dealership.webp',
			'content'   => self::block('boxed', $tabs, ['tabActiveBg' => '#c1121f', 'tabActiveBorderColor' => '#c1121f', 'questionActiveColor' => '#c1121f', 'cardActiveBorderColor' => '#c1121f']),
		];
	}

	private static function admissions() {
		$tabs = [
			self::tab(__('Applying', 'faq-and-answers'), [
				self::q(__('When is the application deadline?', 'faq-and-answers'), __('Applications for the September intake close on 31 January. Late applications are reviewed if places remain.', 'faq-and-answers')),
				self::q(__('What documents do I need?', 'faq-and-answers'), __('Your transcripts, a personal statement, one reference and a copy of your passport.', 'faq-and-answers')),
				self::q(__('Is there an application fee?', 'faq-and-answers'), __('No. Applying to any undergraduate course is free.', 'faq-and-answers')),
			]),
			self::tab(__('Fees & Funding', 'faq-and-answers'), [
				self::q(__('How much are tuition fees?', 'faq-and-answers'), __('Fees depend on the course and your fee status. Every course page lists the exact amount for the year.', 'faq-and-answers')),
				self::q(__('Do you offer scholarships?', 'faq-and-answers'), __('Yes. Merit and need-based scholarships are open to all applicants, with no separate form.', 'faq-and-answers')),
				self::q(__('Can I pay in instalments?', 'faq-and-answers'), __('Fees can be paid in three instalments across the academic year.', 'faq-and-answers')),
			]),
			self::tab(__('International', 'faq-and-answers'), [
				self::q(__('What English level do I need?', 'faq-and-answers'), __('IELTS 6.5 overall, or an equivalent test. Pre-sessional English courses are available if you are close.', 'faq-and-answers')),
				self::q(__('Will you help with my student visa?', 'faq-and-answers'), __('Our international office guides you through every step once you accept your offer.', 'faq-and-answers')),
			]),
			self::tab(__('Campus Life', 'faq-and-answers'), [
				self::q(__('Is accommodation guaranteed?', 'faq-and-answers'), __('First-year students who apply by the deadline are guaranteed a room in university halls.', 'faq-and-answers')),
				self::q(__('Can I visit before I apply?', 'faq-and-answers'), __('Join an open day on campus or take the virtual tour any time.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — University Admissions (Pills)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-university-admissions-pills',
			'groups'    => ['education'],
			'keywords'  => ['tabs', 'university', 'college', 'admissions', 'students', 'fees', 'pills', 'pro'],
			'thumbnail' => 'tabbed-university-admissions.webp',
			'content'   => self::block('pills', $tabs, ['openFirst' => true, 'tabActiveBg' => '#4338ca', 'tabActiveBorderColor' => '#4338ca', 'questionActiveColor' => '#4338ca', 'iconColor' => '#4338ca', 'cardActiveBorderColor' => '#c7d2fe']),
		];
	}

	private static function charity() {
		$tabs = [
			self::tab(__('Donating', 'faq-and-answers'), [
				self::q(__('How much of my donation goes to projects?', 'faq-and-answers'), __('88 pence of every pound goes straight to our projects. The rest keeps the lights on and raises the next pound.', 'faq-and-answers')),
				self::q(__('Can I give monthly?', 'faq-and-answers'), __('Yes. Monthly gifts let us plan ahead, and you can change or stop yours at any time.', 'faq-and-answers')),
				self::q(__('Is my donation tax deductible?', 'faq-and-answers'), __('We are a registered charity, so eligible donations qualify for tax relief. You get a receipt by email.', 'faq-and-answers')),
			], __('Giving to our work', 'faq-and-answers')),
			self::tab(__('Volunteering', 'faq-and-answers'), [
				self::q(__('How can I volunteer?', 'faq-and-answers'), __('Fill in the short form and we will match you with a local project that fits your time and skills.', 'faq-and-answers')),
				self::q(__('Do I need experience?', 'faq-and-answers'), __('No. Every volunteer gets a free induction and a named contact to help along the way.', 'faq-and-answers')),
			]),
			self::tab(__('Fundraising', 'faq-and-answers'), [
				self::q(__('Can I fundraise for you?', 'faq-and-answers'), __('Yes, please! Run, bake, cycle or swim. We send a free fundraising pack with everything you need.', 'faq-and-answers')),
				self::q(__('Can my company match my donation?', 'faq-and-answers'), __('Many employers do. Ask your HR team and we will send them the paperwork.', 'faq-and-answers')),
			]),
			self::tab(__('Our Impact', 'faq-and-answers'), [
				self::q(__('Where does the charity work?', 'faq-and-answers'), __('We run clean water and school projects in 14 countries, always with local partners.', 'faq-and-answers')),
				self::q(__('How do you report results?', 'faq-and-answers'), __('Our annual impact report and audited accounts are published every summer.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — Charity Donations (Sidebar)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-charity-donations-sidebar',
			'groups'    => ['nonprofit'],
			'keywords'  => ['tabs', 'charity', 'nonprofit', 'donate', 'volunteer', 'fundraising', 'sidebar', 'pro'],
			'thumbnail' => 'tabbed-charity.webp',
			'content'   => self::block('sidebar', $tabs, ['openFirst' => true]),
		];
	}

	private static function fashion_store() {
		$tabs = [
			self::tab(__('Sizing', 'faq-and-answers'), [
				self::q(__('How do I find my size?', 'faq-and-answers'), __('Every product page has a size chart in centimetres and inches, plus notes on how the fit runs.', 'faq-and-answers')),
				self::q(__('What if I am between sizes?', 'faq-and-answers'), __('For a relaxed fit size up; for a close fit size down. Our stylists can help over chat.', 'faq-and-answers')),
			]),
			self::tab(__('Delivery', 'faq-and-answers'), [
				self::q(__('How fast is delivery?', 'faq-and-answers'), __('Standard delivery takes 2 to 4 working days. Order by 2 pm for next-day express.', 'faq-and-answers')),
				self::q(__('Do you ship worldwide?', 'faq-and-answers'), __('We ship to over 60 countries, with duties calculated at checkout so there are no surprises.', 'faq-and-answers')),
			]),
			self::tab(__('Returns', 'faq-and-answers'), [
				self::q(__('What is your returns policy?', 'faq-and-answers'), __('Return unworn items with tags within 30 days for a full refund. Returns are free.', 'faq-and-answers')),
				self::q(__('How long do refunds take?', 'faq-and-answers'), __('Refunds reach your original payment method within 5 working days of the return arriving.', 'faq-and-answers')),
			]),
			self::tab(__('Care', 'faq-and-answers'), [
				self::q(__('How should I wash linen pieces?', 'faq-and-answers'), __('Cold wash, gentle cycle, then dry flat. A quick steam brings back the drape.', 'faq-and-answers')),
				self::q(__('Do you repair clothes?', 'faq-and-answers'), __('Yes. Our repair service fixes seams, buttons and zips on anything bought from us, for free in the first year.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — Fashion Store (Pills)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-fashion-store-pills',
			'groups'    => ['fashion'],
			'keywords'  => ['tabs', 'fashion', 'clothing', 'store', 'sizing', 'returns', 'pills', 'pro'],
			'thumbnail' => 'tabbed-fashion-store.webp',
			'content'   => self::block('pills', $tabs, ['openFirst' => true, 'tabActiveBg' => '#111111', 'tabActiveBorderColor' => '#111111', 'questionActiveColor' => '#111111', 'iconColor' => '#111111', 'cardActiveBorderColor' => '#d4d4d4']),
		];
	}

	/* ---------------------------------------------------------- helpers */

	private static function presets() {
		static $presets = null;

		if (null === $presets) {
			$file    = AFAQ_DIR_PATH . 'assets/data/tabbed-faq-presets.json';
			$presets = is_readable($file) ? json_decode((string) file_get_contents($file), true) : []; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- Local file.
			$presets = is_array($presets) ? $presets : [];
		}

		return $presets;
	}

	public static function q($question, $answer) {
		return ['question' => $question, 'answer' => $answer];
	}

	public static function tab($title, array $items, $heading = '') {
		return ['title' => $title, 'heading' => $heading, 'items' => $items];
	}

	public static function block($design, array $tabs, array $extra = []) {
		$presets = self::presets();
		$attrs   = array_merge(
			['template' => $design, 'align' => 'wide', 'tabs' => $tabs, 'enableSchema' => true, 'showHeading' => true],
			$presets[$design] ?? [],
			$extra
		);

		return Parts::block('faa/tabbed-faq', $attrs);
	}

	/* ------------------------------------------------------------- boxed */

	private static function gift_store() {
		$tabs = [
			self::tab(__('Bulk Orders & Delivery', 'faq-and-answers'), [
				self::q(__('Are delivery charges included in product prices?', 'faq-and-answers'), __('Prices are listed without delivery. Shipping is calculated at checkout from the order weight and the delivery pin code, and bulk orders above a set value ship free.', 'faq-and-answers')),
				self::q(__('What are your typical delivery timelines?', 'faq-and-answers'), __('Ready stock ships in 2 to 4 working days. Customised and bulk orders usually take 7 to 12 working days, depending on quantity and finishing.', 'faq-and-answers')),
				self::q(__('How far in advance should bulk return gifts be planned?', 'faq-and-answers'), __('We recommend ordering three to four weeks before the event, so there is time for samples, approval and personalisation.', 'faq-and-answers')),
				self::q(__('Do you ship across India and internationally?', 'faq-and-answers'), __('Yes. We deliver to every serviceable pin code in India and ship internationally on request.', 'faq-and-answers')),
				self::q(__('What happens if a product arrives damaged?', 'faq-and-answers'), __('Share an unboxing photo or video within 48 hours and we will replace or refund the damaged pieces.', 'faq-and-answers')),
				self::q(__('Who bears the shipping cost for a damaged replacement?', 'faq-and-answers'), __('We do. Replacements for items damaged in transit are shipped at no extra cost.', 'faq-and-answers')),
				self::q(__('Can ordered products be returned or exchanged?', 'faq-and-answers'), __('Ready-stock items in their original packaging can be exchanged within 7 days. Personalised products cannot be returned unless damaged.', 'faq-and-answers')),
				self::q(__('Is the advance payment refundable?', 'faq-and-answers'), __('The advance is fully refundable until production starts.', 'faq-and-answers')),
			]),
			self::tab(__('Customization & Branding', 'faq-and-answers'), [
				self::q(__('Can you add our logo or names to the gifts?', 'faq-and-answers'), __('Yes. We print, engrave or emboss logos, names and dates, and share a digital proof before production.', 'faq-and-answers')),
				self::q(__('Is there a minimum quantity for customisation?', 'faq-and-answers'), __('Most personalised items start at 25 pieces; some engraved products start at one.', 'faq-and-answers')),
				self::q(__('Can we choose our own colours and packaging?', 'faq-and-answers'), __('Absolutely. Pick ribbons, tags and box finishes to match your event or brand palette.', 'faq-and-answers')),
				self::q(__('Will we see a sample before the full order?', 'faq-and-answers'), __('Yes. A physical sample can be sent for approval on bulk orders.', 'faq-and-answers')),
			]),
			self::tab(__('Trust & Experience', 'faq-and-answers'), [
				self::q(__('How long have you been making return gifts?', 'faq-and-answers'), __('For over ten years, for families, companies and event planners.', 'faq-and-answers')),
				self::q(__('Can we visit your studio?', 'faq-and-answers'), __('Yes. Book a slot and see our products and finishes in person.', 'faq-and-answers')),
			]),
			self::tab(__('Wedding Packing', 'faq-and-answers'), [
				self::q(__('Do you offer trousseau and wedding gift packing?', 'faq-and-answers'), __('Yes. We pack trousseau, shagun and wedding favours in trays, baskets and boxes themed to your ceremony.', 'faq-and-answers')),
				self::q(__('Can you pack items that we send you?', 'faq-and-answers'), __('Of course. Send your items to our studio and we will pack them in the style you choose.', 'faq-and-answers')),
			]),
			self::tab(__('Gift Hampers', 'faq-and-answers'), [
				self::q(__('Can we build a custom hamper?', 'faq-and-answers'), __('Yes. Choose the products, the basket and a personal note, and we will put it together.', 'faq-and-answers')),
				self::q(__('Can hampers go to multiple addresses?', 'faq-and-answers'), __('Yes. Share a list of addresses and we will ship each hamper separately, with tracking.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — Gift Store (Boxed)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-gift-store-boxed',
			'groups'    => ['sales'],
			'keywords'  => ['tabs', 'gift', 'store', 'ecommerce', 'bulk orders', 'delivery', 'boxed', 'pro'],
			'thumbnail' => 'tabbed-gift-store.webp',
			'content'   => self::block('boxed', $tabs),
		];
	}

	private static function event_venue() {
		$tabs = [
			self::tab(__('Booking & Availability', 'faq-and-answers'), [
				self::q(__('How early should we book the venue?', 'faq-and-answers'), __('Weekend dates in the wedding season fill up 9 to 12 months ahead. Weekdays are often available at shorter notice.', 'faq-and-answers')),
				self::q(__('Can we hold a date before paying?', 'faq-and-answers'), __('Yes. We hold a date for 7 days while you decide, with no charge.', 'faq-and-answers')),
				self::q(__('What is the guest capacity?', 'faq-and-answers'), __('The main hall seats 350 for dinner and the lawn hosts up to 800 standing.', 'faq-and-answers')),
				self::q(__('Can we visit before booking?', 'faq-and-answers'), __('Of course. Site visits run every day from 11 am to 6 pm by appointment.', 'faq-and-answers')),
			], __('Booking the venue', 'faq-and-answers')),
			self::tab(__('Catering', 'faq-and-answers'), [
				self::q(__('Can we bring our own caterer?', 'faq-and-answers'), __('Outside caterers are welcome for a kitchen-use fee, provided they hold a food safety licence.', 'faq-and-answers')),
				self::q(__('Do you offer tasting sessions?', 'faq-and-answers'), __('Yes. A tasting for up to six people is included once the booking is confirmed.', 'faq-and-answers')),
				self::q(__('Can you cater for dietary needs?', 'faq-and-answers'), __('Vegetarian, Jain, vegan and gluten-free menus are all available.', 'faq-and-answers')),
			]),
			self::tab(__('Decor & Setup', 'faq-and-answers'), [
				self::q(__('Is basic decor included?', 'faq-and-answers'), __('Tables, chairs, linen and stage lighting are included. Floral and theme decor are quoted separately.', 'faq-and-answers')),
				self::q(__('When can our decorator start setting up?', 'faq-and-answers'), __('Set-up can start 8 hours before the event and must be cleared within 3 hours after.', 'faq-and-answers')),
			]),
			self::tab(__('Policies', 'faq-and-answers'), [
				self::q(__('What is the cancellation policy?', 'faq-and-answers'), __('Cancel more than 90 days ahead for a full refund of the deposit; after that the deposit moves to a new date within a year.', 'faq-and-answers')),
				self::q(__('Is there a music curfew?', 'faq-and-answers'), __('Outdoor music ends at 10 pm as per local rules; indoor events can continue until midnight.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — Event Venue (Boxed)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-event-venue-boxed',
			'groups'    => ['hotel'],
			'keywords'  => ['tabs', 'venue', 'wedding', 'events', 'booking', 'catering', 'boxed', 'pro'],
			'thumbnail' => 'tabbed-event-venue.webp',
			'content'   => self::block('boxed', $tabs, ['tabActiveBg' => '#1f3b2d', 'tabActiveBorderColor' => '#1f3b2d', 'questionActiveColor' => '#1f3b2d', 'cardActiveBorderColor' => '#1f3b2d']),
		];
	}

	/* ------------------------------------------------------------- pills */

	private static function saas_help() {
		$tabs = [
			self::tab(__('Getting started', 'faq-and-answers'), [
				self::q(__('How do I create my first project?', 'faq-and-answers'), __('Click New project on your dashboard, pick a template and invite your team. It takes about two minutes.', 'faq-and-answers')),
				self::q(__('Can I import data from another tool?', 'faq-and-answers'), __('Yes. Import CSV files or connect Trello, Asana and Jira from Settings, then Import.', 'faq-and-answers')),
				self::q(__('Is there a mobile app?', 'faq-and-answers'), __('Yes, for iOS and Android, with offline access to your recent projects.', 'faq-and-answers')),
				self::q(__('Where can I find tutorials?', 'faq-and-answers'), __('Our Academy has short videos for every feature, plus a weekly live onboarding call.', 'faq-and-answers')),
			], __('Getting started', 'faq-and-answers')),
			self::tab(__('Billing', 'faq-and-answers'), [
				self::q(__('Is there a free trial?', 'faq-and-answers'), __('Every paid plan starts with a 14-day trial. No card required.', 'faq-and-answers')),
				self::q(__('Can I change plans at any time?', 'faq-and-answers'), __('Yes. Upgrades apply immediately and downgrades at the end of the billing cycle, prorated.', 'faq-and-answers')),
				self::q(__('Do you offer discounts for non-profits?', 'faq-and-answers'), __('Registered non-profits and schools get 50 percent off any plan.', 'faq-and-answers')),
			]),
			self::tab(__('Integrations', 'faq-and-answers'), [
				self::q(__('Which tools do you integrate with?', 'faq-and-answers'), __('Slack, Google Workspace, Microsoft 365, GitHub, Zapier and more than 60 others.', 'faq-and-answers')),
				self::q(__('Do you have an API?', 'faq-and-answers'), __('Yes, a REST API and webhooks on every paid plan, with full documentation.', 'faq-and-answers')),
			]),
			self::tab(__('Security', 'faq-and-answers'), [
				self::q(__('Where is my data stored?', 'faq-and-answers'), __('In ISO 27001 certified data centres in the EU or US — you choose the region.', 'faq-and-answers')),
				self::q(__('Do you support single sign-on?', 'faq-and-answers'), __('SAML SSO and SCIM provisioning are available on the Business plan.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — SaaS Help Centre (Pills)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-saas-help-centre-pills',
			'groups'    => ['support'],
			'keywords'  => ['tabs', 'saas', 'help centre', 'billing', 'software', 'pills', 'pro'],
			'thumbnail' => 'tabbed-saas-help.webp',
			'content'   => self::block('pills', $tabs, ['openFirst' => true]),
		];
	}

	private static function online_course() {
		$tabs = [
			self::tab(__('Enrolment', 'faq-and-answers'), [
				self::q(__('When does the next cohort start?', 'faq-and-answers'), __('A new cohort starts on the first Monday of every month.', 'faq-and-answers')),
				self::q(__('Are there any prerequisites?', 'faq-and-answers'), __('No. The course starts from the basics and builds up week by week.', 'faq-and-answers')),
				self::q(__('Can I pay in instalments?', 'faq-and-answers'), __('Yes. Split the fee into three monthly payments at no extra cost.', 'faq-and-answers')),
			]),
			self::tab(__('Learning', 'faq-and-answers'), [
				self::q(__('How many hours a week should I plan for?', 'faq-and-answers'), __('Around 5 to 6 hours: two live sessions and a short project.', 'faq-and-answers')),
				self::q(__('Are the live sessions recorded?', 'faq-and-answers'), __('Every session is recorded and available within an hour.', 'faq-and-answers')),
				self::q(__('Will I get feedback on my work?', 'faq-and-answers'), __('Yes. A mentor reviews each project and leaves written feedback.', 'faq-and-answers')),
			]),
			self::tab(__('Certificates', 'faq-and-answers'), [
				self::q(__('Do I get a certificate?', 'faq-and-answers'), __('Complete every project to receive a verifiable certificate you can add to LinkedIn.', 'faq-and-answers')),
				self::q(__('Is the certificate accredited?', 'faq-and-answers'), __('It is industry-recognised and endorsed by our hiring partners.', 'faq-and-answers')),
			]),
			self::tab(__('Refunds', 'faq-and-answers'), [
				self::q(__('What if the course is not for me?', 'faq-and-answers'), __('Ask for a full refund within the first 14 days. No questions asked.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — Online Course (Pills)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-online-course-pills',
			'groups'    => ['onboarding'],
			'keywords'  => ['tabs', 'course', 'education', 'learning', 'school', 'pills', 'pro'],
			'thumbnail' => 'tabbed-online-course.webp',
			'content'   => self::block('pills', $tabs, ['tabActiveBg' => '#0ea5e9', 'tabActiveBorderColor' => '#0ea5e9', 'questionActiveColor' => '#0284c7', 'iconColor' => '#0284c7', 'cardActiveBorderColor' => '#bae6fd', 'columns' => ['desktop' => 1, 'tablet' => 1, 'mobile' => 1]]),
		];
	}

	/* ----------------------------------------------------------- sidebar */

	private static function hotel_guest() {
		$tabs = [
			self::tab(__('Check-in & check-out', 'faq-and-answers'), [
				self::q(__('What time is check-in?', 'faq-and-answers'), __('Check-in is from 2 pm and check-out is until 11 am. Early check-in is offered when rooms are ready.', 'faq-and-answers')),
				self::q(__('Can I store my luggage?', 'faq-and-answers'), __('Yes. The concierge stores luggage free of charge before check-in and after check-out.', 'faq-and-answers')),
				self::q(__('Do you offer airport transfers?', 'faq-and-answers'), __('A private car can be booked for 45 dollars each way. Ask at least 24 hours ahead.', 'faq-and-answers')),
			], __('Arriving and leaving', 'faq-and-answers')),
			self::tab(__('Rooms', 'faq-and-answers'), [
				self::q(__('Is Wi-Fi included?', 'faq-and-answers'), __('Fast Wi-Fi is free in every room and across the hotel.', 'faq-and-answers')),
				self::q(__('Can I request an extra bed?', 'faq-and-answers'), __('Rollaway beds and cots are available in most rooms on request.', 'faq-and-answers')),
				self::q(__('Are pets allowed?', 'faq-and-answers'), __('Dogs under 15 kg are welcome in garden rooms for a small cleaning fee.', 'faq-and-answers')),
			]),
			self::tab(__('Dining', 'faq-and-answers'), [
				self::q(__('Is breakfast included?', 'faq-and-answers'), __('Breakfast is included with most rates and served from 7 to 10:30 am.', 'faq-and-answers')),
				self::q(__('Is there room service?', 'faq-and-answers'), __('Room service runs from 7 am to 11 pm, with a short night menu after that.', 'faq-and-answers')),
			]),
			self::tab(__('Spa & pool', 'faq-and-answers'), [
				self::q(__('What are the pool hours?', 'faq-and-answers'), __('The pool is open from 7 am to 9 pm. Towels are provided poolside.', 'faq-and-answers')),
				self::q(__('Do I need to book spa treatments?', 'faq-and-answers'), __('We recommend booking a day ahead from the app or at reception.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — Hotel Guests (Sidebar)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-hotel-guests-sidebar',
			'groups'    => ['hotel'],
			'keywords'  => ['tabs', 'hotel', 'travel', 'guests', 'resort', 'sidebar', 'pro'],
			'thumbnail' => 'tabbed-hotel-guest.webp',
			'content'   => self::block('sidebar', $tabs, ['openFirst' => true]),
		];
	}

	private static function clinic() {
		$tabs = [
			self::tab(__('Appointments', 'faq-and-answers'), [
				self::q(__('How do I book an appointment?', 'faq-and-answers'), __('Book online any time, or call the front desk from 8 am to 8 pm, Monday to Saturday.', 'faq-and-answers')),
				self::q(__('Can I see the same doctor every time?', 'faq-and-answers'), __('Yes. Choose your preferred doctor when booking and we keep them on your record.', 'faq-and-answers')),
				self::q(__('Do you offer video consultations?', 'faq-and-answers'), __('Follow-ups and many first visits can be done by secure video call.', 'faq-and-answers')),
			]),
			self::tab(__('Insurance & billing', 'faq-and-answers'), [
				self::q(__('Which insurance plans do you accept?', 'faq-and-answers'), __('We work with most major insurers. Call us with your policy number to confirm cover.', 'faq-and-answers')),
				self::q(__('When do I pay?', 'faq-and-answers'), __('Your co-pay is collected at the visit; the rest is billed to your insurer directly.', 'faq-and-answers')),
			]),
			self::tab(__('Before your visit', 'faq-and-answers'), [
				self::q(__('What should I bring?', 'faq-and-answers'), __('Photo ID, your insurance card, a list of medicines and any recent test reports.', 'faq-and-answers')),
				self::q(__('Do I need to fast before a blood test?', 'faq-and-answers'), __('Some tests need 8 to 12 hours of fasting. Your booking confirmation will say if yours does.', 'faq-and-answers')),
			]),
			self::tab(__('Test results', 'faq-and-answers'), [
				self::q(__('How do I get my results?', 'faq-and-answers'), __('Results appear in the patient portal, usually within 48 hours, and your doctor will call if anything needs attention.', 'faq-and-answers')),
			]),
		];

		return [
			'title'     => __('Tabbed FAQ — Clinic Patients (Sidebar)', 'faq-and-answers'),
			'slug'      => 'tabbed-faq-clinic-patients-sidebar',
			'groups'    => ['health'],
			'keywords'  => ['tabs', 'clinic', 'health', 'doctor', 'patients', 'sidebar', 'pro'],
			'thumbnail' => 'tabbed-clinic.webp',
			'content'   => self::block('sidebar', $tabs, [
				'containerBg'           => ['type' => 'solid', 'color' => '#f3f7fb'],
				'tabActiveColor'        => '#1d4ed8',
				'tabActiveBorderColor'  => '#2563eb',
				'questionActiveColor'   => '#1d4ed8',
				'iconColor'             => '#2563eb',
				'cardActiveBorderColor' => '#2563eb',
				'cardBorder'            => ['width' => '1px', 'style' => 'solid', 'color' => '#dbe4ef', 'side' => 'bottom', 'radius' => '0px'],
			]),
		];
	}
}

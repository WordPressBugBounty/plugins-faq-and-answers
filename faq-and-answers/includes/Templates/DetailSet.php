<?php
/**
 * The pages that get written after launch.
 *
 * Status, security, procurement, migration, integrations, accessibility,
 * refunds — the pages nobody plans for and everybody eventually needs, usually
 * because one customer asked and it turned out fifty wanted to know.
 *
 * They are grouped into the existing categories rather than new ones. A
 * category per page would leave fifteen sidebar entries holding one template
 * each, which is a worse way to find anything than three holding ten.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class DetailSet
{

	/**
	 * @return array
	 */
	public static function all()
	{
		return [
			self::status_and_incidents(),
			self::contact_routes(),
			self::accessibility(),
			self::migration_guide(),
			self::enterprise(),
			self::integrations(),
			self::security_and_privacy(),
		];
	}

	/* ----------------------------------------------------- support pages */

	/**
	 * A status page's FAQ. The badge theme earns its place here: every answer
	 * is about a state — up, degraded, planned — and the badge is the thing
	 * somebody is actually scanning for.
	 *
	 * @return array
	 */
	private static function status_and_incidents()
	{
		$rightNow = [
			Parts::faq_item(
				__('How do I know if it is you or me?', 'faq-and-answers'),
				__('Check the status page first — it is hosted separately, so it stays up when we do not. If everything there is green, it is worth trying a different network before writing to us.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('What counts as an incident?', 'faq-and-answers'),
				__('Anything that stops you doing something you could do an hour ago. Slower than usual counts as degraded, and we post those too rather than hoping nobody notices.', 'faq-and-answers'),
				1
			),
		];

		$notifications = [
			Parts::faq_item(
				__('Can I be told automatically?', 'faq-and-answers'),
				__('Subscribe on the status page for email or a webhook. Both fire within a minute of an incident opening and again when it closes.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Do you publish post-mortems?', 'faq-and-answers'),
				__('For anything over fifteen minutes, within five working days, with what broke and what changed so it does not again. Names are left out; causes are not.', 'faq-and-answers'),
				1
			),
		];

		$maintenance = [
			Parts::faq_item(
				__('Do you have downtime windows?', 'faq-and-answers'),
				__('Planned work is announced a week ahead and scheduled between 02:00 and 04:00 UTC on a Sunday. Most releases need no window at all.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('Real-Time Status', 'faq-and-answers'),
			__('Current system state and incident classification.', 'faq-and-answers'),
			0,
			$rightNow,
			true
		)
			. Parts::faq_item(
				__('Notifications & Reports', 'faq-and-answers'),
				__('Automated alerts, webhooks, and post-mortem logs.', 'faq-and-answers'),
				0,
				$notifications
			)
			. Parts::faq_item(
				__('Scheduled Maintenance', 'faq-and-answers'),
				__('Planned downtime windows and maintenance schedules.', 'faq-and-answers'),
				0,
				$maintenance
			);

		return [
			'title' => __('Status & Incidents', 'faq-and-answers'),
			'groups' => ['support'],
			'keywords' => ['status', 'uptime', 'incidents', 'downtime', 'maintenance', 'sla', 'nested'],
			'thumbnail' => 'status-incidents.svg',
			'content' => Parts::section(
				Parts::heading(__('Status and incidents', 'faq-and-answers'))
				. Parts::paragraph(__('What we post, when we post it, and how to be told without checking.', 'faq-and-answers'))
				. Parts::wrap(
					'faa/nested-faq',
					[
						'template' => 'default',
						'openFirst' => true,
						'allowMultiple' => false,
						'iconType' => 'arrow',
						'iconPosition' => 'left',
						'questionColor' => '#ffffff',
						'questionBg' => ['type' => 'solid', 'color' => '#1e293b'],
						'questionOpenColor' => '#ffffff',
						'questionOpenBg' => ['type' => 'solid', 'color' => '#0f172a'],
						'nestedQuestionColor' => '#1e293b',
						'nestedQuestionBg' => ['type' => 'solid', 'color' => '#f1f5f9'],
						'answerColor' => '#475569',
						'answerBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'itemBorder' => ['width' => '0px', 'style' => 'solid', 'color' => '#e2e8f0', 'side' => 'all', 'radius' => '12px'],
					],
					$tree
				),
				'#f1f5f9'
			),
		];
	}

	/**
	 * Every way of reaching a person, with the form and the AI box beside each
	 * other. Somebody who has decided to write should not have to scroll, and
	 * somebody who has not should be offered the faster option first.
	 *
	 * @return array
	 */
	private static function contact_routes()
	{
		return [
			'title' => __('Ask AI Assistant', 'faq-and-answers'),
			'groups' => ['support'],
			'keywords' => ['contact', 'support', 'ask ai', 'ai assistant', 'routes'],
			'thumbnail' => 'contact-routes.svg',
			'content' => Parts::section(
				Parts::heading(__('Get in touch', 'faq-and-answers'))
				. Parts::paragraph(__('Try the quick way first. Most questions are already answered somewhere on this site.', 'faq-and-answers'))
				. Parts::block(
					'faa/ask-ai',
					[
						'heading' => __('Ask first', 'faq-and-answers'),
						'subheading' => __('Most questions are already answered somewhere on this site.', 'faq-and-answers'),
						'headingAlign' => 'center',
						'subheadingAlign' => 'center',
						'buttonText' => __('Ask', 'faq-and-answers'),
						'showSources' => true,
						'showFeedback' => true,
						'fallbackText' => __('Still need help? Write to us.', 'faq-and-answers'),
						'accent' => '#1d4ed8',
						'boxBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'answerBg' => ['type' => 'solid', 'color' => '#f2f6fe'],
						'suggestions' => [
							__('How do I reset my password?', 'faq-and-answers'),
							__('Where is my invoice?', 'faq-and-answers'),
							__('How do I move my licence?', 'faq-and-answers'),
						],
						'border' => ['width' => '1px', 'style' => 'solid', 'color' => '#dbe3f2', 'side' => 'all', 'radius' => '16px'],
					]
				),
				'#eef3fc'
			),
		];
	}

	/**
	 * An accessibility statement, made searchable. The people who need this
	 * page arrive with one specific question, which is exactly the case the
	 * search theme is for.
	 *
	 * @return array
	 */
	private static function accessibility()
	{
		$faqs = [
			Parts::faq(
				__('Keyboard', 'faq-and-answers'),
				__('Can everything be used without a mouse?', 'faq-and-answers'),
				__('Yes. Every question is a real button, focus is always visible, and nothing traps the keyboard inside it. Tab and Enter reach everything a click does.', 'faq-and-answers')
			),
			Parts::faq(
				__('Screen readers', 'faq-and-answers'),
				__('Is open and closed announced?', 'faq-and-answers'),
				__('Each question carries its expanded state and points at the answer it controls, so a screen reader says whether it is open before you decide to open it.', 'faq-and-answers')
			),
			Parts::faq(
				__('Screen readers', 'faq-and-answers'),
				__('Which readers do you test with?', 'faq-and-answers'),
				__('NVDA on Windows and VoiceOver on macOS and iOS. Those three cover most of the people who write to us about it.', 'faq-and-answers')
			),
			Parts::faq(
				__('Motion', 'faq-and-answers'),
				__('Can I turn the animation off?', 'faq-and-answers'),
				__('It turns itself off. If your system asks for reduced motion, panels open instantly instead of sliding, and nothing moves under the pointer.', 'faq-and-answers')
			),
			Parts::faq(
				__('Colour', 'faq-and-answers'),
				__('Do the default colours pass contrast?', 'faq-and-answers'),
				__('Every default combination meets AA for body text. Once you change them that is yours to check, and the contrast figure is shown beside the colour picker.', 'faq-and-answers')
			),
			Parts::faq(
				__('Reporting', 'faq-and-answers'),
				__('I found a barrier. Who do I tell?', 'faq-and-answers'),
				__('Write to us with the page and what happened. Accessibility reports are treated as bugs rather than requests, and they go to the front of the queue.', 'faq-and-answers')
			),
		];

		return [
			'title' => __('Accessibility', 'faq-and-answers'),
			'groups' => ['support'],
			'keywords' => ['accessibility', 'a11y', 'keyboard', 'screen reader', 'wcag', 'contrast'],
			'thumbnail' => 'accessibility.svg',
			'content' => Parts::section(
				Parts::heading(__('Accessibility', 'faq-and-answers'))
				. Parts::paragraph(__('What works, what we test, and where to tell us it does not.', 'faq-and-answers'))
				. Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeSeven']),
				'#f4f6fa'
			),
		];
	}

	/* --------------------------------------------------- getting started */


	/**
	 * Moving from another plugin. A tree, because every answer here is "it
	 * depends which one you are coming from".
	 *
	 * @return array
	 */
	private static function migration_guide()
	{
		$before = [
			Parts::faq_item(
				__('Do I have to remove the old plugin first?', 'faq-and-answers'),
				__('No, and you should not. Leave it active until the new pages are published, then deactivate rather than delete for a fortnight.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Will my URLs change?', 'faq-and-answers'),
				__('Not unless you move the pages. FAQs live inside a page here rather than having addresses of their own.', 'faq-and-answers'),
				1
			),
		];

		$during = [
			Parts::faq_item(
				__('Can I bring the questions across automatically?', 'faq-and-answers'),
				__('From the common formats, yes. From a page builder\'s own accordion, usually not — those store content in a shape only they can read.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('What about my styling?', 'faq-and-answers'),
				__('It does not come with them, and that is a feature. Pick the closest theme and adjust; matching the old plugin exactly usually means keeping choices you had stopped liking.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('What if the two clash on one page?', 'faq-and-answers'),
				__('Switch schema off on one of them. Two sets of FAQ markup is the only real conflict, and it is a setting rather than a code change.', 'faq-and-answers'),
				1
			),
		];

		$after = [
			Parts::faq_item(
				__('Will search rankings drop?', 'faq-and-answers'),
				__('Not from this, as long as the questions and answers stay on the same URLs and stay visible without clicking. Keep the wording and you keep the position.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('How long should I keep the old one?', 'faq-and-answers'),
				__('Two weeks, deactivated. Long enough to spot a page you forgot, short enough that nobody reactivates it by accident.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('Before you start', 'faq-and-answers'),
			__('Two things worth knowing, both of which save an afternoon.', 'faq-and-answers'),
			0,
			$before,
			true
		)
			. Parts::faq_item(
				__('Moving the content', 'faq-and-answers'),
				__('What comes across on its own and what has to be retyped.', 'faq-and-answers'),
				0,
				$during
			)
			. Parts::faq_item(
				__('Afterwards', 'faq-and-answers'),
				__('Rankings, and when it is safe to delete the old plugin.', 'faq-and-answers'),
				0,
				$after
			)
			. Parts::faq_item(
				__('Want us to check it?', 'faq-and-answers'),
				__('Send the URL of one migrated page before you do the rest. We would rather look at one than untangle thirty.', 'faq-and-answers'),
				0
			);

		return [
			'title' => __('Migration Guide', 'faq-and-answers'),
			'groups' => ['onboarding'],
			'keywords' => ['migration', 'import', 'switching', 'nested', 'move', 'seo'],
			'thumbnail' => 'migration-guide.svg',
			'content' => Parts::section(
				Parts::heading(__('Moving from another plugin', 'faq-and-answers'))
				. Parts::paragraph(__('Three stages, and the honest answer on what does not come across.', 'faq-and-answers'))
				. Parts::wrap(
					'faa/nested-faq',
					[
						'template' => 'default',
						'openFirst' => true,
						'allowMultiple' => false,
						'iconType' => 'arrow',
						'iconPosition' => 'left',
						'questionColor' => '#ffffff',
						'questionBg' => ['type' => 'solid', 'color' => '#0369a1'],
						'questionOpenColor' => '#ffffff',
						'questionOpenBg' => ['type' => 'solid', 'color' => '#075985'],
						'nestedQuestionColor' => '#0c4a6e',
						'nestedQuestionBg' => ['type' => 'solid', 'color' => '#eff8fe'],
						'answerColor' => '#475569',
						'answerBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'itemBorder' => ['width' => '0px', 'style' => 'solid', 'color' => '#d8ecf8', 'side' => 'all', 'radius' => '12px'],
					],
					$tree
				),
				'#eff6fc'
			),
		];
	}

	/* ------------------------------------------------------- sales pages */

	/**
	 * Procurement's questions, which are nobody's favourite page and lose more
	 * deals than the product does. Side-by-side, because these are read next
	 * to a checklist somebody has been handed.
	 *
	 * @return array
	 */
	private static function enterprise()
	{
		$faqs = [
			Parts::faq(
				__('Paperwork', 'faq-and-answers'),
				__('Can you complete our vendor questionnaire?', 'faq-and-answers'),
				__('Yes, and usually within three working days. Send it early — it is the step that delays these the most, and it is rarely the buyer who is slow.', 'faq-and-answers')
			),
			Parts::faq(
				__('Paperwork', 'faq-and-answers'),
				__('Will you sign our contract instead of yours?', 'faq-and-answers'),
				__('We will read it and mark what we cannot agree to, which is usually two clauses about unlimited liability. Everything else is negotiable.', 'faq-and-answers')
			),
			Parts::faq(
				__('Paperwork', 'faq-and-answers'),
				__('Do you have a DPA?', 'faq-and-answers'),
				__('One that is pre-signed and downloadable, with sub-processors listed. If your legal team wants changes, send them and we will look.', 'faq-and-answers')
			),
			Parts::faq(
				__('Payment', 'faq-and-answers'),
				__('Can we pay by invoice and purchase order?', 'faq-and-answers'),
				__('Annually, by bank transfer, on thirty-day terms. Quarterly is possible above a threshold; monthly invoicing is not.', 'faq-and-answers')
			),
			Parts::faq(
				__('Payment', 'faq-and-answers'),
				__('Is there a discount for multi-year?', 'faq-and-answers'),
				__('Two years at ten per cent, three at fifteen, and the rate is locked for the term. Ask rather than assuming it is on the pricing page.', 'faq-and-answers')
			),
		];

		$right = Parts::subheading(__('What we can send today', 'faq-and-answers'), 3)
			. Parts::bullets(
				[
					__('Pre-signed data processing agreement', 'faq-and-answers'),
					__('Sub-processor list and hosting locations', 'faq-and-answers'),
					__('Insurance certificate and company details', 'faq-and-answers'),
					__('Accessibility conformance statement', 'faq-and-answers'),
					__('A quote against a purchase order', 'faq-and-answers'),
				]
			)
			. Parts::text(__('Ask for all five in one email and they come back in one reply.', 'faq-and-answers'))
			. Parts::button(__('Request the pack', 'faq-and-answers'), '#', '#1e293b');

		return [
			'title' => __('Enterprise & Procurement', 'faq-and-answers'),
			'groups' => ['sales'],
			'keywords' => ['enterprise', 'procurement', 'legal', 'dpa', 'invoice', 'purchase order'],
			'thumbnail' => 'enterprise-procurement.svg',
			'content' => Parts::section(
				Parts::heading(__('For procurement', 'faq-and-answers'))
				. Parts::columns(
					[
						['width' => '60%', 'inner' => Parts::block('faa/faq-and-answers', ['faqData' => $faqs, 'theme' => 'themeTwelve'])],
						['width' => '40%', 'inner' => $right],
					]
				),
				'#f3f5f9'
			),
		];
	}


	/* ---------------------------------------------------- product pages */

	/**
	 * Integrations, as a grid. Every answer is independent and somebody is
	 * looking for one specific name, so hiding them behind clicks is the worst
	 * possible shape for this page.
	 *
	 * @return array
	 */
	private static function integrations()
	{
		$items = [
			Parts::card(
				'🧱',
				__('Does it work with my page builder?', 'faq-and-answers'),
				__('Through a shortcode anywhere a builder gives you a text field, and as a native block in the block editor. Both produce the same markup.', 'faq-and-answers'),
				'large',
				__('Most asked', 'faq-and-answers')
			),
			Parts::card(
				'🔎',
				__('Will my SEO plugin conflict?', 'faq-and-answers'),
				__('Only over FAQ schema, and only if both are printing it. Switch it off in one of the two and they stay out of each other\'s way.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'🌐',
				__('Is it translation ready?', 'faq-and-answers'),
				__('Every string goes through the translation functions, and the multilingual plugins treat each FAQ as translatable content.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'⚡',
				__('What about caching and optimisation?', 'faq-and-answers'),
				__('Nothing here needs to be excluded from a cache. Styles and scripts load per block and only on pages using one, so combining them is safe.', 'faq-and-answers'),
				'wide'
			),
			Parts::card(
				'🧩',
				__('Is there a hook for developers?', 'faq-and-answers'),
				__('Filters on the query, the output and the schema, and a REST route for the library. All documented rather than discovered.', 'faq-and-answers'),
				'wide'
			),
		];

		return [
			'title' => __('Integrations', 'faq-and-answers'),
			'groups' => ['features'],
			'keywords' => ['integrations', 'compatibility', 'page builder', 'seo', 'woocommerce', 'grid'],
			'thumbnail' => 'integrations.svg',
			'content' => Parts::section(
				Parts::heading(__('What it works with', 'faq-and-answers'))
				. Parts::paragraph(__('The compatibility questions, answered without a matrix nobody reads.', 'faq-and-answers'))
				. Parts::block(
					'faa/bento-faq',
					[
						'items' => $items,
						'openMode' => 'modal',
						'columns' => ['desktop' => 4, 'tablet' => 2, 'mobile' => 1],
						'showIcons' => true,
						'showExcerpt' => true,
						'accent' => '#4338ca',
						'cardBg' => '#ffffff',
						'cardBorder' => '#ddd9fa',
						'cardRadius' => '18px',
					]
				),
				'#f2f2fc'
			),
		];
	}

	/**
	 * Security and privacy, as a tree. These questions genuinely nest — "where
	 * is my data" has a different answer for the library, the submissions and
	 * the AI box, and answering it once flatly satisfies nobody.
	 *
	 * @return array
	 */
	private static function security_and_privacy()
	{
		$data = [
			Parts::faq_item(
				__('Where do the questions live?', 'faq-and-answers'),
				__('In your own WordPress database, as ordinary posts. Nothing about your library is stored anywhere else, and there is no account to create.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('What about form submissions?', 'faq-and-answers'),
				__('Also your database. They hold the name and email the visitor typed, which is why deleting one is permanent and says so before it happens.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('And the AI answers?', 'faq-and-answers'),
				__('The question and the matching FAQ text are sent to the model to compose a reply. No visitor identity goes with it, and nothing is used for training.', 'faq-and-answers'),
				1
			),
		];

		$access = [
			Parts::faq_item(
				__('Who can see submissions?', 'faq-and-answers'),
				__('Anyone who can edit pages on your site, and nobody else. It follows your existing roles rather than adding permissions of its own.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Can I export or delete on request?', 'faq-and-answers'),
				__('Both, from the Form Submissions screen, and a delete is a real delete rather than a flag. That is what makes a subject access request answerable in minutes.', 'faq-and-answers'),
				1
			),
		];

		$practice = [
			Parts::faq_item(
				__('How do you handle vulnerability reports?', 'faq-and-answers'),
				__('Acknowledged within one working day, fixed and released before it is described publicly, and the reporter credited if they want to be.', 'faq-and-answers'),
				1
			),
			Parts::faq_item(
				__('Is the code audited?', 'faq-and-answers'),
				__('Every release goes through automated checks, and every input is validated before it reaches a database or a stylesheet. Independent review has happened twice.', 'faq-and-answers'),
				1
			),
		];

		$tree = Parts::faq_item(
			__('Where your data lives', 'faq-and-answers'),
			__('Three different answers, depending on which data you mean.', 'faq-and-answers'),
			0,
			$data,
			true
		)
			. Parts::faq_item(
				__('Who can reach it', 'faq-and-answers'),
				__('Roles, exports, and deleting on request.', 'faq-and-answers'),
				0,
				$access
			)
			. Parts::faq_item(
				__('How we work', 'faq-and-answers'),
				__('Reports, releases and review.', 'faq-and-answers'),
				0,
				$practice
			)
			. Parts::faq_item(
				__('Reporting something', 'faq-and-answers'),
				__('Use the security address rather than the support form, so it reaches somebody who can act on it the same day.', 'faq-and-answers'),
				0
			);

		return [
			'title' => __('Security & Privacy', 'faq-and-answers'),
			'groups' => ['features'],
			'keywords' => ['security', 'privacy', 'gdpr', 'data', 'nested', 'compliance'],
			'thumbnail' => 'security-privacy.svg',
			'content' => Parts::section(
				Parts::heading(__('Security and privacy', 'faq-and-answers'))
				. Parts::paragraph(__('Where things are kept, who can reach them, and what happens when somebody finds a hole.', 'faq-and-answers'))
				. Parts::wrap(
					'faa/nested-faq',
					[
						'template' => 'default',
						'openFirst' => true,
						'allowMultiple' => false,
						'iconType' => 'plus',
						'iconPosition' => 'right',
						'questionColor' => '#ffffff',
						'questionBg' => ['type' => 'solid', 'color' => '#1e293b'],
						'questionOpenColor' => '#ffffff',
						'questionOpenBg' => ['type' => 'solid', 'color' => '#0f172a'],
						'nestedQuestionColor' => '#1e293b',
						'nestedQuestionBg' => ['type' => 'solid', 'color' => '#f1f5f9'],
						'answerColor' => '#475569',
						'answerBg' => ['type' => 'solid', 'color' => '#ffffff'],
						'itemBorder' => ['width' => '0px', 'style' => 'solid', 'color' => '#e2e8f0', 'side' => 'all', 'radius' => '12px'],
					],
					$tree
				),
				''
			),
		];
	}
}

<?php
/**
 * The pieces every built-in template is assembled from.
 *
 * Serialising blocks by hand is where templates break, so it happens in one
 * place: attributes go through wp_json_encode because they are JSON, and the
 * static blocks print the class names and inline styles the editor would have
 * saved. A group that omits them renders with no background until somebody
 * opens the page and saves it again.
 *
 * @package Awesome_FAQ
 */

namespace AFAQ\Templates;

if (!defined('ABSPATH')) {
	exit;
}

class Parts {

	/**
	 * One block with nothing inside it.
	 *
	 * @param string $name  Block name, e.g. faa/post-faq.
	 * @param array  $attrs Block attributes.
	 * @return string
	 */
	public static function block($name, array $attrs = []) {
		// The space after the closing brace is not cosmetic. WordPress's block
		// grammar matches attributes as `{...}\s+`, so `{...}/-->` parses as a
		// block with no attributes at all — or not at all — and the editor drops
		// it without saying anything.
		$json = $attrs ? ' ' . wp_json_encode($attrs) . ' ' : ' ';

		return '<!-- wp:' . $name . $json . '/-->';
	}

	/**
	 * One block with content inside it.
	 *
	 * Needed for the blocks that keep their questions as child blocks rather
	 * than in an attribute — Nested FAQ moved to real inner blocks, and a
	 * template that puts its questions in the old `faqs` attribute renders on
	 * the front end but opens empty in the editor.
	 *
	 * @param string $name
	 * @param array  $attrs
	 * @param string $inner Already-serialised inner blocks.
	 * @return string
	 */
	public static function wrap($name, array $attrs, $inner) {
		$json = $attrs ? ' ' . wp_json_encode($attrs) . ' ' : ' ';

		return '<!-- wp:' . $name . $json . '-->' . $inner . '<!-- /wp:' . $name . ' -->';
	}

	/**
	 * A tinted section around a template.
	 *
	 * This is what gives each template a look of its own without touching the
	 * FAQ block's own style object. That object is one deep nested array and
	 * the block destructures `Styles.heading` with no fallback, so a template
	 * supplying half of it takes the editor down with it. A core group around
	 * the outside is safe, is what an author would reach for anyway, and stays
	 * theirs to change afterwards.
	 *
	 * core/group is a static block: the markup below is its saved output, so
	 * the class and the inline style have to be printed here or the background
	 * does not appear until the page is opened and saved again.
	 *
	 * A gradient is recognised by its own value rather than by a flag. core
	 * saves a flat colour and a gradient under different keys and prints them
	 * as different CSS properties — `background-color` against `background` —
	 * and a gradient handed to the colour key comes out as no background at
	 * all, silently, which is a long way to go to find a missing argument.
	 *
	 * @param string $inner      Already-serialised inner blocks.
	 * @param string $background Hex colour, a linear/radial gradient, or '' for
	 *                           no background.
	 * @param string $radius     Corner radius, e.g. '18px'.
	 * @return string
	 */
	public static function section($inner, $background = '', $radius = '18px') {
		/*
		 * Fluid rather than fixed. 56px above and below is right on a desktop
		 * and a third of the screen on a phone — and block spacing has no
		 * breakpoints to set it per device, so the value itself has to bend.
		 * clamp() is a plain CSS value, so it survives in the attribute, in
		 * the inline style, and in the editor's own preview.
		 */
		$pad = [
			'top'    => 'clamp(28px, 5vw, 56px)',
			'right'  => 'clamp(16px, 3vw, 28px)',
			'bottom' => 'clamp(28px, 5vw, 56px)',
			'left'   => 'clamp(16px, 3vw, 28px)',
		];

		$style = ['spacing' => ['padding' => $pad]];
		$css   = '';

		if ('' !== $radius) {
			$style['border'] = ['radius' => $radius];
			$css            .= 'border-radius:' . $radius . ';';
		}

		if ('' !== $background) {
			if (preg_match('/^(linear|radial|conic)-gradient\(/i', trim($background))) {
				$style['color'] = ['gradient' => $background];
				$css           .= 'background:' . $background . ';';
			} else {
				$style['color'] = ['background' => $background];
				$css           .= 'background-color:' . $background . ';';
			}
		}

		$css .= 'padding-top:' . $pad['top'] . ';padding-right:' . $pad['right']
			. ';padding-bottom:' . $pad['bottom'] . ';padding-left:' . $pad['left'] . ';';

		$attrs = ['style' => $style, 'layout' => ['type' => 'constrained']];
		$class = 'wp-block-group' . ('' !== $background ? ' has-background' : '');

		return '<!-- wp:group ' . wp_json_encode($attrs) . ' -->'
			. '<div class="' . esc_attr($class) . '" style="' . esc_attr(rtrim($css, ';')) . '">'
			. $inner
			. '</div>'
			. '<!-- /wp:group -->';
	}

	/**
	 * Two or more columns side by side.
	 *
	 * core/columns and core/column are static blocks as well, so the same rule
	 * applies as for section(): the class names and the flex-basis have to be
	 * printed here. A column with the width only in its attributes comes out
	 * even until somebody re-saves the page.
	 *
	 * Widths are percentages that should add up to 100. The columns stack on
	 * their own below 782px, which is why a template can put a form beside an
	 * FAQ without doing anything about small screens.
	 *
	 * @param array  $columns  Each ['width' => '48%', 'inner' => '…'].
	 * @param string $vertical top|center|bottom
	 * @return string
	 */
	public static function columns(array $columns, $vertical = 'center') {
		$inner = '';

		foreach ($columns as $column) {
			$width = $column['width'];
			$colVert = isset($column['vertical']) ? $column['vertical'] : $vertical;

			$colAttrs = ['width' => $width];
			$colClass = 'wp-block-column';
			if ($colVert) {
				$colAttrs['verticalAlignment'] = $colVert;
				$colClass .= ' is-vertically-aligned-' . esc_attr($colVert);
			}

			$inner .= '<!-- wp:column ' . wp_json_encode($colAttrs) . ' -->'
				. '<div class="' . esc_attr($colClass) . '" style="flex-basis:' . esc_attr($width) . '">'
				. $column['inner']
				. '</div>'
				. '<!-- /wp:column -->';
		}

		$attrs = [];
		$columnsClass = 'wp-block-columns';
		if ($vertical) {
			$attrs['verticalAlignment'] = $vertical;
			$columnsClass .= ' are-vertically-aligned-' . esc_attr($vertical);
		}

		return '<!-- wp:columns ' . wp_json_encode($attrs) . ' -->'
			. '<div class="' . esc_attr($columnsClass) . '">'
			. $inner
			. '</div>'
			. '<!-- /wp:columns -->';
	}

	/**
	 * A left-aligned heading, for the text column beside an FAQ. The centred
	 * one above a section would look wrong at half the width.
	 *
	 * @param string $text
	 * @param int    $level
	 * @param string $colour
	 * @return string
	 */
	public static function subheading($text, $level = 3, $colour = '') {
		$attrs = ['level' => (int) $level];
		$class = 'wp-block-heading';
		$css   = '';

		if ('' !== $colour) {
			$attrs['style'] = ['color' => ['text' => $colour]];
			$class         .= ' has-text-color';
			$css            = ' style="color:' . esc_attr($colour) . '"';
		}

		return '<!-- wp:heading ' . wp_json_encode($attrs) . ' -->'
			. '<h' . (int) $level . ' class="' . esc_attr($class) . '"' . $css . '>'
			. esc_html($text)
			. '</h' . (int) $level . '>'
			. '<!-- /wp:heading -->';
	}

	/**
	 * A bulleted list.
	 *
	 * @param array $items
	 * @return string
	 */
	public static function bullets(array $items) {
		$inner = '';

		foreach ($items as $item) {
			$inner .= '<!-- wp:list-item --><li>' . esc_html($item) . '</li><!-- /wp:list-item -->';
		}

		return '<!-- wp:list --><ul class="wp-block-list">' . $inner . '</ul><!-- /wp:list -->';
	}

	/**
	 * One button. Left aligned, since these live in a text column.
	 *
	 * @param string $label
	 * @param string $url
	 * @param string $background
	 * @param string $colour
	 * @return string
	 */
	public static function button($label, $url = '#', $background = '#2563eb', $colour = '#ffffff', $radius = '8px', $align = 'left') {
		$attrs = [
			'style' => [
				'color'  => ['background' => $background, 'text' => $colour],
				'border' => ['radius' => $radius],
			],
		];

		$css = 'border-radius:' . esc_attr($radius) . ';background-color:' . $background . ';color:' . $colour;

		$buttonsAttrs = [];
		$buttonsClass = 'wp-block-buttons';

		if ('right' === $align) {
			$buttonsAttrs['layout'] = ['type' => 'flex', 'justifyContent' => 'right'];
			$buttonsClass .= ' is-content-justification-right';
		} elseif ('center' === $align) {
			$buttonsAttrs['layout'] = ['type' => 'flex', 'justifyContent' => 'center'];
			$buttonsClass .= ' is-content-justification-center';
		}

		$button = '<!-- wp:button ' . wp_json_encode($attrs) . ' -->'
			. '<div class="wp-block-button">'
			. '<a class="wp-block-button__link has-text-color has-background wp-element-button" href="' . esc_url($url) . '" style="' . esc_attr($css) . '">'
			. esc_html($label)
			. '</a>'
			. '</div>'
			. '<!-- /wp:button -->';

		$json = $buttonsAttrs ? ' ' . wp_json_encode($buttonsAttrs) : '';

		return '<!-- wp:buttons' . $json . ' --><div class="' . esc_attr($buttonsClass) . '">' . $button . '</div><!-- /wp:buttons -->';
	}

	/**
	 * Normalise font size names to standard Gutenberg slugs.
	 *
	 * @param string $size e.g. 'XL', 'M', 'x-large', 'medium'
	 * @return string
	 */
	public static function font_size_slug($size) {
		$map = [
			's'   => 'small',
			'm'   => 'medium',
			'l'   => 'large',
			'xl'  => 'x-large',
			'xxl' => 'xx-large',
		];
		$key = strtolower(trim((string) $size));

		return $map[$key] ?? $key;
	}

	/**
	 * @param string $text
	 * @param int    $level
	 * @param string $colour Hex colour, or '' to inherit the theme.
	 * @param string $fontSize Gutenberg font size slug (e.g. 'x-large', 'medium') or preset ('XL', 'M')
	 * @param string $align Text alignment: 'left', 'center', 'right'
	 * @return string
	 */
	public static function heading($text, $level = 2, $colour = '', $fontSize = '', $align = 'center') {
		$attrs = ['textAlign' => $align, 'level' => (int) $level];
		$class = 'wp-block-heading has-text-align-' . $align;
		$css   = '';

		if ('' !== $colour) {
			$attrs['style'] = ['color' => ['text' => $colour]];
			$class         .= ' has-text-color';
			$css            = ' style="color:' . esc_attr($colour) . '"';
		}

		if ('' !== $fontSize) {
			$slug = self::font_size_slug($fontSize);
			$attrs['fontSize'] = $slug;
			$class            .= ' has-' . $slug . '-font-size';
		}

		return '<!-- wp:heading ' . wp_json_encode($attrs) . ' -->'
			. '<h' . (int) $level . ' class="' . esc_attr($class) . '"' . $css . '>'
			. esc_html($text)
			. '</h' . (int) $level . '>'
			. '<!-- /wp:heading -->';
	}

	/**
	 * @param string $text
	 * @param string $align
	 * @param string $colour
	 * @param string $fontSize Gutenberg font size slug (e.g. 'medium') or preset ('M')
	 * @return string
	 */
	public static function paragraph($text, $align = 'center', $colour = '', $fontSize = '') {
		$attrs = [];
		$class = 'wp-block-paragraph';
		$css   = '';

		if ($align) {
			$attrs['align'] = $align;
			$class         .= ' has-text-align-' . $align;
		}

		if ('' !== $colour) {
			$attrs['style'] = ['color' => ['text' => $colour]];
			$class         .= ' has-text-color';
			$css            = ' style="color:' . esc_attr($colour) . '"';
		}

		if ('' !== $fontSize) {
			$slug = self::font_size_slug($fontSize);
			$attrs['fontSize'] = $slug;
			$class            .= ' has-' . $slug . '-font-size';
		}

		$json = $attrs ? ' ' . wp_json_encode($attrs) : '';

		return '<!-- wp:paragraph' . $json . ' -->'
			. '<p class="' . esc_attr($class) . '"' . $css . '>' . esc_html($text) . '</p>'
			. '<!-- /wp:paragraph -->';
	}

	/**
	 * A paragraph with no alignment, for text inside another block.
	 *
	 * @param string $text
	 * @return string
	 */
	public static function text($text) {
		return '<!-- wp:paragraph --><p>' . esc_html($text) . '</p><!-- /wp:paragraph -->';
	}

	/**
	 * One row of the Awesome FAQ block's faqData.
	 *
	 * @param string $category
	 * @param string $question
	 * @param string $answer
	 * @param string $image    Picture URL, for the themes that show one beside
	 *                         the answer. Ignored by every other theme, so it
	 *                         costs nothing to leave empty.
	 * @return array
	 */
	public static function faq($category, $question, $answer, $image = '') {
		return [
			'categories' => $category,
			'question'   => $question,
			'answer'     => $answer,
			'image'      => $image,
		];
	}

	/**
	 * One question of a Nested FAQ, as the FAQ Item child block it really is.
	 *
	 * @param string $question
	 * @param string $answer
	 * @param int    $depth    0 for a top-level question.
	 * @param array  $children Already-serialised child FAQ Items.
	 * @param bool   $open
	 * @return string
	 */
	public static function faq_item($question, $answer, $depth = 0, array $children = [], $open = false) {
		$attrs = ['question' => $question, 'depth' => (int) $depth];

		if ($open) {
			$attrs['openByDefault'] = true;
		}

		return self::wrap('faa/faq-item', $attrs, self::text($answer) . implode('', $children));
	}

	/**
	 * One panel of an Image FAQ block.
	 *
	 * @param string $file        Filename in assets/images/image-faq/.
	 * @param string $alt
	 * @param string $title
	 * @param string $description
	 * @param string $button
	 * @return array
	 */
	public static function panel($file, $alt, $title, $description, $button = '') {
		return [
			'image'       => ['id' => 0, 'url' => self::asset($file), 'alt' => $alt],
			'title'       => $title,
			'description' => $description,
			'buttonText'  => '' !== $button ? $button : __('Read More', 'faq-and-answers'),
			'buttonUrl'   => '#',
			'newTab'      => false,
		];
	}

	/**
	 * One card of a Bento FAQ block.
	 *
	 * @param string $emoji
	 * @param string $question
	 * @param string $answer
	 * @param string $size  normal|wide|large
	 * @param string $badge
	 * @return array
	 */
	public static function card($emoji, $question, $answer, $size = 'normal', $badge = '') {
		return [
			'icon'     => '',
			'emoji'    => $emoji,
			'question' => $question,
			'answer'   => '<p>' . esc_html($answer) . '</p>',
			'size'     => $size,
			'badge'    => $badge,
		];
	}

	/* ------------------------------------------- the FAQ block's own style */

	/**
	 * The Awesome FAQ block's default Styles object, read from block.json.
	 *
	 * Read rather than written down. The object is five levels deep and every
	 * theme reaches into a different corner of it, so a copy kept here would be
	 * wrong the first time a key is added to the block and nobody remembers to
	 * add it in two places.
	 *
	 * @return array Empty when block.json cannot be read, which makes styles()
	 *               fall back to passing the overrides through untouched.
	 */
	public static function block_styles() {
		static $styles = null;

		if (null !== $styles) {
			return $styles;
		}

		$styles = [];
		$path   = AFAQ_DIR_PATH . 'build/block.json';

		if (is_readable($path)) {
			// phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents -- a file inside the plugin, not a remote resource.
			$json = json_decode((string) file_get_contents($path), true);

			if (isset($json['attributes']['Styles']['default']) && is_array($json['attributes']['Styles']['default'])) {
				$styles = $json['attributes']['Styles']['default'];
			}
		}

		return $styles;
	}

	/**
	 * A complete Styles object with $overrides laid over the block's defaults.
	 *
	 * Templates used to hand the block a hand-built fragment of this object,
	 * and a fragment is what breaks it: Style.js walks the tree with plain
	 * destructuring, so a `content` that arrives without `icon` in it reaches
	 * `icon.size.desktop` on undefined and takes the editor down with the block
	 * still selected. Merging over the real defaults means a template can say
	 * "this question is white on blue" and nothing else, and every key the
	 * block expects is still there underneath.
	 *
	 * @param array $overrides Any subset of the Styles tree.
	 * @return array
	 */
	public static function styles(array $overrides = []) {
		return self::merge(self::block_styles(), $overrides);
	}

	/**
	 * Recursive array merge where a list replaces rather than appends.
	 *
	 * array_merge_recursive() is not this: given two colours for one key it
	 * keeps both, as an array, and a colour that is secretly a list of two
	 * colours prints as nothing at all.
	 *
	 * @param array $base
	 * @param array $over
	 * @return array
	 */
	private static function merge(array $base, array $over) {
		foreach ($over as $key => $value) {
			if (is_array($value) && isset($base[$key]) && is_array($base[$key]) && !self::is_list($value)) {
				$base[$key] = self::merge($base[$key], $value);

				continue;
			}

			$base[$key] = $value;
		}

		return $base;
	}

	/**
	 * Whether an array is a plain list. array_is_list() is PHP 8.1.
	 *
	 * @param array $value
	 * @return bool
	 */
	private static function is_list(array $value) {
		return [] === $value || array_keys($value) === range(0, count($value) - 1);
	}

	/**
	 * A named pair of accordion icons, for the faqIcon attribute.
	 *
	 * The block keeps these as raw SVG markup rather than a name, so a template
	 * that wants anything other than plus-and-minus has to carry the whole
	 * markup. Naming them here keeps that out of the template files, and keeps
	 * the six of them drawn to the same weight and viewBox — which matters,
	 * because the block sizes them with width and height and a mismatched
	 * viewBox comes out visibly smaller than the one beside it.
	 *
	 * `fill: currentColor` is not enough on its own: Style.js writes `fill`
	 * onto the svg from the icon colour, and a path with its own fill would win
	 * over it. So the paths inherit, and the colour set in the block applies.
	 *
	 * Every attribute below is single quoted, and has to stay that way. This is
	 * not a style choice — it is the one thing standing between these icons and
	 * a template that imports as an empty block.
	 *
	 * The Template Library hands the imported markup through
	 * `.replaceAll('\"', '"')` before parsing it (bpl-tools, Templates.js). That
	 * exists to undo the extra layer of escaping the remote template server puts
	 * on its content, and it is right for remote templates. The built-ins are
	 * not double encoded, so on them it is pure damage: a double quote inside an
	 * SVG becomes `\"` when the attributes are JSON encoded, the replace strips
	 * the backslash, and the attribute payload stops being valid JSON. The
	 * editor's parser then reports no attributes at all and the block falls back
	 * to every default in block.json — no questions, no theme, no colours.
	 *
	 * A single quote never becomes `\"`, so it passes through untouched. It is
	 * also how block.json writes the block's own default faqIcon, which is why
	 * that one has always survived.
	 *
	 * @param string $name minus-plus|cross-check|chevron|arrow
	 * @return array ['open' => svg, 'close' => svg]
	 */
	public static function icons($name = 'minus-plus') {
		$svg = static function ($path, $stroke = false) {
			return "<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' height='1em' width='1em' "
				. ($stroke
					? "fill='none' stroke='currentColor' stroke-width='2.2' stroke-linecap='round' stroke-linejoin='round'"
					: "fill='currentColor'")
				. '>' . $path . '</svg>';
		};

		$sets = [
			'minus-plus' => [
				'open'  => $svg("<path d='M5 11h14v2H5z'/>"),
				'close' => $svg("<path d='M11 5h2v6h6v2h-6v6h-2v-6H5v-2h6z'/>"),
			],
			'cross-check' => [
				'open'  => $svg("<path d='M6.2 4.8 12 10.6l5.8-5.8 1.4 1.4-5.8 5.8 5.8 5.8-1.4 1.4-5.8-5.8-5.8 5.8-1.4-1.4 5.8-5.8-5.8-5.8z'/>"),
				'close' => $svg("<path d='M9.6 16.2 5.4 12l-1.4 1.4 5.6 5.6L20.4 8.2 19 6.8z'/>"),
			],
			'chevron' => [
				'open'  => $svg("<polyline points='18 15 12 9 6 15'/>", true),
				'close' => $svg("<polyline points='6 9 12 15 18 9'/>", true),
			],
			'arrow' => [
				'open'  => $svg("<line x1='5' y1='12' x2='19' y2='12'/><polyline points='13 6 19 12 13 18'/>", true),
				'close' => $svg("<line x1='12' y1='5' x2='12' y2='19'/><polyline points='6 13 12 19 18 13'/>", true),
			],
		];

		return isset($sets[$name]) ? $sets[$name] : $sets['minus-plus'];
	}

	/**
	 * A picture that ships with the plugin.
	 *
	 * @param string $file
	 * @return string
	 */
	public static function asset($file) {
		return AFAQ_DIR_URL . 'assets/images/image-faq/' . $file;
	}

	/**
	 * The thumbnail shown on a template's card in the library.
	 *
	 * @param string $file
	 * @return string
	 */
	public static function thumb($file) {
		return AFAQ_DIR_URL . 'assets/images/templates/' . $file;
	}
}

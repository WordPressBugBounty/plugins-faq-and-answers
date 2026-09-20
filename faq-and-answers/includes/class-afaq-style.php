<?php
/**
 * bpl-tools style objects, turned into CSS on the server.
 *
 * The shared controls (Typography, Background, BorderControl, BoxControl) save
 * structured objects, and until now the only thing that could read them was
 * their JavaScript twin in bpl-tools/utils/getCSS.js — so a server rendered
 * block had to mount React just to paint itself, which means a flash of
 * unstyled content and nothing at all when a script blocker is on.
 *
 * This mirrors those functions in PHP. Everything is validated on the way
 * through: these values are printed straight into a <style> block, so a colour
 * that is not a colour is dropped rather than escaped.
 *
 * @package Awesome_FAQ
 */

if (!defined('ABSPATH')) {
	exit;
}

if (!class_exists('AFAQ_Style')) {
	class AFAQ_Style
	{
		/** Where the responsive font sizes switch, matching bpl-tools. */
		public const TABLET_BREAKPOINT = 991;
		public const MOBILE_BREAKPOINT = 767;

		/**
		 * A CSS length: a number with a unit this plugin recognises.
		 *
		 * @param mixed  $value
		 * @param string $fallback
		 * @return string
		 */
		public static function length($value, $fallback = '')
		{
			if (is_numeric($value)) {
				return (float) $value . 'px';
			}

			$value = trim((string) $value);

			if ('' === $value) {
				return $fallback;
			}

			return preg_match('/^-?\d*\.?\d+(px|em|rem|%|vh|vw|pt)$/i', $value) ? strtolower($value) : $fallback;
		}

		/**
		 * A unitless number, for line-height and font-weight.
		 *
		 * @param mixed  $value
		 * @param string $fallback
		 * @return string
		 */
		public static function number($value, $fallback = '')
		{
			if (is_numeric($value)) {
				return (string) $value;
			}

			$value = trim((string) $value);

			return preg_match('/^\d*\.?\d+$/', $value) ? $value : $fallback;
		}

		/**
		 * A colour, or nothing.
		 *
		 * @param mixed  $value
		 * @param string $fallback
		 * @return string
		 */
		public static function color($value, $fallback = '')
		{
			$value = trim((string) $value);

			if ('' === $value) {
				return $fallback;
			}

			if (preg_match('/^#([0-9a-f]{3,4}|[0-9a-f]{6}|[0-9a-f]{8})$/i', $value)) {
				return strtolower($value);
			}

			if (preg_match('/^rgba?\(\s*\d{1,3}\s*,\s*\d{1,3}\s*,\s*\d{1,3}\s*(,\s*(0|1|0?\.\d+)\s*)?\)$/i', $value)) {
				return strtolower($value);
			}

			if (in_array(strtolower($value), ['transparent', 'currentcolor', 'inherit'], true)) {
				return strtolower($value);
			}

			return $fallback;
		}

		/**
		 * One of a fixed list, or the fallback. Used for every enum-ish value
		 * so nothing arbitrary reaches the stylesheet.
		 *
		 * @param mixed  $value
		 * @param array  $allowed
		 * @param string $fallback
		 * @return string
		 */
		public static function keyword($value, array $allowed, $fallback = '')
		{
			$value = strtolower(trim((string) $value));

			return in_array($value, $allowed, true) ? $value : $fallback;
		}

		/**
		 * BoxControl — {top,right,bottom,left} into one shorthand.
		 *
		 * @param mixed  $value
		 * @param string $fallback
		 * @return string
		 */
		public static function box($value, $fallback = '')
		{
			if (is_string($value)) {
				return self::length($value, $fallback);
			}

			if (!is_array($value)) {
				return $fallback;
			}

			$sides = [];

			foreach (['top', 'right', 'bottom', 'left'] as $side) {
				$sides[] = self::length($value[$side] ?? '', '0px');
			}

			return implode(' ', $sides);
		}

		/**
		 * A corner radius: one to four lengths, the way `border-radius` takes
		 * them.
		 *
		 * BorderControl writes all four corners the moment the control is
		 * touched ("8px 8px 8px 8px"), so putting the value through `length()`
		 * — which only accepts a single length — threw the radius away on the
		 * front end while the editor carried on showing it.
		 *
		 * @param mixed  $value
		 * @param string $fallback
		 * @return string
		 */
		public static function radius($value, $fallback = '')
		{
			if (is_numeric($value)) {
				return (float) $value . 'px';
			}

			$parts = preg_split('/\s+/', trim((string) $value), -1, PREG_SPLIT_NO_EMPTY);

			if (empty($parts) || count($parts) > 4) {
				return $fallback;
			}

			$corners = [];

			foreach ($parts as $part) {
				$length = self::length($part, '');

				// One unreadable corner makes the whole declaration
				// untrustworthy — the fallback beats a lopsided radius.
				if ('' === $length) {
					return $fallback;
				}

				$corners[] = $length;
			}

			return implode(' ', $corners);
		}

		/**
		 * BorderControl — {width, style, color, side, radius}.
		 *
		 * @param mixed $value
		 * @return string CSS declarations.
		 */
		public static function border($value)
		{
			if (!is_array($value)) {
				return '';
			}

			$width  = self::length($value['width'] ?? '', '');
			$style  = self::keyword($value['style'] ?? 'solid', ['none', 'solid', 'dashed', 'dotted', 'double', 'groove', 'ridge', 'inset', 'outset'], 'solid');
			$color  = self::color($value['color'] ?? '', '');
			$radius = self::radius($value['radius'] ?? '', '');
			$side   = strtolower((string) ($value['side'] ?? 'all'));

			$css = '';

			// A zero or missing width means no border at all, whatever else is
			// set — matching how the control behaves in the editor.
			if ('' !== $width && 0 !== (int) $width) {
				foreach (['top', 'right', 'bottom', 'left'] as $edge) {
					if (false !== strpos($side, 'all') || false !== strpos($side, $edge)) {
						$css .= "border-{$edge}:{$width} {$style} {$color};";
					}
				}
			}

			if ('' !== $radius) {
				$css .= "border-radius:{$radius};";
			}

			return $css;
		}

		/**
		 * Background — solid, gradient or image.
		 *
		 * @param mixed $value
		 * @return string CSS declarations.
		 */
		public static function background($value)
		{
			if (!is_array($value)) {
				return '';
			}

			$type = self::keyword($value['type'] ?? 'solid', ['solid', 'gradient', 'image'], 'solid');

			if ('gradient' === $type) {
				$gradient = trim((string) ($value['gradient'] ?? ''));

				// Only a gradient function, nothing that could carry a url() or
				// close the declaration.
				return preg_match('/^(linear|radial|conic)-gradient\([^;{}]*\)$/i', $gradient)
					? 'background:' . $gradient . ';'
					: '';
			}

			if ('image' === $type) {
				$url = isset($value['image']['url']) ? esc_url_raw((string) $value['image']['url']) : '';

				if ('' === $url) {
					return '';
				}

				$css = 'background-image:url(' . $url . ');';

				$overlay = self::color($value['overlayColor'] ?? '', '');

				if ('' !== $overlay) {
					$css .= 'background-color:' . $overlay . ';background-blend-mode:overlay;';
				}

				$position = self::keyword(
					$value['position'] ?? 'center center',
					['left top', 'left center', 'left bottom', 'center top', 'center center', 'center bottom', 'right top', 'right center', 'right bottom'],
					'center center'
				);

				$css .= 'background-position:' . $position . ';';
				$css .= 'background-repeat:' . self::keyword($value['repeat'] ?? 'no-repeat', ['no-repeat', 'repeat', 'repeat-x', 'repeat-y'], 'no-repeat') . ';';

				$size = self::keyword($value['size'] ?? '', ['auto', 'cover', 'contain'], '');

				if ('' !== $size) {
					$css .= 'background-size:' . $size . ';';
				}

				$attachment = self::keyword($value['attachment'] ?? '', ['scroll', 'fixed', 'local'], '');

				if ('' !== $attachment) {
					$css .= 'background-attachment:' . $attachment . ';';
				}

				return $css;
			}

			$color = self::color($value['color'] ?? '', '');

			return '' !== $color ? 'background:' . $color . ';' : '';
		}

		/**
		 * Typography, as three blocks of CSS — the font size is the only part
		 * that changes with the screen, so the media queries carry just that.
		 *
		 * @param string $selector Already safe.
		 * @param mixed  $value
		 * @return string Full rules, including any media queries.
		 */
		public static function typography($selector, $value)
		{
			if (!is_array($value)) {
				return '';
			}

			$family = trim((string) ($value['fontFamily'] ?? ''));
			$is_default = '' === $family || 'Default' === $family;

			$declarations = '';

			if (!$is_default) {
				// Quoted and stripped of anything that could end the
				// declaration — a font name is text, not CSS.
				$family = preg_replace('/[^A-Za-z0-9 _-]/', '', $family);
				$category = self::keyword($value['fontCategory'] ?? 'sans-serif', ['serif', 'sans-serif', 'monospace', 'cursive', 'fantasy', 'display', 'handwriting'], 'sans-serif');

				if ('' !== $family) {
					$declarations .= "font-family:'{$family}',{$category};";
				}
			}

			$weight = self::keyword((string) ($value['fontWeight'] ?? ''), ['100', '200', '300', '400', '500', '600', '700', '800', '900', 'normal', 'bold', 'lighter', 'bolder'], '');

			if ('' !== $weight) {
				$declarations .= "font-weight:{$weight};";
			}

			$style = self::keyword($value['fontStyle'] ?? '', ['normal', 'italic', 'oblique'], '');

			if ('' !== $style) {
				$declarations .= "font-style:{$style};";
			}

			$transform = self::keyword($value['textTransform'] ?? '', ['none', 'capitalize', 'uppercase', 'lowercase'], '');

			if ('' !== $transform) {
				$declarations .= "text-transform:{$transform};";
			}

			$decoration = self::keyword($value['textDecoration'] ?? '', ['none', 'underline', 'overline', 'line-through'], '');

			if ('' !== $decoration) {
				$declarations .= "text-decoration:{$decoration};";
			}

			$line_height = self::number($value['lineHeight'] ?? '', self::length($value['lineHeight'] ?? '', ''));

			if ('' !== $line_height) {
				$declarations .= "line-height:{$line_height};";
			}

			$spacing = self::length($value['letterSpace'] ?? '', '');

			if ('' !== $spacing) {
				$declarations .= "letter-spacing:{$spacing};";
			}

			$sizes   = is_array($value['fontSize'] ?? null) ? $value['fontSize'] : ['desktop' => $value['fontSize'] ?? ''];
			$desktop = self::length($sizes['desktop'] ?? '', '');
			$tablet  = self::length($sizes['tablet'] ?? '', '');
			$mobile  = self::length($sizes['mobile'] ?? '', '');

			$css = '';

			if ('' !== $desktop) {
				$declarations .= "font-size:{$desktop};";
			}

			if ('' !== $declarations) {
				$css .= "{$selector}{{$declarations}}";
			}

			if ('' !== $tablet) {
				$css .= '@media(max-width:' . self::TABLET_BREAKPOINT . "px){{$selector}{font-size:{$tablet};}}";
			}

			if ('' !== $mobile) {
				$css .= '@media(max-width:' . self::MOBILE_BREAKPOINT . "px){{$selector}{font-size:{$mobile};}}";
			}

			return $css;
		}

		/**
		 * Wrap declarations in a rule, skipping the rule entirely when nothing
		 * survived validation — an empty `{}` in the output is noise.
		 *
		 * @param string $selector
		 * @param string $declarations
		 * @return string
		 */
		public static function rule($selector, $declarations)
		{
			$declarations = trim((string) $declarations);

			return '' === $declarations ? '' : $selector . '{' . $declarations . '}';
		}
	}
}

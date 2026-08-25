<?php
if (!defined('ABSPATH')) {
    exit;
}
function faa_is_premium()
{
    return AFAQ_HAS_PRO ? faa_fs()->can_use_premium_code() : false;
}

if (!function_exists('afaq_menu_badge')) {
    /**
     * A small badge to append to an admin menu label, e.g. "Ask AI  NEW".
     *
     * Styled inline because a stylesheet for one span would otherwise have to
     * load on every admin page. It lives in this file — which ships in both the
     * free and the premium build — so the badge on the free Ask AI screen and
     * the one on the premium screen cannot drift apart.
     *
     * @param string $text Short, already translated label.
     * @return string Markup, or an empty string when no text was given.
     */
    function afaq_menu_badge($text)
    {
        if ('' === trim((string) $text)) {
            return '';
        }

        return sprintf(
            '<span class="afaq-menu-badge" aria-hidden="true" style="%1$s">%2$s</span>',
            'display:inline-block;margin-left:6px;padding:0 6px;border-radius:0;'
                . 'background:#0f5fdb;color:#fff;'
                . 'font-size:9px;font-weight:700;line-height:16px;letter-spacing:.05em;'
                . 'text-transform:uppercase;vertical-align:middle;',
            esc_html($text)
        );
    }
}

/**
 * Nested FAQ helpers.
 *
 * These live here (instead of inside a block render.php) because the FAQ Item
 * block renders before its parent container, so both files need them available.
 */

if (!function_exists('afaq_nf_max_depth')) {
    /**
     * How many nested levels the current plan allows.
     * Depth 0 is a top level question.
     *
     * @return int
     */
    function afaq_nf_max_depth()
    {
        return (function_exists('faa_is_premium') && faa_is_premium()) ? 3 : 1;
    }
}

if (!function_exists('afaq_nf_icon')) {
    /**
     * Inline SVG used as the accordion toggle.
     *
     * @param string $type chevron|plus|arrow|none.
     * @return string
     */
    function afaq_nf_icon($type)
    {
        switch ($type) {
            case 'none':
                return '';

            case 'plus':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" aria-hidden="true"><line class="afaq-nf-plus-v" x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>';

            case 'arrow':
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="13 6 19 12 13 18"></polyline></svg>';

            default:
                return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>';
        }
    }
}

if (!function_exists('afaq_nf_collect_schema')) {
    /**
     * FAQ Item blocks push their question/answer pair here while rendering.
     * The parent container pops the list and prints the FAQPage JSON-LD.
     *
     * @param string $question Plain text question.
     * @param string $answer   Plain text answer.
     * @return void
     */
    function afaq_nf_collect_schema($question, $answer)
    {
        if (!isset($GLOBALS['afaq_nf_schema']) || !is_array($GLOBALS['afaq_nf_schema'])) {
            $GLOBALS['afaq_nf_schema'] = [];
        }

        if ('' === $question || '' === $answer) {
            return;
        }

        $GLOBALS['afaq_nf_schema'][] = [
            '@type'          => 'Question',
            'name'           => $question,
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text'  => $answer,
            ],
        ];
    }
}

if (!function_exists('afaq_nf_flush_schema')) {
    /**
     * Returns and clears the collected schema entries.
     *
     * @return array
     */
    function afaq_nf_flush_schema()
    {
        $items = (isset($GLOBALS['afaq_nf_schema']) && is_array($GLOBALS['afaq_nf_schema']))
            ? $GLOBALS['afaq_nf_schema']
            : [];

        $GLOBALS['afaq_nf_schema'] = [];

        return $items;
    }
}

if (!function_exists('afaq_nf_legacy_items')) {
    /**
     * Renders the pre-InnerBlocks `faqs` array so content saved by the first
     * version of the block keeps working until it is re-saved in the editor.
     *
     * @param array  $faqs      FAQ rows.
     * @param array  $settings  icon_type, base_id, open_first, max_depth.
     * @param int    $depth     Current depth.
     * @param string $id_prefix Prefix for the aria ids.
     * @return string
     */
    function afaq_nf_legacy_items($faqs, $settings, $depth = 0, $id_prefix = '')
    {
        if (empty($faqs) || !is_array($faqs)) {
            return '';
        }

        $html = '';
        $icon = afaq_nf_icon($settings['icon_type']);

        foreach (array_values($faqs) as $index => $faq) {
            if (!is_array($faq)) {
                continue;
            }

            $question = isset($faq['question']) ? $faq['question'] : '';
            $answer   = isset($faq['answer']) ? $faq['answer'] : '';
            $children = (isset($faq['children']) && is_array($faq['children']) && $depth < $settings['max_depth'])
                ? $faq['children']
                : [];

            if ('' === trim(wp_strip_all_tags($question))) {
                continue;
            }

            $row_id     = $id_prefix . $index;
            $panel_id   = $settings['base_id'] . '-panel-' . $row_id;
            $button_id  = $settings['base_id'] . '-q-' . $row_id;
            $is_open    = ($settings['open_first'] && 0 === $depth && 0 === $index);

            afaq_nf_collect_schema(trim(wp_strip_all_tags($question)), trim(wp_strip_all_tags($answer)));

            $html .= '<div class="afaq-nf-item' . ($is_open ? ' is-open' : '') . '" data-depth="' . esc_attr($depth) . '">';
            $html .= '<button type="button" class="afaq-nf-question" id="' . esc_attr($button_id) . '"'
                . ' aria-expanded="' . ($is_open ? 'true' : 'false') . '"'
                . ' aria-controls="' . esc_attr($panel_id) . '">';
            $html .= '<span class="afaq-nf-question-text">' . wp_kses_post($question) . '</span>';

            if ($icon) {
                $html .= '<span class="afaq-nf-icon">' . $icon . '</span>';
            }

            $html .= '</button>';
            $html .= '<div class="afaq-nf-answer" id="' . esc_attr($panel_id) . '" role="region"'
                . ' aria-labelledby="' . esc_attr($button_id) . '">';
            $html .= '<div><div class="afaq-nf-answer-inner">';
            $html .= wp_kses_post($answer);
            $html .= afaq_nf_legacy_items($children, $settings, $depth + 1, $row_id . '-');
            $html .= '</div></div></div>';
            $html .= '</div>';
        }

        return $html;
    }
}

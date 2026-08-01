<?php
if (!defined('ABSPATH')) {
	exit;
}
$id = wp_unique_id('bBlocksTestPurpose-');
?>
<div <?php echo get_block_wrapper_attributes(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> id='<?php echo esc_attr($id); ?>'
	data-attributes='<?php echo esc_attr(wp_json_encode($attributes)); ?>'
	data-faq-title='<?php echo esc_attr(!empty($attributes['faqTitle']) ? $attributes['faqTitle'] : get_the_title()); ?>'
	data-faq-id='<?php echo esc_attr(!empty($attributes['faqId']) ? $attributes['faqId'] : 0); ?>'>
</div>
<?php
/**
 * Shortcode that renders a single list item displayed as a fullwidth bordered box.
 *
 * List item contains headline, description, button and a coloured (possibly partial) circle.
 */

/**
 * The shortcode itself.
 *
 * Just parses the attributes and calls the template.
 */
function list_item_shortcode($atts) {
	$atts = shortcode_atts(
		[
			'name' => 'Title',
			'description' => 'Description',
			'button_text' => __('Detail', 'roots'),
			'color' => '',
			'brand_color' => '',
			'tags' => [],
			'url' => '/',
			'progress' => 100,
			'top_border' => true,
			'disabled' => false,
			'anec' => '',
			'anea' => '',
		],
		$atts,
		'list-item');

	if(is_string($atts['tags']))
		$atts['tags'] = explode(',', $atts['tags']);

	ob_start();

	set_query_var( 'data', $atts );

	get_template_part('templates/shortcode-list-item');

	return ob_get_clean();
}
add_shortcode('list-item', 'list_item_shortcode');

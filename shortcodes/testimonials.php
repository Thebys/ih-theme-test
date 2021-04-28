<?php

/** Shortcode to display slider of testimonials filtered by their category.
 * Returns a testimonials slider. The testimonials are filtered based on a category. The category should
 * be supplied by a shortcode attribute 'category'. Shortcode also supports attributes: 'count', 'photo' (if defined
 * the slider will show testimonial photos) and 'anec' (used for GA tracking).
 *
 * @param array $atts Shortcode attributes defined by the user
 *
 * @return string HTML code of the slider or empty string if no testimonials were found
 */
function testimonials_slider($atts) {
	$atts = shortcode_atts(
		[
			'category' => null,
			'count' => 4,
			'photo' => false,
			'arrow_background' => 'bg-light-gray',
			'arrow_color' => 'c-gray',
			'anec' => 'undefined'
		],
		$atts,
		'testimonials-slider');

	$args = array(
		'posts_per_page'        => $atts['count'],
		'post_status'           => 'publish',
		'post_type'             => 'testimonial',
		'orderby'               => 'meta_value',
		'order'                 => 'ASC',
		'tax_query'             => array()
	);

	if($atts['category'] != null)
		$args['tax_query'][0] = [
			'taxonomy' => 'testimonial_categories',
			'field'    => 'slug',
			'terms'    => explode(",", $atts['category']),
		];

	$testimonials = get_posts($args);

	if(count($testimonials) < 1)
		return '';

	ob_start();

	set_query_var( 'testimonials', get_posts($args) );
	set_query_var( 'atts', $atts );
	get_template_part('templates/shortcode-testimonials-slider');

	return ob_get_clean();
}
add_shortcode( 'testimonials-slider', 'testimonials_slider' );

/** Shortcode to display single testimonial.
 * Returns HTML element containing a testimonial which is defined by the 'id' shortcode attribute. Also supports
 * attributes 'photo' (if defined element will contain testimonial' photo), 'button_class' (custom CSS classes for C2A
 * button), 'wrapper_class' (custom CSS classes for wrapper, e.g. background color) and 'anec' (used for GA tracking).
 * @param array $atts Shortcode attributes defined by the user
 *
 * @return string HTML code of the testimonial element or empty string if no testimonials were found
 */
function testimonial($atts) {
	$atts = shortcode_atts(
		[
			'id' => null,
			'photo' => false,
			'anec' => 'undefined',
			'button_class' => '',
			'wrapper_class' => ''
		],
		$atts,
		'testimonial');

	if($atts['id'] == null)
		return '';

	$testimonial = get_post($atts['id']);

	if($testimonial == null)
		return '';

	ob_start();

	set_query_var( 'testimonial', $testimonial );
	set_query_var( 'atts', $atts );
	get_template_part('templates/shortcode-testimonial');

	return ob_get_clean();
}
add_shortcode( 'testimonial', 'testimonial' );
add_shortcode( 'photo-slider', 'photo_slider' );
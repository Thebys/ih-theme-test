<?php

/** Shortcode to display slider with photos.
 * Shortcode renders a photo slider based on a photo slider CPT defined by the user. The slider to be rendered
 * is specified by the 'id' shortcode attribute. 'anec' attribute is also supported to track user click actions via GA.
 * @param array $atts Array of user defined shortcode attributes.
 *
 * @return string Returns HTML code of the slider.
 */
function photo_slider($atts) {
	$atts = shortcode_atts(
		[
			'id' => null,
			'anec' => 'undefined',
			'arrow_class' => ''
		],
		$atts,
		'photo-slider');

	if($atts['id'] == null)
		return;

	$slider = get_post($atts['id']);

	if($slider == null || get_field('photos', $slider->ID) == null)
		return;

	ob_start();

	set_query_var( 'slider', $slider );
	set_query_var( 'atts', $atts );
	get_template_part('templates/shortcode-photo-slider');

	return ob_get_clean();
}
add_shortcode( 'photo-slider', 'photo_slider' );

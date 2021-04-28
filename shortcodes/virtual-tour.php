<?php

/** Shortcode to display Google Maps virtual tour
 * @param $atts User defined shortcode attributes that define width and height of the element
 *
 * @return string HTML code of the <iframe> element
 */
function virtual_tour_shortcode($atts) {
	$atts = shortcode_atts(
		[
			'width' => '100%',
			'height' => '100%'
		],
		$atts,
		'virtual-tour');

	$iframeCode = '<iframe src="https://www.google.com/maps/embed?pb=!4v1529335301324!6m8!1m7!1sCAoSLEFGMVFpcE9VN3gzSC1PazVteU1Pb1hPMW9vTXZ1Qno2amhXWnVNVFZ4V0VU!2m2!1d50.07644922166!2d14.402456801404!3f119.11253347398221!4f-3.875949460253466!5f0.7820865974627469" 
							frameborder="0" 
							style="border:0;width:%s;height:%s;" 
							allowfullscreen=""></iframe>';
	$iframeCode = sprintf($iframeCode, $atts['width'], $atts['height']);

	return $iframeCode;
}
add_shortcode('virtual-tour', 'virtual_tour_shortcode');
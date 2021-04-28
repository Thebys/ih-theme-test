<?php

/** Shortcode to display pricing table element with various number of prices
 *
 * @param array $atts Array of user defined shortcode attributes.
 *
 * @return string Returns HTML code of the pricing table
 */
function pricing_table($atts) {
	$atts = shortcode_atts(
		[
			'head_title' => 'Example title',
			'head_top_note' => 'Example top note',
			'head_bottom_note' => 'Example bottom note',
			'head_image' => '',
			'head_overlay' => 'bg-grey',
			'head_hover' => true,
			'head_shadow' => false,
			'variants' => [],
		],
		$atts,
		'pricing-table');

	//if the shortcode is not used throughout Elementor we support parsing of the variants from string
	//variants are separated by ;; while title, description and both prices of a single variant are split using @@
	//Example: "Variant 1@@Best variant@@100 CZK@@120CZK;;Variant 2@@Second best@@200 CZK@@242 CZK"
	if(is_string($atts['variants'])) {
		$stringVariants = str_split($atts['variants'], ';;');
		$variants = [];
		foreach ($stringVariants as $var) {
			$var_details = str_split($var, '@@');
			$variant = [
				'variant_title' => !empty($var_details[0]) ?  $var_details[0] : '',
				'variant_description' => !empty($var_details[1]) ?  $var_details[1] : '',
				'variant_price_novat' => !empty($var_details[2]) ?  $var_details[2] : '',
				'variant_price_vat' => !empty($var_details[3]) ?  $var_details[3] : '',
			];
			$variants[] = $variant;
		}
		$atts['variants'] = $variants;
	}

	ob_start();

	set_query_var( 'atts', $atts );
	get_template_part('templates/shortcode-pricing-table');

	return ob_get_clean();
}
add_shortcode('pricing-table', 'pricing_table');
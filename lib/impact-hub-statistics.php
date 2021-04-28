<?php
/**
 * This file defines a custom settings page in the WP administration that enables us to manage certain facts in a single place while the data is then displayed on multiple places.
 *
 * It also defines a shortcode that can be used to display the data anywhere in the website.
 *
 * TODO: This is not so nice. It would be cooler if we moved those fields inside Wordpress Theme Customizer.
 */

// in case ACF plugin is not installed code won't be executed
if(!function_exists('acf_add_options_sub_page') || !function_exists('register_field_group'))
	return;

// Creates custom Admin Page
acf_add_options_sub_page(array(
	'title' => 'Impact Hub Statistics',
	'slug' => 'impact-hub-statistics',
	'parent' => 'options-general.php'
));

// Registers the ACF fields
register_field_group(array(
	'key' => 'impact_hub_global_statistics_guide_group',
	'title' => 'Impact Hub Statistics Guide',
	'fields' => array (
		array (
			'key' => 'ihs-guide',
			'label' => '',
			'name' => 'ihs-guide',
			'type' => 'text',
			'readonly' => 1,
			'disabled' => 1,
			'instructions' => 'You can retrieve each field value using following shortcode wherever you need: <code>[ihstat key="key-of-the-field-of-your-choice"]</code>. <ul><strong>For each field you can use following modifiers: </strong><br><li>Default format for value 17000 is "17 000" in Czech and "17,000" in English.</li><li>If you use <code>[ihstat key="ihs-hub-count" plain="true"]</code> you will get exact value without modifications = "17000".</li><li>If you use <code>[ihstat key="ihs-hub-count" thousand="true"]</code> you will get value divided by a thousand = "17".</li></ul> The following field has no use.'
		)
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'impact-hub-statistics',
			),
		),
	),
	'options' => array (
        'position' => 'normal',
        'layout' => 'default',
        'hide_on_screen' => array()
    )
));

register_field_group(array(
	'key' => 'impact_hub_global_statistics_group',
	'title' => 'Impact Hub Global Statistics',
	'fields' => array (
		array (
			'key' => 'ihs-hub-count',
			'label' => 'Number of running Impact Hubs',
			'name' => 'ihs-hub-count',
			'type' => 'number',
			'instructions' => 'You can retrieve this value using following shortcode: <code>[ihstat key="ihs-hub-count"]</code>.'
		),
		array (
			'key' => 'ihs-members-global-count',
			'label' => 'Number of members in Global network',
			'name' => 'ihs-members-global-count',
			'type' => 'number',
			'instructions' => 'You can retrieve this value using following shortcode: <code>[ihstat key="ihs-members-global-count"]</code>.'
		)	
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'impact-hub-statistics',
			),
		),
	),
	'options' => array (
        'position' => 'normal',
        'layout' => 'default',
        'hide_on_screen' => array()
    )
));

register_field_group(array(
	'id' => 'impact_hub_local_statistics_group',
	'title' => 'Impact Hub Local Statistics',
	'fields' => array (
		array (
			'key' => 'ihs-members-czech-count',
			'label' => 'Number of members in Local network',
			'name' => 'ihs-members-czech-count',
			'type' => 'number',
			'instructions' => 'You can retrieve this value using following shortcode: <code>[ihstat key="ihs-members-czech-count"]</code>.'
		),
		array (
			'key' => 'ihs-accelerators',
			'label' => 'Number of running Acceleration Programmes',
			'name' => 'ihs-accelerators',
			'type' => 'number',
			'instructions' => 'You can retrieve this value using following shortcode: <code>[ihstat key="ihs-accelerators"]</code>.'
		),
		array (
			'key' => 'ihs-accelerated-projects',
			'label' => 'Number of accelerated projects per year',
			'name' => 'ihs-accelerated-projects',
			'type' => 'number',
			'instructions' => 'You can retrieve this value using following shortcode: <code>[ihstat key="ihs-accelerated-projects"]</code>.'
		)
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'impact-hub-statistics',
			),
		),
	),
	'options' => array (
        'position' => 'normal',
        'layout' => 'default',
        'hide_on_screen' => array()
    )
));

// Shortcode used to display the data defined in the settings page.
add_shortcode( 'ihstat', 'impact_hub_statistics_shortcode' );
function impact_hub_statistics_shortcode($args) {
	// statistics are shared across languages
	add_filter('acf/settings/current_language',function() {
	     global $sitepress;
	     return $sitepress->get_default_language();
	});

	if(!isset($args['key']))
		return 'You have to specify \'key\' argument to get the value.';
	if(!($value = get_field($args['key'], 'option')))
		return 'This key does not exist!';
	if(isset($args['thousand']))
		$value = floor($value / 1000);
	if(isset($args['plain']))
		return $value;

	// reset to original language
	add_filter('acf/settings/current_language',function() {
	     return ICL_LANGUAGE_CODE;
	});	

	return spacesOrCommas($value);
}

function spacesOrCommas($number) {
	if(ICL_LANGUAGE_CODE == 'cs')
		return str_replace('#',"&nbsp;",number_format($number, 0, ',', '#'));
	return number_format($number, 0, '.', ',');
}
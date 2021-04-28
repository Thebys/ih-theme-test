<?php
/**
 * Functionality that registers options into the Wordpress Theme Customizer
 */

// Add Google Tag Manager setting to Customize menu of the theme
add_action( 'customize_register', 'add_google_tag_manager_option' );
function add_google_tag_manager_option($wp_customize) {
	$wp_customize->add_section(
		'analytics-settings' ,
		array(
			'title'      => __( 'Analytics & API', 'roots-customizer' ),
			'priority'   => 30,
			'description' => __( 'Configure analytics and API keys for Impact Hub Theme.', 'roots-customizer')
		)
	);

	$wp_customize->add_setting(
		'google_tag_manager_id' ,
		array(
			'default'   => '',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'google_analytics_id' ,
		array(
			'default'   => '',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'google_maps_api_key' ,
		array(
			'default'   => '',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'google_tag_manager_id',
		array(
			'type' => 'text',
			'section' => 'analytics-settings',
			'label' => __( 'Google Tag Manager ID' ),
			'input_attrs' => array(
				'placeholder' => __( 'GTM-XXXXXXX' ),
			)
		)
	);

	$wp_customize->add_control(
		'google_analytics_id',
		array(
			'type' => 'text',
			'section' => 'analytics-settings',
			'label' => __( 'Google Analytics ID' ),
			'description' => 'Insert GA tracking ID to enable server-side forms tracking in case the visitor has GA disabled.',
			'input_attrs' => array(
				'placeholder' => __( 'UA-XXXXXXX-XX' ),
			)
		)
	);

	$wp_customize->add_control(
		'google_maps_api_key',
		array(
			'type' => 'text',
			'section' => 'analytics-settings',
			'label' => __( 'Google Maps API key' ),
			'description' => 'Insert Google Maps API key to enable Google Maps on the website. If not present, theme won\'t load Google Maps library.',
			'input_attrs' => array(
				'placeholder' => __( 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' ),
			)
		)
	);
}

// Add social media links
add_action( 'customize_register', 'social_links_settings' );
function social_links_settings($wp_customize) {
	$wp_customize->add_section(
		'social-links' ,
		array(
			'title'      => __( 'Social links', 'roots-customizer' ),
			'priority'   => 40,
			'description' => __( 'Enter links to your social network profiles so they can be displayed in various places.', 'roots-customizer')
		)
	);

	$wp_customize->add_setting(
		'url_facebook' ,
		array(
			'default'   => '',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'url_youtube' ,
		array(
			'default'   => '',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'url_instagram' ,
		array(
			'default'   => '',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'url_linkedin' ,
		array(
			'default'   => '',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_setting(
		'url_slideslive' ,
		array(
			'default'   => '',
			'transport' => 'postMessage',
		)
	);

	$wp_customize->add_control(
		'url_facebook',
		array(
			'type' => 'text',
			'section' => 'social-links',
			'label' => __( 'Facebook' ),
			'input_attrs' => array(
				'placeholder' => __( 'https://facebook.com/...' ),
			)
		)
	);

	$wp_customize->add_control(
		'url_youtube',
		array(
			'type' => 'text',
			'section' => 'social-links',
			'label' => __( 'YouTube' ),
			'input_attrs' => array(
				'placeholder' => __( 'https://youtube.com/...' ),
			)
		)
	);

	$wp_customize->add_control(
		'url_instagram',
		array(
			'type' => 'text',
			'section' => 'social-links',
			'label' => __( 'Instagram' ),
			'input_attrs' => array(
				'placeholder' => __( 'https://instagram.com/...' ),
			)
		)
	);

	$wp_customize->add_control(
		'url_linkedin',
		array(
			'type' => 'text',
			'section' => 'social-links',
			'label' => __( 'Linkedin' ),
			'input_attrs' => array(
				'placeholder' => __( 'https://linkedin.com/...' ),
			)
		)
	);

	$wp_customize->add_control(
		'url_slideslive',
		array(
			'type' => 'text',
			'section' => 'social-links',
			'label' => __( 'Slideslive' ),
			'input_attrs' => array(
				'placeholder' => __( 'https://slideslive.com/...' ),
			)
		)
	);
}
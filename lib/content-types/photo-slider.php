<?php

/*  ==========================================================================
Photo slider post type
========================================================================== */
add_action( 'init', 'photo_slider_post_type' );
function photo_slider_post_type() {
	$labels = array(
		'name' => 'Photo Sliders',
		'singular_name' => 'Photo Slider',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Photo Slider',
		'edit_item' => 'Edit Photo Slider',
		'new_item' => 'New Photo Slider',
		'all_items' => 'All Photo Sliders',
		'view_item' => 'View Photo Sliders',
		'search_items' => 'Search Photo Sliders',
		'not_found' =>  'No Photo Sliders found',
		'not_found_in_trash' => 'No Photo Sliders found in Trash',
		'menu_name' => 'Photo Sliders'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'photo_slider' ),
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title'),
		'exclude_from_search' => true
	);
	register_post_type( 'photo_slider', $args );
}

/*  ==========================================================================
Init custom fields
========================================================================== */

add_action('after_setup_theme', 'photo_slider_custom_fields', 11);
function photo_slider_custom_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;


	register_field_group(array (
		'id' => 'acf_photo-slider-fields',
		'title' => 'Photo Slider Fields',
		'fields' => array (
			array (
				'key' => 'field_photoSliderHeadline',
				'label' => 'Headline',
				'name' => 'headline',
				'type' => 'text',
				'required' => 0,
				'wrapper' => array(
					'width' => '30',
				),
			),
			array (
				'key' => 'field_photoSliderDescription',
				'label' => 'Description',
				'name' => 'description',
				'type' => 'textarea',
				'new_lines' => 'br',
				'required' => 0,
				'wrapper' => array(
					'width' => '50',
				),
			),
			array (
				'key' => 'field_photoSliderRandomized',
				'label' => 'Slides randomized',
				'name' => 'randomized',
				'type' => 'true_false',
				'instructions' => 'Do wou want the photos to be displayed in random order?',
				'wrapper' => array(
					'width' => '20',
				),
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'Yes',
				'ui_off_text' => 'No',
			),
			array (
				'key' => 'field_photoSliderPhotos',
				'label' => 'Photos',
				'name' => 'photos',
				'type' => 'repeater',
				'required' => 1,
				'min' => 0,
				'max' => 0,
				'layout' => 'table',
				'button_label' => 'Add a photo',
				'sub_fields' => array(
					array(
						'key' => 'field_photoSliderPhotos_label',
						'label' => 'Label',
						'name' => 'photo-label',
						'type' => 'text',
						'required' => 1,
						'wrapper' => array(
							'width' => '50'
						),
					),
					array(
						'key' => 'field_photoSliderPhotos_photo',
						'label' => 'Photo',
						'name' => 'photo-photo',
						'type' => 'image',
						'required' => 1,
						'preview_size' => 'thumbnail',
						'min_width' => 800,
						'wrapper' => array(
							'width' => '50'
						),
					),
				),
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'photo_slider'
				),
			),
		),
		'menu_order' => 0,
	));
}
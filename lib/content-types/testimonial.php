<?php

/*  ==========================================================================
Testimonials post type
========================================================================== */
add_action( 'init', 'hub_testimonial_post_type' );
function hub_testimonial_post_type() {
	$labels = array(
		'name' => 'Testimonials',
		'singular_name' => 'Testimonial',
		'add_new' => 'Add New',
		'add_new_item' => 'Add New Testimonial',
		'edit_item' => 'Edit Testimonial',
		'new_item' => 'New Testimonial',
		'all_items' => 'All Testimonials',
		'view_item' => 'View Testimonials',
		'search_items' => 'Search Testimonials',
		'not_found' =>  'No testimonials found',
		'not_found_in_trash' => 'No testimonials found in Trash',
		'menu_name' => 'Testimonials'
	);

	$args = array(
		'labels' => $labels,
		'public' => true,
		'publicly_queryable' => true,
		'show_ui' => true,
		'show_in_menu' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'testimonial' ),
		'capability_type' => 'post',
		'has_archive' => false,
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array( 'title', 'thumbnail' ),
		'exclude_from_search' => true
	);
	register_post_type( 'testimonial', $args );
}

add_action( 'init', 'testimonial_category_taxonomy', 0 );
function testimonial_category_taxonomy() {
	$labels = array(
		'name'              => _x( 'Testimonial Categories', 'taxonomy general name' ),
		'singular_name'     => _x( 'Testimonial Category', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Testimonial Categories' ),
		'all_items'         => __( 'All Testimonial Categories' ),
		'parent_item'       => __( 'Parent Testimonial Category' ),
		'parent_item_colon' => __( 'Parent Testimonial Category:' ),
		'edit_item'         => __( 'Edit Testimonial Category' ),
		'update_item'       => __( 'Update Testimonial Category' ),
		'add_new_item'      => __( 'Add New Testimonial Category' ),
		'new_item_name'     => __( 'New Testimonial Category Name' ),
		'menu_name'         => __( 'Testimonial Categories' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'testimonial_categories' ),
	);

	register_taxonomy( 'testimonial_categories', array( 'testimonial' ), $args );
}

/*  ==========================================================================
Init custom fields
========================================================================== */

add_action('after_setup_theme', 'testimonial_custom_fields', 11);
function testimonial_custom_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;


	register_field_group(array (
		'id' => 'acf_testimonial-fields',
		'title' => 'Testimonial Fields',
		'fields' => array (
			array (
				'key' => 'field_testimonialName',
				'label' => 'Name',
				'name' => 'name',
				'type' => 'text',
				'required' => 0,
				'wrapper' => array(
					'width' => '50',
				),
			),
			array (
				'key' => 'field_testimonialTitle',
				'label' => 'Title',
				'name' => 'title',
				'type' => 'text',
				'required' => 0,
				'wrapper' => array(
					'width' => '50',
				),
			),
			array (
				'key' => 'field_526acde43ba7f',
				'label' => 'Description',
				'name' => 'description',
				'type' => 'textarea',
				'required' => 1,
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'br',
			),
			array (
				'key' => 'field_testimonialC2AText',
				'label' => 'Button text',
				'name' => 'button_text',
				'type' => 'text',
				'required' => 0,
				'wrapper' => array(
					'width' => '50',
				),
			),
			array (
				'key' => 'field_testimonialC2ALink',
				'label' => 'Button link',
				'name' => 'button_link',
				'type' => 'text',
				'required' => 0,
				'wrapper' => array(
					'width' => '50',
				),
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'testimonial',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'acf_after_title',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

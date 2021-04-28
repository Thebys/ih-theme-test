<?php

/*  ==========================================================================
Space post type
========================================================================== */
add_action( 'init', 'hub_space_post_type' );
function hub_space_post_type() {
    $labels = array(
        'name' => 'Spaces',
        'singular_name' => 'Space',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Space',
        'edit_item' => 'Edit Space',
        'new_item' => 'New Space',
        'all_items' => 'All Spaces',
        'view_item' => 'View Spaces',
        'search_items' => 'Search Spaces',
        'not_found' =>  'No spaces found',
        'not_found_in_trash' => 'No spaces found in Trash',
        'menu_name' => 'Spaces'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'space' ),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'thumbnail' )
    );
    register_post_type( 'space', $args );
}

add_action( 'init', 'space_category_taxonomy', 0 );
function space_category_taxonomy() {
    $labels = array(
        'name'              => _x( 'Space Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Space Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Space Categories' ),
        'all_items'         => __( 'All Space Categories' ),
        'parent_item'       => __( 'Parent Space Category' ),
        'parent_item_colon' => __( 'Parent Space Category:' ),
        'edit_item'         => __( 'Edit Space Category' ),
        'update_item'       => __( 'Update Space Category' ),
        'add_new_item'      => __( 'Add New Space Category' ),
        'new_item_name'     => __( 'New Space Category Name' ),
        'menu_name'         => __( 'Space Categories' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'space_categories' ),
    );

    register_taxonomy( 'space_categories', array( 'space' ), $args );
}



/*  ==========================================================================
Init custom fields
========================================================================== */
add_action('after_setup_theme', 'space_custom_fields', 11);
function space_custom_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;


    register_field_group(array (
		'id' => 'acf_space-fields',
		'title' => 'Space Fields',
		'fields' => array (
			array (
				'key' => 'field_5252d442e0780',
				'label' => 'Seating Capacity',
				'name' => 'seating_capacity',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '50 - 60',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5252d46ce0781',
				'label' => 'Standing Capacity',
				'name' => 'standing_capacity',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '80 - 100',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5252d47be0782',
				'label' => 'Dimensions',
				'name' => 'dimensions',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '60 sqm',
				'prepend' => '',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_5252d9dde0783',
				'label' => 'Description',
				'name' => 'description',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'html',
			),
			array (
				'key' => 'field_5252da62e0784',
				'label' => 'Amenities',
				'name' => 'amenities',
				'type' => 'textarea',
				'default_value' => '',
				'placeholder' => '',
				'maxlength' => '',
				'formatting' => 'html',
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'space',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}

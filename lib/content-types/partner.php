<?php

/*  ==========================================================================
Team post type
========================================================================== */
add_action( 'init', 'hub_partner_post_type' );
function hub_partner_post_type() {
    $labels = array(
        'name' => 'Partners',
        'singular_name' => 'Partner',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Partner',
        'edit_item' => 'Edit Partner',
        'new_item' => 'New Partner',
        'all_items' => 'All Partners',
        'view_item' => 'View Partner',
        'search_items' => 'Search Partners',
        'not_found' =>  'No partners found',
        'not_found_in_trash' => 'No partners found in Trash',
        'menu_name' => 'Partners'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'partner' ),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'thumbnail', 'page-attributes'),
        'exclude_from_search' => true
    );
    register_post_type( 'partner', $args );
}

add_action( 'init', 'partner_category_taxonomy', 0 );
function partner_category_taxonomy() {
    $labels = array(
        'name'              => _x( 'Partner Categories', 'taxonomy general name' ),
        'singular_name'     => _x( 'Partner Category', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Partner Categories' ),
        'all_items'         => __( 'All Partner Categories' ),
        'parent_item'       => __( 'Parent Partner Category' ),
        'parent_item_colon' => __( 'Parent Partner Category:' ),
        'edit_item'         => __( 'Edit Partner Category' ),
        'update_item'       => __( 'Update Partner Category' ),
        'add_new_item'      => __( 'Add New Partner Category' ),
        'new_item_name'     => __( 'New Partner Category Name' ),
        'menu_name'         => __( 'Partner Categories' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'partner_categories' ),
    );

    register_taxonomy( 'partner_categories', array( 'partner' ), $args );
}


/*  ==========================================================================
Init custom fields
========================================================================== */
add_action('after_setup_theme', 'partner_custom_fields', 11);
function partner_custom_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;


    register_field_group(array (
        'id' => 'acf_partner-fields',
        'title' => 'Partner Fields',
        'fields' => array (
            array (
                'key' => 'field_5251d76e531a5',
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
                'key' => 'field_5251d795531a6',
                'label' => 'Contact Methods',
                'name' => 'contact_methods',
                'type' => 'repeater',
                'sub_fields' => array (
                    array (
                        'key' => 'field_5251d7a8531a7',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'column_width' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'none',
                        'maxlength' => '',
                    ),
                    array (
                        'key' => 'field_5251d7ae531a8',
                        'label' => 'Url',
                        'name' => 'url',
                        'type' => 'text',
                        'column_width' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'prepend' => '',
                        'append' => '',
                        'formatting' => 'none',
                        'maxlength' => '',
                    ),
                ),
                'row_min' => 0,
                'row_limit' => '',
                'layout' => 'row',
                'button_label' => 'Add Row',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'partner',
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
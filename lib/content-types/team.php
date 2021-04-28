<?php

/*  ==========================================================================
Team post type
========================================================================== */
add_action( 'init', 'hub_team_post_type' );
function hub_team_post_type() {
    $labels = array(
        'name' => 'Team Members',
        'singular_name' => 'Team Member',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Team Member',
        'edit_item' => 'Edit Team Member',
        'new_item' => 'New Team Member',
        'all_items' => 'All Team Members',
        'view_item' => 'View Team Members',
        'search_items' => 'Search Team Members',
        'not_found' =>  'No team members found',
        'not_found_in_trash' => 'No team members found in Trash',
        'menu_name' => 'Team'
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'team' ),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title', 'thumbnail' ),
        'exclude_from_search' => true
    );
    register_post_type( 'team', $args );
}


add_action( 'init', 'team_role_taxonomy', 0 );
function team_role_taxonomy() {
    $labels = array(
        'name'              => _x( 'Team Roles', 'taxonomy general name' ),
        'singular_name'     => _x( 'Team Role', 'taxonomy singular name' ),
        'search_items'      => __( 'Search Team Roles' ),
        'all_items'         => __( 'All Team Roles' ),
        'parent_item'       => __( 'Parent Team Role' ),
        'parent_item_colon' => __( 'Parent Team Role:' ),
        'edit_item'         => __( 'Edit Team Role' ),
        'update_item'       => __( 'Update Team Role' ),
        'add_new_item'      => __( 'Add New Team Role' ),
        'new_item_name'     => __( 'New Team Role Name' ),
        'menu_name'         => __( 'Team Roles' ),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array( 'slug' => 'team_role' ),
    );

    register_taxonomy( 'team_role', array( 'team' ), $args );
}

/*  ==========================================================================
Init custom fields
========================================================================== */

add_action('after_setup_theme', 'team_custom_fields', 11);
function team_custom_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;


register_field_group(array (
	'id' => 'acf_team-member-fields',
	'title' => 'Team Member Fields',
	'fields' => array (
		array (
			'key' => 'field_5251b6ab64679',
			'label' => 'Title',
			'name' => 'title',
			'required' => 1,
		        'type' => 'text',
		        'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
            array (
                'key' => 'field_5251b6c76467a',
                'label' => 'Description',
                'name' => 'description',
                'type' => 'textarea',
                'required' => 0,
                'default_value' => '',
                'placeholder' => '',
                'maxlength' => '',
                'formatting' => 'br',
            ),
            array (
                'key' => 'field_5251b70214ff5',
                'label' => 'Contact Methods',
                'name' => 'contact_methods',
                'type' => 'repeater',
                'sub_fields' => array (
                    array (
                        'key' => 'field_5251b71614ff6',
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
                        'key' => 'field_5251b72514ff7',
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
                    'value' => 'team',
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

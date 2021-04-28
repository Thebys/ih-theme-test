<?php

/*  ==========================================================================
    Notification post type
    ========================================================================== */


if ( ! function_exists('acf_add_local_field_group') )
	return;

// Register Custom Post Type
function register_notification_post_type() {
	$labels = array(
		'name'                  => _x( 'Notifications', 'Post Type General Name', 'text_domain' ),
		'singular_name'         => _x( 'Notification', 'Post Type Singular Name', 'text_domain' ),
		'menu_name'             => __( 'Notifications', 'text_domain' ),
		'name_admin_bar'        => __( 'Notification', 'text_domain' ),
		'archives'              => __( 'Notification Archives', 'text_domain' ),
		'attributes'            => __( 'Notification Attributes', 'text_domain' ),
		'parent_item_colon'     => __( 'Parent Notification:', 'text_domain' ),
		'all_items'             => __( 'All Notification', 'text_domain' ),
		'add_new_item'          => __( 'Add New Notification', 'text_domain' ),
		'add_new'               => __( 'Add Notification', 'text_domain' ),
		'new_item'              => __( 'New Notification', 'text_domain' ),
		'edit_item'             => __( 'Edit Notification', 'text_domain' ),
		'update_item'           => __( 'Update Notification', 'text_domain' ),
		'view_item'             => __( 'View Notification', 'text_domain' ),
		'view_items'            => __( 'View Notification', 'text_domain' ),
		'search_items'          => __( 'Search Notification', 'text_domain' ),
		'not_found'             => __( 'Not found', 'text_domain' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'text_domain' ),
		'featured_image'        => __( 'Featured Image', 'text_domain' ),
		'set_featured_image'    => __( 'Set featured image', 'text_domain' ),
		'remove_featured_image' => __( 'Remove featured image', 'text_domain' ),
		'use_featured_image'    => __( 'Use as featured image', 'text_domain' ),
		'insert_into_item'      => __( 'Insert into Notification', 'text_domain' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'text_domain' ),
		'items_list'            => __( 'Items list', 'text_domain' ),
		'items_list_navigation' => __( 'Items list navigation', 'text_domain' ),
		'filter_items_list'     => __( 'Filter items list', 'text_domain' ),
	);
	$args = array(
		'label'                 => __( 'Notification', 'text_domain' ),
		'description'           => __( 'Notifications on IH websites', 'text_domain' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'custom-fields' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 30,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => true,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'hub_notification', $args );
}
add_action( 'init', 'register_notification_post_type', 0 );


/*  ==========================================================================
    Init custom fields
    ========================================================================== */

add_action('acf/init', 'register_notification_fields');
function register_notification_fields() {
	acf_add_local_field_group(array(
		'key' => 'group_5d7be780dec27',
		'title' => 'Notification fields',
		'fields' => array(
			array(
				'key' => 'field_5d7be8a493e23',
				'label' => 'Notification Image',
				'name' => 'notification_image',
				'type' => 'image',
				'instructions' => 'Upload a notification image with resolution of 870x278px. The size of the image should not be bigger than 150kB.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '40',
				),
				'return_format' => 'url',
				'preview_size' => 'full',
				'library' => 'all',
				'min_width' => 870,
				'min_height' => 278,
				'min_size' => '',
				'max_width' => 870,
				'max_height' => 278,
				'max_size' => '0.15',
				'mime_types' => '',
			),
			array(
				'key' => 'field_5d7be91f93e24',
				'label' => 'Button Text',
				'name' => 'button_text',
				'type' => 'text',
				'instructions' => 'Text on the main button.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '60',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_5d7be93c93e25',
				'label' => 'Button Link',
				'name' => 'button_link',
				'type' => 'text',
				'instructions' => 'Where the button should point at. You can insert a short url without the domain name too, for example "/coworking/". Make sure there is the / at the beginning. Also keep the /en/ for english pages. Link should also terminate with a /.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
				),
				'default_value' => '',
				'placeholder' => '',
			),
			array(
				'key' => 'field_5d7bfaf072f74',
				'label' => 'Display to',
				'name' => 'display_to',
				'type' => 'date_picker',
				'instructions' => 'When the notification should stop displaying. If you do not know the exact date, please set some random date in the next 3 years.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
				),
				'display_format' => 'Y-m-d',
				'return_format' => 'Y-m-d',
				'first_day' => 1,
			),
			array(
				'key' => 'field_5d7bfb2b72f75',
				'label' => 'Page picker',
				'name' => 'page_picker',
				'type' => 'post_object',
				'instructions' => 'Select the pages, where the notification should not be displayed.',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
				),
				'post_type' => array(
					0 => 'page',
				),
				'taxonomy' => '',
				'allow_null' => 0,
				'multiple' => 1,
				'return_format' => 'id',
				'ui' => 1,
			),
			array(
				'key' => 'field_5d7cd3c514282',
				'label' => 'Campaign ID',
				'name' => 'campaign_id',
				'type' => 'text',
				'instructions' => 'Set the notification ID - e.g. name of the campaign. Please note, that this field should not contain any spaces and ID should be unique for each campaign.',
				'required' => 1,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '50',
				),
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
				'maxlength' => '',
			),
			array(
				'key' => 'field_background_picker',
				'label' => 'Background color of Notification',
				'name' => 'bgc-notification',
				'type' => 'select',
				'instructions' => '<p class="description">Pick one of the following colors: <code style="background-color: #075a61; color: #ffffff;">Hunter green</code> <code style="background-color: #3a9b89; color: #ffffff;">Fern green</code> <code style="background-color: #ca2c55; color: #ffffff;">Ruby red</code> <code style="background-color: #404043; color: #ffffff;">Grey</code> <code style="background-color: #ffffff; color: #404043;">White</code> <code style="background-color: #f5f5f5; color: #404043;">Light grey</code> <code style="background-color: #ee4f3f; color: #ffffff;">Light red</code> <code style="background-color: #f78a3c; color: #ffffff;">Orange</code> <code style="background-color: #f6a974; color: #ffffff;">Tan orange</code> <code style="background-color: #ff5353; color: #ffffff;">Coral red</code> <code style="background-color: #0f3a5f; color: #ffffff;">Midnight blue</code> <code style="background-color: #3894c2; color: #ffffff;">Blue</code> <code style="background-color: #41bed0; color: #ffffff;">Mint blue</code> <code style="background-color: #266887; color: #ffffff;">Ocean blue</code> <code style="background-color: #7ebb55; color: #ffffff;">Greenhouse</code> <code style="background-color: #aacb70; color: #ffffff;">Pistachio</code> <code style="background-color: #ffd546; color: #ffffff;">Yellow</code>.</p>',
				'wrapper' => array(
					'width' => '60',
				),
				'choices' => get_color_class_options(),
				'default_value' => array(
					0 => 'bg-white',
				),
				'allow_null' => 1,
				'multiple' => 0,
				'ui' => 1,
				'ajax' => 0,
				'return_format' => 'value',
				'required' => true
			),
			array(
				'key' => 'field_5d7cf10db6814',
				'label' => 'Button - transparent background',
				'name' => 'is_transparent_background',
				'type' => 'true_false',
				'instructions' => 'Tick this field, if you want the button to be transparent with white text and borders. Also please notice, that the text will be white. Otherwise, the button background will be Impact Red and text will be black.',
				'required' => 0,
				'wrapper' => array(
					'width' => '40',
				),
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'Yes',
				'ui_off_text' => 'No'
			),
			array(
				'key' => 'field_form_or_newsletter_notification',
				'label' => 'Newsletter of Form notification',
				'name' => 'form_or_newsletter_notification',
				'type' => 'true_false',
				'instructions' => 'Tick this field if this is special notification. That means longer delay before displaying. This special category includes newsletter or form notifications in general.',
				'required' => 0,
				'wrapper' => array(
					'width' => '50',
				),
				'default_value' => 0,
				'ui' => 1,
				'ui_on_text' => 'Yes',
				'ui_off_text' => 'No'
			)
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'hub_notification',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => 'Notification settings',
	));
}

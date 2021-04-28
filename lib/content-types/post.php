<?php

/*  ==========================================================================
    Change "Posts" to "Stories"
    http://stackoverflow.com/a/12950041
    ========================================================================== */

add_action('init', 'change_post_object_label');
function change_post_menu_label()
{
	global $menu;
	global $submenu;
	$menu[5][0] = __('Stories', 'roots');
	$submenu['edit.php'][5][0] = __('Stories', 'roots');
	$submenu['edit.php'][10][0] = __('Add Stories', 'roots');
	echo '';
}

add_action('admin_menu', 'change_post_menu_label');
function change_post_object_label()
{
	global $wp_post_types;
	$labels = & $wp_post_types['post']->labels;
	$labels->name = __('Stories', 'roots');
	$labels->singular_name = __('Story', 'roots');
	$labels->add_new = __('Add Story', 'roots');
	$labels->add_new_item = __('Add Story', 'roots');
	$labels->edit_item = __('Edit Story', 'roots');
	$labels->new_item = __('Story', 'roots');
	$labels->view_item = __('View Story', 'roots');
	$labels->search_items = __('Search Stories', 'roots');
	$labels->not_found = __('No stories found', 'roots');
	$labels->not_found_in_trash = __('No stories found in Trash', 'roots');
}

// Append author details after the post content
add_action('after_single_content', 'render_author_details', 1);
function render_author_details()
{
	global $post;
	if(!(is_single() && 'post' == get_post_type()))
		return;
	get_template_part("templates/content","single-author-details");
}

/*  ==========================================================================
Init custom author fields for stories
Init custom fields for homepage stories loop
========================================================================== */
add_action('after_setup_theme', 'story_custom_fields', 11);
function story_custom_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;

	register_field_group(array (
		'id' => 'acf_stories-homepage-summary',
		'key' => 'group_stories-homepage-summary',
		'title' => 'Homepage post summary',
		'fields' => array (
			array (
				'key' => 'story_homepage_img',
				'label' => 'Thumbnail picture',
				'name' => 'homepage_thumbnail',
				'type' => 'image',
				'required' => 0,
				'wrapper' => array (
					'width' => '50%',
				)
			)
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post'
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

	register_field_group(array (
		'id' => 'acf_stories-author-fields',
		'key' => 'group_stories-author-fields',
		'title' => 'Author Fields',
		'fields' => array (
			array (
				'key' => 'story_author_image',
				'label' => 'Profile picture',
				'name' => 'author_image',
				'type' => 'image',
				'required' => 0,
				'wrapper' => array (
					'width' => '50%',
				)
			),
			array (
				'key' => 'story_author_intro',
				'label' => 'Intro text',
				'name' => 'author_intro',
				'type' => 'text',
				'default' => 'Autorem článku je',
				'required' => 0,
			),
			array (
				'key' => 'story_author_name',
				'label' => 'Name',
				'name' => 'author_name',
				'type' => 'text',
				'required' => 0,
			),
			array (
				'key' => 'story_author_description',
				'label' => 'Description',
				'name' => 'author_description',
				'type' => 'textarea',
				'required' => 0,
				'formatting' => 'br',
			),
			array (
				'key' => 'story_author_facebook',
				'label' => 'Facebook profile link',
				'name' => 'author_fb',
				'type' => 'text',
				'required' => 0,
			),
			array (
				'key' => 'story_author_linkedin',
				'label' => 'Linkedin profile link',
				'name' => 'author_li',
				'type' => 'text',
				'required' => 0,
			),
			array (
				'key' => 'story_author_twitter',
				'label' => 'Twitter profile link',
				'name' => 'author_tw',
				'type' => 'text',
				'required' => 0,
			),
			array (
				'key' => 'story_author_email',
				'label' => 'E-mail address',
				'name' => 'author_email',
				'type' => 'text',
				'required' => 0,
			),
			array (
				'key' => 'story_author_website',
				'label' => 'Website',
				'name' => 'author_web',
				'type' => 'text',
				'required' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'post'
				),
			),
		),
		'options' => array (
			'position' => 'normal',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 1,
	));
}

/* Display similar stories after the single story content */
//require_once WP_CONTENT_DIR . '/themes/impacthub/lib/similar-stories.php';
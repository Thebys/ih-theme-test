<?php
/*
 * Banners post type including multiple actions/shortcodes that display shortcodes on different pages.
 * TODO: This can be removed. We don't use banners anymore.
 */

add_action( 'init', 'hub_banner_post_type' );
function hub_banner_post_type() {
    $labels = array(
        'name' => 'Banners',
        'singular_name' => 'Banner',
        'add_new' => 'Add New',
        'add_new_item' => 'Add New Banner',
        'edit_item' => 'Edit Banner',
        'new_item' => 'New Banner',
        'all_items' => 'All Banners',
        'view_item' => 'View Banners',
        'search_items' => 'Search Banners',
        'not_found' =>  'No banners found',
        'not_found_in_trash' => 'No banners found in Trash',
        'menu_name' => 'Banners'
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'banner' ),
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'menu_position' => null,
        'supports' => array( 'title' ),
        'exclude_from_search' => true
    );
    register_post_type( 'banner', $args );
}

add_shortcode( 'banner', 'banner_shortcode' );
function banner_shortcode( $atts ) {
    extract( shortcode_atts( array(
        'id' => '',
        'type' => 'default'
    ), $atts ) );

    $banner = is_numeric( $id ) ? get_post($id) : get_page_by_path( $id, 'OBJECT', 'banner' ) ;

    ob_start();
    banner_display($banner, $type);
    $banner_output = ob_get_contents();
    ob_end_clean();

    return $banner_output;
}


function banner_display($banner = false, $type = 'default' ) {
    $type = ( $type == '' ) ? 'default' : $type ;
    if ( $banner && function_exists('get_field') )
        include(locate_template('templates/banner.php'));
}

function hub_banner_types() {
    return array(
        1 => 'Default',
        // 2 => 'Feature',
        3 => 'Tall',
    );
}


/*  ==========================================================================
The banner on pages
========================================================================== */

add_action('page_banner', 'page_banner');
function page_banner() {
    if ( is_page() || is_singular('program') ) {
        global $post;
        echo '<div class="page-banner container">';
        // print banner only if one is selected
        if ( $banner = get_field('page_banner', $post->ID) ) {
            banner_display( $banner, apply_filters('banner_feature', get_field('type'), $post->ID ) );
        }
        echo '</div>';
    } else if ( is_singular('post') ) {
        echo '<header>';
        get_template_part('templates/content', 'feature-top');
        echo '</header>';
    }
}


/*  ==========================================================================
Init custom fields
========================================================================== */

add_action('after_setup_theme', 'banner_custom_fields', 11);
function banner_custom_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;

    register_field_group(array (
        'id' => 'acf_banner-fields',
        'title' => 'Banner Fields',
        'fields' => array (
            array (
                'key' => 'field_52157f5a8a448',
                'label' => 'Slide',
                'name' => 'slide',
                'type' => 'repeater',
                'sub_fields' => array (
                    array (
                        'key' => 'field_52157f758a449',
                        'label' => 'Image',
                        'name' => 'image',
                        'type' => 'image',
                        'column_width' => '',
                        'save_format' => 'object',
                        'preview_size' => 'full',
                        'library' => 'all',
                    ),
                    array (
                        'key' => 'field_52157f928a44a',
                        'label' => 'Image Link URL',
                        'name' => 'image_link_url',
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
                        'key' => 'field_52157fdd8a44b',
                        'label' => 'Caption Heading',
                        'name' => 'caption_heading',
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
                        'key' => 'field_52157ff58a44c',
                        'label' => 'Caption Text',
                        'name' => 'caption_text',
                        'type' => 'textarea',
                        'column_width' => '',
                        'default_value' => '',
                        'placeholder' => '',
                        'maxlength' => '',
                        'formatting' => 'none',
                    ),
                    array (
                        'key' => 'field_521580098a44d',
                        'label' => 'Caption Box URL',
                        'name' => 'caption_box_url',
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
                'button_label' => 'Add Slide',
            ),
            array (
                'key' => 'field_5217c60eddf76',
                'label' => 'Anchor Element',
                'name' => 'anchor_element',
                'type' => 'text',
                'default_value' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
                'formatting' => 'none',
                'maxlength' => '',
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'banner',
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
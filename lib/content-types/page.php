<?php

/*
 * Here we only have definitions of custom fields for the Pages.
 */

//TODO: Fields for banner functionality could be removed as we don't use banners anymore.
add_action('after_setup_theme', 'page_custom_fields', 11);
function page_custom_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('register_field_group'))
		return;

    register_field_group(array (
        'id' => 'acf_page-fields',
        'title' => 'Page Fields',
        'fields' => array (
            array (
                'key' => 'field_5251e3d6835cd',
                'label' => 'Page Banner',
                'name' => 'page_banner',
                'type' => 'post_object',
                'post_type' => array (
                    0 => 'banner',
                ),
                'taxonomy' => array (
                    0 => 'all',
                ),
                'allow_null' => 1,
                'multiple' => 0,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                    'order_no' => 0,
                    'group_no' => 0,
                )
            ),
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'program',
                    'order_no' => 0,
                    'group_no' => 1,
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

// Custom Fileds used for the background image & page intro functionality
add_action('acf/init', 'register_page_intro_fields');
function register_page_intro_fields() {

	// do not do anything if Advanced Custom Fields is not present
	if(!function_exists('acf_add_local_field_group'))
		return;

    acf_add_local_field_group(array(
        'key' => 'group_5be722ebe7225',
        'title' => 'Page Intro Options',
        'fields' => array(
            array(
                'key' => 'field_5be7256d03f70',
                'label' => 'Content',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_5be72d15b6423',
                'label' => 'New page intro',
                'name' => 'new_page_intro',
                'type' => 'true_false',
                'instructions' => 'Enable new page intro with background image instead of the old banner layout?',
                'wrapper' => array(
                    'width' => '40',
                ),
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Yes',
                'ui_off_text' => 'No',
            ),
            array(
                'key' => 'field_5be729e503f76',
                'label' => 'Background color',
                'name' => 'bgc',
                'type' => 'select',
                'instructions' => get_color_selector_description(),
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
                'return_format' => 'value'
            ),
	        array(
		        'key' => 'field_5ae7a36a01f6c',
		        'label' => 'Tag',
		        'name' => 'tag',
		        'type' => 'text',
		        'instructions' => 'A tag displayed above the main headline. White label with colored text.',
		        'wrapper' => array(
			        'width' => '15'
		        )
	        ),
	        array(
		        'key' => 'field_5af7a36f01f61',
		        'label' => 'Special tag',
		        'name' => 'special_tag',
		        'type' => 'text',
		        'instructions' => 'Second tag highlighted in yellow (for discounts etc.)',
		        'wrapper' => array(
			        'width' => '15'
		        )
	        ),
	        array(
                'key' => 'field_5be7236a03f6c',
                'label' => 'Headline',
                'name' => 'headline',
                'type' => 'text',
                'instructions' => 'H1 element of the page. This is the most important headline of a page. This headline should be as SEO friendly as possible.',
                'wrapper' => array(
                    'width' => '30'
                )
            ),
            array(
                'key' => 'field_5be723c803f6d',
                'label' => 'Introduction description',
                'name' => 'description',
                'type' => 'textarea',
                'instructions' => 'Introduction description that follows the H1 headline. Explain what the user can expect in this page and try to encourage him to browse through the page.',
                'wrapper' => array(
                    'width' => '40'
                ),
                'rows' => 4
            ),
	        array(
		        'key' => 'field_5c18f8f39141a',
		        'label' => 'Highlight numbers',
		        'name' => 'numbers',
		        'type' => 'repeater',
		        'instructions' => 'Enter the numbers and their labels that are to be displayed right under the headline.',
		        'max' => 5,
		        'layout' => 'table',
		        'button_label' => 'Add new number & label',
		        'sub_fields' => array(
			        array(
				        'key' => 'field_1c18f8ba9942a',
				        'label' => 'Number',
				        'name' => 'number',
				        'type' => 'text',
				        'instructions' => 'The highlighted number (possibly followed by a + sign or something).',
				        'required' => 1,
				        'conditional_logic' => 0,
				        'wrapper' => array(
					        'width' => '50'
				        )
			        ),
			        array(
				        'key' => 'field_3c18f8ba9942a',
				        'label' => 'Label',
				        'name' => 'label',
				        'type' => 'text',
				        'instructions' => 'Describe the number.',
				        'required' => 1,
				        'conditional_logic' => 0,
				        'wrapper' => array(
					        'width' => '50'
				        )
			        ),
		        ),
	        ),
            array(
                'key' => 'field_5be7263303f71',
                'label' => 'Background Image',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_5be7243503f6e',
                'label' => 'Desktop image',
                'name' => 'img_desktop',
                'type' => 'image',
                'instructions' => 'Background image of this page. Dimensions of this image should be at least around 1900x900px. The size of the image should not exceed 400kB.',
                'wrapper' => array(
                    'width' => '40',
                ),
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => 1900,
                'min_height' => 900,
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '0.5',
                'mime_types' => 'jpg',
            ),
            array(
                'key' => 'field_5be724c703f6f',
                'label' => 'Mobile image',
                'name' => 'img_mobile',
                'type' => 'image',
                'instructions' => 'Background image of this page displayed on mobile devices. Dimensions of this image should be around 800x250px. The size of the image should not exceed 100kB.',
                'wrapper' => array(
                    'width' => '40'
                ),
                'return_format' => 'url',
                'preview_size' => 'medium',
                'library' => 'all',
                'min_width' => 768,
                'min_height' => 250,
                'min_size' => '',
                'max_width' => '',
                'max_height' => '',
                'max_size' => '0.2',
                'mime_types' => 'jpg',
            ),
	        array(
		        'key' => 'field_5be719e303f76',
		        'label' => 'Mobile background align',
		        'name' => 'mobile_align',
		        'type' => 'select',
		        'instructions' => 'Select align mode for the background image on mobile devices. By default image will be centered but if there is an important part of the image on the left/right side you can modify the alignment here.',
		        'wrapper' => array(
			        'width' => '20',
		        ),
		        'choices' => [
		        	'left' => 'Align to left',
		        	'center' => 'Center',
			        'right' => 'Align to right'
		        ],
		        'default_value' => 'center',
		        'allow_null' => 0,
		        'multiple' => 0,
		        'ui' => 1,
		        'ajax' => 0,
		        'return_format' => 'value'
	        ),
            array(
                'key' => 'field_5be7268203f72',
                'label' => 'Icons',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_5be726b403f73',
                'label' => 'Icons',
                'name' => 'icons',
                'type' => 'repeater',
                'instructions' => 'Icons displayed below the headline & introduction.',
                'collapsed' => '',
                'min' => 0,
                'max' => 6,
                'layout' => 'table',
                'button_label' => 'Add icon',
                'sub_fields' => array(
                    array(
                        'key' => 'field_5be7277003f74',
                        'label' => 'Icon',
                        'name' => 'class',
                        'type' => 'select',
                        'instructions' => 'Pick one of the icons below.',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '25'
                        ),
                        'choices' => get_icon_options_array(),
                        'allow_null' => 0,
                        'multiple' => 0,
                        'ui' => 1,
                        'ajax' => 0,
                        'return_format' => 'value'
                    ),
                    array(
                        'key' => 'field_5be7285503f75',
                        'label' => 'Icon label',
                        'name' => 'label',
                        'type' => 'text',
                        'instructions' => 'Add an icon description. It should be 3-4 words at maximum. Use <code>&lt;br&gt;</code> to divide text into multiple lines if needed. You can also replace a space with <code>&amp;nbsp;</code> to separate words with unbreakable space.',
                        'required' => 1,
                        'wrapper' => array(
                            'width' => '25',
                        )
                    ),
                    array(
                        'key' => 'field_5be8a4fffac69',
                        'label' => 'Tooltip',
                        'name' => 'tooltip',
                        'type' => 'text',
                        'instructions' => 'Text displayed when user places mouse cursor on the icon.',
                        'wrapper' => array(
                            'width' => '25'
                        )
                    ),
                    array(
                        'key' => 'field_5be8a53bfac6a',
                        'label' => 'Link',
                        'name' => 'link',
                        'type' => 'text',
                        'instructions' => 'Link where user will be redirected when clicks on the icon.',
                        'wrapper' => array(
                            'width' => '25'
                        )
                    )
                ),
            ),
            array(
                'key' => 'field_5ba7268202f72',
                'label' => 'Button',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_5be8d4fffa263',
                'label' => 'Button text',
                'name' => 'button_text',
                'type' => 'text',
                'instructions' => 'Enter the text displayed on the button. Usually 1-3 words.',
                'wrapper' => array(
                    'width' => '50'
                )
            ),
            array(
                'key' => 'field_5ae8d53b3ac6a',
                'label' => 'Button link',
                'name' => 'button_link',
                'type' => 'text',
                'instructions' => 'Link where the button should lead.',
                'wrapper' => array(
                    'width' => '50'
                )
            ),
            array(
                'key' => 'field_5fe8a537fa389',
                'label' => 'Button position',
                'name' => 'button_bottom',
                'type' => 'true_false',
                'instructions' => 'Should the button be displayed below the icons? Original position is right below the introduction text.',
                'wrapper' => array(
                    'width' => '33'
                ),
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Yes',
                'ui_off_text' => 'No'
            ),
            array(
                'key' => 'field_5fe82ac3fa389',
                'label' => 'Open in new window',
                'name' => 'button_open_blank',
                'type' => 'true_false',
                'instructions' => 'Should the link be opened in a new tab?',
                'wrapper' => array(
                    'width' => '33'
                ),
                'default_value' => 0,
                'ui' => 1,
                'ui_on_text' => 'Yes',
                'ui_off_text' => 'No'
            ),
            array(
                'key' => 'field_5fe82ac3fa389',
                'label' => 'Transparency',
                'name' => 'button_transparent',
                'type' => 'true_false',
                'instructions' => 'Should the button be transparent? This works better with most of the background colors.',
                'wrapper' => array(
                    'width' => '33'
                ),
                'default_value' => 1,
                'ui' => 1,
                'ui_on_text' => 'Yes',
                'ui_off_text' => 'No'
            ),
	        array(
		        'key' => 'field_1be8d4abca261',
		        'label' => 'anec',
		        'name' => 'anec',
		        'type' => 'text',
		        'instructions' => 'Enter the GA tracking category.',
		        'wrapper' => array(
			        'width' => '50'
		        )
	        ),
	        array(
		        'key' => 'field_1be8d4abca262',
		        'label' => 'anea',
		        'name' => 'anea',
		        'type' => 'text',
		        'instructions' => 'Enter the GA tracking action.',
		        'default_value' => 'page-intro-click',
		        'wrapper' => array(
			        'width' => '50'
		        )
	        ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'page',
                ),
            ),
        ),
        'menu_order' => -1,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => 1,
        'description' => 'Page introduction section and background image.',
    ));
}

// reusable function for any place where we would like to select an Icomoon icon
// TODO: would be better to move to /lib/utils.php
function get_icon_options_array() {
    $classes = array('icon-chart13', 'icon-heart-arrow', 'icon-movie', 'icon-people06', 'icon-chart10', 'icon-open', 'icon-people05', 'icon-24-7', 'icon-address', 'icon-apple', 'icon-arrow4-left', 'icon-arrow4-right', 'icon-arrow-left', 'icon-at', 'icon-award05', 'icon-baloon', 'icon-battery', 'icon-bike', 'icon-book', 'icon-briefcase', 'icon-bulb', 'icon-calculator02', 'icon-calendar01', 'icon-camera', 'icon-circled-cross', 'icon-circled-minus', 'icon-circled-plus', 'icon-coffee02', 'icon-cross', 'icon-crown', 'icon-cutlery', 'icon-dolar-sign', 'icon-envelope01', 'icon-euro-sign', 'icon-eye', 'icon-facebook', 'icon-flipchart', 'icon-gears2', 'icon-gift', 'icon-glass-celebration', 'icon-glasses-moustache', 'icon-globe01', 'icon-google-plus', 'icon-heart', 'icon-help', 'icon-house', 'icon-chart03', 'icon-chart05', 'icon-chart09', 'icon-check', 'icon-chicken', 'icon-i', 'icon-instagram', 'icon-key01', 'icon-lady', 'icon-lady02', 'icon-laptop', 'icon-letters', 'icon-lifebuoy', 'icon-like', 'icon-linkedin', 'icon-location', 'icon-man', 'icon-man02', 'icon-map', 'icon-mike', 'icon-music', 'icon-music02', 'icon-network', 'icon-people', 'icon-phone', 'icon-pin', 'icon-pinterest', 'icon-plane', 'icon-play', 'icon-pound-sign', 'icon-pulse', 'icon-quote', 'icon-resize-full2', 'icon-resize-small2', 'icon-share', 'icon-shuffle', 'icon-skype', 'icon-slider1', 'icon-smile', 'icon-sound', 'icon-speech-bubble02', 'icon-squared-cross', 'icon-squared-minus', 'icon-squared-plus', 'icon-star', 'icon-sun', 'icon-tie', 'icon-turn-on', 'icon-twitter', 'icon-user', 'icon-user03', 'icon-user04', 'icon-user05', 'icon-user06', 'icon-user07', 'icon-user08', 'icon-user09', 'icon-video', 'icon-vimeo', 'icon-wallet', 'icon-wifi01', 'icon-wifi02', 'icon-wifi03', 'icon-wine', 'icon-zoom-in', 'icon-zoom-out', 'icon-education', 'icon-user-plus', 'icon-user-circle', 'icon-users', 'icon-prez', 'icon-prez02', 'icon-chart11', 'icon-scales', 'icon-piggy', 'icon-hands', 'icon-pen', 'icon-darts', 'icon-oculares', 'icon-scales02', 'icon-rocket', 'icon-plant', 'icon-acelerate', 'icon-set', 'icon-recycle', 'icon-office', 'icon-coffee03', 'icon-fly', 'icon-zoom', 'icon-pencil', 'icon-chair', 'icon-lamp', 'icon-mouse', 'icon-printer', 'icon-papers', 'icon-supplies', 'icon-file02', 'icon-files', 'icon-award', 'icon-award02', 'icon-bell', 'icon-clock', 'icon-stopwatch', 'icon-clock02', 'icon-calendar02', 'icon-calendar', 'icon-flag', 'icon-svg', 'icon-zoom-analysis', 'icon-chart12', 'icon-arrow-right', 'icon-circles', 'icon-zoom-people', 'icon-people02', 'icon-people03', 'icon-people04', 'icon-atom', 'icon-bulb03', 'icon-factory', 'icon-file05', 'icon-chart032', 'icon-hubert', 'icon-key02', 'icon-lab', 'icon-man03', 'icon-moon', 'icon-rocket02', 'icon-parking', 'icon-screw-01', 'icon-tv', 'icon-diamond', 'icon-download', 'icon-untitled', 'icon-box', 'icon-computer', 'icon-mail', 'icon-mail02', 'icon-circled-play', 'icon-connect-01', 'icon-enable', 'icon-mute');
    $result = [];
    foreach ($classes as $class) {
        $result[$class] = "<i class=\"$class\"></i> = $class";
    }
    return $result;
}

// include Icomoon font into administration so icons can be viewed in admin
// TODO: would be better to move to /lib/scripts.php
function add_icons_css() {
  wp_enqueue_style('admin-custom-icons', get_stylesheet_directory_uri().'/assets/css/icon-font.php');
}
add_action('admin_enqueue_scripts', 'add_icons_css');

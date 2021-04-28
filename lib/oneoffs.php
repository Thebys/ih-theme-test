<?php
/**
 *  One time use scripts that are mostly used for maintenance.
 */

// function will trigger deletion of passed events
// use with shortcode or something.
// EDIT DATE THRESHOLD & UNCOMMENT DELETE COMMAND
function delete_events() {

	$args = array(
		'post_type' => 'tribe_events',
		'post_status' => 'any',
		'meta_key' => '_EventStartDate',
		'orderby' => 'meta_value',
		'meta_query'     => array(
			array(
				'key'     => '_EventStartDate',
				'value'   => (new DateTime("2017-01-01 00:00"))->format(DateTime::ATOM),
				'compare' => '<=',
			),
		),
		'order' => 'ASC',
		'suppress_filters' => true,
		'posts_per_page' => -1
	);

	$out = '';
	$query = get_posts(  $args );
	foreach($query as $post) {
		$out .= tribe_get_start_date($post, true) . " " . $post->post_title . '<br>';
		//wp_delete_post($post->ID, true);
	}
	return $out;
}

//TODO: The rest of this file can be most likely dropped. It was used for automatic conversion of data from the old page builder to Elementor
//add_action('inside_main_start', 'transform_meta_to_elementor');
//add_action('inside_main_start', 'transfer_pages');
function transfer_pages() {
	global $post;
	$args = [
		'post_type' => 'page',
		'posts_per_page' => -1,
		'post_status' => 'any',
		'meta_key' => '_cfct_build_data_backup',
		'meta_compare' => 'NOT EXISTS',
	];

	$posts = get_posts($args);

	var_dump(count($posts));

	$i = 0;
	foreach ($posts as $post) {
		setup_postdata($post);
		var_dump($post->post_title);
		transform_meta_to_elementor();
		$i++;
		if($i > 30)
			break;
	}

	wp_reset_postdata();
}

function transform_meta_to_elementor() {
	global $post;

	$car_data = get_post_meta($post->ID, '_cfct_build_data', true);
	if(!$car_data) {
		update_post_meta($post->ID, '_cfct_build_data_backup', esc_sql('empty'));
		return;
	}

	fwrite(fopen('metadata-original', 'w'), print_r($car_data, true));

	$res = [];

	foreach ($car_data['template']['rows'] as $row_id => $row) {
		$res[] = create_section($row, $car_data);
	}
	fwrite(fopen('metadata-transformed', 'w'), json_encode($res));

	update_post_meta($post->ID, '_elementor_data', esc_sql(json_encode($res)));
	update_post_meta($post->ID, '_elementor_edit_mode', 'builder');
	update_post_meta($post->ID, '_elementor_template_type', 'post');
	update_post_meta($post->ID, '_elementor_version', '2.5.13');
	update_post_meta($post->ID, '_elementor_page_settings', esc_sql('a:12:{s:21:"background_color_stop";a:3:{s:4:"unit";s:1:"%";s:4:"size";i:0;s:5:"sizes";a:0:{}}s:23:"background_color_b_stop";a:3:{s:4:"unit";s:1:"%";s:4:"size";i:100;s:5:"sizes";a:0:{}}s:25:"background_gradient_angle";a:3:{s:4:"unit";s:3:"deg";s:4:"size";i:180;s:5:"sizes";a:0:{}}s:15:"background_xpos";a:3:{s:4:"unit";s:2:"px";s:4:"size";i:0;s:5:"sizes";a:0:{}}s:22:"background_xpos_tablet";a:3:{s:4:"unit";s:2:"px";s:4:"size";i:0;s:5:"sizes";a:0:{}}s:22:"background_xpos_mobile";a:3:{s:4:"unit";s:2:"px";s:4:"size";i:0;s:5:"sizes";a:0:{}}s:15:"background_ypos";a:3:{s:4:"unit";s:2:"px";s:4:"size";i:0;s:5:"sizes";a:0:{}}s:22:"background_ypos_tablet";a:3:{s:4:"unit";s:2:"px";s:4:"size";i:0;s:5:"sizes";a:0:{}}s:22:"background_ypos_mobile";a:3:{s:4:"unit";s:2:"px";s:4:"size";i:0;s:5:"sizes";a:0:{}}s:19:"background_bg_width";a:3:{s:4:"unit";s:1:"%";s:4:"size";i:100;s:5:"sizes";a:0:{}}s:26:"background_bg_width_tablet";a:3:{s:4:"unit";s:2:"px";s:4:"size";s:0:"";s:5:"sizes";a:0:{}}s:26:"background_bg_width_mobile";a:3:{s:4:"unit";s:2:"px";s:4:"size";s:0:"";s:5:"sizes";a:0:{}}}'));
	$cfct_backup = get_post_meta($post->ID, '_cfct_build_data');
	if($cfct_backup)
		update_post_meta($post->ID, '_cfct_build_data_backup', esc_sql($cfct_backup));
	delete_post_meta($post->ID, '_cfct_build_data');
}

function create_section($row, $data) {
	$id = $row['guid'];
	$section = array(
		'id' => create_id($id),
		'elType' => 'section',
		'settings' => [
			'css_classes' => ''
		],
		'elements' => get_columns($row['blocks'], $data, get_row_css($id, $data)),
		'isInner' => false
	);
	$section = maybe_hide_section($section, $row);
	return $section;
}

function get_columns($blocks, $data, $classes) {
	$size = floor(100 / count($blocks));
	$columns = [];
	foreach ($blocks as $block) {
		$columns[] = create_column($block, $size, $data, $classes);
	}
	return $columns;
}

function create_column($block, $size_int, $data, $classes) {
	return array(
		'id' => create_id($block['guid']),
		'elType' => 'column',
		'settings' => [
			'_column_size' => $size_int,
			'css_classes' => $block['class'] . ' ' . $classes
		],
		'elements' => get_elements($block['guid'], $data),
		'isInner' => false
	);
}

function get_elements($block_id, $data) {
	if(!isset($data['data']['blocks'][ $block_id ]))
		return [];
	$module_ids = $data['data']['blocks'][ $block_id ];

	$elements = [];
	foreach ($module_ids as $id) {
		$el = create_element( $data['data']['modules'][ $id ], $data );
		if(!empty($el))
			$elements[] = $el;
	}
	return $elements;
}

function create_element($module, $data) {
	global $post;
	switch ($module['module_type']) {
		case 'cfct_module_html':
			return create_html_element($module, $data);
		case 'cfct_module_shortcode':
			return create_shortcode_element($module, $data);
		case 'cfct-widget-module-gform_widget':
			return create_gform_element($module, $data);
		case 'cfct_module_loop':
			return create_loop_widget($module, $data);
		default:
			error_log('[TRANS_WARN] Unknown module found. Page ' . $post->post_title . '. Module type ' . $module['module_type']);
			return [];
	}
}

function create_loop_widget($module, $data) {
	$post_type = $module['cfct-module-loop-post_type'][0];
	switch ($post_type) {
		case 'team':
			$posts_layout = 'templates/content-team-new';
			break;
		case 'space':
			$posts_layout = 'templates/content-space';
			break;
		case 'coffee_break':
			$posts_layout = 'templates/content-coffeebreak';
			break;
		default:
			$posts_layout = 'templates/content-team';
	}
	$el = create_widget($data, $module, 'ih_elementor_loop');
	$el['settings']['post_type'] = $post_type;
	$el['settings']['posts_layout'] = $posts_layout;
	$el['settings']['post_count'] = $module['cfct-module-loop-item_count'];
	$el['settings']['container_classes'] = $el['settings']['_css_classes'];
	$el['settings']['_css_classes'] = '';
	$el['settings']['taxonomy_combine'] = strtolower($module['cfct-module-loop-relation']);


	switch ($module['cfct-module-loop-item_offset']) {
		case -1:
			$el['settings']['post_order_by'] = 'rand';
			break;
		case -2:
			$el['settings']['post_order_by'] = 'title';
			$el['settings']['post_order'] = 'asc';
			break;
		case -3:
			$el['settings']['posts_layout'] = 'templates/content-homepage-post';
			break;
		case -4:
			$el['settings']['post_order_by'] = 'date';
			$el['settings']['post_order'] = 'asc';
			break;
	}

	$filters = [];
	if(isset($module['cfct-module-loop-tax_input']) && is_array($module['cfct-module-loop-tax_input'])) {
		foreach ($module['cfct-module-loop-tax_input'] as $tax_name => $tax_values) {
			foreach ($tax_values as $value) {
				$filters[] = [
					'taxonomy_name' => $tax_name,
					'taxonomy_value' => get_term($value, $tax_name)->slug,
					'_id' => substr(md5( rand() . uniqid() ), 0, 7)
				];
			}
		}
	}

	if(count($filters) > 0)
		$el['settings']['filters'] = $filters;

	return $el;
}

function create_gform_element($module, $data) {
	$el = create_widget($data, $module, 'shortcode');
	$shortcode_content = sprintf(
		"[gravityform id=\"%s\" title=\"false\" description=\"false\" ajax=\"false\" tabindex=\"%s\"]",
		$module['widget']['form_id'],
		$module['widget']['tabindex']
	);
	$el['settings'] = [ 'shortcode' => $shortcode_content ];
	return $el;
}

function create_html_element($module, $data) {
	$el = create_widget($data, $module, 'html');
	$html = str_replace('<img src=', '<img data-src=', $module['cfct-html-content']);
	$el['settings']['html'] = $html;
	return $el;
}

function create_shortcode_element($module, $data) {
	$el = create_widget($data, $module, 'shortcode');
	$el['settings']['shortcode'] = $module['cfct-shortcode-content'];
	return $el;
}

function create_widget($data, $module, $widgetType, $elements = [], $elType = 'widget') {
	$widget = array(
		'id' => create_id($module['module_id']),
		'elType' => $elType,
		'settings' => [
			'shortcode' => '',
			'html' => '',
			'hide_desktop' => $module['render'] === 0 ? 'hidden-desktop' : '',
			'hide_tablet' => $module['render'] === 0 ? 'hidden-tablet' : '',
			'hide_mobile' => $module['render'] === 0 ? 'hidden-phone' : '',
			'_css_classes' => get_module_css($module['module_id'], $data)
		],
		'elements' => $elements,
		'widgetType' => $widgetType
	);
	return $widget;
}

function create_id($original_id) {
	return substr($original_id, -7);
}

function get_row_css($id, $data) {
	return get_css($id, $data, 'row', 'row-custom-classes', 'custom-classes');
}

function get_module_css($id, $data) {
	return get_css($id, $data, 'module', 'custom-classes', 'custom-css');
}

function get_css($id, $data, $tag, $ar1, $ar2) {
	$classes = $data[$tag . '-options'][$id][$ar1][$ar2];

	if($classes == null)
		return '';

	return join(' ', $classes);
}

function maybe_hide_section($section, $row) {
	if(isset($row['render']) && $row['render'] != 1) {
		var_dump($row['render']);
		$section['settings']['hide_desktop'] = 'hidden-desktop';
		$section['settings']['hide_tablet'] = 'hidden-tablet';
		$section['settings']['hide_mobile'] = 'hidden-phone';
	}

	return $section;
}
<?php
/**
 * Functionality for job opportunities.
 *
 * TODO: Deprecated. Can be removed.
 */

add_shortcode( 'job-opportunities', 'list_job_opportunities' );
function list_job_opportunities($atts) {
 	$ops = get_field('job_opportunities');
 	$email = $atts['email'];
 	$noJobs = $atts['no-jobs-text'];
 	if(!$ops or count($ops) < 1)
 		return sprintf( $noJobs, "<a href=\"mailto:$email\" target=\"_blank\">$email</a>.");

 	$btnText = __('More information','roots');
 	$out = "";
 	foreach ($ops as $key => $op) {
 		$title = $op['title'];
 		$link = $op['link'];
 		$out .= "
 		<div class=\"free-position\">
			<h3>$title</h3>
			<a class=\"page-button-new\" href=\"$link\" target=\"_blank\" anec=\"hledame\" anea=\"opportunity-click\">$btnText</a>
		</div>";
 	}
 	return $out;
}

/*  ==========================================================================
Init custom fields for job opportunities
========================================================================== */
add_action('after_setup_theme', 'job_opportunities_custom_fields', 11);
function job_opportunities_custom_fields() {
	if(function_exists("register_field_group")) {
		register_field_group(array (
			'id' => 'acf_job_opportunities_fields',
			'key' => 'group_job_opportunities_fields',
			'title' => 'Open Job Opportunities',
			'fields' => array (
				array (
					'key' => 'field_job_opportunities',
					'label' => '',
					'name' => 'job_opportunities',
					'type' => 'repeater',
					'button_label' => __('Add new opportunity','roots'),
					'sub_fields' => array (
						array (
							'key' => 'title',
							'label' => 'Job title',
							'name' => 'title',
							'type' => 'text',
							'required' => 1,
							'column_width' => 50,
							'formatting' => 'none',
							'instructions' => __("Remember to keep names consistent. Ex.: Finance Manager pro Impact Hub Praha, Relationship Manager pro inovační část Impact Hubu", 'roots')
						),
						array (
							'key' => 'link',
							'label' => 'Link to detail',
							'name' => 'link',
							'type' => 'text',
							'required' => 1,
							'column_width' => 50,
							'formatting' => 'none',
							'instructions' => __("Enter link to page with the job opportunity. Copy the link from the address bar of your web browser. Link should begin with http:// or https://.")
						)
					)
				)
			),
			'location' => array (
				array (
					array (
						'param' => 'page_template',
						'operator' => '==',
						'value' => 'page-jobs.php'
					)
				),
			),
			'options' => array (
				'position' => 'normal',
				'layout' => 'default',
				'hide_on_screen' => array ()
			),
			'menu_order' => 0
		));
	}
}
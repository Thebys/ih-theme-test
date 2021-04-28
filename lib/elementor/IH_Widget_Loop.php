<?php
/**
 * Widget that renders posts of any post type using predefined templates.
 */

class IH_Widget_Loop extends \Elementor\Widget_Base {

	protected $post_type;
	protected $count;
	protected $order_by;
	protected $order;
	protected $taxonomy_filters = [];
	protected $taxonomy_filters_mode;
	protected $template;
	protected $classes;

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_loop';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Loop', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-repeat';
	}

	/**
	 * Get widget categories.
	 */
	public function get_categories() {
		return [ 'impacthub' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function _register_controls() {

		$this->start_controls_section(
			'posts_section',
			[
				'label' => __( 'Posts settings', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'post_type',
			[
				'label' => __( 'Post type', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->_get_post_type_options(),
				'default' => 'post'
			]
		);

		$this->add_control(
			'post_count',
			[
				'label' => __( 'Number of posts', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'placeholder' => __( 'Any number of posts. -1 represents all.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => -1
			]
		);

		$this->add_control(
			'post_order_by',
			[
				'label' => __( 'Posts order by', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'date' => 'Date created',
					'title' => 'Post title',
					'modified' => 'Last modified',
					'rand' => 'Random'
				],
				'default' => 'date'
			]
		);

		$this->add_control(
			'post_order',
			[
				'label' => __( 'Posts order', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'desc' => 'DESC',
					'asc' => 'ASC'
				],
				'default' => 'desc'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'filters_section',
			[
				'label' => __( 'Post filters', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'taxonomy_combine',
			[
				'label' => __( 'Filters mode', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'AND' => 'AND',
					'OR' => 'OR'
				],
				'default' => 'OR'
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'taxonomy_name',
			[
				'label' => __( 'Taxonomy slug', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'eg. tribe_events_cat', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$repeater->add_control(
			'taxonomy_value',
			[
				'label' => __( 'Taxonomy value', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'eg. event-marketing-academy', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$this->add_control(
			'filters',
			[
				'label' => __( 'Taxonomy filters', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls()
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'layout_section',
			[
				'label' => __( 'Layout', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'posts_layout',
			[
				'label' => __( 'Posts layout', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'templates/content-story-card' => 'Story Card',
					'templates/content-benefit' => 'Benefit',
					'templates/content-coffeebreak' => 'Coffee break',
					'templates/content-summary' => 'Default',
					'templates/content-team-new' => 'Team',
					'templates/content-space' => 'Space',
					'templates/content-team' => 'Toggle square',
				],
				'default' => 'template/content-summary'
			]
		);

		$this->add_control(
			'container_classes',
			[
				'label' => __( 'Wrapper CSS classes', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'input_type' => 'text',
				'default' => ''
			]
		);



	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		global $post;

		$this->_get_render_settings();

		$posts = get_posts($this->_get_query_args());

		printf("<div class=\"ih-widget-loop clearfix flex-boxes %s\">", $this->classes);

		foreach ($posts as $post) {
			setup_postdata($post);
			get_template_part($this->template);
		}

		echo "</div>";

		wp_reset_postdata();
	}

	/*
	 * Parses arguments from member variables into an arguments array supported by get_posts() function
	 */
	protected function _get_query_args() {
		$args = [];
		$args['suppress_filters'] = false;
		$args['post_type'] = $this->post_type;
		$args['posts_per_page'] = $this->count;
		$args['orderby'] = $this->order_by;
		$args['order'] = $this->order;
		$args['tax_query'] = [];

		foreach ($this->taxonomy_filters as $tax_slug => $tax_value) {
			if ($tax_slug == '' || $tax_value == '')
				continue;

			$args['tax_query'][] = [
				'taxonomy' => $tax_slug,
				'field'    => 'slug',
				'terms'    => $tax_value,
			];
		}

		if(count($args['tax_query']) > 1)
			$args['tax_query']['relation'] = $this->taxonomy_filters_mode;

		return $args;
	}

	/*
	 * Sets the arguments supplied via the Elementor user interface as member variables of this object.
	 */
	protected function _get_render_settings() {
		$settings = $this->get_settings_for_display();

		$this->post_type = $settings['post_type'];
		$this->count = $settings['post_count'];
		$this->order_by = $settings['post_order_by'];
		$this->order = $settings['post_order'];
		$this->template = $settings['posts_layout'];
		$this->classes = $settings['container_classes'];
		$this->taxonomy_filters_mode = $settings['taxonomy_combine'];

		foreach ($settings['filters'] as $filter) {
			$this->taxonomy_filters[$filter['taxonomy_name']] = $filter['taxonomy_value'];
		}
	}

	/*
	 * Creates options for the select box where user picks which post type to display.
	 */
	protected function _get_post_type_options() {
		$post_types = get_post_types(['public' => true], 'objects');
		$options = [];
		foreach ($post_types as $type) {
			$options[$type->name] = $type->label;
		}
		return $options;
	}

}
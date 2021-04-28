<?php
/**
 * Widget that renders a fancy list item with a title, description and a button.
 */

class IH_Widget_ListItem extends \Elementor\Widget_Base {

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_list_item';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'List Item', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-list-ul';
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
			'content_section',
			[
				'label' => __( 'Content', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'name',
			[
				'label' => __( 'Title', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'description',
			[
				'label' => __( 'Description', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
			]
		);

		$this->add_control(
			'tags',
			[
				'label' => __( 'Tags', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'One or two word long tags to be displayed below title. If more tags are needed, separate by comma.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'button_text',
			[
				'label' => __( 'Button text', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'url',
			[
				'label' => __( 'Button link', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::URL,
				'description' => __( 'Link where the button leads.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'appearance_section',
			[
				'label' => __( 'Appearance', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'top_border',
			[
				'label' => __( 'Add border to the top of the item?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'This should be usually disabled only for the first item in a list.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => 'yes'
			]
		);

		$this->add_control(
			'disabled',
			[
				'label' => __( 'Disable list item?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Use this if you want the item to look unavailable. Button clicks will be disabled.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => 'no'
			]
		);

		$this->add_control(
			'brand_color',
			[
				'label' => __( 'Color', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'One of the brand color names (e.g. yellow, midnight).', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'color',
			[
				'label' => __( 'Custom Color', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'description' => __( 'Select a color if you don\'t want to use a predefined one (not recommended).', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'progress',
			[
				'label' => __( 'Circle shape', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'min' => 0,
				'max' => 100,
				'step' => 1,
				'description' => __( 'Enter percentage of colored circle that should be visible (0-100).', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tracking_section',
			[
				'label' => __( 'Tracking', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'anec',
			[
				'label' => __( 'anec', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Google Analytics event category parameter (usually page specific).', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'anea',
			[
				'label' => __( 'anea', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Google Analytics event action parameter (usually item specific).', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$args = $this->get_settings_for_display();
		$args['url'] = $args['url']['url'];
		$args['disabled'] = $args['disabled'] == 'yes' ? true : false;
		$args['top_border'] = $args['top_border'] == 'yes' ? true : false;

		echo list_item_shortcode($args);
	}
}

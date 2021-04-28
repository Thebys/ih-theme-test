<?php
/**
 * Widget that renders headline and intro paragraph for a section
 */

class IH_Widget_PageButton extends \Elementor\Widget_Base {

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_page_button';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Page Button', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-hand-pointer';
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
			'text_section',
			[
				'label' => __( 'Text', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'text',
			[
				'label' => __( 'Button text', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'link_section',
			[
				'label' => __( 'Link', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'link',
			[
				'label' => __( 'Destination', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::URL,
			]
		);

		$this->add_control(
			'modal',
			[
				'label' => __( 'Opens a modal?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'default' => ''
			]
		);

		$this->add_control(
			'anec',
			[
				'label' => __( 'anec', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Google Analytics event category - used to specify what page is the event related to.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->add_control(
			'anea',
			[
				'label' => __( 'anea', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Google Analytics event action - used to specify what action in the category (e.g. page) occurred.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'style_section',
			[
				'label' => __( 'Style', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'style',
			[
				'label' => __( 'Style', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'description' => __('Do you want to modify style of the button? You can select one or more modifiers.', IH_Elementor_Extension::TEXT_DOMAIN),
				'options' => [
					'transparent' => 'Transparent (transparent, white on hover)',
					'transparent-colored' => 'Transparent and full (transparent, colored on hover)',
					'white' => 'White (white, transparent on hover)',
					'light' => 'Light (white, colored on hover)',
					'centered' => 'Centered',
					'full-width' => 'Full width'
				],
				'multiple' => true
			]
		);

		$this->add_control(
			'size',
			[
				'label' => __( 'Size', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description' => __('Do you want to modify size of the button?', IH_Elementor_Extension::TEXT_DOMAIN),
				'options' => [
					'' => 'Default',
					'narrow' => 'Narrow (original height)',
					'small' => 'Small (reduce height and width)'
				]
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => __( 'Color', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description' => __('Do you want to change color of the button\'s text?', IH_Elementor_Extension::TEXT_DOMAIN),
				'options' => array_merge(['' => 'Default'], get_color_class_options()) ,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$args = $this->get_settings_for_display();
		$args['elementor_widget'] = $this;

		$this->add_inline_editing_attributes( 'text', 'basic' );

		echo shortcode_page_button($args);
	}
}

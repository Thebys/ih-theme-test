<?php
/**
 * Widget that renders headline and intro paragraph for a section
 */

class IH_Widget_SectionHeadline extends \Elementor\Widget_Base {

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_section_headline';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Section Headline', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-heading';
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
			'heading',
			[
				'label' => __( 'Headline', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'headline_text',
			[
				'label' => __( 'Text', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::CODE,
				'rows' => 2,
				'default' => __( 'This is a headline', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'headline_level',
			[
				'label' => __( 'Level', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description' => __('One H1 heading per page. Then follow structure as in a document. 
				Subsections have H2. Subsections of subsections would have H3 etc.', IH_Elementor_Extension::TEXT_DOMAIN),
				'options' => [
					'h1' => 'H1',
					'h2' => 'H2',
					'h3' => 'H3',
					'h4' => 'H4'
				],
				'default' => 'h2'
			]
		);

		$this->add_control(
			'headline_size',
			[
				'label' => __( 'Size', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description' => __('Headline text size.', IH_Elementor_Extension::TEXT_DOMAIN),
				'options' => [
					'default' => 'Large',
					'smaller' => 'Medium',
					'smallest' => 'Small'
				],
				'default' => 'default'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'intro',
			[
				'label' => __( 'Introduction', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'intro_text',
			[
				'label' => __( 'Text', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::CODE,
				'rows' => 10,
				'default' => __( 'This is an introduction text displayed below the headline.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'design',
			[
				'label' => __( 'Design', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'fullwidth',
			[
				'label' => __( 'Fullwidth', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'If not checked, element will have \'contained-row\' class thus it won\' be fullwidth.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => __( 'Top & bottom padding', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Add top & bottom padding of 50px to the headline? Use elementor options to add different padding.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => 'yes'
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

		$this->add_inline_editing_attributes( 'headline_text', 'basic' );
		$this->add_inline_editing_attributes( 'intro_text', 'advanced' );

		echo shortcode_section_headline($args);
	}
}

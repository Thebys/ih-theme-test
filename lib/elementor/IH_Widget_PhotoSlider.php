<?php
/**
 * Widget that renders a photo slider
 */

class IH_Widget_PhotoSlider extends \Elementor\Widget_Base {

	protected $sliderID;
	protected $anec;
	protected $arrowClass;

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_photo_slider';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Photo Slider', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-images';
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
			'slider',
			[
				'label' => __( 'Slider', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'slider_id',
			[
				'label' => __( 'Select slider', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'options' => $this->_get_sliders()
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'attributes',
			[
				'label' => __( 'Attributes', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'anec',
			[
				'label' => __( 'anec', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Enter anec parameter for GA click measuring.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'usually unique for a page', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$this->add_control(
			'arrow_class',
			[
				'label' => __( 'Arrows classes', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Enter CSS classes that will be added to the slider arrows.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'eg. bg-yellow', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {

		$this->_get_render_settings();

		echo photo_slider([
			'id' => $this->sliderID,
			'anec' => $this->anec,
			'arrow_class' => $this->arrowClass
		]);
	}

	/*
	 * Sets the arguments supplied via the Elementor user interface as member variables of this object.
	 */
	protected function _get_render_settings() {
		$settings = $this->get_settings_for_display();

		$this->sliderID = $settings['slider_id'];
		$this->anec = $settings['anec'];
		$this->arrowClass = $settings['arrow_class'];
	}

	/*
	 * Creates options for the select box that enables user to select the Photo Slider to display.
	 */
	protected function _get_sliders() {
		$args = [
			'post_type' => 'photo_slider',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'suppress_filters' => false
		];

		/**
		 * @var $sliders WP_Post[]
		 */
		$sliders = get_posts($args);

		$options = [];
		foreach ($sliders as $slider) {
			$options[$slider->ID] = $slider->post_title;
		}

		return $options;
	}

}
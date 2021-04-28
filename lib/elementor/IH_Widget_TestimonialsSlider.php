<?php
/**
 * Widget that renders a photo slider
 */

class IH_Widget_TestimonialsSlider extends \Elementor\Widget_Base {

	protected $category;
	protected $count;
	protected $usePhoto;
	protected $anec;
	protected $arrowBackground;
	protected $arrowColor;

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_testimonials_slider';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Testimonials Slider', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-user-friends';
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
			'content',
			[
				'label' => __( 'Content', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'category',
			[
				'label' => __( 'Testimonials category', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'description' => __( 'Pick a  testimonials category from which the testimonials will be chosen.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'options' => $this->_get_categories()
			]
		);

		$this->add_control(
			'count',
			[
				'label' => __( 'Count', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'description' => __( 'Enter number of most recent testimonials to be displayed. They will be sorted based on their creation date.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => 4
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'appearance',
			[
				'label' => __( 'Appearance', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'use_photo',
			[
				'label' => __( 'Display photos?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Should the testimonials contain photos? The thumbnail images are used if yes.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => ''
			]
		);

		$this->add_control(
			'arrow_background',
			[
				'label' => __( 'Arrows background', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Enter one of bg-color classes to change the background of slider arrows.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'default: bg-light-gray'
			]
		);

		$this->add_control(
			'arrow_color',
			[
				'label' => __( 'Arrows color', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Enter one of c-color classes to change the color of slider arrows.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'default: c-gray'
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tracking',
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

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {

		$this->_get_render_settings();

		echo testimonials_slider([
			'category' => $this->category,
			'anec' => $this->anec,
			'count' => $this->count,
			'photo' => $this->usePhoto,
			'arrow_background' => $this->arrowBackground,
			'arrow_color' => $this->arrowColor
		]);
	}

	/*
	 * Sets the arguments supplied via the Elementor user interface as member variables of this object.
	 */
	protected function _get_render_settings() {
		$settings = $this->get_settings_for_display();

		$this->category = $settings['category'];
		$this->count = $settings['count'];
		$this->anec = $settings['anec'];
		$this->usePhoto = ($settings['use_photo'] == 'yes');
		$this->arrowBackground = $settings['arrow_background'] ? $settings['arrow_background'] : null;
		$this->arrowColor = $settings['arrow_color'] ? $settings['arrow_color'] : null;
	}

	/*
	 * Creates options for the select box that enables user to select the Testimonials category to display.
	 */
	protected function _get_categories() {
		$args = [
			'taxonomy' => 'testimonial_categories',
			'hide_empty' => true
		];

		/**
		 * @var $cats WP_Term[]
		 */
		$cats = get_terms($args);

		$options = [];
		foreach ($cats as $cat) {
			$options[$cat->slug] = $cat->name;
		}

		return $options;
	}

}
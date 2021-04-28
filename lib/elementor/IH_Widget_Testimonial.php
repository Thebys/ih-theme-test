<?php
/**
 * Widget that renders a photo slider
 */

class IH_Widget_Testimonial extends \Elementor\Widget_Base {

	protected $testimonialID;
	protected $usePhoto;
	protected $anec;
	protected $buttonClass;
	protected $wrapperClass;

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_testimonial';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Single Testimonial', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-user-tie';
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
			'testimonial_id',
			[
				'label' => __( 'Select a testimonial', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SELECT2,
				'options' => $this->_get_testimonials()
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
			'use_photo',
			[
				'label' => __( 'Display photos?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Should the testimonials contain photos? The thumbnail images are used if yes.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => ''
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
			'button_class',
			[
				'label' => __( 'C2A button classes', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Add CSS classes to the call to action button.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'eg. transparent, narrow, light', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$this->add_control(
			'wrapper_class',
			[
				'label' => __( 'Wrapper classes', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Add CSS classes to the outer wrapper element (might be better to use Elementor\'s default CSS classes field.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => __( 'eg. contained-row, bg-mint', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {

		$this->_get_render_settings();

		echo testimonial([
			'id' => $this->testimonialID,
			'anec' => $this->anec,
			'button_class' => $this->buttonClass,
			'wrapper_class' => $this->wrapperClass,
			'photo' => $this->usePhoto
		]);
	}

	/*
	 * Sets the arguments supplied via the Elementor user interface as member variables of this object.
	 */
	protected function _get_render_settings() {
		$settings = $this->get_settings_for_display();

		$this->testimonialID = $settings['testimonial_id'];
		$this->anec = $settings['anec'];
		$this->buttonClass = $settings['button_class'];
		$this->wrapperClass = $settings['wrapper_class'];
		$this->usePhoto = ($settings['use_photo'] == 'yes');
	}

	/*
	 * Creates options for the select box that enables user to select the Testimonial to display.
	 */
	protected function _get_testimonials() {
		$args = [
			'post_type' => 'testimonial',
			'posts_per_page' => -1,
			'post_status' => 'publish',
			'suppress_filters' => false
		];

		/**
		 * @var $testimonials WP_Post[]
		 */
		$testimonials = get_posts($args);

		$options = [];
		foreach ($testimonials as $testimonial) {
			$options[$testimonial->ID] = $testimonial->post_title;
		}

		return $options;
	}

}
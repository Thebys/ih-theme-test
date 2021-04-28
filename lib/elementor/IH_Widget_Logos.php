<?php
/**
 * Widget to render logos of partners or other projects/companies. Supports 3, 4 and 6 columns layout.
 */

class IH_Widget_Logos extends \Elementor\Widget_Base {

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_logos';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Partner Logos', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-copyright';
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
			'logos_content',
			[
				'label' => __( 'Content', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'logo_title',
			[
				'label' => __( 'Title', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Company/partner name. Will be used as image title attribute.', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$repeater->add_control(
			'logo_image',
			[
				'label' => __( 'Logo image', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __( 'Expected aspect ratio is 3x2. All logos in one section should have similar empty space around them. A transparent logo is expected.', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$repeater->add_control(
			'logo_opacity',
			[
				'label' => __( 'Opacity', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::NUMBER,
				'description' => __( 'Opacity of the image. Make it lower to fade out the logo a bit.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'min' => 0,
				'max' => 1,
				'step' => 0.05
			]
		);

		$repeater->add_control(
			'logo_link',
			[
				'label' => __( 'Link', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::URL,
				'description' => __( 'Enter URL where should be the user redirected on logo click.', IH_Elementor_Extension::TEXT_DOMAIN ),
			]
		);

		$repeater->add_control(
			'anea',
			[
				'label' => __( 'anea', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Google Analytics event action parameter for single logo. Overrides the one set for all logos.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'logos',
			[
				'label' => __( 'Logos', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'logo_opacity' => 1
					]
				],
				'title_field' => '{{{ logo_title }}}',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'appearance',
			[
				'label' => __( 'Appearance', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'columns',
			[
				'label' => __( 'Columns layout', 'plugin-domain' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '4',
				'description' => __( 'Select how many columns should be displayed.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'options' => [
					3 => 3,
					4 => 4,
					6 => 6
				],
			]
		);

		$this->add_control(
			'hr',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'grayscale',
			[
				'label' => __( 'Apply grayscale filter?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'If you enable this you can upload original colors as grayscale filter will be applied automatically.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => 'yes'
			]
		);

		$this->add_control(
			'hover',
			[
				'label' => __( 'Original colors on hover?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'If you enable this grayscale filter will disappear on hover.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => 'no'
			]
		);

		$this->add_control(
			'new_tab',
			[
				'label' => __( 'Open links in new tab?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'If you enable this all links will open in a new tab.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => 'yes'
			]
		);

		$this->add_control(
			'hr2',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'padding',
			[
				'label' => __( 'Padding', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'description' => __( 'Configure custom padding for all logos.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'tracking',
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
				'description' => __( 'Google Analytics event action parameter for all logos.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$args = $this->get_settings_for_display();
		$args['grayscale'] = $args['grayscale'] == 'yes' ? true : false;
		$args['hover'] = $args['hover'] == 'yes' ? true : false;
		$args['new_tab'] = $args['new_tab'] == 'yes' ? true : false;

		for($i = 0; $i < count($args['logos']); $i++) {
			$args['logos'][$i]['grayscale'] = $args['grayscale'];
			$args['logos'][$i]['hover'] = $args['hover'];
			$args['logos'][$i]['new_tab'] = $args['new_tab'];
			$args['logos'][$i]['anec'] = $args['anec'];
			$args['logos'][$i]['padding'] = $args['padding'];
			$args['logos'][$i]['columns'] = $args['columns'];
			$args['logos'][$i]['logo_image'] = $args['logos'][$i]['logo_image']['url'];
			$args['logos'][$i]['logo_link'] = $args['logos'][$i]['logo_link']['url'];
			$args['logos'][$i]['anea'] = $args['logos'][$i]['anea'] ? $args['logos'][$i]['anea'] : $args['anea'];;

			echo partner_logo($args['logos'][$i]);
		}
	}
}

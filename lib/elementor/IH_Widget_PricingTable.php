<?php
/**
 * Widget that renders list of coworking tariffs and allows to configure featured tariff and hide
 * selected tariffs from the view so it can be used on multiple sub/pages.
 */

class IH_Widget_PricingTable extends \Elementor\Widget_Base {

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_pricing_table';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Pricing Table', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-credit-card';
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
			'head',
			[
				'label' => __( 'Table head', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'head_title',
			[
				'label' => __( 'Title', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Product\'s name.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'head_top_note',
			[
				'label' => __( 'Top note', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Text which is gonna be placed right under the title.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'head_bottom_note',
			[
				'label' => __( 'Bottom note', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Text which is gonna be put at the bottom of the head.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'head_design',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'head_image',
			[
				'label' => __( 'Background image', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __( 'Image displayed on the background of the head box. Dimensions ideally 600x400px.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'head_overlay',
			[
				'label' => __( 'Background overlay class', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'One of the predefined classes that configure background color (e.g. bg-yellow).', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => 'bg-grey'
			]
		);

		$this->add_control(
			'head_shadow',
			[
				'label' => __( 'Apply text shadow?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'It might be useful to apply a bit of shadow behind the text to make it more readable.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => ''
			]
		);

		$this->add_control(
			'head_hover',
			[
				'label' => __( 'Hide text and overlay on hover?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'Should the text and image overlay be hidden when user mouses over the head?.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => ''
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'variants_section',
			[
				'label' => __( 'Product variants', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'variant_title',
			[
				'label' => __( 'Title', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT
			]
		);

		$repeater->add_control(
			'variant_description',
			[
				'label' => __( 'Description', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Keep it short. Few words should be enough.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$repeater->add_control(
			'variant_price_novat',
			[
				'label' => __( 'Price without VAT', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Default price to be displayed. If VAT Switch is used, enter price without VAT.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$repeater->add_control(
			'variant_price_vat',
			[
				'label' => __( 'Price with VAT', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'If VAT Switch is used, enter price with VAT. Otherwise leave empty.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'variants',
			[
				'label' => __( 'Product variants', IH_Elementor_Extension::TEXT_DOMAIN ),
				'description' => __( 'Enter the variants. They will be displayed below in table-like format.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'variant_title' => __( '10 hours', IH_Elementor_Extension::TEXT_DOMAIN ),
						'variant_description' => __( 'Cheap but good', IH_Elementor_Extension::TEXT_DOMAIN ),
						'variant_price_novat' => __( '100 CZK', IH_Elementor_Extension::TEXT_DOMAIN ),
						'variant_price_vat' => __( '121 CZK', IH_Elementor_Extension::TEXT_DOMAIN ),
					]
				],
				'title_field' => '{{{ variant_title }}}',
			]
		);

		$this->end_controls_section();

	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$args = $this->get_settings_for_display();
		$args['head_image'] = $args['head_image']['url'];
		$args['head_hover'] = !($args['head_hover'] == '');
		$args['head_shadow'] = !($args['head_shadow'] == '');

		echo pricing_table($args);
	}
}

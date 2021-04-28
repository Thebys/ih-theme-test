<?php
/**
 * Widget that renders list of coworking tariffs and allows to configure featured tariff and hide
 * selected tariffs from the view so it can be used on multiple sub/pages.
 */

class IH_Widget_MembershipSummary extends \Elementor\Widget_Base {

	/**
	 * Get widget unique name.
	 */
	public function get_name() {
		return 'ih_elementor_membership_summary';
	}

	/**
	 * Get widget title.
	 */
	public function get_title() {
		return __( 'Membership Summary', IH_Elementor_Extension::TEXT_DOMAIN );
	}

	/**
	 * Get widget icon.
	 */
	public function get_icon() {
		return 'fa fa-laptop-house';
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
			'featured',
			[
				'label' => __( 'Featured tariff', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'featured_show',
			[
				'label' => __( 'Display featured tariff?', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'description' => __( 'If featured tariff should be displayed, tick this and fill the following fields.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => ''
			]
		);

		$this->add_control(
			'featured_content',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'featured_title',
			[
				'label' => __( 'Title', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Tariff\'s name.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'featured_description',
			[
				'label' => __( 'Description', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'description' => __( 'One or two lines long text to describe why teh tariff is unique.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'featured_tags',
			[
				'label' => __( 'Tags', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'One or two word long tags to be displayed below title. If more tags are needed, separate by comma.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'featured_link_text',
			[
				'label' => __( 'Button text', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Text for the button displayed on the bottom of featured box.', IH_Elementor_Extension::TEXT_DOMAIN ),
				'default' => __( 'Detail', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'featured_link_url',
			[
				'label' => __( 'Button link', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::URL,
				'description' => __( 'Link where the button leads.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'featured_design',
			[
				'type' => \Elementor\Controls_Manager::DIVIDER,
			]
		);

		$this->add_control(
			'featured_image',
			[
				'label' => __( 'Background image', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::MEDIA,
				'description' => __( 'Image displayed on the background of the featured box. Dimensions ideally 900x285px.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'featured_overlay',
			[
				'label' => __( 'Background overlay class', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'One of the predefined classes that configure background color (e.g. bg-yellow).', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'hide_section',
			[
				'label' => __( 'Hidden / disabled tariffs', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'hide',
			[
				'label' => __( 'Hidden tariffs', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Comma separated list of tariffs to hide completely.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$this->add_control(
			'disable',
			[
				'label' => __( 'Disabled tariffs', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Comma separated list of tariffs to disable (dimmed, not clickable).', IH_Elementor_Extension::TEXT_DOMAIN )
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

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend.
	 */
	protected function render() {
		$args = $this->get_settings_for_display();
		$args['featured_image'] = $args['featured_image']['url'];
		$args['featured_link_url'] = $args['featured_link_url']['url'];

		echo membership_summary($args);
	}
}

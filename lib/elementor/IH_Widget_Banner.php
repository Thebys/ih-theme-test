<?php
/**
 * Widget that renders a banner based on background image with optional color overlay, configurable with a title, description and a button.
 */

class IH_Widget_Banner extends \Elementor\Widget_Base
{
    /**
     * Get widget unique name.
     */
    public function get_name()
    {
        return 'ih_elementor_banner';
    }

    /**
     * Get widget title.
     */
    public function get_title()
    {
        return __('Banner', IH_Elementor_Extension::TEXT_DOMAIN);
    }

    /**
     * Get widget icon.
     */
    public function get_icon()
    {
        return 'fa fa-image';
    }

    /**
     * Get widget categories.
     */
    public function get_categories()
    {
        return ['impacthub'];
    }
    /**
     * Register widget controls.
     */
    protected function _register_controls()
    {
        $this->start_controls_section(
            'background',
            [
                'label' => __('Background images', IH_Elementor_Extension::TEXT_DOMAIN),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'background-image',
            [
                'label' => __('Background image for desktop', IH_Elementor_Extension::TEXT_DOMAIN),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'background-image-mobile',
            [
                'label' => __('Background image for mobile', IH_Elementor_Extension::TEXT_DOMAIN),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );
        $this->add_control(
            'overlay',
            [
                'label' => __('Show color overlay', IH_Elementor_Extension::TEXT_DOMAIN),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => __('Show', IH_Elementor_Extension::TEXT_DOMAIN),
                'label_off' => __('Hide', IH_Elementor_Extension::TEXT_DOMAIN),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );
        $this->add_control(
            'overlay-color',
            [
                'label' => __('Overlay color', IH_Elementor_Extension::TEXT_DOMAIN),
                'type' => \Elementor\Controls_Manager::COLOR,
            ]
        );


		$this->add_control(
			'overlay-opacity',
			[
				'label' => __( 'Opacity', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::NUMBER,				
				'min' => 0,
				'max' => 1,
				'step' => 0.05
			]
		);

        $this->end_controls_section();

        $this->start_controls_section(
            'content',
            [
                'label' => __('Content', IH_Elementor_Extension::TEXT_DOMAIN),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => __('Title', IH_Elementor_Extension::TEXT_DOMAIN),
                'type' => \Elementor\Controls_Manager::TEXT,
                'rows' => 2,
                'default' => __('This is a banner title', IH_Elementor_Extension::TEXT_DOMAIN),
            ]
        );

        $this->add_control(
            'text',
            [
                'label' => __('Text', IH_Elementor_Extension::TEXT_DOMAIN),
                'type' => \Elementor\Controls_Manager::CODE,
                'rows' => 10,
                'default' => __('This is the text content of a banner.', IH_Elementor_Extension::TEXT_DOMAIN),
            ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
            'buttons',
            [
                'label' => __('Buttons', IH_Elementor_Extension::TEXT_DOMAIN),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'primary-button-text',
            [
                'label' => __('Button text', IH_Elementor_Extension::TEXT_DOMAIN),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Click me', IH_Elementor_Extension::TEXT_DOMAIN),
            ]
        );

        $this->add_control(
            'primary-button-link',
            [
                'label' => __('Button link', IH_Elementor_Extension::TEXT_DOMAIN),
                'type' => \Elementor\Controls_Manager::URL,
                'rows' => 10,
                'default' => [
                    'url' => '',
                ],
            ]
        );
        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     */
    protected function render()
    {
        $args = $this->get_settings_for_display();

        $args['background-image'] = $args['background-image']['url'] ?? '';
        $args['background-image-mobile'] = $args['background-image-mobile']['url'] ?? '';

        $args['overlay'] = $args['overlay'] == 'yes' ? true : false;        

        $args['primary-button-link'] = $args['primary-button-link']['url'] ?? '';        

        $args['elementor_widget'] = $this;

        echo banner($args);
    }
}

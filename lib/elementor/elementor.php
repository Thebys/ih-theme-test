<?php
/**
 * Definition of an Elementor extension.
 *
 * The class has currently the following purposes:
 * 1. Registers custom widgets via init_widgets()
 * 2. Disables loading of fonts defined by Elementor via disable_fonts()
 * 3. Changes default Elementor Image Element behavior so it uses lazy loading via images_lazy_load()
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

IH_Elementor_Extension::instance();

/**
 * Root class for Impact Hub Elementor customizations.
 */
final class IH_Elementor_Extension {

	const TEXT_DOMAIN = 'roots-elementor-customization';

	private static $_instance = null;

	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}

	public function __construct() {
		if ( ! did_action( 'elementor/loaded' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
			return;
		}

		add_action('init', [$this, 'init_widgets']);
		add_action('init', [$this, 'disable_fonts']);
	}

	public function admin_notice_missing_main_plugin() {

		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		$message = esc_html__( 'Impact Hub Theme requires to be installed and activated.', self::TEXT_DOMAIN );

		printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );

	}

	public function init_widgets() {
		require_once locate_template('/lib/elementor/IH_Widget_Loop.php');
		require_once locate_template('/lib/elementor/IH_Widget_SectionHeadline.php');
		require_once locate_template('/lib/elementor/IH_Widget_PageButton.php');
		require_once locate_template('/lib/elementor/IH_Widget_PhotoSlider.php');
		require_once locate_template('/lib/elementor/IH_Widget_TestimonialsSlider.php');
		require_once locate_template('/lib/elementor/IH_Widget_Testimonial.php');
		require_once locate_template('/lib/elementor/IH_Widget_MembershipSummary.php');
		require_once locate_template('/lib/elementor/IH_Widget_PricingTable.php');
		require_once locate_template('/lib/elementor/IH_Widget_ListItem.php');
		require_once locate_template('/lib/elementor/IH_Widget_Logos.php');
		require_once locate_template('/lib/elementor/IH_Widget_Banner.php');
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_Loop() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_SectionHeadline() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_PageButton() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_PhotoSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_TestimonialsSlider() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_Testimonial() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_MembershipSummary() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_PricingTable() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_ListItem() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_Logos() );
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \IH_Widget_Banner() );
	}

	// Remove fonts loaded through by elementor
	public function disable_fonts() {
		add_action( 'wp_enqueue_scripts', function () {
			wp_dequeue_style( 'font-awesome' );
		}, 50 );
		add_action( 'elementor/frontend/after_enqueue_styles', function () {
			wp_dequeue_style( 'font-awesome' );
		} );
		add_filter( 'elementor/frontend/print_google_fonts', '__return_false' );
	}

	public static function images_lazy_load($html) {
		$html = str_replace('src=', 'data-src=', $html);
		$html = str_replace('srcset=', 'data-srcset=', $html);
		$html = preg_replace('/title="[^"]*"/','title=""',$html);
		return $html;
	}

	public static function custom_widget_category( $elements_manager ) {
		$elements_manager->add_category(
			'impacthub',
			[
				'title' => __( 'Impact Hub', IH_Elementor_Extension::TEXT_DOMAIN ),
				'icon' => 'fa fa-plug',
			]
		);

	}

	public static function color_selector_control($label = 'Color', $description, $default = '') {
		return [
			'label' => __($label, IH_Elementor_Extension::TEXT_DOMAIN ),
			'type' => \Elementor\Controls_Manager::SELECT,
			'description' => __($description, IH_Elementor_Extension::TEXT_DOMAIN),
			'options' => array_merge([$default => 'Default'], get_color_class_options()),
			'default' => $default,
		];
	}

	public static function add_tracking_section(\Elementor\Widget_Base &$widget) {
		$widget->start_controls_section(
			'tracking',
			[
				'label' => __( 'Tracking', IH_Elementor_Extension::TEXT_DOMAIN ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT
			]
		);

		$widget->add_control(
			'anec',
			[
				'label' => __( 'anec', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Google Analytics event category parameter (usually page specific).', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$widget->add_control(
			'anea',
			[
				'label' => __( 'anea', IH_Elementor_Extension::TEXT_DOMAIN ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'description' => __( 'Google Analytics event action parameter.', IH_Elementor_Extension::TEXT_DOMAIN )
			]
		);

		$widget->end_controls_section();
	}
}

add_filter('elementor/image_size/get_attachment_image_html', array(IH_Elementor_Extension::class, 'images_lazy_load'), 1, 1);
add_action( 'elementor/elements/categories_registered', array(IH_Elementor_Extension::class, 'custom_widget_category'), 1, 1 );
<?php
/**
 * This file contains Impact Hub Locations functionality.
 *
 * Below there is definition of the ImpactHubLocation class which represents the data structure of a location. This
 * class is then used on multiple places of the website. Class also defines static classes getBrno() etc. which
 * create instance of the class with data of the location. Please note that the data for Brno and Ostrava are not complete
 * as we don't need the location details widgets for them.
 *
 * Apart from that, we define a shortcode that can display a widget with the details about the location. The widget
 * contains a call to action. This feature is then used in situation where we need to split visitors based on the
 * location they are interested in.
 *
 * TODO: In multiple places of the theme we have a functionality that evaluates a string and returns the correct location based on that. Might be done via function here.
 */

add_shortcode( 'location_detail', 'location_detail_shortcode' );
/** Shortcode to display location detail widget
 * @param array[string] $atts Shortcode attributes specified by the user.
 *
 * @return string HTML code with the widget or error message
 */
function location_detail_shortcode($atts) {
	$defaults = array(
		'location' => null,
		'action_text' => '',
		'action_link' => ''
	);

	$atts = shortcode_atts( $defaults, $atts, $shortcode = 'location' );

	if($atts['location'] == null)
		return 'Specify which location detail to display.';

	//Currently limited to D10 and K10
	switch ($atts['location']) {
		case 'd10':
			$atts['location'] = ImpactHubLocation::getD10();
			break;
		case 'k10':
			$atts['location'] = ImpactHubLocation::getK10();
			break;
		default:
			return 'Specified location is not defined.';
	}

	set_query_var( 'location', $atts['location'] );
	set_query_var( 'actionText', $atts['action_text'] );
	set_query_var( 'actionLink', $atts['action_link'] );

	ob_start();

	get_template_part( 'templates/location', 'element' );

	return ob_get_clean();
}

/**
 * Data structure for Impact Hub Location.
 * This is meant to be just a simple structure which holds Impact Hub location data
 * so the template does not have to check whether the data are present.
 * The actual locations can be returned using static methods getD10/getK10/getBrno/getOstrava.
 *
 * Note that the definitions of Brno and Ostrava locations are now only partial.
 */
class ImpactHubLocation
{
	public $name;
	public $cssClass;
	public $address;
	public $description;
	public $iconUrl;
	public $imageUrl;
	public $i1class;
	public $i1text;
	public $i2class;
	public $i2text;
	public $i3class;
	public $i3text;
	public $googleMapsLink;
	public $emailBanner;
	public $email;
	public $phone;

	function __construct( $name, $cssClass, $address, $description, $iconurl, $imageurl, $icons, $googleMapsLink, $emailBanner, $email, $phone)
	{
		$this->name = $name;
		$this->cssClass = $cssClass;
		$this->address = $address;
		$this->description = $description;
		$this->iconUrl = $iconurl;
		$this->imageUrl = $imageurl;
		$this->i1class = $icons[0][0];
		$this->i1text = $icons[0][1];
		$this->i2class = $icons[1][0];
		$this->i2text = $icons[1][1];
		$this->i3class = $icons[2][0];
		$this->i3text = $icons[2][1];
		$this->googleMapsLink = $googleMapsLink;
		$this->emailBanner = $emailBanner;
		$this->email = $email;
		$this->phone = $phone;
	}

	public function getAddressLine() {
		return $this->name . ', ' . $this->address;
	}

	public function getBadge($tooltip) {
		return sprintf(
			'<span class="location %s" %s><img src="%s" title="%s" alt=""></span>',
			$this->cssClass,
			$tooltip ? sprintf('data-tooltip="%s"', $this->address) : '',
			$this->iconUrl,
			$this->name
		);
	}

	public static function getD10() {
		return new ImpactHubLocation(
			__('Impact Hub Prague D10', 'impact_hub_locations'),
			'd10',
			__('Drtinova 557/10, Prague 5 - Smíchov', 'impact_hub_locations'),
			__('Space of the former printing house in Smíchov offers numerous work and relaxation zones. Offices, an open space, meeting rooms and conference facilities.', 'impact_hub_locations'),
			'/wp-content/themes/impacthub/assets/img/locations/d10-loc-badge.png',
			'/wp-content/themes/impacthub/assets/img/locations/d10-loc-detail.jpg',
			array(
				array(
					'icon-resize-full2',
					__('1905 sqm<br class="hidden-xs"> of space', 'impact_hub_locations')
				),
				array(
					'icon-prez',
					__('8 meeting and conference rooms', 'impact_hub_locations')
				),
				array(
					'icon-map',
					__('Anděl Metro Stop,<br class="hidden-xs"> tram 9, 12, 15, 20', 'impact_hub_locations')
				)
			),
			'https://maps.google.com/maps?ll=50.076391,14.402273&z=17&t=m&hl=cs&gl=CZ&mapclient=embed&daddr=Impact%20Hub%20Praha%20D10%20Drtinova%20557%2F10%20150%2000%20Praha%205@50.0763908,14.4022735',
			get_template_directory_uri() . '/assets/img/locations/d10-email-intro.jpg',
			'praha.d10@impacthub.cz',
			'+420 734 746 923'
		);
	}

	public static function getK10() {
		return new ImpactHubLocation(
			__('Impact Hub Prague K10', 'impact_hub_locations'),
			'k10',
			__('Koperníkova 10, Prague 2 - Vinohrady', 'impact_hub_locations'),
			__('This Art Nouveau villa combines the original historical interior with modern elements. The work space meshes well with a bar served by a famous chef.', 'impact_hub_locations'),
			'/wp-content/themes/impacthub/assets/img/locations/k10-loc-badge.png',
			'/wp-content/themes/impacthub/assets/img/locations/k10-loc-detail.jpg',
			array(
				array(
					'icon-resize-full2',
					__('2575 sqm of space including our garden', 'impact_hub_locations')
				),
				array(
					'icon-prez',
					__('10 attractive offices', 'impact_hub_locations')
				),
				array(
					'icon-map',
					__('Nám. míru Metro Stop,<br class="hidden-xs"> tram 4, 13, 22', 'impact_hub_locations')
				)
			),
			'https://maps.google.com/maps?ll=50.069938,14.442063&z=17&t=m&hl=cs&gl=CZ&mapclient=embed&daddr=Impact%20Hub%20Praha%20K10%20Kopern%C3%ADkova%2010%20120%2000%20Praha%205@50.069938,14.442063',
			get_template_directory_uri() . '/assets/img/locations/k10-email-intro.jpg',
			'praha.k10@impacthub.cz',
			'+420 727 896 526'
		);
	}

	public static function getBrno() {
		return new ImpactHubLocation(
			__('Impact Hub Brno', 'impact_hub_locations'),
			'brno',
			__('Cyrilská 7, Brno 602&nbsp;00', 'impact_hub_locations'),
			__('The large open space, glass-walled meeting rooms, hammocks, bean bag chairs and “beds” to relax in, as well two conference rooms and two open terraces make it the perfect place for work and meetings.', 'impact_hub_locations'),
			'/wp-content/themes/impacthub/assets/img/locations/brno-loc-badge.png',
			'',
			array(
				array(
					'',
					__('', 'impact_hub_locations')
				),
				array(
					'',
					__('', 'impact_hub_locations')
				),
				array(
					'',
					__('', 'impact_hub_locations')
				)
			),
			'https://www.google.com/maps/dir//Impact+Hub+Brno,+Cyrilsk%C3%A1+7,+602+00+Brno-st%C5%99ed-Trnit%C3%A1/@49.1903455,16.5859184,13z',
			get_template_directory_uri() . '/assets/img/locations/email-intro.jpg',
			'brno@impacthub.cz',
			'+420 777 201 518'
		);
	}

	public static function getOstrava() {
		return new ImpactHubLocation(
			__('Impact Hub Ostrava', 'impact_hub_locations'),
			'ostrava',
			__('Sokolská třída 1263/24, Ostrava 702&nbsp;00', 'impact_hub_locations'),
			__('Special selection coffee from two coffee grinders in a modern, glamorously designed coworking office in the heart of Ostrava? That is just for starters.', 'impact_hub_locations'),
			'/wp-content/themes/impacthub/assets/img/locations/ostrava-loc-badge.png',
			'',
			array(
				array(
					'',
					__('', 'impact_hub_locations')
				),
				array(
					'',
					__('', 'impact_hub_locations')
				),
				array(
					'icon-map',
					__('', 'impact_hub_locations')
				)
			),
			'https://www.google.com/maps/dir//Impact+Hub+Ostrava,+Sokolsk%C3%A1+t%C5%99%C3%ADda,+Moravsk%C3%A1+Ostrava+a+P%C5%99%C3%ADvoz,+%C4%8Cesko/@49.8393441,18.2573207,13z/',
			get_template_directory_uri() . '/assets/img/locations/email-intro.jpg',
			'ostrava@impacthub.cz',
			'+420 774 142 014'
		);
	}
}
?>
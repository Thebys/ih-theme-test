/*
	Functionality for spaces filtering on the Spaces page.

	This file is included in ./main.js
 */

import $ from 'jquery';

require('imagesloaded');

let Isotope = require('isotope-layout');

// Enable the filter once images are loaded (to not break the layout)
// Define click events on each of the filter buttons
// TODO: Clicks could be surely defined more simply. The target class could be a parameter of the button. Something like data-filter="extra-small,small".
export default function spacesFilter() {
	let $container = $('.filterable');
	let isoObject = null;
	if($container.length < 1)
		return;

	$container.imagesLoaded(function () {
		isoObject = new Isotope('.filterable', {
			// options
			itemSelector: '.toggle-square',
			layoutMode: 'fitRows',
			filter: filterClass()
		});
	});

	$("#all").click(function(){
		isoObject.arrange({filter:'*'});
		switchActive(jQuery(this));
	});

	$("#extra-small").click(function(){
		isoObject.arrange({ filter: '.extra-small, .small' });
		switchActive(jQuery(this));
	});

	$("#small").click(function(){
		isoObject.arrange({ filter: '.small' });
		switchActive(jQuery(this));
	});

	$("#medium").click(function(){
		isoObject.arrange({ filter: '.medium, .big' });
		switchActive(jQuery(this));
	});

	$("#big").click(function(){
		isoObject.arrange({ filter: '.big, .extra-big' });
		switchActive(jQuery(this));
	});

	$("#extra-big").click(function(){
		isoObject.arrange({ filter: '.extra-big' });
		switchActive(jQuery(this));
	});

	$(".location-filter #k10-filter").click(function(){
		isoObject.arrange({ filter: '.k10' });
		switchActive(jQuery(this));
	});

	$(".location-filter #d10-filter").click(function(){
		isoObject.arrange({ filter: '.d10' });
		switchActive(jQuery(this));
	});
}

// Filter spaces on page view in case the page was opened with #d10 or #k10 in URL
function filterClass() {
	var url = window.location.href;
	if(url.indexOf('#') === -1)
		return;
	var spaceHash = url.substring(url.indexOf("#")+1);

	if($('.location-filter #k10-filter').length !== 1)
		return null;

	if (spaceHash === "k10") {
		switchActive($('.location-filter #k10-filter'));
		return '.k10';
	}
	if (spaceHash === "d10") {
		switchActive($('.location-filter #d10-filter'));
		return '.d10';
	}
}

// Add/remove classes used to highlight filter buttons.
function switchActive(obj){
	if(!obj.hasClass('selected')){
	jQuery('.selected').removeClass('selected');
	obj.addClass('selected');}
}

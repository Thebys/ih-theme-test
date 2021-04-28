/*
	Main scripts used throughout the whole website. This is one of the webpack entry points.
 */

import $ from 'jquery';
import backgroundVideo from './background-video.js';
import {gaEvents, sendGA} from "./analytics-button-tracking";
import initCounterUp from "./counter";
import menu from "./menu";
import initializeNotifications from "./notifications";
import vatSwitch from "./prices-switch";
import spacesFilter from "./spaces-filter";
import coworkingFilter from "./tariffs-filter";
import lightbox from "lightbox2";
import LazyLoad from "vanilla-lazyload";
import 'select2';
import 'jquery-ui/ui/widgets/tooltip';

require('bootstrap');
const dateFormat = require('dateformat');

// Make sendGA function globally available so it can be used in snippets printed directly into page source code
window.sendGA = sendGA;

// Register global function that will open modal window with form confirmation.
window.openThankYouModal = () => {
	$('#thank-you-modal').modal('show');
};

$(document).ready(function(){

	// Enable lazy loading of all images except the ones that are in sliders.
	// Sliders handle lazy loading themselves.
	window.lazy = new LazyLoad({
		elements_selector: "img:not(.swiper-lazy)",
	});

	// Handle clicks on <a> elements that have an anchor as target.
	anchorClick();
	// Handle links with anchors.
	openModalOrScroll();

	// Close modal when clicked on a link.
	closeModalLinkClick();

	// Enable Lightbox library.
	setupLightbox();

	// Enable functionality of a video running on the background.
	// Used with the homepage hero box where we can have a video instead of an image.
	backgroundVideo();

	// Phone corner functionality (hover & click)
	callCornerArrangeMeeting();

	// Enable tooltips everywhere
	$('[data-toggle="tooltip"]').tooltip();

	// Coworking tariffs tooltips that were generated globally for the whole page.
	// TODO: No longer used.. Remove.
	createIconTooltips();

	// Register listeners for clicks on GA tracked elements.
	gaEvents();

	// Enable functionality that counts from 0 to target number when the number enters viewport.
	initCounterUp();

	// Header menu functionality (ripple effect, sticky behavior, ...)
	menu();

	// Bottom left notifications functionality
	initializeNotifications();

	// Enable VAT switches on pricelist pages.
	vatSwitch("#prices-switch", "#prices-switch2");
	vatSwitch("#prices-switch2", "#prices-switch");

	// Enable filter functionality on Spaces page
	spacesFilter();

	// Enable location switch on coworking page.
	// TODO: No longer used. Remove.
	coworkingFilter();

	// Enable Select2.js
	activateSelect2();

	// Prevent the anchor jump on accordion clicks
	$('.accordion-toggle').on('click', function(e){
		e.preventDefault();
	});

	// Open / close tariff box on click
	// TODO: Can be removed. Tariff boxes no longer used on coworking, just on acceleration where they are not clickable.
	$('.tarif-box').not('.static').click(function() {
		$(this).toggleClass('open');
	});

	// Animate circles in Membership Summary on all Coworking pages
	// animation of tariff circles starts once they appear in viewport
	$('.membership-summary .tariff').waypoint({
		handler: function(direction) {
			$(this.element).find('path.circle').addClass('animate');
		},
		offset: 'bottom-in-view'
	});

	// dynamic filling of forms
	// doing this on frontend enables caching of form pages
	$('input[value=http_referrer]').val(document.referrer);
	$('input[value=form_sent_timestamp]').val(dateFormat(new Date(), 'd.m.yyyy HH:MM'));

	// add our form loading element once a form is submitted
	$(document).on('submit', 'form', function() {
		$(this).children('.gform_footer').append('<div class="loading_spinner_wrap"><div class="loading_spinner"><img src="/wp-content/themes/impacthub/assets/img/impacthub-loader.svg" alt="Loading..."><img src="/wp-content/themes/impacthub/assets/img/logo-impact-hub-square-red.jpg" alt=""></div></div>');
	});
});

// Open / close Impact Hub Worldwide menu
// TODO: Remove.
function ihMenuSelectorOpen() {
	var ihMenuSelector = '#collapse-select-your-impact-hub';
	$(document).on('click', function(event) {
		if ( $(ihMenuSelector).hasClass('in') ) {
			if ( !$(event.target).parents(ihMenuSelector).length ) {
				$(ihMenuSelector).collapse('hide');
			}
		}
	});
}

// Close modal when click on any link within it
// Close modal on close button click
function closeModalLinkClick() {
	var modalLinkSelector = '.modal a, .modal .modal-close';

	if ( $(modalLinkSelector).length ) {
		$(modalLinkSelector).not('.carousel-control').on('click', function() {
			$(this).closest('.modal').modal('hide');
		});
	}
}

// Scroll on target element is done by elementor
// Here we just open a modal or add open class to the element for legacy functionality
function anchorClick() {
	$('a').not('[data-toggle]').click(function(e) {
		let href = $(this).attr('href');
		handleLocationHref(href, e, false);
	});
}

// If there is a hash in the URL, we will scroll to the element
// and open modal or add open class for legacy functionality
function openModalOrScroll() {
	let currentURL = window.location.href;
	handleLocationHref(currentURL);
}

function handleLocationHref(url, event = null, animate = true) {
	let $root = $('html, body');

	// scroll only if link is an anchor
	if(url === undefined || url.indexOf('#') === -1)
		return;

	let href = url.substring(url.indexOf('#'))
	let $el = $(href);

	// scroll only if anchor exists
	if($el.length < 1)
		return;

	if ($el.hasClass('modal'))
		$el.modal('show');
	else
		$el.toggleClass('open');

	if(!animate)
		return;

	if(event !== null)
		event.preventDefault();

	$root.animate({
		scrollTop: $el.offset().top
	}, 1000, 'swing');
}

// Configure ligtbox options and set proper label for the photos if czech language is selected
function setupLightbox() {
	var lightboxOptions = {
		'resizeDuration': 300,
		'fadeDuration': 500,
		'imageFadeDuration': 300,
	};

	if($('html').attr('lang') === 'cs-CZ') {
		lightboxOptions['albumLabel'] = 'Fotografie %1 z %2';
	}

	if(lightbox)
		lightbox.option(lightboxOptions);
}

// Simplifies creation of tooltips on icons.
// This applies in case there is an array defined in the global scope.
// Look for the array inside content editor. This is used on /coworking pages.
function createIconTooltips() {
	if(typeof tooltips !== 'undefined')
	{
		for(var i=0; i< tooltips.length; i++)
		{
			$('.' + tooltips[i][0]).parent('span').attr('data-tooltip',tooltips[i][1]);
		}
	}
}

// Handles mouseevents on the "Call Us" corner on the Arrange a meeting page
function callCornerArrangeMeeting() {
	$('#phone-corner').mouseenter(function() {
		$(this).addClass('activated');
	});

	$('#phone-corner').click(function() {
		$(this).toggleClass('open');
	});
}

// Transforms select inputs to advanced Select2.js elements.
function activateSelect2() {
	$('.gfield.select2:not(.multiple) select').select2({
		width:'100%',
		minimumResultsForSearch: -1
	});

	$('.gfield.select2.multiple select').select2({
		width: '100%'
	});
}
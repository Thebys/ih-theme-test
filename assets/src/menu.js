/*
	Functionality of the header menu.

	Imported in ./main.js
 */

import $ from 'jquery';

export default function menu() {
	// Sticky menu
	let $menuElement = $('#mainNav');
	let $body = $("body");
	let mq = window.matchMedia( "(max-width: 799px)" );
	let offsetStart = $('.top-menu').first().height();
	let mobileOffsetStart = $('body > header').first().height();

	// Make menu sticky on scroll
	$(window).scroll(function() {
		addStickyBehavior(mq, $body, mobileOffsetStart, offsetStart);
	});

	// Add an open class when dropdown menu was open.
	$menuElement.on('shown.bs.dropdown', function() {
		$menuElement.addClass("dropdown-open");
	});

	// Remove the open class when dropdown closes.
	$menuElement.on('hidden.bs.dropdown', function() {
		$menuElement.removeClass("dropdown-open");
	});

	// Close dropdown when the first order menu is scrolled.
	$menuElement.children('#menu-main-menu').scroll(() => hideDropdown($menuElement));
	// Close dropdown when a simple menu item is clicked.
	$menuElement.find('#menu-main-menu > li:not(.dropdown)').click(() => hideDropdown($menuElement));

	// Show search field when search icon is clicked.
	// TODO: Can be removed.
	$('.navigation .search-form .search-close').click(function(event) {
		event.preventDefault();
		$('.navigation').toggleClass('open-search');
	});

	// TODO: Can be removed.
	$('.navigation .search-form .search-submit').click(function(event) {
		if($('.navigation:not(.open-search) .search-form .search-submit')[0] === $(this)[0]) {
			event.preventDefault();
			$('.navigation').toggleClass('open-search');
		}
	});

	// Menu ripple effect
	// Firstly prevent close on dropdown click
	$menuElement.find('.dropdown-menu').click(function (e) {
		e.stopPropagation();
		performRipple(e, e.target);
	});

	$("html").on("click", "#menu-main-menu li a", function(e) {
		performRipple(e, e.currentTarget);
	});
}

// On menu item click we add a <span> element to the click coordinates.
// CSS then performs the animation.
function performRipple(event, target) {
	let btn = $(target);
	let x = event.pageX - btn.offset().left;
	let y = event.pageY - btn.offset().top;

	$("<span></span>").appendTo(btn).css({
		left: x,
		top: y
	});
}

// Set the menu to be fixed or not based on scroll position.
function addStickyBehavior(mq, $body, stickyMenuPosition, sticky) {
	let scrollCondition = mq.matches ? (window.pageYOffset >= (stickyMenuPosition - 10)) : (window.pageYOffset >= sticky);
	if(scrollCondition)
		$body.addClass("stickyMainMenu");
	else
		$body.removeClass("stickyMainMenu");
}

// Hides all dropdowns and removes CSS class from the menu element.
function hideDropdown($menuElement) {
	$menuElement.find(".dropdown.open").first().removeClass("open");
	$menuElement.removeClass("dropdown-open");
}
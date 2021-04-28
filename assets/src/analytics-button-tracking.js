/*
	Registers event listeners for Google Analytics tracking and defines function that sends custom event to Google Tag Manager/
 */

import $ from 'jquery';

// Register events that are to be tracked via Google Analytics
export function gaEvents() {

	// All clicks on links with anea and anec parameters.
	// TODO: all elements (not only links) should be tracked - remove the a from selector below
	// TODO: wouldn't work on dynamically created elements, rework to $.on(document,'click',function(){}) format.
	// TODO: anec and anea attributes are invalid from the HTML specification point of view, correct way would be data-anea and data-anec. (Lot of work t o change everywhere).
	$("a[anea][anec]").click(function(e)
	{
		var anec = $(this).attr('anec');
		var anea = $(this).attr('anea');
		var href = $(this).attr('href');
		sendGA(anec, anea, href);
	});

	// Form submit button is clicked.
	// TODO: anec could be hardcoded to 'form_submit_completed' and then we could drop the hidden input which is same for all forms.
	$("input[type=submit]").click(function(e)
	{
		let $form = $(this).closest("form");
		let $gas = $form.find('.gform_body input[type=hidden]');
		let $email = $form.find('.gform_body input[type=email]');
		if($email.length === 1)
			var href = $email.val();
		for(var i = 0; i < $gas.length; i++)
		{
			if($($gas[i]).val().indexOf('anea=') === 0)
				var anea = $($gas[i]).val().replace('anea=','');
			if($($gas[i]).val().indexOf('anec=') === 0)
				var anec = $($gas[i]).val().replace('anec=','');
		}
		sendGA(anec, anea, href);
	});
}

// Send a custom event via the Data Layer to the Google Tag Manager.
export function sendGA(anec, anea, anel)
{
	anec = anec || "empty_anec";
	anea = anea || "empty_anea";
	anel = anel || "empty_anel";

	window.dataLayer = window.dataLayer || [];

	window.dataLayer.push({
		'event': 'ga_custom_event',
		'ga_anec': anec,
		'ga_anea': anea,
		'ga_anel': anel
	});

	console.log('ga_sent: {anec: ' + anec + ', anea: ' + anea + ', anel: ' + anel + '}');
}
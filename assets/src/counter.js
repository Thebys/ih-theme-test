/*
	Functionality that enables counting from 0 to target number when the number enters viewport.

	Not used anywhere at the moment.
	TODO: We probably don't use it. Drop it so we don't need to load the library.
 */

import $ from 'jquery';
jQuery = $;

require('waypoints/lib/jquery.waypoints');

require('jquery.counterup/jquery.counterup.min');

var elementsToRaise;

export default function initCounterUp() {
	$('span.animated').counterUp({
		delay: 10, // the delay time in ms
		time: 500 // the speed time in ms
	});

	elementsToRaise = $('span.animated.raise');
	if(elementsToRaise.length > 0)
	{
		let raiseInterval = setInterval(raiseNumber,1000);
	}
}

function raiseNumber()
{
	for(let i=0; i<elementsToRaise.length; i++)
	{
		$(elementsToRaise[i]).text(parseInt($(elementsToRaise[i]).text()) + 1);
	}
}
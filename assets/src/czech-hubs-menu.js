/*
	Functionality for a menu element that enables user to go to another Czech Impact Hub.

	TODO: Remove, no longer used
 */

import $ from 'jquery';

export default function czechImpactHubsMenu() {
	//react to click on the "IMPACT HUB IN CZECH" buttom
	$('#menu-czech-label').click(function()
	{
		//toggle the menu
		$('#menu-czech-hub').slideToggle( 200 , function()
		{
			//if menu have been just opened
			if($('#menu-czech-hub').is(':visible'))
			{
				//add active class
				$('#menu-czech-hub').addClass('active');
			}
			//if menu have been just hidden
			else
			{
				//remove active class
				$('#menu-czech-hub').removeClass('active');
			}
		});
	});

	//react to click anywhere
	$(document).on('click', function(event)
	{
		//if custom menu for the czech hubs is opened
		if($('#menu-czech-hub').hasClass('active'))
		{
			//close the menu and remove active class
			$('#menu-czech-hub').slideUp(200).removeClass('active');
		}
	});
}
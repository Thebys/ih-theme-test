/*
	Functionality for a switch button that changes VAT incl. and VAT exc. prices.

	Works on all elements on the page that have .vat and .no-vat classes.

	This file is included in ./main.js
 */

import $ from 'jquery';

//class used to hide the prices
var hideClass = "hide";

export default function vatSwitch(switchID, second) {

	//change of the switch element
	$(switchID).change(function(){
		//disable more clicks on the switch element
		$(switchID).attr('disabled', 'disabled');

		$(second).attr('disabled', 'disabled');
		$(second).prop('checked', !$(second).prop("checked"));

		//find prices elements (S DPH + BEZ DPH)
		let $prices = $('.vat, .no-vat');
		let $displayed = $prices.not('.'+hideClass);
		let $hidden = $prices.filter('.'+hideClass);
		//hide the currently displayed prices with slide down and fade animation
		$displayed
			.slideDown(300)
			.animate(
				{ opacity: 0 },
				{
					queue: false,
					duration: 300,
					//when prices are faded out, hide them completely
					complete:  function() {
						$(this).addClass(hideClass);
						//then display the second type of prices
						$hidden
							.css({ opacity: 0 })
							.removeClass(hideClass)
							.animate(
								{ opacity: 1 },
								{
									queue: false,
									duration: 300,
									complete: function() {
										//after all enable clicks on the switch element
										$(switchID).removeAttr('disabled');
										$(second).removeAttr('disabled');
									}
								}
							);
					}
				}
			);
	});

}

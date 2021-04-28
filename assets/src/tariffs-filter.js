/*
	Functionality for tariffs-location filtering on coworking page

	This file is included in ./main.js

	TODO: Remove. No longer needed as we have new coworking section.
 */

import $ from 'jquery';

require('imagesloaded');

let Isotope = require('isotope-layout');

export default function coworkingFilter() {
    let $container = $('.filterable-tariffs');
    let $tariffCheckbox = $("#tariffs-switch");
    let $tariffWrappers = $('.tariffs');
    let $parent = $container.closest('.contained-row');
    let isoObject = null;
    if($container.length < 1 || $tariffCheckbox.length < 1)
        return;

    // initiate isotope once images are loaded - proper height of elements
    $container.imagesLoaded(function () {
        isoObject = new Isotope('.filterable-tariffs', {
            itemSelector: ".tariffs",
            layoutMode: "fitRows",
        });
        isoObject.arrange({ filter:filterClassCoworking(window.location.href, $tariffCheckbox) });
        isoObject.once('arrangeComplete', staticBehavior($parent, $tariffWrappers));
    });

    // filter tariffs based on the switch position
    $tariffCheckbox.change( function() {
        isoObject.arrange({ filter: $tariffCheckbox.is(':checked') ? '.k10' : '.d10' });
        isoObject.once('arrangeComplete', staticBehavior($parent, $tariffWrappers));
    });
}

function staticBehavior($parent, $tariffs) {
    $parent.css( "position", "static");
    $parent.css( "height", "auto");
    $tariffs.css("position", "static");
}

function filterClassCoworking(url, tarrifsSwitch) {
    if(url.indexOf('#') === -1)
        return '.d10';

    let spaceHash = url.substring(url.indexOf("#")+1);

    if (spaceHash.indexOf("k10") !== -1) {
        $(tarrifsSwitch).prop("checked", true);
        return '.k10';
    } else {
        return '.d10';
    }
}
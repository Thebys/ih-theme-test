/*
	Sliders functionality used throughout the whole website. This is one of the webpack entry points.
 */

import $ from 'jquery';
import Swiper from 'swiper';
import initializeAboutUsSwiper from "./about-us-swiper";

jQuery = $;

// jQuery extension that can randomize elements.
(function($){

    $.fn.shuffle = function() {

        var allElems = this.get(),
            getRandom = function(max) {
                return Math.floor(Math.random() * max);
            },
            shuffled = $.map(allElems, function(){
                var random = getRandom(allElems.length),
                    randEl = $(allElems[random]).clone(true)[0];
                allElems.splice(random, 1);
                return randEl;
            });

        this.each(function(i){
            $(this).replaceWith($(shuffled[i]));
        });

        return $(shuffled);

    };

})(jQuery);

let imagesLoaded = require('imagesloaded');

// provide jQuery argument
imagesLoaded.makeJQueryPlugin( $ );

$(document).ready(function(){

    // Create photo sliders with .location-photo-slider class.
    initPhotoSliders();

    // Create special slider on the About Us page.
    initializeAboutUsSwiper();

    // Create testimonials sliders with .testimonials-slider class.
    initTestimonialsSliders();
});


// Initialize photo swipers
function initPhotoSliders() {
    let wrappers = $('.location-photo-slider');
    let mq = window.matchMedia( "(max-width: 767px)" );
    let preloadNumber = mq.matches ? 2 : 3;

    // global array of sliders (good for debugging from console)
    // TODO: move the array definition outside the function and we don't need to check if it exists
    if(!window.swipers)
        window.swipers = [];

    // initialize all the found sliders one by one
    for (var i = wrappers.length - 1; i >= 0; i--) {
        // randomize slides order if needed
        if($(wrappers[i]).hasClass('swiper-randomized'))
            $(wrappers[i]).find('.swiper-slide').shuffle();

        let swiper =  new Swiper(wrappers[i], {
            autoplay: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            slidesPerView: 'auto',
            watchSlidesVisibility: true,
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: preloadNumber
            },
            preloadImages: false
        });
        swipers.push(swiper);
    }
}

// Initialize testimonials sliders.
function initTestimonialsSliders() {
    let wrappers = $('.testimonials-slider');

    //TODO: move outside as explained before
    if(!window.swipers)
        window.swipers = [];

    // Initialize sliders after the contained pictures are loaded (because of height)
    // TODO: Maybe the height problem could be fixed with CSS
    $(wrappers).children('img').imagesLoaded(function () {
        // initialize all the found sliders one by one
        for (var i = wrappers.length - 1; i >= 0; i--) {
            let swiper =  new Swiper(wrappers[i], {
                slidesPerView: 1,
                autoplay: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev'
                },
                preloadImages: true,
                updateOnImagesReady: true
            });
            swipers.push(swiper);
        }
    });
}
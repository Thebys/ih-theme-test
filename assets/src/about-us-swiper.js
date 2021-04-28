/*
    Special slider on About Us page.

    Included in ./sliders.js
 */

import $ from 'jquery';
import Swiper from 'swiper';

const SWIPER_YEAR_BULLET_CLASS = 'year-bullet';
const SWIPER_PAGINATION_CLASS = 'swiper-custom-pagination';
const SWIPER_PAGINATION_PROGRESSBAR_CLASS = 'progress';
const SLIDE_YEAR_ATTR = 'slide-year';
const SLIDE_MONTH_ATTR = 'slide-month';
const YEAR_BULLET_YEAR_ATTR = 'year';

export default function initializeAboutUsSwiper() {
    //initialize swiper when document ready
    let aboutUsSwiper = new Swiper ('.swiper-container.about-us-slider', {
        direction: 'horizontal',
        autoplay: {
            delay: 3000
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev'
        },
        on: {
            init: function() {renderPagination(this)},
            slideChangeTransitionStart: function() {animateProgress(this)}
        }
    });


    $('.'+SWIPER_PAGINATION_CLASS).on('click','.'+SWIPER_YEAR_BULLET_CLASS, function(){
        animateToYear(this, aboutUsSwiper);
    });
}

function renderPagination(mySwiper)
{
    let $paginationBox = $('.'+SWIPER_PAGINATION_CLASS);
    prepareYears(mySwiper);
    let oneYearWidth = 100 / mySwiper.years.length;
    for(let i = 0; i < mySwiper.years.length; i++)
    {
        $paginationBox.append('<span style="width: ' + oneYearWidth + '%" ' +
            'class="' + SWIPER_YEAR_BULLET_CLASS + '"'
            +YEAR_BULLET_YEAR_ATTR+'="' + mySwiper.years[i] + '">'
            + mySwiper.years[i] +
            '</span>');
    }
    animateProgress(mySwiper);
}

function prepareYears(mySwiper)
{
    mySwiper.years = [];
    for(let i = 0; i < mySwiper.slides.length; i++)
    {
        let slideYear = $(mySwiper.slides[i]).attr(SLIDE_YEAR_ATTR);
        if(mySwiper.years.indexOf(slideYear) === -1)
            mySwiper.years.push(slideYear);
    }
}

function animateProgress(mySwiper)
{
    $('.' + SWIPER_PAGINATION_CLASS + ' .' + SWIPER_PAGINATION_PROGRESSBAR_CLASS).width(countNewProgressWidth(mySwiper) + "%");
}

function countNewProgressWidth(mySwiper)
{
    let $slide = $(mySwiper.slides[mySwiper.activeIndex]);
    let year = $slide.attr(SLIDE_YEAR_ATTR);
    let month = $slide.attr(SLIDE_MONTH_ATTR);
    let yearPosition = mySwiper.years.indexOf(year);
    let oneYearWidth = 100 / mySwiper.years.length;
    let oneMonthWidth = oneYearWidth / 12;
    return (oneYearWidth * (yearPosition)) + (oneMonthWidth * month);
}

function animateToYear(clickedYear, mySwiper)
{
    for(let i = 0; i < mySwiper.slides.length; i++)
        if($(mySwiper.slides[i]).attr(SLIDE_YEAR_ATTR) === $(clickedYear).attr(YEAR_BULLET_YEAR_ATTR))
            return mySwiper.slideTo(i);
}
/*
	Functionality of a video that will play on background without sound. On click, modal will open and video will start automatically.

	This can be used together with the homepage hero box and location intro fullscreen section.
 */

import $ from 'jquery';

let bgVideoAspectRatio = 720/1280;
const VIDEO_ELEMENT = '#homepage_video';
const VIDEO_PLAY_BUTTON = '#play_video';
const VIDEO_MODAL = '#homepage_video_modal';
const VIDEO_MODAL_ELEMENT = VIDEO_MODAL + ' video';
const VIDEO_TEXT_OVERLAY = '.homepage_video_text';

export default function backgroundVideo() {

	if($(VIDEO_ELEMENT).length < 1)
		return;

	playBackgroundVideo();

	$(VIDEO_PLAY_BUTTON).click(function()
	{
		$(VIDEO_ELEMENT).get(0).pause();
	});

	$(VIDEO_MODAL).modal({
		show: false
	});

	$(VIDEO_MODAL).on('shown.bs.modal', function() {
		stopBackgroundVideo();
		$(VIDEO_MODAL_ELEMENT).get(0).play();
	});

	$(VIDEO_MODAL).on('hide.bs.modal', function() {
		playBackgroundVideo()
		$(VIDEO_MODAL_ELEMENT).get(0).pause();
	});

	$(window).resize(function() {
		playBackgroundVideo();
	});

}

function setBackgroundVideoDimensions()
{
	let videoWidth = $(VIDEO_ELEMENT).width();
	$(VIDEO_TEXT_OVERLAY).css({'height' : bgVideoAspectRatio * videoWidth});
}

function stopBackgroundVideo() {
	$(VIDEO_ELEMENT).get(0).pause();
}

function playBackgroundVideo() {
	setBackgroundVideoDimensions();
	$(VIDEO_ELEMENT).get(0).play();
}
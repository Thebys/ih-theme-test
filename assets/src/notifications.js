/*
	Bottom left notifications functionality.

	This file is included in ./main.js
 */

import $ from 'jquery';
import {sendGA} from "./analytics-button-tracking";

const REMOVE_CLASS = "to-be-removed";
const SPECIAL_CLASS = "special-form-notification";
const ALL_NOTIFICATION = ".news-notification:not(." + REMOVE_CLASS + ')';
const FORM_NOTIFICATION = "." + SPECIAL_CLASS + ":not(." + REMOVE_CLASS + ")";
const NORMAL_NOTIFICATION = ".news-notification:not(." + REMOVE_CLASS + "):not(." + SPECIAL_CLASS + ")";
const NOTIFICATION_CLOSE = ".notification-close";
const NOTIFICATION_ACTION = ".notification-action";
const DISPLAYED_CLASS = "visible";
const NOTIFICATIONS_DISPLAY_LIMIT = 2;
const FORM_NOTIFICATIONS_DISPLAY_LIMIT = 1;
const FIRST_NOTIFICATION_DELAY = 10000;
const FORM_NOTIFICATION_DELAY = 40000;

var notificationCounter = 0;
var formNotificationCounter = 0;

export default function initializeNotifications() {
	//add event handler on close button click
	//close button click will hide notification using localStorage
	//localStorage is cleared only when user deletes cookies
	//so this hide technique is considered as "hide forever"
	$(ALL_NOTIFICATION + ' ' + NOTIFICATION_CLOSE).on('click', function() {
		deleteNotification($(this).parents(ALL_NOTIFICATION), 'close');
		showNextNotification();
	});

	$(ALL_NOTIFICATION + ' ' + NOTIFICATION_ACTION).on('click', function() {
		deleteNotification($(this).parents(ALL_NOTIFICATION), 'click');
		if(!$(this).is('a'))
			showNextNotification();
	});

	$(window).on('load', function() {
		//show first notification
		setTimeout(showNextNotification, FIRST_NOTIFICATION_DELAY);
	});
}

function showNextNotificationInner(notifications, onEmpty = null, delay = 0) {
	// If there is no normal notification left run callback and exit
	if(notifications.length < 1) {
		if(onEmpty !== null)
			onEmpty();
		return;
	}

	let randomness = Math.floor(Math.random() * notifications.length);

	//find out if the next notification should be displayed
	//if so, display it, otherwise delete it from DOM and display next notification
	if(shouldBeDisplayed(notifications[randomness])) {
		setTimeout(function() {
			displayNotification(notifications[randomness]);
		}, delay);
	} else {
		deleteNotification(notifications[randomness], false);
		showNextNotification();
	}
}

function showNextNotification() {
	let forms = $(NORMAL_NOTIFICATION).length < 1;

	//get notifications that should be displayed
	let notifications = forms ? $(FORM_NOTIFICATION) : $(NORMAL_NOTIFICATION);
	let onEmpty = forms ? null : (() => showNextNotification());
	let delay = forms ? FORM_NOTIFICATION_DELAY : 0;

	showNextNotificationInner(notifications, onEmpty, delay);
}

//display notification and save a value to sessionStorage indicating notification was displayed
function displayNotification(notification) {
	$(notification).addClass(DISPLAYED_CLASS);
	let notificationID = $(notification).attr('id');
	if(sessionStorage) {
		sessionStorage[notificationID] = '1';
	}

	if(sendGA !== undefined)
		sendGA('notification', 'display', notificationID);

	let isFormNotification = $(notification).hasClass(FORM_NOTIFICATION.replace('.',''));
	if(isFormNotification)
		formNotificationCounter++;
	notificationCounter++;
}

//notification should be displayed if it has not been displayed during this session (sessionStorage)
//neither user clicked on the close button (localStorage)
function shouldBeDisplayed(notification) {
	let notificationID = $(notification).attr('id');
	let isFormNotification = $(notification).hasClass(SPECIAL_CLASS);
	let limit = isFormNotification ? FORM_NOTIFICATIONS_DISPLAY_LIMIT : NOTIFICATIONS_DISPLAY_LIMIT;
	let current = isFormNotification ? formNotificationCounter : notificationCounter;

	if(current >= limit)
		return false;

	if(sessionStorage === undefined && localStorage === undefined)
		return true;

	return ((localStorage.getItem(notificationID) !== '1') && (sessionStorage[notificationID] !== '1'));
}

//hide notification from the screen and remove it from DOM
function deleteNotification(notification, trigger) {
	let notificationID = $(notification).attr('id');
	$(notification).removeClass(DISPLAYED_CLASS)
		.addClass(REMOVE_CLASS)
		.delay(300)
		.queue(function() {
			$(this).remove();
		});

	if(trigger !== false) {
		if(localStorage !== undefined)
			localStorage.setItem($(notification).attr('id'), '1');

		if(sendGA !== undefined) {
			if(trigger === 'close')
				sendGA('notification', 'close', notificationID);

			if(trigger === 'click')
				sendGA('notification', 'click', notificationID);
		}
	}
}
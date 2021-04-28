<?php
/**
 * Generate welcome session (Impact Hub Intro) occurences
 *
 * Creates welcome session for every day unless exception is set up as field option in administration
 *
 * When caching is enabled, this functionality will not work perfectly as the dates will be cached thus some
 * passed dates might be displayed on the page - this is resolved for now by setting cache TTL to 24 hours
 * worst case is then that "today's" welcome session will be visible even though it passed already
 */

add_filter( 'gform_field_input', 'createWelcomeSessions', 10, 2 );

// in case the form field has class ws-field, welcome session dates will be added as option to the select box
function createWelcomeSessions( $input, $field ) {

    if(strstr($field->cssClass, 'ws-field') === false || !is_array($field->choices) || !is_page())
        return $input;

    // known bug: this is actually number of weekdays that the welcome sessions will be generated
    // depending on which workdays are defined by getData*10() the number of generated welcome sessions may vary
    $wsCount = 15;
    $lastDay = getLastDay($wsCount);
    $options = addFixedExceptions($field->choices);
    $exceptions = createExceptions($options, $lastDay);

    $current_language = apply_filters('wpml_current_language', null);

    //Checking the language, and depending on the language, you get the proper data for Welcome sessions

    if(strstr($current_language, 'cs') !== false) {
        if(strstr($field->cssClass, 'k10') != false)
        {
            $data = getDataK10();
        } else {
            $data = getDataD10();
        }
    } else {
        if(strstr($field->cssClass, 'k10') != false)
        {
            $data = getDataK10();
        } else {
            $data = getDataD10ENG();
        }
    }



    $options = createOptions($exceptions, $lastDay, $data);

    $options[] = array(
        'text' => __('Suggest your own date', 'welcome_sessions'),
        'value' => __('Suggest your own date', 'welcome_sessions'),
        'selected' => false
    );
    $field->choices = $options;
    return $input;
}

// simulate fixed exceptions as they would be created as options through the gravity forms administration
// thanks to this they can be parsed in the same way as the ones created by user
// fixed exceptions are same for each year -- basically Czech business holidays
function addFixedExceptions(&$fieldOptions) {
    $exceptions = $fieldOptions;
    $fixed = array("1-1","5-1","5-8","6-5","6-6","9-28","10-28","11-17","12-24","12-25","12-26");
    foreach ($fixed as $value) {
        $exceptions[]['text'] = $value;
    }
    return $exceptions;
}

// parse all the exceptions using createException function
function createExceptions($options, $lastDay) {
    $exceptions = array();
    foreach ($options as $key => $option) {
        try {
            $exception = createException($option['text'], $lastDay);
            if($exception != null)
                $exceptions[] = $exception;
        } catch (Exception $ex) {
            continue;
        }
    }
    return $exceptions;
}

// parses string from the options to an exception
// there can be two types of exception
// 1. exact date in format yyyy-mm-dd
// 2. repeating day every year in format mm-dd
// that is why function tries to parse the date firstly (case 1) and then adds the current year (case 2)
// NULL is returned instead of the date of exception in case it does not fit in the time interval
// between now and $lastDay
function createException($text, $lastDay) {
    $now = new DateTime();
    try {
        $date = new DateTime($text);
    } catch (Exception $ex) {
        $date = null;
    }

    if($date == null) {
        try {
            $date = new DateTime($now->format('Y') . '-' . $text);
        } catch (Exception $ex) {
            return null;
        }
        if($date < $now)
            $date = $date->add(new DateInterval('P1Y'));
    }

    if($date < $now || $date > $lastDay)
        return null;

    return $date;
}

// generate date of the last working day so $numberOfDays fits into the interval
// between now and the returned date
function getLastDay($numberOfDays) {
    $date = new DateTime();
    while($numberOfDays > 0) {
        if($date->format('N') < 6)
            $numberOfDays--;
        $date = $date->add(new DateInterval('P1D'));
    }
    return $date;
}

// get data for the form labels for each work day
// indexes in the array are numbers of day in week
// when an index is not specified no option will be added to the form for that day
function getDataD10() {
    return array(
        1 => array(
            'h' => 14,
            'm' => 0,
            'text' => __("Monday Impact Hub Intro", 'welcome_sessions')
        ),
        2 => array(
            'h' => 10,
            'm' => 0,
            'text' => __("Tuesday Impact Hub Intro", 'welcome_sessions')
        ),
        4 => array(
            'h' => 16,
            'm' => 0,
            'text' => __("Thursday Impact Hub Intro", 'welcome_sessions')
        )
    );
}

function getDataD10ENG() {
    return array(
        3 => array(
            'h' => 15,
            'm' => 0,
            'text' => __("Wednesday Impact Hub Intro (in English)", 'welcome_sessions')
        )
    );
}

// same as above just for K10 location
function getDataK10() {
    return array(
        2 => array(
            'h' => 15,
            'm' => 30,
            'text' => __("Tuesday Impact Hub Intro", 'welcome_sessions')
        ),
        3 => array(
            'h' => 10,
            'm' => 0,
            'text' => __("Wednesday Impact Hub Intro", 'welcome_sessions')
        ),
        4 => array(
            'h' => 14,
            'm' => 0,
            'text' => __("Thursday Impact Hub Intro", 'welcome_sessions')
        )
    );
}

// creates form options based on the exceptions, time interval and form labels for days of week
// function iterates over the days in the interval, tests whether the day is included in exceptions
// and if it is not an exception new option is added to the array
function createOptions($exceptions, $lastDay, $data) {
    $options = array();
    $date = new DateTime();

    // iterate over the days in the interval
    while($date <= $lastDay) {
        // skip this day if the date is in exceptions or this workday has no welcome session defined
        if(isset($data[$date->format('N')]) && !in_array($date, $exceptions)) {
            // add time to the date as defined in $data
            $date = $date->setTime($data[$date->format('N')]['h'],$data[$date->format('N')]['m']);

            // skip welcome session that already occured (this depends on the time - do not create
            // welcome session if it has already passed)
            if($date >= (new DateTime())) {
                // create an option array
                $optionText = $date->format('j.n.Y G:i') . ' ' . $data[$date->format('N')]['text'];
                $options[] = array('text' => $optionText, 'value' => $optionText, 'selected' => false);
            }
        }
        // next day, reset time
        $date = $date->add(new DateInterval('P1D'));
        $date->setTime(0,0);
    }

    return $options;
}
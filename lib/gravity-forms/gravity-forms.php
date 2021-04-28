<?php

// Enables advanced symbols in confirmations, disables cache on pages with forms, customizes submit buttons and
// provides helper functions for other customizations
require_once locate_template('/lib/gravity-forms/customization.php');

// Provides functionality for submission confirmations and Google Analytics tracking of submissions
require_once locate_template('/lib/gravity-forms/ga-confirmations.php');

// Enables predefined template for automatic e-mail replies sent to users
require_once locate_template('/lib/gravity-forms/autoreply-template.php');
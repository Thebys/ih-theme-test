<?php
/**
 * Template defines the <head> element of every page.
 *
 * This template is called from base.php
 */
?>

<head>
	<meta charset="utf-8">
	<title><?php wp_title('|', true, 'right'); ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="referrer" content="origin-when-crossorigin">
    <!-- Chrome, Firefox OS and Opera -->
    <meta name="theme-color" content="#812926">
    <!-- Windows Phone -->
    <meta name="msapplication-navbutton-color" content="#812926">
    <!-- iOS Safari -->
    <meta name="apple-mobile-web-app-status-bar-style" content="#812926">
	<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri() ?>/assets/img/favicon.png"/>
	<?php wp_head(); ?>

	<link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">
</head>

<?php
/**
 * Base theme of the whole website.
 *
 * Thanks to the functionality of lib/wrapper.php concrete theme of the page/post/event/whatever will be inserted inside of this template.
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--><html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<?php get_template_part('templates/head'); ?>

<body <?php body_class(); ?>>
	<!--[if lt IE 7]><div class="alert"><?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'roots'); ?></div><![endif]-->
	<?php do_action('body_start'); ?>

    <?php get_template_part('templates/header'); ?>

    <main class="clearfix">
	    <?php do_action('inside_wrap_start'); ?>

        <div class="wrapper <?= !is_page() && !is_home() ? 'container' : '' ?>">
	        <?php do_action('inside_main_start'); ?>

            <?php get_template_part( 'templates/page', 'intro' ); ?>
            <?php include roots_template_path(); ?>

            <?php do_action('inside_main_end'); ?>
        </div>
	    <?php do_action('inside_wrap_end'); ?>
    </main>

	<?php get_template_part('templates/footer'); ?>

	<?php do_action('body_end'); ?>
</body>

</html>

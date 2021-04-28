<?php
/**
 * Template defines the header of every page
 *
 * This template is called from base.php
 */
?>

<header id="mainHeader">

	<?php do_action('start_header'); ?>

    <nav class="top-menu" role="navigation">
        <div class="navbar-top-black container">

            <div id="ls-cover">
				<?php do_action('hub_language_select'); ?>
            </div>

            <div class="header-icons">
                <a href="https://members.hubpraha.cz/profile/" target="_blank">
                    <img class="icon-header" src="/wp-content/themes/impacthub/assets/img/icons/member-login.png" data-toggle="tooltip" data-placement="bottom" title="<?= __('Member login', 'roots' ) ?>">
                </a>
            </div>

        </div>
    </nav>
    <nav class="main-menu" role="navigation">
        <div class="container">
            <div class="brand">
                <a class="brand-home" href="<?php echo home_url(); ?>">
                    <img src="/wp-content/themes/impacthub/assets/img/impact-hub-innovation-logo-red.png" alt="Impact Hub Logo" id="mainMenuLogo" />
                </a>
            </div>
            <div class="navigation" id="mainNav">
				<?php
				if (has_nav_menu('primary_navigation'))
					wp_nav_menu(array('theme_location' => 'primary_navigation'));
				?>
            </div>
        </div>
    </nav>

    <div class="shadow"></div>

	<?php do_action('end_header'); ?>

</header>

<?php
/**
 * Template of the footer of every page.
 */
?>

<footer id="footer">
	<div class="bottom-line"></div>

    <div class="container">
        <div class="col-xs-12" id="footer-logo">
            <img data-src="/wp-content/themes/impacthub/assets/img/impact-hub-logo-v2.png">
        </div>
        <div class="flex-boxes" id="footer-top">
            <div class="col-xs-12 col-sm-3" id="footer-left">
                <?php dynamic_sidebar( 'footer-left' ); ?>
            </div>
            <div class="col-xs-12 col-sm-5" id="footer-center">
                <?php dynamic_sidebar( 'footer-center' ); ?>
            </div>
            <div class="col-xs-12 col-sm-4" id="footer-right">
                <?php dynamic_sidebar( 'footer-right' ); ?>
            </div>
        </div>
        <div class="flex-boxes" id="footer-bottom">
            <div class="col-xs-12 col-sm-8" id="footer-form">
                <?php dynamic_sidebar( 'footer-bottom' ); ?>
            </div>
            <div class="col-xs-12 col-sm-4" id="footer-social">
                <?php if($url = get_theme_option_ifset('url_facebook')): ?>  <a href="<?= $url ?>" anec="footer-social-link" anea="click-facebook">Facebook</a><br> <?php endif; ?>
	            <?php if($url = get_theme_option_ifset('url_youtube')): ?>  <a href="<?= $url ?>" anec="footer-social-link" anea="click-youtube">YouTube</a><br> <?php endif; ?>
	            <?php if($url = get_theme_option_ifset('url_instagram')): ?>  <a href="<?= $url ?>" anec="footer-social-link" anea="click-instagram">Instagram</a><br> <?php endif; ?>
	            <?php if($url = get_theme_option_ifset('url_linkedin')): ?>  <a href="<?= $url ?>" anec="footer-social-link" anea="click-linkedin">Linkedin</a><br> <?php endif; ?>
	            <?php if($url = get_theme_option_ifset('url_slideslive')): ?>  <a href="<?= $url ?>" anec="footer-social-link" anea="click-slideslive">Slideslive</a><br> <?php endif; ?>
            </div>
        </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
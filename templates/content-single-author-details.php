<?php
/**
 * Template that displays author details in the single Story layout.
 *
 * This template is called from lib/similar-stories.php
 */

global $post;
$name = get_field('author_name');
$intro = get_field('author_intro');
$desc = get_field('author_description');
$image = get_field('author_image')['id'];
if($image)
    $image = wp_get_attachment_image( $image, 'thumbnail' );
$fb = get_field('author_fb');
$li = get_field('author_li');
$tw = get_field('author_tw');
$email = get_field('author_email');
$web = get_field('author_web');

if(!$name)
    return;
?>
<aside class="about-author padding-top-bottom-30">
	<div class="contained-row">
		<div class="col-xs-12 col-sm-3">
			<?= $image ?>
		</div>
		<div class="col-xs-12 col-sm-9 details">
		<?php if($intro) : ?>
			<p class="intro"><?= $intro ?></p>
		<?php endif; ?>
			<h3><?= $name ?></h3>
		<?php if($desc) : ?>
			<p class="secription"><?= $desc ?></p>
		<?php endif; ?>
			<div class="social">
				<?php if($fb) : ?>
					<a href="<?= $fb ?>"><span>Facebook</span><i class="icon-facebook"></i></a>
				<?php endif; ?>
				<?php if($li) : ?>
					<a href="<?= $li ?>"><span>Linkedin</span><i class="icon-linkedin"></i></a>
				<?php endif; ?>
				<?php if($tw) : ?>
					<a href="<?= $tw ?>"><span>Twitter</span><i class="icon-twitter"></i></a>
				<?php endif; ?>
				<?php if($email) : ?>
					<a href="mailto:<?= $email ?>"><span>Email</span><i class="icon-mail"></i></a>
				<?php endif; ?>
				<?php if($web) : ?>
					<a href="<?= $web ?>"><span>Web</span><i class="icon-globe01"></i></a>
				<?php endif; ?>  
			</div> 
		</div>
	</div>
</aside>
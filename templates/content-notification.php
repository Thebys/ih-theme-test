<?php
/**
 * Template used to display a single bottom left notification.
 *
 * This template is used in /lib/notifications.php for each of the notifications that should be displayed.
 */
?>

<div class="news-notification<?php
    ?> <?= get_field('field_background_picker') ?><?php
    ?> <?= get_field('form_or_newsletter_notification', false, false) == true ? 'special-form-notification' : ''; ?><?php
    ?>" id="<?= get_field('campaign_id')?>">
    <img src="<?= get_field('notification_image');?>" alt="">
    <button class="notification-close"><?php __( "Zavřít", "notification" ) ?><i class="icon-cross"></i></button>
    <div class="notification-content">
        <h2 class="new-headline <?= get_field('is_transparent_background', false, false) == true ? 'c-white' : ''; ?>"><?php the_title();?></h2>
        <p <?= get_field('is_transparent_background', false, false) == true ? 'class="c-white"' : ''; ?>><?= get_the_content();?></p>
        <a href="<?= get_field('button_link')?>/?utm_source=<?= $_SERVER['HTTP_HOST']?>&utm_medium=notification&utm_campaign=<?= get_field('campaign_id');?>&utm_content=<?= $_SERVER['REQUEST_URI']; ?>" class="page-button-new notification-action <?= get_field('is_transparent_background', false, false) == true ? 'transparent' : ''; ?>"><?= get_field('button_text')?></a>
    </div>
</div>
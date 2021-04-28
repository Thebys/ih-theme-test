<?php
/**
 * DEPRECATED: Template that displays date ond members only info inside an event banner.
 *
 * TODO: This is used by the old event layout. Remove it once you remove the layout itself.
 */
?>

<time class="date" datetime="<?php echo get_the_time('c'); ?>"><?php echo apply_filters('meta_time', get_the_date('')); ?></time>

<?php

$members_only_label = '';
$members_only_label = get_field('only_for_members');

if ( $members_only_label  == 'only_members'): ?>
<span class="sep members-only-sep">&#124;</span>
<span class="sep members-only-sep"><?php echo _e('MEMBERS ONLY', 'roots');?></span>
<?php endif; ?>

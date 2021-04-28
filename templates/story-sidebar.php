<?php
/**
 * Template used to display sidebar on the single Story page with recent stories
 *
 * This template is called from templates/content-single.php
 */

$postid = get_the_ID();
$posts = get_stories_similar_posts_sidebar($postid);
?>

<div class="bg-light-grey recent-stories-sidebar">
    <h2 class="new-headline margin-bottom-15"><?= __('Trending stories', 'roots') ?></h2>
    <?php
    render_similar_posts_sidebar($posts);
    ?>
</div>
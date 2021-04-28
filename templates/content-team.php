<?php
/**
 * DEPRECATED: Template used to display a Team Member from within the custom Elementor Loop element.
 *
 * TODO: Remove. This is an old layout not used anymore.
 */

global $post;
$description = get_field('description');
$contact_methods = get_field('contact_methods');
if(strlen($description) < 5)
    $description = null;
?>
<div class="toggle-square">
    <div class="toggle-square-head">
        <?php  if($description): ?>
            <a data-toggle="modal" href="#modal-<?php echo $post->post_name; ?>">
                <?php hub_post_thumbnail('mobile-square'); ?>
            </a>
        <?php else:
            if($contact_methods): ?>
            <a href="<?php echo $contact_methods[0]['url']; ?>" target="_blank">
                <?php hub_post_thumbnail('mobile-square'); ?>
            </a>
            <?php else:
                hub_post_thumbnail('mobile-square');
            endif;
        endif; ?>
    </div>

    <div class="toggle-square-body">
        <div class="toggle-square-text">
            <h4 class="media-heading ">
                <?php the_title(); ?>
            </h4>
            <?php if ($title = get_field('title')): ?>
                <div class="page-button">
                    <a data-toggle="modal" href="#modal-<?php echo $post->post_name; ?>">
                        <span class="action icon-eye"></span>
                        <span> <?php echo __('See a testimonial','roots'); ?> </span>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php if($description): ?>
    <!-- Modal -->
    <div class="modal fade" id="modal-<?php echo $post->post_name; ?>" tabindex="-1" role="dialog"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-close"><img
                        src="/wp-content/plugins/wonderplugin-lightbox/engine/skins/default/lightbox-close.png">
                </div>
                <div class="modal-body">
                    <?php if (has_post_thumbnail()): ?>
                        <div class="image">
                            <?php the_post_thumbnail('full'); ?>
                        </div>
                    <?php endif; ?>

                    <div class="media-body">
                        <h4 class="media-heading">
                            <?php the_title(); ?>
                        </h4>

                        <?php if ($title = get_field('title')): ?>
                            <h5 class="post-info">
                                <?php echo $title ?>
                            </h5>
                        <?php endif; ?>

                        <p class="description">
                            <?php echo $description; ?>
                        </p>

                        <?php if($contact_methods): ?>

                            <?php foreach ($contact_methods as $contact_method): ?>
                                <a href="<?= $contact_method['url'] ?>" target="_blank" class="page-button-new small"><?= $contact_method['title'] ?> </a>
                            <?php endforeach ?>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
	<?php endif; ?>
</div>
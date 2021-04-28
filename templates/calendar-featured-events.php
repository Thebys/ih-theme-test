<?php
/**
 * Template for featured events on the top of calendar view.
 *
 * This template is used by /templates/calendar.php
 */

/** @var WP_Post $primary Event to be displayed as primary featured */

/** @var WP_Post $secondary Event to be displayed as secondary featured*/

/** @var array $video Array with details about the video to be displayed among featured events*/

/** @var string $primaryOverride Content that will be displayed instead of the primary event. */
?>

<div class="clearfix featured-events">
	<div class="col-xs-12 col-md-6">
        <?php if(!$primaryOverride): ?>
		<a href="<?= get_permalink($primary) ?>" anec="calendar-page" anea="featured-primary">
			<div class="primary">
				<?php if(get_field('primary_event_background')): ?>
					<div class="bg"><img class="image-fill-container" src="<?= get_field('primary_event_background')['url'] ?>" alt="Primary featured event background"></div>
				<?php endif; ?>
				<div class="bg <?= get_field('primary_event_overlay'); ?>"></div>
				<span class="c-white date fgt-regular"><?= tribe_get_start_date($primary->ID, false, 'j. n.') ?></span>
				<h3 class="c-white fgt-regular title"><?= $primary->post_title ?></h3>
				<span class="page-button-new small transparent"><?= __('Detail', 'roots') ?></span>
			</div>
		</a>
        <?php else: ?>
            <div class="primary">
		        <?php if(get_field('primary_event_background')): ?>
                    <div class="bg"><img class="image-fill-container" src="<?= get_field('primary_event_background')['url'] ?>" alt="Primary featured event background"></div>
		        <?php endif; ?>
                <div class="bg <?= get_field('primary_event_overlay'); ?>"></div>
                <div class="c-white fgt-regular content-override"><?= $primaryOverride ?></div>
            </div>
        <?php endif; ?>
	</div>
	<?php
	$secondaryIsMashup = tribe_event_in_category('mashup', $secondary->ID) || tribe_event_in_category('mashup-en', $secondary->ID);
	?>
	<div class="col-xs-12 col-md-6">
		<a href="<?= get_permalink($secondary) ?>" anec="calendar-page" anea="featured-secondary">
			<div class="secondary valign-center">
				<?php if(get_field('secondary_event_background')): ?>
					<div class="bg"><img class="image-fill-container" src="<?= get_field('secondary_event_background')['url'] ?>" alt="Secondary featured event background"></div>
				<?php endif; ?>
				<div class="bg <?= get_field('secondary_event_overlay'); ?>"></div>
				<div class="flex-boxes">
					<div class="valign-center date-wrap">
						<span class="c-white date fgt-regular"><?= tribe_get_start_date($secondary->ID, false, 'j. n.') ?></span>
					</div>
					<div class="valign-center title-wrap">
						<?php if($secondaryIsMashup): ?>
							<img data-src="/wp-content/themes/impacthub/assets/img/mashup-title.png" alt="Mashup Title Graphics">
							<h3 class="hide"><?= $secondary->post_title ?></h3>
						<?php else: ?>
							<h3 class="c-white title fgt-regular"><?= $secondary->post_title ?></h3>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</a>
		<?php if($video['link'] && $video['label']): ?>
			<a data-toggle="modal" href="<?= $video['modal'] ?  "#modal-calendar-video" : $video['link'] ?>" <?= $video['modal'] ? '' : 'target="_blank"' ?> anec="calendar-page" anea="featured-video">
				<div class="valign-center secondary slideslive">
					<?php if(!empty($video['background'])): ?>
						<div class="bg"><img class="image-fill-container" src="<?= $video['background']['url'] ?>" alt="Video background"></div>
					<?php endif; ?>
					<div class="bg <?= get_field('video_overlay'); ?>"></div>
					<div class="flex-boxes">
						<div class="valign-center date-wrap">
							<i class="c-white fa fa-play"></i>
						</div>
						<div class="valign-center title-wrap">
							<h3 class="c-white fgt-regular title"><?= $video['label'] ?></h3>
						</div>
					</div>
				</div>
			</a>
		<?php endif; ?>
	</div>
</div>

<?php if($video['link'] && $video['modal']): ?>
<div class="modal fade gallery-modal in" id="modal-calendar-video" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<div class="modal-body">
				<?php if($video['slideslive']): ?>
					<div id="slideslive-embed"></div>
					<script src='https://slideslive.com/embed_presentation.js'></script>
					<script>
                        $videoModal = $("#modal-calendar-video");
                        $videoModal.on('shown.bs.modal', function(){
                            var embed = new SlidesLiveEmbed('slideslive-embed', {
                                presentationId: '<?= $video['link'] ?>',
                                autoPlay: true, // change to true to autoplay the embedded presentation
                                verticalEnabled: true
                            });
                        });

                        $videoModal.on('hide.bs.modal', function(){
                            $("#modal-calendar-video iframe").remove();
                        });
					</script>
				<?php else: ?>
					<iframe src="" data-src="<?= $video['link'] ?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
					<script type="text/javascript">
                        $videoModal = $("#modal-calendar-video");
                        $videoFrame = $videoModal.find("iframe");
                        var calendarVideoURL = $videoFrame.attr('data-src');

                        $videoModal.on('shown.bs.modal', function(){
                            $videoFrame.attr('src', calendarVideoURL);
                        });

                        /* Assign empty url value to the iframe src attribute when
                        modal hide, which stop the video playing */
                        $videoModal.on('hide.bs.modal', function(){
                            $videoFrame.attr('src', '');
                        });
					</script>
				<?php endif; ?>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
<?php endif; ?>
<?php
/**
 * Template used to display a Space from within the custom Elementor Loop element.
 */

global $post;

$seating_capacity = get_field('seating_capacity');
$standing_capacity = get_field('standing_capacity');

$meta = get_post_meta( get_the_ID(), 'mtg_meta', true )[0];
$bookingLink ="";

if(isset($meta["link"]))
	$bookingLink =$meta["link"];

$location_class = '';

if(has_term('k10', 'space_categories'))
	$location_class = 'k10';
if(has_term('d10', 'space_categories'))
	$location_class = 'd10';

$location_link = ICL_LANGUAGE_CODE == 'cs' ? '/' : '/en/';
$location_link .= $location_class;

?>

<div class="toggle-square space <?php if ($amenities = get_field('amenities')) echo $amenities; ?> <?= $location_class ?>" id="<?php echo $post->post_name; ?>">
	<div class="toggle-square-head">
		<?php hub_post_thumbnail('mobile-square'); ?>
	</div>

	<div class="toggle-square-body">
		<div class="toggle-square-text">
            <h4> <?php the_title(); ?> </h4>
            <div class="square-icon">
                <span class="fa fa-users"></span>
                <span><?php echo $seating_capacity; ?> </span>
            </div>
			<div class="page-button">
				<a href="<?php echo $bookingLink ?>">
					<span class="action icon-arrow4-right"></span>
					<span> <?php echo __('Select', 'roots') ?> </span> 
				</a>
			</div>
		</div>
	</div>

	<?php if($location_class == 'd10'): ?>
		<a href="<?= $location_link ?>" class="space-location-badge" data-tooltip="<?= __('Impact&nbsp;Hub&nbsp;Prague&nbsp;D10 Drtinova&nbsp;10, Prague&nbsp;5&nbsp;-&nbsp;Smíchov', 'impact_hub_locations') ?>"></a>
	<?php elseif($location_class == 'k10'): ?>
		<a href="<?= $location_link ?>" class="space-location-badge" data-tooltip="<?= __('Impact&nbsp;Hub&nbsp;Prague&nbsp;K10 Koperníkova&nbsp;10, Prague&nbsp;2&nbsp;-&nbsp;Vinohrady', 'impact_hub_locations') ?>"></a>
	<?php endif; ?>

</div>
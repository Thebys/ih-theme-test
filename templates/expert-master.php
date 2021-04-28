<?php
/**
 * Template used to define the layout of the experts page (/mentori).
 *
 * This template is called from within the render() method of IHExpertsFetcher.
 */

/** @var $this IHExpertsFetcher */
?>

<div class="impact-hub-experts">
	<div class="filters">
		<?php echo $this->renderFilterForm(); ?>
	</div>
	<div class="results">
		<?php echo $this->renderResults(); ?>
	</div>
</div>
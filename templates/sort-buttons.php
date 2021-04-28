<?php
/**
 * DEPRECATED: Sort buttons for the Stories page.
 *
 * TODO: Not used anymore. Remove.
 */

$order = get_query_var('order');

if ( $order == 'DESC' )
	$order_change = 'ASC';
if ( $order == 'ASC' )
	$order_change = 'DESC';
?>

<div class="sort-buttons">
	<div class="sort-buttons-inner clearfix">
		<span><?php _e('Sort by', 'roots') ?>:</span>
		<ul class="<?php echo strtolower($order); ?>">
			<li>
				<a <?php $active = ('date' == get_query_var('orderby') ) ? _e('class="active"') : '' ?> href="<?php echo add_query_arg( array('orderby' => 'date', 'order' => $order_change ) ); ?>"><?php _e('Date', 'roots') ?><i></i></a>
			</li>
		</ul>
		<?php hub_share_buttons(); ?>
	</div>

</div>
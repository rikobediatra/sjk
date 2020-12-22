<?php
/**
 * The sidebar containing the main widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package travel_joy
 */

if ( ! is_active_sidebar( 'sidebar' ) ) {
	return;
}
?>

<li class="right">
	<figure>
		<div class="aside-right">
			<?php dynamic_sidebar( 'sidebar' ); ?>
		</div>
	</figure>
</li>

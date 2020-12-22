<?php
/**
 * Template file for static content.
 *
 * @package travel-joy
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


$enable_content = travel_joy_get_theme_options( 'static_front_page', 'static_front_page', 'enable_content' );
if ( ! $enable_content ) {
	return;
}
?>
	<div id="section-static-content-wrapper">
		<div class="section-wrapper">
			<div class="static-content-header">
				<div class="title">
					<?php the_title( '<h2 class="title-h2">', '</h2>' ); ?>
					<div class="line"></div>
				</div>
			</div>
			<div class="static-contents">
				<?php the_content(); ?>
			</div>
		</div>
	</div>
<?php

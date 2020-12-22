<?php
/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$panel_name   = 'front page';
$section_name = 'popular destination';

$enable_popular_destination = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_popular_destination' );
$enable_popular_destination = apply_filters( 'travel_joy_frontpage_enable_popular_destination', $enable_popular_destination );

if ( $enable_popular_destination ) {
	?><!-- section 4 -->
	<div class="section-4">
		<div class="section-wrapper">
			<?php

			/**
			 * Hook travel_joy_frontpage_popular_destination_header.
			 *
			 * @hooked travel_joy_frontpage_popular_destination_header
			 */
			do_action( 'travel_joy_frontpage_popular_destination_header' );


			/**
			 * Hook travel_joy_frontpage_popular_destination.
			 *
			 * @hooked travel_joy_frontpage_popular_destination
			 */
			do_action( 'travel_joy_frontpage_popular_destination' );
			?>

		</div>
	</div>
	<!-- End of section4  -->
	<?php
}

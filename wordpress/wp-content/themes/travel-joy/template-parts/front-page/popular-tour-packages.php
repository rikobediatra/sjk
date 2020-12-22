<?php
/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Early exit if wp travel is not active.
 */
if ( ! travel_joy_is_wp_travel_active() ) {
	return;
}

/**
 * This start dates is the departure date for this section.
 */
$trip_start_dates = array();

$panel_name   = 'front page';
$section_name = 'popular tour packages';

$enable_popular_tour_packages = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_popular_tour_packages' );
$enable_popular_tour_packages = apply_filters( 'travel_joy_frontpage_enable_popular_tour_packages', $enable_popular_tour_packages );

if ( $enable_popular_tour_packages ) {
	?>
	<!-- section 6  -->
	<div class="section-6">
		<div class="section-wrapper">
			<?php

			/**
			 * Hook travel_joy_frontpage_popular_tour_packages_header.
			 */
			do_action( 'travel_joy_frontpage_popular_tour_packages_header' );


			/**
			 * Hook travel_joy_frontpage_popular_tour_packages.
			 */
			do_action( 'travel_joy_frontpage_popular_tour_packages' );
			?>

		</div>
	</div>
	<!-- End of section 6 -->
	<?php
}

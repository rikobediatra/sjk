<?php
/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$panel_name   = 'front page';
$section_name = 'trip activities';

$enable_trip_activities = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_trip_activities' );
$enable_trip_activities = apply_filters( 'travel_joy_frontpage_enable_trip_activities', $enable_trip_activities );

if ( $enable_trip_activities ) { ?>
	<!-- section 2  -->
	<div class="section-2" id="section-2">
		<div class="section-wrapper">
			<?php

			/**
			 * Hook travel_joy_frontpage_trip_activities_section_header.
			 *
			 * @hooked travel_joy_frontpage_trip_activities_section_header
			 */
			do_action( 'travel_joy_frontpage_trip_activities_section_header' );

			/**
			 * Hook travel_joy_frontpage_trip_activities_lists.
			 *
			 * @hooked travel_joy_frontpage_trip_activities_lists
			 */
			do_action( 'travel_joy_frontpage_trip_activities_lists' );
			?>
		</div>
	</div>
	<!-- End of section 2 -->
	<?php
}

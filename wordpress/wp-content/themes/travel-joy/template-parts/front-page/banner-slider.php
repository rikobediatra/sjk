<?php
/**
 * Exit if access directly.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$enable_banner_slider = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'enable_banner_slider' );
$enable_banner_slider = apply_filters( 'travel_joy_frontpage_enable_banner_slider', $enable_banner_slider );

if ( $enable_banner_slider ) {
	?>
	<main class="main_section">
		<?php

		/**
		 * Hook travel_joy_frontpage_banner_slider_social_links.
		 *
		 * @hooked travel_joy_frontpage_banner_slider_social_links
		 */
		do_action( 'travel_joy_frontpage_banner_slider_social_links' );

		?>
		<div class="main__container">

			<?php

			/**
			 * Hook travel_joy_frontpage_banner_slider.
			 *
			 * @hooked travel_joy_frontpage_banner_slider
			 */
			do_action( 'travel_joy_frontpage_banner_slider' );

			/**
			 * Hook travel_joy_frontpage_banner_slider_trip_filter.
			 *
			 * @hooked travel_joy_frontpage_banner_slider_trip_filter
			 */
			do_action( 'travel_joy_frontpage_banner_slider_trip_filter' );
			?>
		</div>
	</main>
	<?php
}

?>
	<div id="main-content">
<?php

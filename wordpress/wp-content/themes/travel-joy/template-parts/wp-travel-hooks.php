<?php
/**
 * This file handles the single itinerary page and archive-itinerary page of wp travel plugin.
 * It uses the default wp travel hooks.
 *
 * @package travel-joy
 */

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * ====================================
 * Hooks for the single itinerary page.
 * ====================================
 */

if ( ! function_exists( 'travel_joy_single_itinerary_header_contents' ) ) {

	/**
	 * Function to add header content before main content.
	 *
	 * @param int $trip_id WP Travel Trip ID.
	 */
	function travel_joy_single_itinerary_header_contents( $trip_id ) {
		$is_wp_travel_active = travel_joy_is_wp_travel_active();
		if ( ! $is_wp_travel_active ) {
			return;
		}
		$post_title     = get_the_title( $trip_id );
		$thumbnail      = ! empty( $trip_id ) ? get_the_post_thumbnail_url( $trip_id ) : false;
		$header_image   = has_header_image() ? get_header_image() : TRAVEL_JOY_PLACEHOLDER_IMAGE;
		$post_thumbnail = $thumbnail ? $thumbnail : $header_image;

		$trip_archive_link = get_post_type_archive_link( 'itineraries' );
		ob_start();
		?>
		<!-- Start of main section -->
		<div id="travel-joy-single-itinerary-header-container">
			<?php if ( $post_thumbnail ) { ?>
				<main class="main_section">
					<div class="main__container dynamic-content-page">
							<div class="image-item">
								<img src="<?php echo esc_url( $post_thumbnail ); ?>" alt="<?php echo esc_attr( $post_title ); ?>" />
							</div>
						<div class="main-overlay">
							<div class="description-box">
								<h1><?php echo esc_html( $post_title ); ?></h1>
								<?php
								/**
								 * Theme breadcrumb.
								 */
								travel_joy_get_breadcrumb();
								?>
							</div>
						</div>
					</div>
				</main>
			<?php } else { ?>
				<main class="main_section no_post_thumbnail">
					<div class="main__container">
						<div class="main-overlay">
							<div class="description-box">
								<h1><?php echo esc_html( $post_title ); ?></h1>
								<?php
								/**
								 * Theme breadcrumb.
								 */
								travel_joy_get_breadcrumb();
								?>
							</div>
						</div>
					</div>
				</main>
			<?php } ?>
		</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'wp_travel_before_single_itinerary', 'travel_joy_single_itinerary_header_contents', 5 );
}

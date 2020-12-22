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

$panel_name   = 'front page';
$section_name = 'featured trips slider';

$enable_featured_trips_slider = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_featured_trips_slider' );
$enable_button                = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_button' );
$button_label                 = travel_joy_get_theme_options( $panel_name, $section_name, 'button_label' );
$display_trip_details         = travel_joy_get_theme_options( $panel_name, $section_name, 'display_trip_details' );

$args = array(
	'post_type'   => 'itineraries',
	'post_status' => 'publish',
);

$query = new WP_Query( $args );
$trips = ! empty( $query->posts ) ? $query->posts : '';

$total_trips = is_array( $trips ) ? count( $trips ) : 0;

if ( $total_trips < 1 ) {
	$enable_featured_trips_slider = false;
}

$total_featured_trips = 0;
if ( is_array( $trips ) && count( $trips ) > 0 ) {
	foreach ( $trips as $trip ) {
		$trip_id     = ! empty( $trip->ID ) ? $trip->ID : '';
		$is_featured = ! empty( $trip_id ) ? get_post_meta( $trip_id, 'wp_travel_featured', true ) : false;

		if ( 'yes' === $is_featured ) {
			$total_featured_trips++;
		}
	}
}

if ( $total_featured_trips < 1 ) {
	$enable_featured_trips_slider = false;
}

if ( $enable_featured_trips_slider ) {
	?>
	<!-- secton 5 -->
	<div class="section-5">
		<div class="section-wrapper">
			<div class="slideshow-container">
				<section class="lazy slider" data-sizes="">
					<?php
					if ( is_array( $trips ) && count( $trips ) > 0 ) {
						foreach ( $trips as $trip ) {
							$settings    = wp_travel_get_settings();
							$trip_id     = ! empty( $trip->ID ) ? $trip->ID : '';
							$is_featured = ! empty( $trip_id ) ? get_post_meta( $trip_id, 'wp_travel_featured', true ) : false;
							if ( 'yes' === $is_featured ) {

								// General variables.
								$trip_name        = ! empty( $trip->post_title ) ? $trip->post_title : '';
								$trip_url         = get_post_permalink( $trip_id ) ? get_post_permalink( $trip_id ) : '';
								$average_rating   = wp_travel_get_average_rating( $trip_id );
								$travel_locations = ! empty( $trip_id ) ? get_the_terms( $trip_id, 'travel_locations' ) : '';
								$location         = ! empty( $travel_locations[0]->name ) ? $travel_locations[0]->name : __( 'N/A', 'travel-joy' );
								$itinerary_types  = ! empty( $trip_id ) ? get_the_terms( $trip_id, 'itinerary_types' ) : '';
								$trip_activities  = ! empty( $itinerary_types[0]->name ) ? $itinerary_types[0]->name : __( 'N/A', 'travel-joy' );

								// Departures and durations.
								$trip_start_date      = get_post_meta( $trip_id, 'wp_travel_start_date', true );
								$trip_end_date        = get_post_meta( $trip_id, 'wp_travel_end_date', true );
								$fixed_departure      = ! empty( $trip_start_date ) && ! empty( $trip_end_date ) ? $trip_start_date . ' - ' . $trip_end_date : '';
								$trip_duration        = get_post_meta( $trip_id, 'wp_travel_trip_duration', true );
								$trip_duration        = ( $trip_duration ) ? $trip_duration : 0;
								$trip_duration_night  = get_post_meta( $trip_id, 'wp_travel_trip_duration_night', true );
								$trip_duration_night  = ( $trip_duration_night ) ? $trip_duration_night : 0;
								$trip_duration_string = $trip_duration > 0 ? sprintf( __( '%1$d Days(s), %2$d Night(s)', 'travel-joy' ), $trip_duration, $trip_duration_night ) : __( 'N/A', 'travel-joy' ); // phpcs:ignore
								$duration             = ! empty( $fixed_departure ) ? $fixed_departure : $trip_duration_string;

								// Prices and symbols.
								$currency_code   = ( ! empty( $settings['currency'] ) ) ? $settings['currency'] : '';
								$currency_symbol = wp_travel_get_currency_symbol( $currency_code );
								$price_per_text  = wp_travel_get_price_per_text( $trip_id );
								$trip_price      = wp_travel_get_price( $trip_id );
								$regular_price   = wp_travel_get_price( $trip_id, true );
								$enable_sale     = wp_travel_is_enable_sale_price( $trip_id, true );
								$sale_price      = wp_travel_get_price( $trip_id );
								$min_pricing_id  = wp_travel_get_min_pricing_id( $trip_id );
								$min_pricing_id  = ! empty( $min_pricing_id['pricing_id'] ) ? $min_pricing_id['pricing_id'] : '';
								$pricings        = wp_travel_get_trip_pricing_option( $trip_id );
								$pricings        = ! empty( $pricings['pricing_data'][ $min_pricing_id ] ) ? $pricings['pricing_data'][ $min_pricing_id ] : '';
								$categories      = ! empty( $pricings['categories'] ) ? $pricings['categories'] : '';

								// PAX and groups.
								$inventory = ! empty( $pricings['inventory'] ) ? $pricings['inventory'] : '';
								$min_pax   = ! empty( $inventory['min_pax'] ) ? $inventory['min_pax'] : '';
								$max_pax   = ! empty( $inventory['max_pax'] ) ? $inventory['max_pax'] : '';
								?>
								<div>
									<div class="flex-box">
										<div class="flex__image-box box__shadow">
											<a href="<?php echo esc_url( $trip_url ); ?>">
												<?php echo wp_travel_get_post_thumbnail( $trip_id, 'large' ); // phpcs:ignore ?>
											</a>
										</div>
										<div class="flex__description-box">

											<div class="title">
												<a href="<?php echo esc_url( $trip_url ); ?>">
													<h3><?php echo esc_html( $trip_name ); ?></h3>
												</a>
											</div>

											<div class="review-box">
												<?php if ( ! empty( $trip_price ) ) { ?>
													<?php if ( $enable_sale && ! empty( $sale_price ) ) { ?>
														<p>
															<del>
																<?php echo wp_travel_get_formated_price_currency( $regular_price, true, '', $trip_id ); // phpcs:ignore ?>
															</del>
															<?php echo wp_travel_get_formated_price_currency( $sale_price, false, '', $trip_id ); // phpcs:ignore ?>
														</p>
													<?php } else { ?>
														<p>
															<?php echo wp_travel_get_formated_price_currency( $trip_price, true, '', $trip_id  ); // phpcs:ignore ?>
														</p>
													<?php } ?>
												<?php } else { ?>
													<p><?php esc_html_e( 'Price N/A', 'travel-joy' ); ?></p>
												<?php } ?>
												<div class="review-item__right" title="<?php printf( esc_attr__( 'Rated %s out of 5', 'travel-joy' ), $average_rating ); // phpcs:ignore ?>">
													<div class="rating-with-no-color">
														<span class="bg-rating">
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
														</span>
														<span class="rating-overlay-with-color" style="width:<?php echo esc_attr( ( $average_rating / 5 ) * 100 ); ?>%;">
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
															<i class="fas fa-star"></i>
														</span>
													</div>
													<p><?php printf( esc_html__( '%d reviews', 'travel-joy' ), $average_rating ); // phpcs:ignore ?></p>
												</div>
											</div>

											<div class="flex__description">
												<p><?php echo esc_html( get_the_excerpt( $trip_id ) ); ?></p>
											</div>

											<?php if ( $enable_button ) { ?>
												<div class="button__box">
													<a href="<?php echo esc_url( $trip_url ); ?>"><button class="btn-prop primary-button"><?php echo esc_html( $button_label ); ?></button></a>
												</div>
											<?php } ?>

											<?php if ( $display_trip_details ) { ?>
												<div class="flex__footer">
													<div class="bottom-position">
														<div class="flex-define">

															<div class="column">
																<div class="title">
																	<p><?php esc_html_e( 'Duration', 'travel-joy' ); ?></p>
																</div>
																<div class="detail">
																	<p><?php echo esc_html( $duration ); ?></p>
																</div>
															</div>

															<div class="column">
																<div class="title">
																	<p><?php esc_html_e( 'Trip Type', 'travel-joy' ); ?></p>
																</div>
																<div class="detail">
																	<p><?php echo esc_html( $trip_activities ); ?></p>
																</div>
															</div>

															<div class="column">
																<div class="title">
																	<p><?php esc_html_e( 'Group Sizes', 'travel-joy' ); ?></p>
																</div>
																<div class="detail">
																	<p>
																	<?php
																	if ( ! empty( $min_pax ) && ! empty( $max_pax ) ) {
																		/* translators: %1$d is Minimum Pax, %2$d is Maximum Pax */
																		printf( esc_html__( '%1$d - %2$d PAX', 'travel-joy' ), esc_html( $min_pax ), esc_html( $max_pax ) );
																	} else {
																		esc_html_e( 'N/A', 'travel-joy' );
																	}
																	?>
																	</p>
																</div>
															</div>

															<div class="column">
																<div class="title">
																	<p><?php esc_html_e( 'Location', 'travel-joy' ); ?></p>
																</div>
																<div class="detail">
																	<p><?php echo esc_html( $location ); ?></p>
																</div>
															</div>

														</div>
													</div>
												</div>
											<?php } ?>

										</div>
									</div>
								</div>
								<?php
							}
						}
					}
					?>
				</section>
			</div>
		</div>
	</div>
	<!-- End of section 5 -->
	<?php
}

wp_reset_postdata();

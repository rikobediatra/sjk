<?php
/**
 * This file has the required codes for the frontpage section hooks.
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
 * ==========================================
 * Hooks for the banner slider section starts.
 * ==========================================
 */

if ( ! function_exists( 'travel_joy_frontpage_enable_banner_slider' ) ) {

	/**
	 * It hook in filter to override the $enable_banner_slider accordingly.
	 *
	 * @param bool $enable_banner_slider Is banner slider must of enabled or disabled.
	 * @return bool $enable_banner_slider Is banner slider must of enabled or disabled.
	 */
	function travel_joy_frontpage_enable_banner_slider( $enable_banner_slider ) {
		$term_name             = '';
		$pages_dropdown        = array();
		$is_wp_travel_terms    = false;
		$taxonomy_name         = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'taxonomies_dropdown' );
		$number_of_trip_slides = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'number_of_trip_slides' );
		$post_type_name        = travel_joy_get_post_name_by_taxonomy( $taxonomy_name );

		if ( 'category' === $taxonomy_name ) {
			$term_name = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'terms_category_dropdown' );
		}
		if ( 'travel_locations' === $taxonomy_name ) {
			$term_name          = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'terms_travel_locations_dropdown' );
			$is_wp_travel_terms = true;
		}
		if ( 'itinerary_types' === $taxonomy_name ) {
			$term_name          = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'terms_itinerary_types_dropdown' );
			$is_wp_travel_terms = true;
		}

		if ( $is_wp_travel_terms && empty( $term_name ) ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy_name,
					'hide_empty' => false,
				)
			);
			if ( ! is_object( $terms ) ) {
				$term_name = is_array( $terms ) && ! empty( $terms[0]->slug ) ? $terms[0]->slug : '';
			}
		}

		$args = array(
			'post_type'      => $post_type_name,
			'post_status'    => 'publish',
			'posts_per_page' => $number_of_trip_slides,
			'tax_query'      => array( // phpcs:ignore
				array(
					'taxonomy' => $taxonomy_name,
					'field'    => 'slug',
					'terms'    => $term_name,
				),
			),
		);

		$query       = new WP_Query( $args );
		$slide_posts = ! empty( $query->posts ) ? $query->posts : '';

		/**
		 * Override the slider posts and create array of pages details when user select the pages in taxonomy dropdown.
		 */
		if ( 'pages' === $taxonomy_name ) {
			$slide_posts    = array();
			$pages_dropdown = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'pages_dropdown' );
			if ( count( $pages_dropdown ) > 0 ) {
				foreach ( $pages_dropdown as $page_id ) {
					$page_details = get_post( $page_id );
					array_push( $slide_posts, $page_details );
				}
			}
		}
		wp_reset_postdata();

		return $enable_banner_slider;
	}
	add_filter( 'travel_joy_frontpage_enable_banner_slider', 'travel_joy_frontpage_enable_banner_slider' );
}

if ( ! function_exists( 'travel_joy_frontpage_banner_slider_social_links' ) ) {

	/**
	 * Hooks the social link at banner slider section.
	 */
	function travel_joy_frontpage_banner_slider_social_links() {
		$enable_social_links = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'enable_social_links' );
		if ( ! $enable_social_links ) {
			return;
		}

		$enable             = true;
		$social_links_array = array();

		$social_links = array( 'facebook', 'twitter', 'linkedin', 'instagram' );
		if ( is_array( $social_links ) && count( $social_links ) > 0 ) {
			foreach ( $social_links as $index => $social_link_key ) {
				$links = travel_joy_get_theme_options( 'front_page', 'banner_slider', $social_link_key );
				if ( ! empty( $links ) ) {
					$social_links_array[ $index ] = $links;
				}
			}
		}

		if ( empty( $social_links_array ) ) {
			$enable = false;
		}

		if ( ! $enable ) {
			?>
			<!-- This css helps in banner full width when no social links are provided. -->
			<style type="text/css">
				.wrapper .main_section .main__container {
					width: 100%;
				}
				.wrapper .main_section .main__container img {
					border-radius: 0;
				}
			</style>
			<?php
			return;
		}

		ob_start();
		?>
			<aside>
				<ul>
					<?php
					if ( is_array( $social_links ) && count( $social_links ) > 0 ) {
						foreach ( $social_links as $social_link_key ) {
							$social_link_url    = travel_joy_get_theme_options( 'front_page', 'banner_slider', $social_link_key );
							$social_link_string = ucfirst( $social_link_key );
							if ( ! empty( $social_link_url ) ) {
								?>
									<li>
										<a class="<?php echo esc_attr( $social_link_key ); ?>" href="<?php echo esc_url( $social_link_url ); ?>">
											<?php echo esc_html( $social_link_string ); ?>
										</a>
									</li>
								<?php
							}
						}
					}
					?>
				</ul>
				<div class="down-arrow">
					<a href="#main-content" class="scroll"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/image/scrolldown.png"></a>
				</div>
			</aside>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_frontpage_banner_slider_social_links', 'travel_joy_frontpage_banner_slider_social_links' );
}

if ( ! function_exists( 'travel_joy_frontpage_banner_slider' ) ) {

	/**
	 * Hooks the banner sliders to the frontpage.
	 */
	function travel_joy_frontpage_banner_slider() {

		$term_name             = '';
		$pages_dropdown        = array();
		$is_wp_travel_terms    = false;
		$taxonomy_name         = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'taxonomies_dropdown' );
		$number_of_trip_slides = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'number_of_trip_slides' );
		$post_type_name        = travel_joy_get_post_name_by_taxonomy( $taxonomy_name );
		$is_wp_travel_active   = travel_joy_is_wp_travel_active();

		if ( 'category' === $taxonomy_name ) {
			$term_name = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'terms_category_dropdown' );
		}
		if ( 'travel_locations' === $taxonomy_name ) {
			$term_name          = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'terms_travel_locations_dropdown' );
			$is_wp_travel_terms = true;
		}
		if ( 'itinerary_types' === $taxonomy_name ) {
			$term_name          = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'terms_itinerary_types_dropdown' );
			$is_wp_travel_terms = true;
		}

		if ( $is_wp_travel_terms && empty( $term_name ) ) {
			$terms = get_terms(
				array(
					'taxonomy'   => $taxonomy_name,
					'hide_empty' => false,
				)
			);
			if ( ! is_object( $terms ) ) {
				$term_name = ! empty( $terms[0]->slug ) ? $terms[0]->slug : '';
			}
		}

		$args = array(
			'post_type'      => $post_type_name,
			'post_status'    => 'publish',
			'posts_per_page' => $number_of_trip_slides,
			'tax_query'      => array( // phpcs:ignore
				array(
					'taxonomy' => $taxonomy_name,
					'field'    => 'slug',
					'terms'    => $term_name,
				),
			),
		);

		$query       = new WP_Query( $args );
		$slide_posts = ! empty( $query->posts ) ? $query->posts : '';

		/**
		 * Override the slider posts and create array of pages details when user select the pages in taxonomy dropdown.
		 */
		if ( 'pages' === $taxonomy_name ) {
			$slide_posts    = array();
			$pages_dropdown = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'pages_dropdown' );
			if ( count( $pages_dropdown ) > 0 ) {
				foreach ( $pages_dropdown as $page_id ) {
					$page_details = get_post( $page_id );
					array_push( $slide_posts, $page_details );
				}
			}
		}

		if ( is_array( $slide_posts ) && count( $slide_posts ) > 0 ) {
			ob_start();
			?>
			<!-- background image slider -->
			<div class="main__slider">
				<section class="lazy slider" data-sizes="">
					<?php
					foreach ( $slide_posts as $slide_post ) {
						$slider_post_id    = ! empty( $slide_post->ID ) ? $slide_post->ID : '';
						$slider_post_title = ! empty( $slide_post->post_title ) ? $slide_post->post_title : '';
						$is_trip_post      = get_post_type( $slider_post_id ) && 'itineraries' === get_post_type( $slider_post_id ) ? true : false;
						$slider_thumbnail  = get_the_post_thumbnail_url( $slider_post_id ) ? get_the_post_thumbnail_url( $slider_post_id ) : TRAVEL_JOY_PLACEHOLDER_IMAGE;
						?>
						<div>
							<div class="image-container" style="position:relative;">
								<img src="<?php echo esc_url( $slider_thumbnail ); ?>" alt="<?php echo esc_attr( $slider_post_title ); ?>" />
								<div class="main-overlay">
									<div class="description-box">
										<h2><?php echo esc_html( $slider_post_title ); ?></h2>
										<p><?php echo esc_html( get_the_excerpt( $slider_post_id ) ); ?></p>
										<div class="main__button">
										<?php
										if ( $is_wp_travel_active && $is_trip_post ) {
											$trip_url = get_post_permalink( $slider_post_id ) ? get_post_permalink( $slider_post_id ) : '';
											?>
											<div class=" button-item">
												<a href="<?php echo esc_url( $trip_url ); ?>/#booking"><button class="bttn primary-button"><?php esc_html_e( 'Book Now', 'travel-joy' ); ?></button></a>
											</div>
										<?php } ?>
											<div class="button-item">
												<a href="<?php echo esc_url( get_the_permalink( $slider_post_id ) ); ?>"><button class="bttn btn-right secondary-button"><?php esc_html_e( 'More Info', 'travel-joy' ); ?></button></a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php } ?>
				</section>
			</div>
			<!-- end of background-image slider -->
			<?php
		}
		$content = ob_get_contents();
		ob_end_flush();
		wp_reset_postdata();

		return $content;
	}
	add_action( 'travel_joy_frontpage_banner_slider', 'travel_joy_frontpage_banner_slider' );
}

if ( ! function_exists( 'travel_joy_frontpage_banner_slider_trip_filter' ) ) {

	/**
	 * Handles the work for the trip filter at banner slider section.
	 */
	function travel_joy_frontpage_banner_slider_trip_filter() {
		$is_wp_travel_active  = travel_joy_is_wp_travel_active();
		$enable_search_filter = travel_joy_get_theme_options( 'front_page', 'banner_slider', 'enable_search_filter' );

		if ( ! $is_wp_travel_active ) {
			$enable_search_filter = false;
		}

		if ( ! $enable_search_filter ) {
			return;
		}

		ob_start();
		?>
			<div class="botton-overlay">
				<form class="description-box" action="">
					<div class="item item-1">
						<i class="fas fa-map-marker-alt"></i>
						<?php
							$taxonomy_name = 'travel_locations';
							$args          = array(
								'show_option_all'   => esc_html__( 'All Location', 'travel-joy' ),
								'show_option_none'  => esc_html__( 'All Location', 'travel-joy' ),
								'option_none_value' => esc_html__( 'All Location', 'travel-joy' ),
								'hide_empty'        => 0,
								'selected'          => 1,
								'hierarchical'      => 1,
								'name'              => $taxonomy_name,
								'class'             => 'wp-travel-taxonomy',
								'taxonomy'          => $taxonomy_name,
								'value_field'       => 'slug',
							);
							wp_dropdown_categories( $args, $taxonomy_name );
							?>
					</div>
					<div class="item item-2">
						<?php
							$taxonomy_name = 'itinerary_types';
							$args          = array(
								'show_option_all'   => esc_html__( 'Trip Types', 'travel-joy' ),
								'show_option_none'  => esc_html__( 'Trip Types', 'travel-joy' ),
								'option_none_value' => esc_html__( 'Trip Types', 'travel-joy' ),
								'hide_empty'        => 1,
								'selected'          => 1,
								'hierarchical'      => 1,
								'name'              => $taxonomy_name,
								'class'             => 'wp-travel-taxonomy',
								'taxonomy'          => $taxonomy_name,
								'value_field'       => 'slug',
							);
							wp_dropdown_categories( $args, $taxonomy_name );
							?>
					</div>
					<div class="item item-3">
						<input type="text" name="s" placeholder="<?php esc_attr_e( 'Keyword', 'travel-joy' ); ?>" id="search">
					</div>
					<div class="item item-4">
						<button type="submit" class="primary-button"><?php esc_html_e( 'Search', 'travel-joy' ); ?></button>
					</div>
				</form>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_frontpage_banner_slider_trip_filter', 'travel_joy_frontpage_banner_slider_trip_filter' );
}



/**
 * ============================================
 * Hooks for the Trip activities section starts.
 * ============================================
 */

if ( ! function_exists( 'travel_joy_frontpage_enable_trip_activities' ) ) {

	/**
	 * Override the $enable_trip_activities value.
	 *
	 * @param bool $enable_trip_activities Enable or disable trip activities.
	 * @return bool $enable_trip_activities Enable or disable trip activities.
	 */
	function travel_joy_frontpage_enable_trip_activities( $enable_trip_activities ) {
		$trip_activities = get_terms(
			array(
				'taxonomy'   => 'activity',
				'hide_empty' => false,
			)
		);

		$total_activities = is_array( $trip_activities ) ? count( $trip_activities ) : 0;

		if ( ! $total_activities ) {
			$enable_trip_activities = false;
		}

		return $enable_trip_activities;
	}
	add_filter( 'travel_joy_frontpage_enable_trip_activities', 'travel_joy_frontpage_enable_trip_activities' );
}

if ( ! function_exists( 'travel_joy_frontpage_trip_activities_section_header' ) ) {

	/**
	 * Hooks the trip_activities header.
	 */
	function travel_joy_frontpage_trip_activities_section_header() {
		$panel_name   = 'front page';
		$section_name = 'trip activities';

		$main_heading       = travel_joy_get_theme_options( $panel_name, $section_name, 'main heading' );
		$sub_heading        = travel_joy_get_theme_options( $panel_name, $section_name, 'sub heading' );
		$enable_button      = travel_joy_get_theme_options( $panel_name, $section_name, 'Enable button' );
		$button_custom_link = travel_joy_get_theme_options( $panel_name, $section_name, 'button_custom_link' );
		$button_label       = travel_joy_get_theme_options( $panel_name, $section_name, 'button label' );

		ob_start();
		?>
			<div class="section__header">
				<div class="title">
					<h2 class="title-h2"><?php echo esc_html( $main_heading ); ?></h2>
					<p class="section-header-description"><?php echo esc_html( $sub_heading ); ?></p>
				</div>
				<?php if ( $enable_button ) { ?>
					<div class="button-item">
						<a href="<?php echo esc_url( $button_custom_link ); ?>"><button class="bttn primary-button"><?php echo esc_html( $button_label ); ?></button></a>
					</div>
				<?php } ?>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_frontpage_trip_activities_section_header', 'travel_joy_frontpage_trip_activities_section_header' );
}

if ( ! function_exists( 'travel_joy_frontpage_trip_activities_lists' ) ) {

	/**
	 * Hook for listing of trip activities.
	 */
	function travel_joy_frontpage_trip_activities_lists() {

		$panel_name   = 'front page';
		$section_name = 'trip activities';

		$display_all         = travel_joy_get_theme_options( $panel_name, $section_name, 'display all trip activities' );
		$selected_activities = travel_joy_get_theme_options( $panel_name, $section_name, 'activities' );
		$number_of_packages  = travel_joy_get_theme_options( $panel_name, $section_name, 'number_of_packages' );

		$trip_activities = get_terms(
			array(
				'taxonomy'   => 'activity',
				'hide_empty' => false,
			)
		);

		$total_activities = is_array( $trip_activities ) ? count( $trip_activities ) : 0;

		if ( ! $total_activities ) {
			return;
		}

		ob_start();
		?>
			<div class="section02-gallery">
				<section class="grid-box">
					<ul>
						<?php
						foreach ( $trip_activities as $index => $trip_activity ) {
							$trip_activity_id   = ! empty( $trip_activity->term_id ) ? $trip_activity->term_id : '';
							$trip_activity_name = ! empty( $trip_activity->name ) ? $trip_activity->name : '';
							$trip_activity_slug = ! empty( $trip_activity->slug ) ? $trip_activity->slug : '';
							$post_count         = ! empty( $trip_activity->count ) ? $trip_activity->count : 0;
							$image_id           = get_term_meta( $trip_activity_id, 'wp_travel_trip_type_image_id', true );
							$image_url          = ! empty( $image_id ) ? wp_get_attachment_url( $image_id ) : TRAVEL_JOY_PLACEHOLDER_IMAGE;
							$trip_activity_url  = ! empty( $trip_activity_id ) ? get_term_link( $trip_activity_id ) : '';
							$selected_activity  = ! empty( $selected_activities[ $index ] ) ? $selected_activities[ $index ] : false;

							if ( ! $display_all && $selected_activity !== $trip_activity_slug ) {
								continue;
							}
							if ( $post_count >= 2 ) {
								/* translators: %d is the number of available posts. */
								$count_string = sprintf( __( '%d Trips Available', 'travel-joy' ), $post_count );
							} elseif ( 1 === $post_count ) {
								/* translators: %d is the number of available posts. */
								$count_string = sprintf( __( '%d Trip Available', 'travel-joy' ), $post_count );
							} else {
								$count_string = __( 'No Trips Available', 'travel-joy' );
							}

							if ( $index < $number_of_packages ) {
								?>
								<li>
									<figure>
										<!-- Photo by Quentin Dr on Unsplash -->
										<img src="<?php echo esc_url( $image_url ); ?>">
										<div class="overlay">
											<div class="image-overlay overlay__bottom">
												<div class="left">
													<a href="<?php echo esc_url( $trip_activity_url ); ?>">
														<?php echo esc_html( $trip_activity_name ); ?>
													</a>
													<span><i class="fas fa-suitcase-rolling"></i> <?php echo esc_html( $count_string ); ?> </span>
												</div>
												<div class="right ">
													<a href="<?php echo esc_url( $trip_activity_url ); ?>"><span class="right-arrow primary-button"><i class="fas fa-arrow-right"></i></span></a>
												</div>
											</div>
										</div>
									</figure>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</section>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_frontpage_trip_activities_lists', 'travel_joy_frontpage_trip_activities_lists' );
}




/**
 * ==================================
 * Hooks for the popular destination.
 * ==================================
 */

if ( ! function_exists( 'travel_joy_frontpage_enable_popular_destination' ) ) {

	/**
	 * Override the enable popular destination.
	 *
	 * @param bool $enable_popular_destination Enable or disable section.
	 * @return bool $enable_popular_destination Enable or disable section.
	 */
	function travel_joy_frontpage_enable_popular_destination( $enable_popular_destination ) {

		$travel_locations = get_terms(
			array(
				'taxonomy'   => 'travel_locations',
				'hide_empty' => false,
			)
		);

		$total_destinations = is_array( $travel_locations ) ? count( $travel_locations ) : 0;

		if ( ! $total_destinations ) {
			$enable_popular_destination = false;
		}

		return $enable_popular_destination;
	}
	add_filter( 'travel_joy_frontpage_enable_popular_destination', 'travel_joy_frontpage_enable_popular_destination' );
}

if ( ! function_exists( 'travel_joy_frontpage_popular_destination_header' ) ) {

	/**
	 * Popular destination header hook.
	 */
	function travel_joy_frontpage_popular_destination_header() {
		$panel_name   = 'front page';
		$section_name = 'popular destination';

		$main_heading       = travel_joy_get_theme_options( $panel_name, $section_name, 'main_heading' );
		$sub_heading        = travel_joy_get_theme_options( $panel_name, $section_name, 'sub_heading' );
		$button_label       = travel_joy_get_theme_options( $panel_name, $section_name, 'button_label' );
		$button_custom_link = travel_joy_get_theme_options( $panel_name, $section_name, 'button_custom_link' );

		ob_start();
		?>
			<div class="section__header">
				<div class="title">
					<h2 class="title-h2"><?php echo esc_html( $main_heading ); ?></h2>
					<p class="section-header-description"><?php echo esc_html( $sub_heading ); ?></p>
				</div>
				<div class="button-item">
					<a href="<?php echo esc_url( $button_custom_link ); ?>"><button class="bttn primary-button"><?php echo esc_html( $button_label ); ?></button></a>
				</div>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_frontpage_popular_destination_header', 'travel_joy_frontpage_popular_destination_header' );
}

if ( ! function_exists( 'travel_joy_frontpage_popular_destination' ) ) {

	/**
	 * Hooks the popular destination listing.
	 */
	function travel_joy_frontpage_popular_destination() {

		$panel_name   = 'front page';
		$section_name = 'popular destination';

		$display_all           = travel_joy_get_theme_options( $panel_name, $section_name, 'Display all popular destinations' );
		$selected_destinations = travel_joy_get_theme_options( $panel_name, $section_name, 'destinations' );
		$number_of_destination = travel_joy_get_theme_options( $panel_name, $section_name, 'number_of_destination' );

		$travel_locations = get_terms(
			array(
				'taxonomy'   => 'travel_locations',
				'hide_empty' => false,
			)
		);

		$total_destinations = is_array( $travel_locations ) ? count( $travel_locations ) : 0;

		if ( ! $total_destinations ) {
			return;
		}

		ob_start();
		?>
			<div class="section04-gallery">
				<section class="grid-box">
					<ul>
					<?php
					foreach ( $travel_locations as $index => $travel_location ) {
						$travel_location_id   = ! empty( $travel_location->term_id ) ? $travel_location->term_id : '';
						$travel_location_name = ! empty( $travel_location->name ) ? $travel_location->name : '';
						$travel_location_slug = ! empty( $travel_location->slug ) ? $travel_location->slug : '';
						$post_count           = ! empty( $travel_location->count ) ? $travel_location->count : 0;
						$image_id             = get_term_meta( $travel_location_id, 'wp_travel_trip_type_image_id', true );
						$image_url            = ! empty( $image_id ) ? wp_get_attachment_url( $image_id ) : TRAVEL_JOY_PLACEHOLDER_IMAGE;
						$travel_location_url  = ! empty( $travel_location_id ) ? get_term_link( $travel_location_id ) : '';
						$selected_location    = ! empty( $selected_destinations[ $index ] ) ? $selected_destinations[ $index ] : false;

						if ( ! $display_all && $selected_location !== $travel_location_slug ) {
							continue;
						}
						if ( $post_count >= 2 ) {
							/* translators: %d is the number of available posts. */
							$count_string = sprintf( __( '%d Trips Available', 'travel-joy' ), $post_count );
						} elseif ( 1 === $post_count ) {
							/* translators: %d is the number of available posts. */
							$count_string = sprintf( __( '%d Trip Available', 'travel-joy' ), $post_count );
						} else {
							$count_string = __( 'No Trips Available', 'travel-joy' );
						}

						if ( $index < $number_of_destination ) {
							?>
							<li>
								<figure>
									<img src="<?php echo esc_url( $image_url ); ?>">
									<div class="overlay">
										<div class="image-overlay overlay__bottom">
											<div class="left">
												<a href="<?php echo esc_url( $travel_location_url ); ?>">
													<?php echo esc_html( $travel_location_name ); ?>
												</a>
												<span><i class="fas fa-suitcase-rolling"></i><?php echo esc_html( $count_string ); ?></span>
											</div>
											<div class="right ">
												<a href="<?php echo esc_url( $travel_location_url ); ?>"><span class="right-arrow primary-button"><i class="fas fa-arrow-right"></i></span></a>
											</div>
										</div>
									</div>
								</figure>
							</li>
							<?php
						}
					}
					?>
					</ul>
				</section>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_frontpage_popular_destination', 'travel_joy_frontpage_popular_destination' );
}


/**
 * ============================================
 * Hooks for the popular tour packages starts
 * ============================================
 */

if ( ! function_exists( 'travel_joy_frontpage_enable_popular_tour_packages' ) ) {

	/**
	 * Hook to override enable disabe popular tour packages.
	 *
	 * @param bool $enable_popular_tour_packages Enable disable popular tour packages.
	 * @return bool $enable_popular_tour_packages Enable disable popular tour packages.
	 */
	function travel_joy_frontpage_enable_popular_tour_packages( $enable_popular_tour_packages ) {

		$panel_name   = 'front page';
		$section_name = 'popular tour packages';

		$trips_dropdown       = travel_joy_get_theme_options( $panel_name, $section_name, 'trips_dropdown' );
		$count_selected_trips = is_array( $trips_dropdown ) ? count( $trips_dropdown ) : 0;

		if ( $count_selected_trips < 1 || empty( $trips_dropdown[0] ) ) {
			$enable_popular_tour_packages = false;
		}

		return $enable_popular_tour_packages;
	}
	add_filter( 'travel_joy_frontpage_enable_popular_tour_packages', 'travel_joy_frontpage_enable_popular_tour_packages' );
}

if ( ! function_exists( 'travel_joy_frontpage_popular_tour_packages_header' ) ) {

	/**
	 * Hook the header html of section.
	 */
	function travel_joy_frontpage_popular_tour_packages_header() {

		$panel_name   = 'front page';
		$section_name = 'popular tour packages';

		$main_heading = travel_joy_get_theme_options( $panel_name, $section_name, 'main_heading' );
		$sub_heading  = travel_joy_get_theme_options( $panel_name, $section_name, 'sub_heading' );

		$button_custom_link = get_home_url() . '/itinerary';
		ob_start();
		?>
			<div class="section__header">
				<div class="title">
					<h2 class="title-h2"><?php echo esc_html( $main_heading ); ?></h2>
					<p class="section-header-description"><?php echo esc_html( $sub_heading ); ?></p>
				</div>
				<div class="button-item">
					<a href="<?php echo esc_url( $button_custom_link ); ?>"><button class="bttn primary-button"><?php esc_html_e( 'View All', 'travel-joy' ); ?></button></a>
				</div>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_frontpage_popular_tour_packages_header', 'travel_joy_frontpage_popular_tour_packages_header' );
}

if ( ! function_exists( 'travel_joy_frontpage_popular_tour_packages' ) ) {

	/**
	 * Hooks the main content to the section.
	 */
	function travel_joy_frontpage_popular_tour_packages() {

		$panel_name   = 'front page';
		$section_name = 'popular tour packages';

		$trips_dropdown          = travel_joy_get_theme_options( $panel_name, $section_name, 'trips_dropdown' );
		$button_label            = travel_joy_get_theme_options( $panel_name, $section_name, 'button_label' );
		$display_next_departures = travel_joy_get_theme_options( $panel_name, $section_name, 'display_next_departures' );
		$count_selected_trips    = is_array( $trips_dropdown ) ? count( $trips_dropdown ) : 0;

		if ( ! $count_selected_trips ) {
			return;
		}

		$settings = wp_travel_get_settings();
		ob_start();
		?>
			<div class="section06-gallery">
				<section class="grid-box">
					<ul>
						<?php
						foreach ( $trips_dropdown as $trip_id ) {

							// General Variables.
							$trip_name            = get_the_title( $trip_id );
							$trip_url             = ! empty( $trip_id ) ? get_post_permalink( $trip_id ) : '';
							$travel_locations     = ! empty( $trip_id ) ? get_the_terms( $trip_id, 'travel_locations' ) : '';
							$location             = ! empty( $travel_locations[0]->name ) ? $travel_locations[0]->name : __( 'N/A', 'travel-joy' );
							$enable_multi_depart  = get_post_meta( $trip_id, 'wp_travel_enable_multiple_fixed_departue', true );
							$is_inventory_enabled = apply_filters( 'inventory_enabled', false, $trip_id );

							// All Pricings.
							$pricings         = wp_travel_get_trip_pricing_option( $trip_id );
							$pricing_data     = isset( $pricings['pricing_data'] ) ? $pricings['pricing_data'] : array();
							$currency_code    = ! empty( $settings['currency'] ) ? $settings['currency'] : '';
							$currency_symbol  = ! empty( $currency_code ) ? wp_travel_get_currency_symbol( $currency_code ) : '';
							$price_per_text   = wp_travel_get_price_per_text( $trip_id );
							$trip_price       = wp_travel_get_price( $trip_id );
							$regular_price    = wp_travel_get_price( $trip_id, true );
							$enable_sale      = wp_travel_is_enable_sale_price( $trip_id, true );
							$sale_price       = wp_travel_get_price( $trip_id );
							$min_pricing_data = wp_travel_get_min_pricing_id( $trip_id );
							$min_pricing_id   = ! empty( $min_pricing_data['pricing_id'] ) ? $min_pricing_data['pricing_id'] : '';
							$min_price        = ! empty( $pricing_data[ $min_pricing_id ] ) ? $pricing_data[ $min_pricing_id ] : '';

							// Departures and durations.
							$trip_start_date      = get_post_meta( $trip_id, 'wp_travel_start_date', true ); // Fixed departure.
							$trip_end_date        = get_post_meta( $trip_id, 'wp_travel_end_date', true ); // Fixed departure.
							$fixed_departure      = ! empty( $trip_start_date ) && ! empty( $trip_end_date ) ? $trip_start_date . ' - ' . $trip_end_date : '';
							$trip_duration        = get_post_meta( $trip_id, 'wp_travel_trip_duration', true );
							$trip_duration        = ( $trip_duration ) ? $trip_duration : 0;
							$trip_duration_night  = get_post_meta( $trip_id, 'wp_travel_trip_duration_night', true );
							$trip_duration_night  = ( $trip_duration_night ) ? $trip_duration_night : 0;
							$trip_duration_string = sprintf( __( '%1$d Days(s), %2$d Night(s)', 'travel-joy' ), $trip_duration, $trip_duration_night ); // phpcs:ignore
							$duration             = ! empty( $fixed_departure ) ? $fixed_departure : $trip_duration_string;
							$trip_start_dates     = ( 'yes' === $enable_multi_depart ) ? wp_list_pluck( $pricing_data, 'arrival_date' ) : array(); // Multiple departure.

							// Group Discount.
							$group_discount_available = false;
							if ( travel_joy_is_wp_travel_addon_active( 'WP Travel Group Discount' ) ) {
								$group_discount = get_post_meta( $trip_id, 'wp_travel_group_discount', true );
								if ( ! empty( $group_discount ) ) {
									$group_discount_available = true;
								}
							}

							// Inventory.
							$inventory_data = $is_inventory_enabled ? wp_list_pluck( $pricing_data, 'inventory' ) : array();
							?>
							<li>
								<figure>
									<div class="image-top">
										<a href="<?php echo esc_url( $trip_url ); ?>">
											<?php echo wp_travel_get_post_thumbnail( $trip_id ); // phpcs:ignore ?>
										</a>
										<div class="overlay">
											<div class="image-overlay overlay__bottom">
												<div class="left">
													<?php if ( ! empty( $trip_price ) ) { ?>
														<?php if ( $enable_sale && ! empty( $sale_price ) ) { ?>
															<h2>
																<del>
																	<?php echo wp_travel_get_formated_price_currency( $regular_price, true, '', $trip_id ); // phpcs:ignore ?>
																</del>
																<h1><?php echo wp_travel_get_formated_price_currency( $sale_price, false, '', $trip_id ) . sprintf( __( '%s', 'travel-joy' ), $price_per_text ); // phpcs:ignore ?></h1>
															</h2>
														<?php } else { ?>
															<h1>
																<?php echo wp_travel_get_formated_price_currency( $trip_price, true, '', $trip_id  ) . sprintf( __( '%s', 'travel-joy' ), $price_per_text ); // phpcs:ignore ?>
															</h1>
														<?php } ?>
													<?php } else { ?>
														<p><?php esc_html_e( 'Price N/A', 'travel-joy' ); ?></p>
													<?php } ?>
												</div>
												<div class="right ">
													<?php if ( $group_discount_available ) { ?>
														<button style="cursor: default;"><?php esc_html_e( 'Group Discount', 'travel-joy' ); ?></button>
													<?php } ?>
												</div>
											</div>
										</div>
									</div>

									<div class="other-info">
										<div class="title">
											<a href="<?php echo esc_url( $trip_url ); ?>">
												<?php echo esc_html( $trip_name ); ?>
											</a>
											<div class="address-time">
												<span><i class="fas fa-map-marker-alt"></i>
													<p><?php echo esc_html( $location ); ?></p>
												</span>
												<?php if ( ( ! count( $trip_start_dates ) > 0 ) && $trip_duration || $trip_duration_night ) { ?>
													<span><i class="fas fa-clock"></i>
														<p><?php echo esc_html( $duration ); ?></p>
													</span>
												<?php } ?>
											</div>
										</div>
										<?php if ( $display_next_departures ) { ?>
											<div class="depature-time">
												<div class="title">
													<h3><?php esc_html_e( 'Next Departure', 'travel-joy' ); ?></h3>
												</div>
												<div class="dept-detail">
													<ul>
													<?php
													if ( is_array( $trip_start_dates ) && count( $trip_start_dates ) > 0 ) {
														foreach ( $trip_start_dates as $index => $arrival_date ) {
															if ( $index < 3 ) {
																$departure_date = gmdate( 'M d, Y', strtotime( $arrival_date ) );
																$available_pax  = ! empty( $inventory_data[ $index ]['available_pax'] ) ? sprintf( __( ' - %d seats left', 'travel-joy' ), $inventory_data[ $index ]['available_pax'] ) : ''; // phpcs:ignore
																?>
																<li class="item">
																	<span>
																		<p id="date"><?php echo esc_html( $departure_date ); ?><?php echo esc_html( $available_pax ); ?></p>
																	</span>
																</li>
																<?php
															}
														}
													} else {
														?>
														<li class="item">
															<span>
																<p id="date"><?php esc_html_e( 'Not available', 'travel-joy' ); ?></p>
															</span>
														</li>
														<?php
													}
													?>
													</ul>
												</div>

											</div>
										<?php } ?>
										<div class="botton__box">
											<a href="<?php echo esc_url( $trip_url ); ?>"><button class="btn__prop primary-button"><?php echo esc_html( $button_label ); ?></button></a>
										</div>
									</div>
								</figure>

							</li>
						<?php } ?>
					</ul>
				</section>
			</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_frontpage_popular_tour_packages', 'travel_joy_frontpage_popular_tour_packages' );
}

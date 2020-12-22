<?php
/**
 * Exit if accessed directly.
 *
 * @package ./travel-joy
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$panel_name   = 'front page';
$section_name = 'testimonials';

$enable_testimonials     = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_testimonials' );
$main_heading            = travel_joy_get_theme_options( $panel_name, $section_name, 'main_heading' );
$add_manage_testimonials = travel_joy_get_theme_options( $panel_name, $section_name, 'add_manage_testimonials' );
$testimonials_category   = travel_joy_get_theme_options( $panel_name, $section_name, 'Taxonomies Dropdown' );
$testimonials_terms      = ! empty( $testimonials_category ) ? travel_joy_get_theme_options( $panel_name, $section_name, 'Terms Category Dropdown' ) : '';

$terms = get_terms(
	array(
		'taxonomy'   => $testimonials_category,
		'hide_empty' => true,
	)
);
$args  = array(
	'post_type'      => 'post',
	'post_status'    => 'publish',
	'posts_per_page' => 4,
	'tax_query'      => array( // phpcs:ignore
		array(
			'taxonomy' => $testimonials_category,
			'field'    => 'slug',
			'terms'    => $testimonials_terms,
		),
	),
);
$query = ! empty( $testimonials_category ) ? new WP_Query( $args ) : '';

$testimonial_posts = ! empty( $query->posts ) ? $query->posts : '';


/**
 * If user selects the 'pages' as the taxonomy dropdown, recreate the $testimonial_posts array.
 */
if ( 'pages' === $testimonials_category ) {
	$testimonial_posts = array();
	$page_ids          = travel_joy_get_theme_options( $panel_name, $section_name, 'pages_dropdown' );
	if ( is_array( $page_ids ) && count( $page_ids ) > 0 ) {
		foreach ( $page_ids as $page_id ) {
			$page_details = get_post( $page_id );
			array_push( $testimonial_posts, $page_details );
		}
	}
}


if ( ! empty( $testimonial_posts ) ) {
	$add_manage_testimonials = array();
	foreach ( $testimonial_posts as $key => $testimonial_post ) {
		$thumbnail = ! empty( $testimonial_post->ID ) ? get_post_thumbnail_id( $testimonial_post->ID ) : false;

		$add_manage_testimonials[ $key ]['reviewer_name']    = ! empty( $testimonial_post->post_title ) ? $testimonial_post->post_title : '';
		$add_manage_testimonials[ $key ]['reviewer_message'] = ! empty( $testimonial_post->post_content ) ? $testimonial_post->post_content : '';
		$add_manage_testimonials[ $key ]['reviewer_image']   = ! empty( $thumbnail ) ? get_post_thumbnail_id( $testimonial_post->ID ) : '';
	}
}

if ( ! $enable_testimonials || is_array( $add_manage_testimonials ) && ! count( $add_manage_testimonials ) > 0 ) {
	$add_manage_testimonials = array();
}

if ( is_array( $add_manage_testimonials ) && count( $add_manage_testimonials ) > 0 ) {
	?>
<!-- Section 9 -->
	<div class="section-9">
		<div class="section-wrapper">
			<?php if ( $main_heading ) { ?>
				<div class="section__header">
					<div class="title">
						<h2 class="title-h2"><?php echo esc_html( $main_heading ); ?></h2>
						<div class="line"></div>
					</div>
				</div>
			<?php } ?>
			<div class="slider-box">
				<div class="slideshow-container">
					<section class="lazy slider" data-sizes="">
						<?php

						foreach ( $add_manage_testimonials as $testimonials ) {
							// Variables.
							$reviewer_name     = ! empty( $testimonials['reviewer_name'] ) ? $testimonials['reviewer_name'] : '';
							$reviewer_position = ! empty( $testimonials['reviewer_position'] ) ? $testimonials['reviewer_position'] : '';
							$reviewer_company  = ! empty( $testimonials['reviewer_company'] ) ? ', ' . $testimonials['reviewer_company'] : '';
							$reviewer_message  = ! empty( $testimonials['reviewer_message'] ) ? $testimonials['reviewer_message'] : '';
							$reviewer_image    = ! empty( $testimonials['reviewer_image'] ) ? wp_get_attachment_url( $testimonials['reviewer_image'] ) : false;
							$no_image_class    = $reviewer_image ? '' : 'testimonial-no-thumbnail';
							?>
							<div>
								<div class="mySlides-two ">
									<div class="container">
										<div class="container__wrapper ">
											<?php if ( $reviewer_image ) { ?>
												<div class="container__image">
													<img src="<?php echo esc_url( $reviewer_image ); ?>" alt="<?php echo esc_attr( $reviewer_name ); ?>" />
												</div>
											<?php } ?>
											<div class="container__description <?php echo esc_attr( $no_image_class ); ?>">
												<div class="description">
													<p><?php echo wpautop( $reviewer_message ); // phpcs:ignore ?></p>
												</div>
												<div class="personal__info">
													<p><?php echo esc_html( $reviewer_name ); ?></p>
													<p class="position"><?php echo esc_html( $reviewer_position ); ?><?php echo esc_html( $reviewer_company ); ?></p>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<?php
						}
						?>
					</section>
				</div>
			</div>
		</div>
	</div>
	<!-- End of section 9 -->
	<?php
}

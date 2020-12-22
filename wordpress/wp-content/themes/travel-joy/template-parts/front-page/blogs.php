<?php
/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$panel_name   = 'front page';
$section_name = 'blogs';
$date_format  = get_option( 'date_format' );

$term_name           = '';
$enable_blogs        = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_blogs' );
$main_heading        = travel_joy_get_theme_options( $panel_name, $section_name, 'main_heading' );
$sub_heading         = travel_joy_get_theme_options( $panel_name, $section_name, 'sub_heading' );
$taxonomies_dropdown = travel_joy_get_theme_options( $panel_name, $section_name, 'taxonomies_dropdown' );
$number_of_blogs     = travel_joy_get_theme_options( $panel_name, $section_name, 'number_of_blogs' );
$enable_button       = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_button' );
$button_label        = travel_joy_get_theme_options( $panel_name, $section_name, 'button_label' );
$button_custom_link  = travel_joy_get_theme_options( $panel_name, $section_name, 'button_custom_link' );
$post_type_name      = travel_joy_get_post_name_by_taxonomy( $taxonomies_dropdown );
$button_custom_link  = ! empty( $button_custom_link ) ? $button_custom_link : get_post_type_archive_link( $post_type_name );
if ( 'category' === $taxonomies_dropdown ) {
	$term_name = travel_joy_get_theme_options( $panel_name, $section_name, 'terms_category_dropdown' );
}
if ( 'travel_locations' === $taxonomies_dropdown ) {
	$term_name = travel_joy_get_theme_options( $panel_name, $section_name, 'terms_travel_locations_dropdown' );
}
if ( 'itinerary_types' === $taxonomies_dropdown ) {
	$term_name = travel_joy_get_theme_options( $panel_name, $section_name, 'terms_itinerary_types_dropdown' );
}

$terms      = get_terms(
	array(
		'taxonomy'   => $taxonomies_dropdown,
		'hide_empty' => true,
	)
);
$list_terms = ! empty( $taxonomies_dropdown ) ? wp_list_pluck( $terms, 'slug' ) : array();
$args       = array(
	'post_type'      => $post_type_name,
	'post_status'    => 'publish',
	'posts_per_page' => $number_of_blogs,
	'tax_query'      => array(
		array(
			'taxonomy' => $taxonomies_dropdown,
			'field'    => 'slug',
			'terms'    => $term_name,
		),
	),
);

$query = new WP_Query( $args );
$blogs = ! empty( $query->posts ) ? $query->posts : '';

/**
 * If user selects the pages as the taxonomy dropdown, recreate the blogs array.
 */
if ( 'pages' === $taxonomies_dropdown ) {
	$blogs    = array();
	$page_ids = travel_joy_get_theme_options( $panel_name, $section_name, 'pages_dropdown' );
	if ( is_array( $page_ids ) && count( $page_ids ) > 0 ) {
		foreach ( $page_ids as $page_id ) {
			$page_details = get_post( $page_id );
			array_push( $blogs, $page_details );
		}
	}
}

if ( $enable_blogs ) {
	if ( is_array( $blogs ) && count( $blogs ) > 0 ) {
		?>
		<!-- section 8 -->
		<div class="section-8 section-2">
			<div class="section-wrapper">
				<div class="section__header">
					<div class="title">
						<h2 class="title-h2"><?php echo esc_html( $main_heading ); ?></h2>
						<p class="section-header-description"><?php echo esc_html( $sub_heading ); ?></p>
					</div>
					<?php if ( $enable_button ) { ?>
						<div class="button-item">
							<a href="<?php echo esc_url( $button_custom_link ); ?>">
								<button class="bttn primary-button"><?php echo esc_html( $button_label ); ?></button>
							</a>
						</div>
					<?php } ?>
				</div>
					<div class="section02-gallery">
						<section class="grid-box">
							<ul>
							<?php
							foreach ( $blogs as $blog ) {

								// Variables.
								$tj_blog_id     = ! empty( $blog->ID ) ? $blog->ID : '';
								$tj_blog_title  = ! empty( $blog->post_title ) ? $blog->post_title : '';
								$blog_date_time = ! empty( $blog->post_date ) ? $blog->post_date : '';
								$blog_date_time = ! empty( $blog_date_time ) ? explode( ' ', $blog_date_time ) : '';
								$blog_date      = ! empty( $blog_date_time[0] ) ? gmdate( $date_format, strtotime( $blog_date_time[0] ) ) : '';
								$blog_image     = get_the_post_thumbnail_url( $tj_blog_id ) ? get_the_post_thumbnail_url( $tj_blog_id ) : TRAVEL_JOY_PLACEHOLDER_IMAGE;
								?>
								<li>
									<figure>
										<?php if ( ! empty( $blog_image ) ) { ?>
											<img src="<?php echo esc_url( $blog_image ); ?>">
										<?php } ?>
										<div class="overlay">
											<div class="position__bottom">
												<div class="info">
													<div class="top">
														<p><?php echo esc_html( $blog_date ); ?></p>
														<a href="<?php echo esc_url( get_the_permalink( $tj_blog_id ) ); ?>">
															<?php echo esc_html( $tj_blog_title ); ?>
														</a>
													</div>
													<div class="bottom ">
														<a href="<?php echo esc_url( get_the_permalink( $tj_blog_id ) ); ?>"><button class="bttn primary-button"><?php esc_html_e( 'Read More', 'travel-joy' ); ?></button></a>
													</div>
												</div>
											</div>
										</div>
									</figure>
								</li>
							<?php } ?>
							</ul>
						</section>
					</div>
			</div>
		</div>
		<!-- End of section 8 -->
		<?php
	}
}

wp_reset_postdata();

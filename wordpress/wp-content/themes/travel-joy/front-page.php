<?php
/**
 * The main template file for the front page.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package travel_joy
 */

get_header();


if ( 'posts' === get_option( 'show_on_front' ) ) {
	do_action( 'travel_joy_page_header' );
	?>
	<!-- middle-section -->
	<div class="middle-section">
		<div class="section-wrapper" id="main-content">
			<div class="section__gallery">
				<section class="grid-box">
					<ul>
						<!-- left -->
						<?php
							/**
							 * Hooked: travel_joy_blog_left_sidebar,
							 */
							do_action( 'travel_joy_sidebar_left' );
						?>

						<!-- middle -->
						<li class="middle">
							<figure>
								<?php
								if ( have_posts() ) {
									while ( have_posts() ) {
										the_post();
										get_template_part( 'template-parts/content', '' );
									}
									the_posts_pagination();
								} else {
									get_template_part( 'template-parts/content', 'none' );
								}
								?>
							</figure>
						</li>

						<!-- right -->
						<?php
							/**
							 * Hooked: travel_joy_add_right_sidebar,
							 */
							do_action( 'travel_joy_sidebar_right' );
						?>
					</ul>
				</section>
			</div>
		</div>
	</div>
	<!-- middle-section -->
	<?php

} else {

	$sections_banner = array( 'banner_slider', 'static_contents' );
	$sections_other  = travel_joy_get_theme_options( 'theme_options', 'sort_sections', 'sort_sections' );
	$sections        = array_merge( $sections_banner, $sections_other );

	$sections_to_disable = array();
	$is_wp_travel_active = travel_joy_is_wp_travel_active();

	if ( ! $is_wp_travel_active ) {

		/**
		 * Include the methods name that you want to disable from
		 * customizer when WP Travel is not activated.
		 */
		$sections_to_disable = travel_joy_wp_travel_dependent_sections();
	}

	/**
	 * This loop helps in sorting of the section.
	 * Section name: "Banner Slider" has been excluded from the sorting list,
	 * now "Banner Slider" section stays in top of the page permanently.
	 * It also includes the sections.
	 */
	if ( is_array( $sections ) && count( $sections ) > 0 ) {
		foreach ( $sections as $section ) {
			if ( ! in_array( $section, $sections_to_disable, true ) ) {
				$file_name     = str_replace( '_', '-', $section );
				$template_path = 'template-parts/front-page/' . $file_name;
				get_template_part( $template_path );
			}
		}
	}

	do_action( 'travel_joy_after_static_contents' );
}
get_footer();

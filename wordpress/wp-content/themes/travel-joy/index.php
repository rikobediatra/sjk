<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package travel_joy
 */

get_header();
do_action( 'travel_joy_page_header' );
?>

<!-- middle-section -->
<div class="middle-section">
	<div class="section-wrapper" id="main-content">
		<div class="section__gallery">
			<section class="grid-box">
				<ul>
					<!-- left -->
					<?php do_action( 'travel_joy_sidebar_left' ); ?>

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
					<?php do_action( 'travel_joy_sidebar_right' ); ?>
				</ul>
			</section>

		</div>
	</div>
</div>
<!-- middle-section -->

<?php

get_footer();

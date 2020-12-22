<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package travel_joy
 */

get_header();

$tj_post_id = get_the_ID();

/**
 * Hook travel_joy_single_before_post_title.
 *
 * @hooked travel_joy_single_post_breadcrumbs.
 */
do_action( 'travel_joy_single_before_post_title', $tj_post_id );


/**
 * Hook travel_joy_single_post_title
 *
 * @hooked travel_joy_single_post_title
 */
do_action( 'travel_joy_single_post_title', $tj_post_id );
?>

<!-- middle-section -->
<div class="middle-section">
	<div class="section-wrapper" id="main-content">
		<div class="section__gallery">
		<section class="grid-box">
				<ul class="grid-box__item">
					<li class="middle">
						<figure>

							<article class="D-article-1 ">
								<div class="detail-box">
									<?php
										/**
										 * Hook travel_joy_single_before_content.
										 *
										 * @hooked travel_joy_single_post_tags
										 */
										do_action( 'travel_joy_single_before_content', $tj_post_id );
									?>

									<div class="article">
										<?php
										while ( have_posts() ) {
											the_post();
											the_content();
										}
										?>
									</div>
								</div>
							</article>
							<?php

							/**
							 * Hook travel_joy_single_before_comments.
							 *
							 * @hooked travel_joy_single_post_paginations
							 */
							do_action( 'travel_joy_single_before_comments', $tj_post_id );

							// If comments are open or we have at least one comment, load up the comment template.
							if ( comments_open() || get_comments_number() ) {
								comments_template();
							}
							?>

						</figure>
					</li>

					<?php do_action( 'travel_joy_sidebar_right' ); ?>

				</ul>
			</section>

		</div>
	</div>
</div>
<!-- /middle-section -->

<?php
get_footer();

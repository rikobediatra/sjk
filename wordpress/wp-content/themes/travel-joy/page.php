<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package travel_joy
 */

get_header();

// Post ID and title details.
$tj_post_id = get_the_ID();

/**
 * Hook travel_joy_before_page_title.
 *
 * @hooked travel_joy_page_conditional_styles
 */
do_action( 'travel_joy_before_page_title', $tj_post_id );

/**
 * Hook travel_joy_page_title
 *
 * @hooked travel_joy_page_title_and_thumbnail
 */
do_action( 'travel_joy_page_title', $tj_post_id );
?>

	<!-- middle-section -->
	<div class="middle-section">
		<div class="section-wrapper" id="main-content">
			<div class="section__gallery">
			<section class="grid-box">
					<ul class="grid-box__item">
						<li class="middle dynamic-article">
							<figure>
								<article class="D-article-1 ">
									<div class="detail-box">
										<?php

										/**
										 * Hook travel_joy_before_page_contents
										 *
										 * @hooked travel_joy_page_author_and_date
										 */
										do_action( 'travel_joy_before_page_contents' );
										?>
										<div class="dynamic-article">
											<?php
											while ( have_posts() ) {
												the_post();
												the_content();
												wp_link_pages(
													array(
														'before'           => '<div class="page-links-container"><span class="page-link-text">' . __( 'More pages: ', 'travel-joy' ) . '</span>',
														'after'            => '</div>',
														'link_before'      => '<span class="page-link">',
														'link_after'       => '</span>',
														'next_or_number'   => 'next',
														'separator'        => ' | ',
														'nextpagelink'     => __( 'Next &raquo', 'travel-joy' ),
														'previouspagelink' => __( '&laquo Previous', 'travel-joy' ),
													)
												);
											}
											?>
										</div>
									</div>
								</article>

								<?php
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
	<!-- middle-section -->

<?php
get_footer();

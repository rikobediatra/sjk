<?php
/**
 * This file is used for the listing of all the blog posts in archive or index file.
 *
 * @package template-part/archive/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$tj_post_id = get_the_ID();
if ( empty( $tj_post_id ) ) {
	return;
}
$post_title     = get_the_title( $tj_post_id );
$post_link      = get_the_permalink( $tj_post_id );
$post_date      = get_the_date( 'M d, Y', $tj_post_id );
$post_excerpt   = get_the_excerpt( $tj_post_id ) ? wp_trim_words( get_the_excerpt( $tj_post_id ), 20, null ) : '';
$count_comments = get_comments_number( $tj_post_id );
$post_thumbnail = get_the_post_thumbnail_url( $tj_post_id ) ? get_the_post_thumbnail_url( $tj_post_id ) : TRAVEL_JOY_PLACEHOLDER_IMAGE;

// Post tags, taxonomy and term details.
$taxonomies   = get_taxonomies( '', 'names' );
$term_data    = wp_get_post_terms( $tj_post_id, $taxonomies );
$term_type    = ! empty( $term_data[0] ) ? $term_data[0] : '';
$term_id      = ! empty( $term_type->term_id ) ? $term_type->term_id : '';
$term_name    = ! empty( $term_type->name ) ? $term_type->name : '';
$term_link    = ! empty( $term_id ) ? get_term_link( $term_id ) : false;
$comment_link = ! empty( $post_link ) && comments_open() ? "{$post_link}/#comments" : false;

?>
	<article <?php post_class( ' m-article-1' ); ?>>
	<div class = "image-top">
		<a href = "<?php echo esc_url( $post_link ); ?>"><img src = "<?php echo esc_url( $post_thumbnail ); ?>" alt = "<?php echo esc_attr( $post_title ); ?>"></a>
	</div>
		<div class="other-info">
			<div class="address-time">
				<span>
					<p><?php echo esc_html( $post_date ); ?></p>
				</span>
				<?php if ( ! empty( $term_name ) ) { ?>
					<a href="<?php echo esc_url( $term_link ); ?>" class="uncategorized">
						<p><?php echo esc_html( $term_name ); ?></p>
					</a>
				<?php } ?>
			</div>
			<div class="title">
				<a href="<?php echo esc_url( $post_link ); ?>">
					<?php the_title(); ?>
				</a>
				<?php if ( ! empty( $post_excerpt ) ) { ?>
					<?php the_excerpt(); ?>
				<?php } ?>
			</div>
			<div class="info-bottom">
				<a href="<?php echo esc_url( $post_link ); ?>"><button class="btn__prop primary-button"><?php esc_html_e( 'Read More', 'travel-joy' ); ?></button></a>

				<?php
				if ( $comment_link ) {
					?>
					<div class="icon">
						<a href="<?php echo esc_url( $comment_link ); ?>"><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/image/blog/comment.png" alt="<?php esc_attr_e( 'comment', 'travel-joy' ); ?>">
							<p><?php echo esc_html( $count_comments ); ?></p>
						</a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</article>
<?php

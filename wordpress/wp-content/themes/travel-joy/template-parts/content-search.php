<?php
/**
 * The template part for displaying results in search pages
 *
 * @package travel-joy
 */

$post_thumbnail = get_the_post_thumbnail_url();
$post_thumbnail = ! empty( $post_thumbnail ) ? $post_thumbnail : TRAVEL_JOY_PLACEHOLDER_IMAGE;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class( 'search-result' ); ?>>
	<div class="entry-header">
		<img width='150' height='150' src="<?php echo esc_url( $post_thumbnail ); ?>" />
		<div class="img-caption">
			<?php
			the_title(
				sprintf(
					'<h2 class="entry-title"><a href="%s" rel="bookmark">',
					esc_url( get_permalink() )
				),
				'</a></h2>'
			);
			the_excerpt();
			?>
		</div>
		
	</div><!-- .entry-header -->
</article><!-- #post-<?php the_ID(); ?> -->

<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package travel_joy
 */

/**
 * Hook travel_joy_before_footer_starts.
 *
 * @hooked travel_joy_close_main_wrapper_div.
 */
do_action( 'travel_joy_before_footer_starts' );
?>

<!-- Section 11 -->
<div class="section-11">
	<div class="section__wrapper section">
		<footer>

			<?php

				/**
				 * Hook travel_joy_before_footer_widget_area.
				 */
				do_action( 'travel_joy_before_footer_widget_areas' );
			?>

			<div class="footer__description">

				<?php

					/**
					 * Hooked: travel_joy_footer_widget_area_html,
					 */
					do_action( 'travel_joy_footer_widget_areas' );
				?>

				<div class="socialMedia__link">
					<?php

						/**
						 * Hooked: travel_joy_footer_credit_section,
						 */
						do_action( 'travel_joy_after_footer_widget_areas' );
					?>
				</div>

			</div>
		</footer>
	</div>
</div>
<!-- end of section 11 -->
</div>

<?php wp_footer(); ?>
</body>
</html>

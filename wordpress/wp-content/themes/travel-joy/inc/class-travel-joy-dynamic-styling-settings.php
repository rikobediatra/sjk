<?php
/**
 * This file has all the required codes for the dynamic stylings that might be needed after customizer settings changes.
 * This file must be included after assets file.
 *
 * @package ./inc/
 */

if ( ! class_exists( 'Travel_Joy_Dynamic_Styling_Settings' ) ) {

	/**
	 * Loads the CSS according to the customizer settings.
	 */
	class Travel_Joy_Dynamic_Styling_Settings {

		/**
		 * Init class.
		 */
		public function __construct() {
			add_action( 'wp_head', array( $this, 'load_methods' ) );
		}

		/**
		 * Automatically loads all the methods of this class.
		 *
		 * @return void
		 */
		public function load_methods() {
			$methods = get_class_methods( $this );

			/**
			 * Exclude construct and this method.
			 */
			if ( is_array( $methods ) && isset( $methods[0] ) && isset( $methods[1] ) ) {
				unset( $methods[0] );
				unset( $methods[1] );
			}

			if ( is_array( $methods ) && count( $methods ) > 0 ) {
				foreach ( $methods as $method ) {
					if ( method_exists( $this, $method ) ) {
						$this->$method();
					}
				}
			}
		}

		/**
		 * All the stylings for site layout regarding the side bar.
		 */
		public function site_layout() {
			$panel_name   = 'theme_options';
			$section_name = __FUNCTION__;
			$layout_for   = is_single() ? 'single_post_layout' : 'pages_layout';
			$layout       = travel_joy_get_theme_options( $panel_name, $section_name, $layout_for );
			$css_single   = '.detail-wrapper .middle-section .section-wrapper .section__gallery .grid-box .grid-box__item{display:grid;grid-template-areas:"middle";-ms-grid-columns:1fr 363px;grid-template-columns:1fr;grid-gap:2rem;width:100%}@media(max-width:768px){.detail-wrapper .middle-section .section-wrapper .section__gallery .grid-box .grid-box__item{grid-template-areas:"middle";-ms-grid-columns:100%;grid-template-columns:100%}}.detail-wrapper .middle-section .section-wrapper .section__gallery .grid-box ul li figure .D-article-2 .inner-box{justify-content:space-between}';
			$css_other    = '.blog-wrapper .middle-section .section-wrapper .section__gallery .grid-box ul li figure .m-article-1 .image-top img { height:400px;}.blog-wrapper .middle-section .section-wrapper .section__gallery .grid-box ul{display: -ms-grid; display: grid; grid-template-areas: "left middle"; -ms-grid-columns:  1fr; grid-template-columns:  1fr; grid-template-areas: "middle"; grid-gap: 2rem;}@media (max-width: 768px){.blog-wrapper .middle-section .section-wrapper .section__gallery .grid-box ul{grid-template-areas: "middle"; -ms-grid-columns: 100%; grid-template-columns: 100%;}}';
			$css          = is_single() || is_page() && ! is_page_template() && ! is_front_page() ? $css_single : $css_other;
			if ( ! is_active_sidebar( 'sidebar' ) || 'full_width' === $layout ) {
				?>
				<style>
					<?php echo esc_attr( $css ); ?>
				</style>
				<?php
			}
		}

		/**
		 * All the stylings affected by the social link section are listed here.
		 *
		 * @return void
		 */
		public function banner_slider() {
			$panel_name          = 'front_page';
			$section_name        = __FUNCTION__;
			$enable_social_links = travel_joy_get_theme_options( $panel_name, $section_name, 'enable_social_links' );
			if ( ! $enable_social_links ) {
				?>
				<style>
					.wrapper .main_section .main__container{width: 100%;}.wrapper .main_section .main__container img{border-radius: 20px;}
				</style>
				<?php
			}
		}

		/**
		 * All the stylings affected by the social link section are listed here.
		 *
		 * @return void
		 */
		public function counter() {
			$panel_name       = 'front_page';
			$section_name     = __FUNCTION__;
			$background_image = travel_joy_get_theme_options( $panel_name, $section_name, 'background_image' );
			?>
			<style>
				.wrapper .section-7 {
					background-image: url(<?php echo esc_url( $background_image ); ?>) !important;
				}
			</style>
			<?php
		}

	}
	new Travel_Joy_Dynamic_Styling_Settings();
}

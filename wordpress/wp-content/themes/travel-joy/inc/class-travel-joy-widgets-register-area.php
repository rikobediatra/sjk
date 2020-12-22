<?php
/**
 * This file has required codes for initilizing the widgets for this theme.
 *
 * @package ./inc/
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Travel_Joy_Widgets_Register_Area' ) ) {

	/**
	 * Class to register widgets area for this theme.
	 */
	class Travel_Joy_Widgets_Register_Area {

		/**
		 * Initilize Travel_Joy_Widgets_Register_Area
		 */
		public function __construct() {
			add_action( 'widgets_init', array( $this, 'load_methods' ) );
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
				foreach ( $methods as $widget_area ) {
					if ( method_exists( $this, $widget_area ) ) {
						$this->$widget_area();
					}
				}
			}
		}

		/**
		 * Sidebar widget area.
		 *
		 * @return void
		 */
		public function sidebar() {
			$widget_area_id = __FUNCTION__;
			register_sidebar(
				array(
					'name'          => esc_html__( 'Sidebar', 'travel-joy' ),    // phpcs:ignore
					'id'            => $widget_area_id,
					'description'   => esc_html__( 'Add sidebar widgets here.', 'travel-joy' ),
					'before_widget' => '<div class="flex__inner-item">',
					'after_widget'  => '</div>',
					'before_title'  => '<h1>',
					'after_title'   => '</h1>',
				)
			);
		}

		/**
		 * Footer widget area one.
		 *
		 * @return void
		 */
		public function footer_widget_one() {
			$widget_area_id = __FUNCTION__;

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Widget One', 'travel-joy' ),    // phpcs:ignore
					'id'            => $widget_area_id,
					'description'   => esc_html__( 'Add first footer widgets here.', 'travel-joy' ),
					'before_widget' => '<div class="flex__inner-item">',
					'after_widget'  => '</div>',
					'before_title'  => '<h1>',
					'after_title'   => '</h1>',
				)
			);
		}

		/**
		 * Footer widget area two.
		 *
		 * @return void
		 */
		public function footer_widget_two() {
			$widget_area_id = __FUNCTION__;

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Widget Two', 'travel-joy' ),    // phpcs:ignore
					'id'            => $widget_area_id,
					'description'   => esc_html__( 'Add second footer widgets here.', 'travel-joy' ),
					'before_widget' => '<div class="flex__inner-item">',
					'after_widget'  => '</div>',
					'before_title'  => '<h1>',
					'after_title'   => '</h1>',
				)
			);
		}

		/**
		 * Footer widget area three.
		 *
		 * @return void
		 */
		public function footer_widget_three() {
			$widget_area_id = __FUNCTION__;

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Widget Three', 'travel-joy' ),    // phpcs:ignore
					'id'            => $widget_area_id,
					'description'   => esc_html__( 'Add third footer widgets here.', 'travel-joy' ),
					'before_widget' => '<div class="flex__inner-item">',
					'after_widget'  => '</div>',
					'before_title'  => '<h1>',
					'after_title'   => '</h1>',
				)
			);
		}

		/**
		 * Footer widget area four.
		 *
		 * @return void
		 */
		public function footer_widget_four() {
			$widget_area_id = __FUNCTION__;

			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Widget Four', 'travel-joy' ),    // phpcs:ignore
					'id'            => $widget_area_id,
					'description'   => esc_html__( 'Add fourth footer widgets here.', 'travel-joy' ),
					'before_widget' => '<div class="flex__inner-item">',
					'after_widget'  => '</div>',
					'before_title'  => '<h1>',
					'after_title'   => '</h1>',
				)
			);
		}

	}

	new Travel_Joy_Widgets_Register_Area();
}

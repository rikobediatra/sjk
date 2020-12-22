<?php
/**
 * This file has the class to load all the required assets for this theme.
 * This does not handle the customizer assets.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Travel_Joy_Load_Theme_Assets' ) ) {

	/**
	 * Class to load all the assets of Travel Joy theme.
	 */
	class Travel_Joy_Load_Theme_Assets {

		/**
		 * Default theme prefix for handles.
		 *
		 * @var string
		 */
		public $handle_prefix = 'travel-joy';

		/**
		 * Suffix for file name.
		 *
		 * @var string
		 */
		public $suffix = '';

		/**
		 * Theme root template directory uri.
		 *
		 * @var string
		 */
		public $template_dir_uri = '';

		/**
		 * Initialize the class.
		 */
		public function __construct() {
			$this->suffix           = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			$this->template_dir_uri = get_template_directory_uri();

			add_action( 'wp_enqueue_scripts', array( $this, 'frontend_assets' ) );
		}

		/**
		 * Lists both frontend scripts and styles.
		 *
		 * @return void
		 */
		public function frontend_assets() {
			$this->frontend_styles();
			$this->frontend_scripts();
		}

		/**
		 * Lists all the frontend related css files.
		 *
		 * @return void
		 */
		public function frontend_styles() {
			$handle_prefix    = $this->handle_prefix;
			$suffix           = $this->suffix;
			$template_dir_uri = $this->template_dir_uri;

			wp_enqueue_style( 'dashicons' );
			wp_enqueue_style( $handle_prefix . '-poppins-font', 'https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap' );
			wp_enqueue_style( $handle_prefix . '-fontawesome', $template_dir_uri . '/css/all' . $suffix . '.css', array(), '5.11.2', 'all' );

			// Slick sliders styles.
			if ( ! defined( 'WP_TRAVEL_VERSION' ) ) {
				wp_enqueue_style( $handle_prefix . '-slick-styles', $template_dir_uri . '/libraries/slick/slick' . $suffix . '.css', array(), '1.0.0', 'all' );
				wp_enqueue_style( $handle_prefix . '-slick-theme-styles', $template_dir_uri . '/libraries/slick/slick-theme.css', array(), '1.0.0', 'all' );
				wp_enqueue_style( $handle_prefix . '-slick-components', $template_dir_uri . '/css/component' . $suffix . '.css', array(), '1.0.0', 'all' );
			} else {
				wp_enqueue_style( 'wp-travel-slick' );
			}

			// Theme and custom styles.
			wp_enqueue_style( $handle_prefix . '-main-style', $template_dir_uri . '/css/style' . $suffix . '.css', array(), '1.0.0', 'all' );
			wp_enqueue_style( $handle_prefix . '-dynamic', $template_dir_uri . '/css/dynamic' . $suffix . '.css', array(), '1.0.0', 'all' );
			wp_enqueue_style( $handle_prefix . '-style', get_stylesheet_uri(), array(), '1.0.0', 'all' );

		}

		/**
		 * Lists all the frontend related js files.
		 *
		 * @return void
		 */
		public function frontend_scripts() {
			$handle_prefix    = $this->handle_prefix;
			$suffix           = $this->suffix;
			$template_dir_uri = $this->template_dir_uri;

			if ( is_singular() ) {
				wp_enqueue_script( 'comment-reply' );
			}

			/**
			 * Scripts.
			 */
			if ( defined( 'WP_TRAVEL_VERSION' ) ) {
				wp_enqueue_script( 'wp-travel-slick' );
			} else {
				wp_enqueue_script( $handle_prefix . '-slick-script', $template_dir_uri . '/libraries/slick/slick' . $suffix . '.js', array( 'jquery' ), '1.8.0', true );
			}
			wp_enqueue_script( $handle_prefix . '-main-script', $template_dir_uri . '/js/custom' . $suffix . '.js', array( 'jquery' ), '1.0.0', true );
		}
	}
	new Travel_Joy_Load_Theme_Assets();
}

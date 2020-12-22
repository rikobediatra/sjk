<?php
/**
 * Travel joy functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package travel_joy
 */

if ( ! isset( $content_width ) ) {
	$content_width = 640;
}

if ( ! defined( 'TRAVEL_JOY_PLACEHOLDER_IMAGE' ) ) {
	$placeholder_image = get_template_directory_uri() . '/image/placeholder-no-image.jpg';
	/**
	 * Returns the placeholder image url.
	 */
	define( 'TRAVEL_JOY_PLACEHOLDER_IMAGE', $placeholder_image );
}

if ( ! function_exists( 'travel_joy_is_wptravel_related_page' ) ) {

	/**
	 * Checks if current page is wp travel related page or not.
	 *
	 * @param bool $page_type Return page type.
	 * @return bool|string
	 */
	function travel_joy_is_wptravel_related_page( $page_type = false ) {
		if ( travel_joy_is_wp_travel_active() ) {
			if ( $page_type ) {
				if ( wp_travel_is_cart_page() ) {
					return 'wp-travel-cart-page';
				} elseif ( wp_travel_is_checkout_page() ) {
					return 'wp-travel-checkout-page';
				} elseif ( wp_travel_is_dashboard_page() ) {
					return 'wp-travel-dashboard-page';
				} else {
					return false;
				}
			} else {
				return ( wp_travel_is_cart_page() || wp_travel_is_checkout_page() || wp_travel_is_dashboard_page() ) ? true : false;
			}
		} else {
			return false;
		}
	}
}

if ( ! function_exists( 'travel_joy_primary_menu_fallback' ) ) {

	/**
	 * Fallback for Primary menu.
	 *
	 * @since 1.0.0
	 */
	function travel_joy_primary_menu_fallback() {

		echo '<ul class="menu">';
		echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'travel-joy' ) . '</a></li>';
		wp_list_pages(
			array(
				'title_li' => '',
				'depth'    => 1,
				'number'   => 8,
			)
		);
		echo '</ul>';

	}
}

if ( ! function_exists( 'travel_joy_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function travel_joy_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on travel joy, use a find and replace
		 * to change 'travel-joy' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'travel-joy', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		// This theme uses wp_nav_menu() in multiple location.
		register_nav_menus(
			array(
				'primary_menu' => esc_html__( 'Primary Menu', 'travel-joy' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'travel_joy_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'width'       => 150,
				'height'      => 50,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => array( 'site-title', 'site-description' ),
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'travel_joy_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function travel_joy_content_width() {
	// This variable is intended to be overruled from themes.
	// Open WPCS issue: {@link https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1043}.
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = apply_filters( 'travel_joy_content_width', 640 );
}
add_action( 'after_setup_theme', 'travel_joy_content_width', 0 );


/**
 * Outputs the logo html according to the location name given.
 *
 * @param boolean $is_footer If this function is used for footer.
 * @param boolean $return Return or echo the data.
 * @return string site identity info.
 */
function travel_joy_site_identity( $is_footer = false, $return = false ) {
	ob_start();

	if ( has_custom_logo() ) {
		?>
		<div class="site-identity">
		<?php
	} elseif ( ! has_custom_logo() && ! $is_footer ) {
		?>
		<div class="site-identity">
		<?php
	}
	if ( has_custom_logo() ) {
		?>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="custom-logo-link" rel="home" itemprop="url">
			<?php the_custom_logo(); ?>
			</a>
			<?php
	}

	if ( ! $is_footer ) {
		?>
			<div class="site-branding-text">
			<?php if ( is_front_page() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif; ?>
			<?php
			$description = get_bloginfo( 'description', 'display' );
			if ( $description || is_customize_preview() ) :
				?>
					<p class="site-description"><?php echo $description; // phpcs:ignore ?></p>
				<?php endif; ?>
			</div>
			<?php
	}
	if ( has_custom_logo() ) {
		?>
			</div>
		<?php
	} elseif ( ! has_custom_logo() && ! $is_footer ) {
		?>
			</div>
		<?php
	}
	$content = ob_get_contents();
	ob_end_clean();

	if ( $return ) {
		return $content;
	} else {
		echo $content; // phpcs:ignore
	}
}

/**
 * Gets the dynamic side bar or widget area according to the widget area id provided.
 *
 * @param string $widget_area_id Id of the widget area.
 * @param array  $args            Widget area wrapper.
 * @param bool   $return            Return or echo the content.
 * @return mixed $widget_area Returns or echos the html depending upon the third parameter.
 */
function travel_joy_get_widget_area( $widget_area_id, $args = array(), $return = false ) {

	$widget_area = '';
	$default     = array(
		'type'          => '',
		'wrapper_id'    => '',
		'wrapper_class' => '',
	);
	$args        = wp_parse_args( $args, $default );

	if ( is_active_sidebar( $widget_area_id ) ) {
		if ( ! empty( $args['type'] ) ) {
			$type          = $args['type'];
			$wrapper_id    = $args['wrapper_id'];
			$wrapper_class = $args['wrapper_class'];

			ob_start();
			dynamic_sidebar( $widget_area_id );
			$content = ob_get_contents();
			ob_end_clean();

			$widget_area  = '<' . $type . ' id="' . $wrapper_id . '" class="' . $wrapper_class . '" >';
			$widget_area .= $content;
			$widget_area .= '</' . $type . '>';
		} else {
			ob_start();
			dynamic_sidebar( $widget_area_id );
			$widget_area = ob_get_contents();
			ob_end_clean();
		}
	}

	if ( ! $return ) {
		echo $widget_area; // phpcs:ignore
	} else {
		return $widget_area;
	}
}

if ( ! function_exists( 'travel_joy_get_post_name_by_taxonomy' ) ) {

	/**
	 * Returns the post type name by taxonomy slug.
	 *
	 * @param  string $taxonomy Taxonomy slug
	 * @return string $post_type_name Post type name
	 */
	function travel_joy_get_post_name_by_taxonomy( $taxonomy ) {
		if ( ! $taxonomy ) {
			return;
		}
		global $wp_taxonomies;
		if ( isset( $wp_taxonomies[ $taxonomy ] ) ) {
			$post_type_name = ! empty( $wp_taxonomies[ $taxonomy ]->object_type[0] ) ? $wp_taxonomies[ $taxonomy ]->object_type[0] : '';
			return $post_type_name;
		}
	}
}

if ( ! function_exists( 'travel_joy_is_wp_travel_addon_active' ) ) {

	/**
	 * Checks if WP Travel dependent addon is active or not.
	 *
	 * @param string $addon_name Addon name as 'WP Travel Multiple Currency'.
	 * @return void
	 */
	function travel_joy_is_wp_travel_addon_active( $addon_name ) {
		if ( empty( $addon_name ) || ! travel_joy_is_wp_travel_active() ) {
			return;
		}

		if ( ! class_exists( 'WP_Travel_Addons_Settings' ) ) {
			return;
		}

		$addon_settings = new WP_Travel_Addons_Settings( $addon_name );
		return $addon_settings->is_addon_active();
	}
}

if ( ! function_exists( 'travel_joy_is_wp_travel_active' ) ) {

	/**
	 * Checks if WP Travel plugin is active or not.
	 *
	 * @return boolean
	 */
	function travel_joy_is_wp_travel_active() {
		if ( function_exists( 'WP_Travel' ) ) {
			return true;
		}
		return false;
	}
}

if ( ! function_exists( 'travel_joy_get_breadcrumb' ) ) {

	/**
	 * Returns the html for breadcrumbs if $display is provided false else echos it.
	 *
	 * @param bool $display Echo or return the html.
	 */
	function travel_joy_get_breadcrumb( $display = true ) {

		$breadcrumb            = '';
		$use_yoast_breadcrumbs = function_exists( 'yoast_breadcrumb' ) && yoast_breadcrumb( '', '', false ) ? true : false;

		$args = array(
			'container'     => 'div',
			'show_on_front' => false,
			'show_browse'   => false,
			'echo'          => false,
		);

		$is_showable = breadcrumb_trail( $args );

		$breadcrumb .= '<!-- Breadcrumb Starts -->';

		if ( $use_yoast_breadcrumbs ) {
			/**
			 * Add support for yoast breadcrumb.
			 */
			$breadcrumb .= yoast_breadcrumb( '<div class="breadcrumb"><div class="container">', '</div></div><!-- Breadcrumbs-end -->', false );
		} else {
			if ( $is_showable ) {
				$breadcrumb .= '<div class="breadcrumb">';
				$breadcrumb .= '<div class="container">';
				$breadcrumb .= breadcrumb_trail( $args );
				$breadcrumb .= '</div>';
				$breadcrumb .= '</div>';
			}
		}

		$breadcrumb .= '<!-- Breadcrumb Ends -->';

		if ( ! $display ) {
			return $breadcrumb;
		}
		echo $breadcrumb; // phpcs:ignore
	}
}

if ( ! function_exists( 'travel_joy_wp_travel_dependent_sections' ) ) {

	/**
	 * Returns the wp travel dependent section that needs to activate when wp travel is active.
	 *
	 * @return array $dependent_sections WP travel dependent sections.
	 */
	function travel_joy_wp_travel_dependent_sections() {

		$dependent_sections = array();
		/**
		 * Include the methods name that you want to disable from
		 * customizer when WP Travel is not activated.
		 */
		$dependent_sections = array(
			'trip_activities',
			'travel_base_process',
			'popular_destination',
			'featured_trips_slider',
			'popular_tour_packages',
		);

		return $dependent_sections;
	}
}

/**
 * Register widgets.
 */
require_once get_template_directory() . '/inc/class-travel-joy-widgets-register-area.php';

/**
 * Loads all the file.
 */
require_once get_template_directory() . '/inc/load-files.php';

/**
* TGM plugin additions.
*/
require get_template_directory() . '/inc/tgm-plugin/tgmpa-hook.php';

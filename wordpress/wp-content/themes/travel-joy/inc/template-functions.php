<?php
/**
 * Functions which enhance the theme by hooking into WordPress or Travel joy theme itself.
 *
 * @package travel_joy
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function travel_joy_body_classes( $classes ) {

	global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

	$user_agent = ! empty( $_SERVER['HTTP_USER_AGENT'] ) ? sanitize_text_field( wp_unslash( $_SERVER['HTTP_USER_AGENT'] ) ) : '';

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar' ) ) {
		$classes[] = 'no-sidebar';
	}

	/**
	 * Check browser type.
	 */
	if ( $is_lynx ) {
		$classes[] = 'lynx';
	} elseif ( $is_gecko ) {
		$classes[] = 'gecko';
	} elseif ( $is_opera ) {
		$classes[] = 'opera';
	} elseif ( $is_NS4 ) {
		$classes[] = 'ns4';
	} elseif ( $is_safari ) {
		$classes[] = 'safari';
	} elseif ( $is_chrome ) {
		$classes[] = 'chrome';
	} elseif ( $is_IE ) {
		$classes[] = 'ie';
	} else {
		$classes[] = 'unknown-browser';
	}

	/**
	 * Check platform or os type.
	 */
	if ( $is_iphone ) {
		$classes[] = 'iphone';
	}
	if ( stristr( $user_agent, 'mac' ) ) {
		$classes[] = 'mac';
	} elseif ( stristr( $user_agent, 'linux' ) ) {
		$classes[] = 'linux';
	} elseif ( stristr( $user_agent, 'windows' ) ) {
		$classes[] = 'windows';
	}

	$classes[] = travel_joy_is_wptravel_related_page( true );

	return $classes;
}
add_filter( 'body_class', 'travel_joy_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function travel_joy_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'travel_joy_pingback_header' );

/**
 * Checks if sidebar is active.
 */
function travel_joy_is_sidebar_active() {
	$panel_name   = 'theme_options';
	$section_name = 'site_layout';
	$layout_for   = is_single() ? 'single_post_layout' : 'pages_layout';
	$layout       = travel_joy_get_theme_options( $panel_name, $section_name, $layout_for );
	if ( ! is_active_sidebar( 'sidebar' ) || 'full_width' === $layout ) {
		return false;
	}
	return true;
}


if ( ! function_exists( 'travel_joy_page_header' ) ) {

	/**
	 * Adds the header content before the archive contents.
	 */
	function travel_joy_page_header() {
		$valid = ( is_home() && ! is_front_page() ) || is_search();
		if ( ! $valid ) {
			return;
		}
		$thumbnail      = has_header_image() ? get_header_image() : false;
		$blog_thumbnail = $thumbnail ? $thumbnail : TRAVEL_JOY_PLACEHOLDER_IMAGE;
		ob_start();
		if ( $blog_thumbnail ) {
			?>
		<!-- Start of main section -->
		<main class="main_section">
			<div class="main__container dynamic-content-page">
					<div class="image-item">
						<img src="<?php echo esc_url( $blog_thumbnail ); ?>" alt="<?php wp_title( '' ); ?>" />
					</div>
				<div class="main-overlay">
					<div class="description-box">
						<h1><?php wp_title( '' ); ?></h1>
						<?php
						/**
						 * Theme breadcrumb.
						 */
						travel_joy_get_breadcrumb();
						?>
					</div>
				</div>
			</div>
		</main>
		<?php } else { ?>
		<main class="main_section no_post_thumbnail">
			<div class="main__container">
				<div class="main-overlay">
					<div class="description-box">
						<h1><?php wp_title( '' ); ?></h1>
						<?php
						/**
						 * Theme breadcrumb.
						 */
						travel_joy_get_breadcrumb();
						?>
					</div>
				</div>
			</div>
		</main>
			<?php
		}
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_page_header', 'travel_joy_page_header', 8 );
}


if ( ! function_exists( 'travel_joy_archive_header_contents' ) ) {

	/**
	 * Adds the header content before the archive contents.
	 */
	function travel_joy_archive_header_contents() {
		if ( ! is_archive() ) {
			return;
		}
		$thumbnail         = has_header_image() ? get_header_image() : false;
		$archive_thumbnail = $thumbnail ? $thumbnail : TRAVEL_JOY_PLACEHOLDER_IMAGE;

		ob_start();
		if ( $archive_thumbnail ) {
			?>
		<!-- Start of main section -->
		<main class="main_section">
			<div class="main__container dynamic-content-page">
					<div class="image-item">
						<img src="<?php echo esc_url( $archive_thumbnail ); ?>"/>
					</div>
				<div class="main-overlay">
					<div class="description-box">
						<h1><?php wp_title( ' ' ); ?></h1>
						<?php
						/**
						 * Theme breadcrumb.
						 */
						travel_joy_get_breadcrumb();
						?>
					</div>
				</div>
			</div>
		</main>
		<?php } else { ?>
		<main class="main_section no_post_thumbnail">
			<div class="main__container">
				<div class="main-overlay">
					<div class="description-box">
						<h1><?php wp_title( ' ' ); ?></h1>
						<?php
						/**
						 * Theme breadcrumb.
						 */
						travel_joy_get_breadcrumb();
						?>
					</div>
				</div>
			</div>
		</main>
			<?php
		}
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_before_archive_itinerary_wrapper', 'travel_joy_archive_header_contents', 8 );
	add_action( 'travel_joy_archives_header', 'travel_joy_archive_header_contents', 8 ); // For archives header.
}


/* Sidebar template functions Starts. */
if ( ! function_exists( 'travel_joy_add_right_sidebar' ) ) {

	/**
	 * Add sidebar in pages.
	 *
	 * @since 1.0.0
	 */
	function travel_joy_add_right_sidebar() {

		if ( ! travel_joy_is_sidebar_active() ) {
			return;
		}
		if ( ( is_front_page() && ! is_home() ) || is_404() || is_search() ) {
			return;
		}

		?>
		<style>
			/* CSS inlined in template-functions.php file */
			@media(max-width:1100px) and (min-width:769px){
				.blog-wrapper .middle-section .section-wrapper .section__gallery .grid-box ul {
					grid-template-areas: " middle middle "
											"right right";
					grid-template-columns: 250px 1fr ;
				}
			}
		</style>
		<?php

		get_sidebar();
	}
	add_action( 'travel_joy_sidebar_right', 'travel_joy_add_right_sidebar' );
}

if ( ! function_exists( 'travel_joy_doctype' ) ) {

	/**
	 * Hooks the html and doctype start tags to theme header.
	 */
	function travel_joy_doctype() {
		ob_start();
		?>
		<!DOCTYPE html>
			<html <?php language_attributes(); ?>>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_doctype', 'travel_joy_doctype' );
}

if ( ! function_exists( 'travel_joy_before_wp_head' ) ) {

	/**
	 * Head tag codes.
	 */
	function travel_joy_before_wp_head() {
		ob_start();
		?>
			<meta charset="<?php bloginfo( 'charset' ); ?>">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<meta http-equiv="X-UA-Compatible" content="ie=edge">
			<link rel="profile" href="https://gmpg.org/xfn/11" />
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_before_wp_head', 'travel_joy_before_wp_head' );
}

if ( ! function_exists( 'travel_joy_main_wrapper' ) ) {

	/**
	 * Main wrapper function that adds the div with required class for css.
	 */
	function travel_joy_main_wrapper() {
		$wrapper_class = is_single() && ( 'itineraries' !== get_post_type() ) ? 'detail-wrapper' : 'wrapper';

		if ( is_page() && ! is_page_template() && ! is_front_page() ) {
			$wrapper_class = 'detail-wrapper';
		}

		if ( is_archive() || ( is_home() && 'posts' === get_option( 'show_on_front' ) ) || is_home() ) {
			$wrapper_class = 'blog-wrapper';
		}

		ob_start();
		?>
			<div class="<?php echo esc_attr( $wrapper_class ); ?>">
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;

	}
	add_action( 'travel_joy_before_header_starts', 'travel_joy_main_wrapper' );
}

if ( ! function_exists( 'travel_joy_main_header' ) ) {

	/**
	 * Theme main header htmls with menu and site identity.
	 */
	function travel_joy_main_header() {

		ob_start();
		?>
			<header class="header">

				<!-- Skip to link -->
				<a class="screen-reader-text skip-link" href="#main-content"><?php echo esc_html__( 'Skip to content', 'travel-joy' ); ?></a>

				<!-- logo -->
						<?php travel_joy_site_identity(); ?>
				<!-- End of logo -->

				<!-- wp nav menu -->
				<!-- navigation bar -->
				<div class="menu-primary-nav-menu-container">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary_menu',
								'fallback_cb'    => 'travel_joy_primary_menu_fallback',
							)
						);
						?>
				</div>
				<!-- //wp nav menu -->

				<!-- navigation bar -->
				<div class="mobile-nav menu-primary-nav-menu-container">
					<a href="javascript:void(0)" class="toggle" style="font-size:30px;cursor:pointer" id="open-navigation-bar">&#9776;</a>
					<div id="mySidenav" class=" mobNav_wrapper sidenav">

						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary_menu',
								'fallback_cb'    => 'travel_joy_primary_menu_fallback',
							)
						);
						?>
						<a href="javascript:void(0)" class="closebtn" id="close-navigation-bar">&times;</a>
					</div>


				</div>

			</header>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_header', 'travel_joy_main_header' );
}

if ( ! function_exists( 'travel_joy_single_post_title' ) ) {

	/**
	 * Hooks the html for single post title and thumbnail.
	 *
	 * @param int $post_id Single post id.
	 */
	function travel_joy_single_post_title( $post_id ) {
		$post_title     = get_the_title( $post_id );
		$thumbnail      = ! empty( $post_id ) ? get_the_post_thumbnail_url( $post_id, 'large' ) : false;
		$header_image   = has_header_image() ? get_header_image() : false;
		$post_thumbnail = $thumbnail ? $thumbnail : $header_image;
		$post_thumbnail = $post_thumbnail ? $post_thumbnail : TRAVEL_JOY_PLACEHOLDER_IMAGE;
		ob_start();
		?>
		<main class="main_section">
			<div class="main__container">
				<div class="image-container">
					<img src="<?php echo esc_url( $post_thumbnail ); ?>" alt="<?php echo esc_attr( $post_title ); ?> <?php echo esc_attr__( 'Thumbnail', 'travel-joy' ); ?>" />
				</div>
				<div class="main-overlay">
					<div class="description-box">
						<h2><?php echo esc_html( $post_title ); ?></h2>
						<?php
						/**
						 * Theme breadcrumb.
						 */
						travel_joy_get_breadcrumb();
						?>
					</div>
				</div>
			</div>
		</main>
		<!-- End of main section -->
		<?php
		$content = ob_get_contents();
		ob_end_flush();
	}
	add_action( 'travel_joy_single_post_title', 'travel_joy_single_post_title' );
}

if ( ! function_exists( 'travel_joy_single_post_tags' ) ) {

	/**
	 * Hooks the post tags before the main content start in single post.
	 *
	 * @param int $post_id Single post ID.
	 * @return string $content Tags html
	 */
	function travel_joy_single_post_tags( $post_id ) {
		$tags          = get_the_tags( $post_id );
		$tags          = ! empty( $tags ) ? get_the_tags( $post_id ) : array();
		$date_format   = get_option( 'date_format' );
		$post_date     = get_the_date( $date_format, $post_id );
		$author_id     = get_post_field( 'post_author', $post_id );
		$author_name   = get_the_author_meta( 'display_name', $author_id );
		$author_post   = get_author_posts_url( $author_id );
		$archive_year  = get_the_time( 'Y', $post_id );
		$archive_month = get_the_time( 'm', $post_id );
		$archive_day   = get_the_time( 'd', $post_id );

		ob_start();
		?>
		<div class="top-part">
			<div class="left-content">
				<span>
					<strong><?php esc_html_e( 'Posted by', 'travel-joy' ); ?></strong>
					&nbsp;<a href="<?php echo esc_url( $author_post ); ?>"><?php echo esc_html( ucfirst( $author_name ) ); ?></a>
				</span>
				<span>
					<strong><?php esc_html_e( 'Posted on', 'travel-joy' ); ?></strong>
					&nbsp;<a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ); ?>"><?php echo esc_html( $post_date ); ?></a>
				</span>
				<?php
				if ( count( $tags ) > 0 ) {
					?>
					<div class="uncategorized-item">
					<?php
					foreach ( $tags as $post_tag ) {
						$tag_slug = ! empty( $post_tag->slug ) ? $post_tag->slug : '';
						$tag_name = ! empty( $post_tag->name ) ? $post_tag->name : $tag_slug;
						if ( ! empty( $tag_name ) && is_string( $tag_name ) ) {
							?>
							<span class="uncategorized">
								<p>#<?php echo esc_html( $tag_name ); ?></p>
							</span>
							<?php
						}
					}
					?>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_single_before_content', 'travel_joy_single_post_tags' );
}

if ( ! function_exists( 'travel_joy_single_post_paginations' ) ) {

	/**
	 * Hooks the html for post pagination in single post.
	 *
	 * @param int $post_id Single post id.
	 */
	function travel_joy_single_post_paginations( $post_id ) {

		// Post pagination data.
		$next_post_obj   = get_next_post();
		$next_post_id    = ! empty( $next_post_obj->ID ) ? $next_post_obj->ID : '';
		$next_post_title = ! empty( $next_post_obj->post_title ) ? wp_trim_words( $next_post_obj->post_title, 5, null ) : '';
		$next_post_url   = ! empty( $next_post_obj ) ? get_the_permalink( $next_post_obj ) : '';

		$prev_post_obj   = get_previous_post();
		$prev_post_id    = ! empty( $prev_post_obj->ID ) ? $prev_post_obj->ID : '';
		$prev_post_title = ! empty( $prev_post_obj->post_title ) ? wp_trim_words( $prev_post_obj->post_title, 5, null ) : '';
		$prev_post_url   = ! empty( $prev_post_obj ) ? get_the_permalink( $prev_post_obj ) : '';

		ob_start();
		?>
		<article class="D-article-2">
			<div class="inner-box">
			<?php if ( ! empty( $prev_post_id ) ) { ?>
				<div class="box-1 box-prev">
					<a href="<?php echo esc_url( $prev_post_url ); ?>"><?php echo esc_html( $prev_post_title ); ?></a>
				</div>
			<?php } ?>
			<?php if ( ! empty( $next_post_id ) ) { ?>
				<div class="box-1 box-next">
					<a href="<?php echo esc_url( $next_post_url ); ?>"><?php echo esc_html( $next_post_title ); ?></a>
				</div>
			</div>
			<?php } ?>
		</article>
		<?php
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_single_before_comments', 'travel_joy_single_post_paginations' );
}

if ( ! function_exists( 'travel_joy_page_conditional_styles' ) ) {

	/**
	 * Hooks the css according to the page type.
	 *
	 * @param int $page_id Page id.
	 */
	function travel_joy_page_conditional_styles( $page_id ) {
		$is_wptravel_page = travel_joy_is_wptravel_related_page() ? false : true;

		ob_start();
		if ( ! $is_wptravel_page ) {
			?>
			<style type="text/css">
				/**
				* <?php echo esc_html( 'Page.php ' . __LINE__ ); ?>
				*/
				.wp-travel-itinerary-items ul.wp-travel-itinerary-list li {
					width: calc(49.333% - 20px) !important;
				}
				@media(max-width:1092px){
					.wp-travel-itinerary-items ul.wp-travel-itinerary-list li {
						width: calc(100% - 20px) !important;
					}
				}
			</style>
			<?php
		}

		/**
		 * Conditions if current page is WP Travel Cart page.
		 */
		if ( 'wp-travel-cart-page' === travel_joy_is_wptravel_related_page( true ) ) {

			/**
			 * If sidebar is active.
			 */
			if ( travel_joy_is_sidebar_active() ) {
				?>
				<style type="text/css">
					/**
					* <?php echo esc_html( 'Page.php ' . __LINE__ ); ?>
					*/
					@media(max-width:1136px) {
						.detail-wrapper .middle-section .section-wrapper .section__gallery .grid-box .grid-box__item {
							grid-template-areas: "middle" "right";
							-ms-grid-columns: 100%;
							grid-template-columns: 100%
						}
					}
					@media(min-width:968px) {
						.ws-theme-cart-page .coupon {
							float: left;
							display: -webkit-inline-box;
							display: -ms-inline-flexbox;
							display: inline-grid
						}
						.ws-theme-cart-page .actions .book-now-btn{
							margin-top:20px;
						}
						.ws-theme-cart-page .actions {
							float:right;
							display: -webkit-inline-box;
							display: -ms-inline-flexbox;
							display: inline-grid
						}
						.ws-theme-cart-page .coupon input[type=submit]{
							margin-top:20px;
						}
					}
					@media(max-width:968px) {
						.ws-theme-cart-page .coupon input[type=submit]{
							margin-top:20px;
						}
					}
					@media(max-width:810px) {
						.ws-theme-cart-page .actions .book-now-btn{
							margin-top:20px;
						}
					}
				</style>
				<?php
			} else {
				/**
				 * If sidebar is not active.
				 */
				?>
				<style type="text/css">
					/**
					* <?php echo esc_html( 'Page.php ' . __LINE__ ); ?>
					*/
					@media (min-width: 968px){
						.ws-theme-cart-page .coupon input[type=submit] {
							margin-left: 14px;
						}
						.ws-theme-cart-page .actions input[type=submit] {
							margin-left: 14px;
						}
					}
					@media(max-width:1086px) and (min-width: 811px){

						.ws-theme-cart-page .actions{
							float: left;
							display: -ms-inline-grid;
							display: inline-grid;
						}
						.ws-theme-cart-page .actions input[type=submit] {
							margin-left: 0px;
						}
					}
				</style>
				<?php
			}
		}

		/**
		 * Styles if current page is WP Travel Checkout page.
		 */
		if ( 'wp-travel-checkout-page' === travel_joy_is_wptravel_related_page( true ) ) {

			/**
			 * Styles if sidebar is active in checkout page.
			 */
			if ( travel_joy_is_sidebar_active() ) {
				?>
				<style type="text/css">
					/**
					* <?php echo esc_html( 'Page.php ' . __LINE__ ); ?>
					*/
					@media (max-width: 1300px) {
						.col-sm-8, .col-sm-4 {
							display: block;
							width: 100%;
							position: static !important;
						}
					}
					@media(min-width:1301px){
						.col-sm-8, .col-sm-4 {
							display: block;
							width: 100%;
							position: static !important;
						}
						.checkout-page-wrap .wp-travel-minicart{
							margin-bottom:15px;
						}
					}
					@media(max-width:886px) {
						.detail-wrapper .middle-section .section-wrapper .section__gallery .grid-box .grid-box__item {
							grid-template-areas: "middle" "right";
							-ms-grid-columns: 100%;
							grid-template-columns: 100%
						}
					}
				</style>
				<?php
			}
		}

		/**
		 * Conditions if current page is WP Travel Dashboard page.
		 */
		if ( 'wp-travel-dashboard-page' === travel_joy_is_wptravel_related_page( true ) ) {

			/**
			 * Styles if sidebar is active in WP Travel Dashboard page.
			 */
			if ( travel_joy_is_sidebar_active() ) {
				?>
				<style type="text/css">
					@media (max-width: 1083px) {
						.detail-wrapper .middle-section .section-wrapper .section__gallery .grid-box .grid-box__item {
							grid-template-areas:
								"middle"
								"right";
							-ms-grid-columns: 100%;
							grid-template-columns: 100%;
						}
					}
				</style>
				<?php
			}
		}
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_before_page_title', 'travel_joy_page_conditional_styles' );
}

if ( ! function_exists( 'travel_joy_page_title_and_thumbnail' ) ) {

	/**
	 * Hooks the title and thumbnail image before the contents.
	 *
	 * @param int $page_id Page id.
	 */
	function travel_joy_page_title_and_thumbnail( $page_id ) {
		$post_title     = get_the_title( $page_id );
		$thumbnail      = ! empty( $page_id ) ? get_the_post_thumbnail_url( $page_id ) : false;
		$header_image   = has_header_image() ? get_header_image() : false;
		$post_thumbnail = $thumbnail ? $thumbnail : $header_image;
		ob_start();
		?>
		<!-- Start of main section -->
		<?php if ( $post_thumbnail ) { ?>
			<main class="main_section">
				<div class="main__container dynamic-content-page">
						<div class="image-item">
							<img src="<?php echo esc_url( $post_thumbnail ); ?>" alt="<?php echo esc_attr( $post_title ); ?> <?php echo esc_attr__( 'Thumbnail', 'travel-joy' ); ?>" />
						</div>
					<div class="main-overlay">
						<div class="description-box">
							<h1><?php echo esc_html( $post_title ); ?></h1>
							<?php
							/**
							 * Theme breadcrumb.
							 */
							travel_joy_get_breadcrumb();
							?>
						</div>
					</div>
				</div>
			</main>
		<?php } else { ?>
			<main class="main_section no_post_thumbnail">
				<div class="main__container">
					<div class="main-overlay">
						<div class="description-box">
							<h1><?php echo esc_html( $post_title ); ?></h1>
							<?php
							/**
							 * Theme breadcrumb.
							 */
							travel_joy_get_breadcrumb();
							?>
						</div>
					</div>
				</div>
			</main>
			<?php
		}
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_page_title', 'travel_joy_page_title_and_thumbnail' );
}

if ( ! function_exists( 'travel_joy_page_author_and_date' ) ) {

	/**
	 * Hooks the html in page before contents with author name and page date.
	 *
	 * @param int $page_id Page ID.
	 */
	function travel_joy_page_author_and_date( $page_id ) {
		$is_wptravel_page = travel_joy_is_wptravel_related_page() ? false : true;
		$author_id        = get_post_field( 'post_author', $page_id );
		$author_name      = get_the_author_meta( 'display_name', $author_id );
		$author_post      = get_author_posts_url( $author_id );
		$date_format      = get_option( 'date_format' );
		$post_date        = get_the_date( $date_format, $page_id );
		$archive_year     = get_the_time( 'Y', $page_id );
		$archive_month    = get_the_time( 'm', $page_id );
		$archive_day      = get_the_time( 'd', $page_id );
		ob_start();
		if ( $is_wptravel_page ) {
			?>
			<div class="top-part">
				<div class="left-content">
					<span>
						<strong><?php esc_html_e( 'Posted by', 'travel-joy' ); ?></strong>
						&nbsp;<a href="<?php echo esc_url( $author_post ); ?>"><?php echo esc_html( ucfirst( $author_name ) ); ?></a>
					</span>
					<span>
						<strong><?php esc_html_e( 'Posted on', 'travel-joy' ); ?></strong>
						&nbsp;<a href="<?php echo esc_url( get_day_link( $archive_year, $archive_month, $archive_day ) ); ?>"><?php echo esc_html( $post_date ); ?></a>
					</span>
				</div>
			</div>
			<?php
		}
		$content = ob_get_contents();
		ob_end_flush();
		return $content;
	}
	add_action( 'travel_joy_before_page_contents', 'travel_joy_page_author_and_date' );
}

if ( ! function_exists( 'travel_joy_before_footer_content_starts' ) ) {

	/**
	 * Closes the div of main content wrapper.
	 * of ID #main-content.
	 */
	function travel_joy_close_main_wrapper_div() {
		if ( is_front_page() || is_home() ) {
			?>
				</div> <!-- #main-content -->
			<?php
		}
	}
}

if ( ! function_exists( 'travel_joy_footer_widget_area_html' ) ) {

	/**
	 * Hook the html for footer widget areas.
	 */
	function travel_joy_footer_widget_area_html() {
		ob_start();
		?>
		<div class="flex__define">
			<?php if ( travel_joy_site_identity( true, true ) || travel_joy_get_widget_area( 'footer_widget_one', array(), true ) ) { ?>
				<div class="flex__item">
					<?php travel_joy_site_identity( true ); ?>
					<?php travel_joy_get_widget_area( 'footer_widget_one' ); ?>
				</div>
			<?php } ?>
			<?php if ( travel_joy_get_widget_area( 'footer_widget_two', array(), true ) ) { ?>
				<div class="flex__item">
					<?php travel_joy_get_widget_area( 'footer_widget_two' ); ?>
				</div>
			<?php } ?>
			<?php if ( travel_joy_get_widget_area( 'footer_widget_three', array(), true ) ) { ?>
				<div class="flex__item">
					<?php travel_joy_get_widget_area( 'footer_widget_three' ); ?>
				</div>
			<?php } ?>
			<?php if ( travel_joy_get_widget_area( 'footer_widget_four', array(), true ) ) { ?>
				<div class="flex__item">
					<?php travel_joy_get_widget_area( 'footer_widget_four' ); ?>
				</div>
			<?php } ?>
		</div>
		<?php
		$footer_widget_areas = ob_get_contents();
		ob_end_flush();
		return $footer_widget_areas;
	}
	add_action( 'travel_joy_footer_widget_areas', 'travel_joy_footer_widget_area_html' );
}


if ( ! function_exists( 'travel_joy_footer_credit_section' ) ) {

	/**
	 * Hook the html after the footer widget areas.
	 */
	function travel_joy_footer_credit_section() {
		$panel   = 'theme_options';
		$section = 'footer';

		$copyright_text = travel_joy_get_theme_options( $panel, $section, 'copyright_text' );
		$facebook       = travel_joy_get_theme_options( $panel, $section, 'facebook' );
		$twitter        = travel_joy_get_theme_options( $panel, $section, 'twitter' );
		$instagram      = travel_joy_get_theme_options( $panel, $section, 'instagram' );
		$linkedin       = travel_joy_get_theme_options( $panel, $section, 'linkedin' );

		ob_start();
		?>
			<div class="flex_define">
				<div class="flex__left">
					<?php if ( ! empty( $copyright_text ) ) { ?>
						<p><?php printf( esc_html__( '%s', 'travel-joy' ), $copyright_text ); // phpcs:ignore ?></p>
					<?php } ?>
				</div>
				<div class="flex__right">
					<?php if ( ! empty( $facebook ) ) { ?>
						<a href="<?php echo esc_url( $facebook ); ?>"><i class="facebook fab fa-facebook-square"></i></a>
					<?php } ?>
					<?php if ( ! empty( $twitter ) ) { ?>
						<a href="<?php echo esc_url( $twitter ); ?>"><i class="twitter fab fa-twitter"></i></a>
					<?php } ?>
					<?php if ( ! empty( $instagram ) ) { ?>
						<a href="<?php echo esc_url( $instagram ); ?>"><i class="instagram fab fa-instagram"></i></a>
					<?php } ?>
					<?php if ( ! empty( $linkedin ) ) { ?>
						<a href="<?php echo esc_url( $linkedin ); ?>"><i class="linkedin fab fa-linkedin-in"></i></a>
					<?php } ?>
				</div>
			</div>
		<?php
		$footer_credit_html = ob_get_contents();
		ob_end_flush();
		return $footer_credit_html;
	}
	add_action( 'travel_joy_after_footer_widget_areas', 'travel_joy_footer_credit_section' );
}

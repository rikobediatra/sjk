<?php
/**
 * Sample implementation of the Custom Header feature
 *
 * You can add an optional custom header image to header.php like so ...
 *
	<?php the_header_image_tag(); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package travel_joy
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses travel_joy_header_style()
 */
function travel_joy_custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'travel_joy_custom_header_args',
			array(
				'default-image'      => '',
				'default-text-color' => '000000',
				'width'              => 1000,
				'height'             => 250,
				'flex-height'        => true,
				'wp-head-callback'   => 'travel_joy_header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'travel_joy_custom_header_setup' );

if ( ! function_exists( 'travel_joy_header_style' ) ) {
	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @see travel_joy_custom_header_setup().
	 */
	function travel_joy_header_style() {
		$header_text_color = get_header_textcolor();

		// If we get this far, we have custom styles. Let's do this.
		if ( ! display_header_text() ) {
			$custom_css = '
			.site-title,.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
			}';
		} else {
			$custom_css = '
			.site-title a {
			color:#' . esc_attr( $header_text_color ) . ' !important;
			}';
		}
		?>
		<style type="text/css">
		<?php echo esc_attr( $custom_css ); ?>
		</style>
		<?php
	}
}

/**
 * Add color styling from theme.
 *
 * It is necessary to keep in free as well as pro version.
 */
function travel_joy_custom_color_options() {
	$panel_name   = 'colors';
	$section_name = $panel_name;
	$suffix       = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'travel-joy-custom-colors-style', get_template_directory_uri() . '/css/custom-colors' . $suffix . '.css', array(), '1.0.0', 'all' );

	// Color Values.
	$link_color       = travel_joy_get_theme_options( $panel_name, $section_name, 'link_color' );
	$link_hover_color = travel_joy_get_theme_options( $panel_name, $section_name, 'link_hover_color' );

	$post_title_color = travel_joy_get_theme_options( $panel_name, $section_name, 'post_title_color' );

	$primary_button_bg_color         = travel_joy_get_theme_options( $panel_name, $section_name, 'primary_button_bg_color' );
	$primary_button_bg_hover_color   = travel_joy_get_theme_options( $panel_name, $section_name, 'primary_button_hover_color' );
	$primary_button_text_color       = travel_joy_get_theme_options( $panel_name, $section_name, 'primary_button_text_color' );
	$primary_button_text_hover_color = travel_joy_get_theme_options( $panel_name, $section_name, 'primary_button_text_hover_color' );

	$secondary_button_bg_color         = travel_joy_get_theme_options( $panel_name, $section_name, 'secondary_button_bg_color' );
	$secondary_button_bg_hover_color   = travel_joy_get_theme_options( $panel_name, $section_name, 'secondary_button_bg_hover_color' );
	$secondary_button_text_color       = travel_joy_get_theme_options( $panel_name, $section_name, 'secondary_button_text_color' );
	$secondary_button_text_hover_color = travel_joy_get_theme_options( $panel_name, $section_name, 'secondary_button_text_hover_color' );

	$footer_section_bg_color = travel_joy_get_theme_options( $panel_name, $section_name, 'footer_section_bg_color' );

	$custom_css = "
	body {
		background-color: #ffffff;
	}
	.blog-wrapper .aside-left a {
		color: {$link_color} !important;
	}
	.blog-wrapper .aside-left a:hover {
		color: {$link_hover_color} !important;
	}
	.footer-credit-text {
		color: {$link_color} !important;
	}
	.footer-credit-text:hover {
		color: {$link_hover_color} !important;
	}



	.wrapper a.facebook {
		color: #000000 !important;
		-webkit-transition: 0.5s;
		transition: 0.5s;
	}
	.wrapper a.facebook:hover {
		color: #3b5998 !important;
	}
	.wrapper a.facebook:focus {
		color: #3b5998 !important;
	}
	.wrapper a.twitter {
		color: #000000 !important;
		-webkit-transition: 0.5s;
		transition: 0.5s;
	}
	.wrapper a.twitter:hover {
		color: #00acee !important;
	}
	.wrapper a.twitter:focus {
		color: #00acee !important;
	}
	.wrapper a.linkedin {
		color: #000000 !important;
		-webkit-transition: 0.5s;
		transition: 0.5s;
	}
	.wrapper a.linkedin:hover {
		color: #0e76a8 !important;
	}
	.wrapper a.linkedin:focus {
		color: #0e76a8 !important;
	}
	.wrapper a.instagram {
		color: #000000 !important;
		-webkit-transition: 0.5s;
		transition: 0.5s;
	}
	.wrapper a.instagram:hover {
		color: #3f729b !important;
	}
	.wrapper a.instagram:focus {
		color: #3f729b !important;
	}


	.wrapper .section-5 .section-wrapper .flex-box .flex__description-box .title h3 {
		color: {$link_color} !important;
	}
	.wrapper .section-5 .section-wrapper .flex-box .flex__description-box .title h3:hover {
		color: {$link_hover_color} !important;
	}
	.menu-primary-nav-menu-container a {
		color: {$link_color} !important;
	}
	.menu-primary-nav-menu-container a:hover {
		color: {$link_hover_color} !important;
	}
	.D-article-1 a {
		color: {$link_color} !important;
	}
	.D-article-1 a:hover {
		color: {$link_hover_color} !important;
	}
	#comments a {
		color: {$link_color} !important;
	}
	#comments a:hover, #comments a:focus {
		color: {$link_hover_color} !important;
	}
	.wp-travel-archive-content .entry-meta .post-category a {
		color: {$link_color} !important;
	}
	.wp-travel-archive-content .entry-meta .post-category a:hover, .wp-travel-archive-content .entry-meta .post-category a:focus{
		color: {$link_hover_color} !important;
	}
	.header .menu-primary-nav-menu-container ul .menu-item .sub-menu li a:hover {
		color: {$link_hover_color} !important;
	}
	a.dropbtn {
		color: {$link_color} !important;
	}
	a.dropbtn:hover {
		color: {$link_hover_color} !important;
	}
	div.dropdown-content a {
		color: {$link_color} !important;
	}
	div.dropdown-content a:hover {
		color: {$link_hover_color} !important;
	}
	.middle .title a {
		color: {$link_color} !important;
	}
	.middle .title a:hover {
		color: {$link_hover_color} !important;
	}
	.right a {
		color: {$link_color} !important;
	}
	
	.right a:hover {
		color: {$link_hover_color} !important;
	}
	.calendar_wrap table  tr td a{
		color: {$link_hover_color} !important;
	}
	#wp-travel-tab-content-logout a, #wp-travel-tab-content-dashboard a {
		color: {$link_color};
	}
	#wp-travel-tab-content-logout a:hover, #wp-travel-tab-content-dashboard a:hover {
		color: {$link_hover_color};
	}
	.dashboard-tab .box-content a {
		color: {$link_hover_color} !important;
	}
	.dashboard-tab .box-content a:hover {
		color: {$link_color} !important;
	}

	.wp-travel-widget-area a{
		color:{$link_color} !important;
	}
	.wp-travel-widget-area a:hover{
		color:{$link_hover_color} !important;
	}
	.wp-travel-view-mode a{
		color:{$link_color}  !important;
	}
	.wp-travel-view-mode.active-mode a{
		color:{$link_hover_color}  !important;
	}
	.wp-travel.trip-headline-wrapper .wp-travel-booking-enquiry{
		color:{$link_color}  !important;
		transition:all 0.5s !important;
	}
	.wp-travel.trip-headline-wrapper .wp-travel-booking-enquiry:hover{
		color:{$link_hover_color}  !important;
	}
	header.entry-header .entry-title a {
		color:{$link_color}  !important;
	}
	.wp-travel-default-article .wp-travel-entry-content-wrapper .description-left .entry-title a:hover {
		color:{$link_hover_color} !important;
	}
	h4.post-title a {
		color: {$link_color} !important;
	}
	h4.post-title a:hover {
		color: {$link_hover_color} !important;
	}
	.item_cart h4 a {
		color: {$link_color} !important;
	}
	.item_cart h4 a:hover {
		color: {$link_hover_color} !important;
	}
	#wp-travel-tab-content-bookings .my-order table.order-list-table td .name-title a, #wp-travel-tab-content-bookings .my-order table.my-order-payment-details td .name-title a {
		color: {$link_color} !important;
	}
	#wp-travel-tab-content-bookings .my-order table.order-list-table td .name-title a:hover, #wp-travel-tab-content-bookings .my-order table.my-order-payment-details td .name-title a:hover {
		color: {$link_hover_color} !important;
	}
	.flex__item .flex__inner-item a {
		color: {$link_color};
	}
	.flex__item .flex__inner-item a:hover {
		color: {$link_hover_color};
	}


	.main-overlay .description-box h2, .grid-box .overlay h1 {
		color: {$post_title_color} !important;
	}


	.wp-travel-toolbar .wp-travel-filter-button .btn-wp-travel-filter,
	.wp-travel-default-article .wp-travel-explore a,
	.wp-travel.trip-headline-wrapper .wp-travel-booknow-btn {
		color: {$primary_button_text_color} !important;
		background-color: {$primary_button_bg_color} !important;
	}
	.wp-travel-toolbar .wp-travel-filter-button .btn-wp-travel-filter:hover,
	.wp-travel-default-article .wp-travel-explore a:hover,
	.wp-travel.trip-headline-wrapper .wp-travel-booknow-btn:hover {
		color: {$primary_button_text_hover_color} !important;
		background-color: {$primary_button_bg_hover_color} !important;
	}
	.primary-button, button.slick-arrow {
		color: {$primary_button_text_color} !important;
		background-color: {$primary_button_bg_color} !important;
	}
	.primary-button:hover, button.slick-arrow:hover, .primary-button:focus, button.slick-arrow:focus {
		color: {$primary_button_text_hover_color} !important;
		background-color: {$primary_button_bg_hover_color} !important;
	}
	ul.availabily-list .availabily-content .btn, .wp-travel .button {
		color: {$primary_button_text_color} !important;
		background-color: {$primary_button_bg_color} !important;
	}
	ul.availabily-list .availabily-content .btn:hover, .wp-travel .button:hover {
		color: {$primary_button_text_hover_color} !important;
		background-color: {$primary_button_bg_hover_color} !important;
	}
	#wp-travel-enquiry-submit {
		color: {$primary_button_text_color} !important;
		background-color: {$primary_button_bg_color} !important;
	}
	#wp-travel-enquiry-submit:hover {
		color: {$primary_button_text_hover_color} !important;
		background-color: {$primary_button_bg_hover_color} !important;
	}
	.slick-prev:before, .slick-next:before {
		color: {$primary_button_text_color} !important;
	}
	.ws-theme-cart-page .actions .book-now-btn {
		color: {$primary_button_text_color} !important;
		background: {$primary_button_bg_color} !important;
	}
	.ws-theme-cart-page .actions .book-now-btn:hover {
		color: {$primary_button_text_hover_color} !important;
		background: {$primary_button_bg_hover_color} !important;
	}
	.wp-travel .button, .checkout-page-wrap .wp-travel-form-field input[type=submit] {
		color: {$primary_button_text_color} !important;
		background: {$primary_button_bg_color} !important;
	}
	.wp-travel .button, .checkout-page-wrap .wp-travel-form-field input[type=submit]:hover {
		color: {$primary_button_text_hover_color} !important;
		background: {$primary_button_bg_hover_color} !important;
	}
	.form-submit .submit {
		color: {$primary_button_text_color} !important;
		background-color: {$primary_button_bg_color} !important;
	}
	.form-submit .submit:hover {
		color: {$primary_button_text_hover_color} !important;
		background-color: {$primary_button_bg_hover_color} !important;
	}
	#wp-travel-tab-content-bookings .my-order .book-more a, #wp-travel-tab-content-bookings .my-order .no-order a {
		color: {$primary_button_text_color} !important;
		background-color: {$primary_button_bg_color} !important;
	}
	#wp-travel-tab-content-bookings .my-order .book-more a:hover, #wp-travel-tab-content-bookings .my-order .no-order a:hover {
		color: {$primary_button_text_hover_color} !important;
		background-color: {$primary_button_bg_hover_color} !important;
	}
	.nav-links .prev.page-numbers, .nav-links .next.page-numbers {
		color: {$primary_button_text_color} !important;
		background-color: {$primary_button_bg_color} !important;
	}
	.nav-links .prev.page-numbers:hover, .nav-links .next.page-numbers:hover {
		color: {$primary_button_text_hover_color} !important;
		background-color: {$primary_button_bg_hover_color} !important;
	}

	.wp-travel-toolbar .wp-travel-filter-button .btn-wp-travel-filter:focus, .wp-travel-default-article .wp-travel-explore a:focus, .wp-travel.trip-headline-wrapper .wp-travel-booknow-btn:focus {
		color: {$primary_button_text_hover_color} !important;
		background-color: {$primary_button_bg_hover_color} !important;
	}

	.secondary-button {
		color: {$secondary_button_text_color} !important;
		background-color: {$secondary_button_bg_color} !important;
	}
	.secondary-button:hover {
		color: {$secondary_button_text_hover_color} !important;
		background-color: {$secondary_button_bg_hover_color} !important;
	}
	.ws-theme-cart-page .update-cart {
		color: {$secondary_button_text_color} !important;
		border: 1px solid {$secondary_button_text_color} !important;
	}
	.ws-theme-cart-page .update-cart:hover {
		color: {$secondary_button_text_hover_color} !important;
		background-color: {$secondary_button_bg_hover_color} !important;
	}

	.section-11 {
		background: {$footer_section_bg_color} !important;
	}

	.wrapper a:focus, .blog-wrapper a:focus, .details-wrapper a:focus {
		color: {$link_color} !important;
	}

	.keyboard-nav-on a:focus, .keyboard-nav-on input:focus, .keyboard-nav-on button:focus {
		outline: thin solid {$link_color} !important;
	}

	@media (max-width: 992px) {
		.header .menu-primary-nav-menu-container .sidenav a:focus {
			color: #fff !important;
		}
	}
	";
	wp_add_inline_style( 'travel-joy-custom-colors-style', esc_html( $custom_css ) );
}
add_action( 'wp_enqueue_scripts', 'travel_joy_custom_color_options' );

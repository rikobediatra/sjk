<?php
/**
 * Theme functions and definitions
 *
 * @package mik_travel
 */ 


if ( ! function_exists( 'mik_travel_enqueue_styles' ) ) :
	/**
	 * Load assets.
	 *
	 * @since 1.0.0
	 */
	function mik_travel_enqueue_styles() {
		wp_enqueue_style( 'mik-style-parent', get_template_directory_uri() . '/style.css' );
		wp_enqueue_style( 'mik-travel-style', get_stylesheet_directory_uri() . '/style.css', array( 'mik-style-parent' ), '1.0.0' );
	}
endif;
add_action( 'wp_enqueue_scripts', 'mik_travel_enqueue_styles', 99 );

function mik_travel_remove_action() {
	remove_action( 'mik_header_start_action', 'mik_header_start', 10 );
	remove_action( 'mik_primary_content_action', 'mik_add_slider_section', 10 );
    remove_action( 'mik_primary_content_action', 'mik_add_featured_section', 10 );
    remove_action( 'mik_primary_content_action', 'mik_add_cta_section', 10 );
}
add_action( 'init', 'mik_travel_remove_action');

if ( ! function_exists( 'mik_travel_theme_defaults' ) ) :
    /**
     * Customize theme defaults.
     *
     * @since 1.0.0
     *
     * @param array $defaults Theme defaults.
     * @param array Custom theme defaults.
     */
    function mik_travel_theme_defaults( $defaults ) {
        $defaults['enable_slider'] = false;
        $defaults['enable_featured_dot'] = false;
        $defaults['enable_latest_blog_dot'] = false;
        $defaults['blog_column_type'] = 'column-2';

        return $defaults;
    }
endif;
add_filter( 'mik_default_theme_options', 'mik_travel_theme_defaults', 99 );

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses mik_travel_header_style()
 */
function mik_travel_custom_header_setup() {

    register_default_headers( array(
        'default-image' => array(
            'url'           => '%2$s/assets/uploads/banner.jpg',
            'thumbnail_url' => '%2$s/assets/uploads/banner.jpg',
            'description'   => esc_html__( 'Default Header Image', 'mik-travel' ),
        ),
    ) );
}
add_action( 'after_setup_theme', 'mik_travel_custom_header_setup' );

if ( ! function_exists( 'mik_travel_custom_header_defaults' ) ) :
    /**
     * set default header image.
     */
    function mik_travel_custom_header_defaults( $defaults ) {
        $defaults['default-image'] = get_stylesheet_directory_uri() . '/assets/uploads/banner.jpg';

        return $defaults;
    }
endif;
add_filter( 'mik_custom_header_args', 'mik_travel_custom_header_defaults', 99 );

if ( ! function_exists( 'mik_travel_header_start' ) ) :
	/**
	 * Header starts html codes
	 *
	 * @since Mik 1.0.0
	 */
	function mik_travel_header_start() { 
        $slider_enable = mik_theme_option('enable_slider', false );
        $class = 'left-absolute';
        if ( is_home() && is_front_page() ) {
            $class = $slider_enable ? 'left-absolute' : 'left-align';
        }
		?>
		<header id="masthead" class="site-header <?php echo esc_attr( $class ); ?>">
		<div class="wrapper">
	<?php }
endif;
add_action( 'mik_header_start_action', 'mik_travel_header_start', 10 );

if ( ! function_exists( 'mik_travel_add_slider_section' ) ) :
    /**
    * Add slider section
    *
    *@since Mik 1.0.0
    */
    function mik_travel_add_slider_section() {

        // Check if slider is enabled on frontpage
        $slider_enable = apply_filters( 'mik_section_status', 'enable_slider', 'slider_entire_site' );

        if ( ! $slider_enable )
            return false;

        if ( ! is_singular() ) {
            $paged = get_query_var( 'paged' );
            if ( $paged !== 0 )
                return false;
        }

        // Get slider section details
        $section_details = array();
        $section_details = apply_filters( 'mik_travel_filter_slider_section_details', $section_details );

        if ( empty( $section_details ) ) 
            return;

        // Render slider section now.
        mik_travel_render_slider_section( $section_details );
    }
endif;
add_action( 'mik_primary_content_action', 'mik_travel_add_slider_section', 10 );

if ( ! function_exists( 'mik_travel_get_slider_section_details' ) ) :
    /**
    * slider section details.
    *
    * @since Mik 1.0.0
    * @param array $input slider section details.
    */
    function mik_travel_get_slider_section_details( $input ) {

        $content = array();
        $post_ids = array();

        for ( $i = 1; $i <= 5; $i++ )  :
            $post_ids[] = mik_theme_option( 'slider_content_post_' . $i );
        endfor;
        
        $args = array(
            'post_type'         => 'post',
            'post__in'          =>  ( array ) $post_ids,
            'posts_per_page'    => 5,
            'orderby'           => 'post__in',
            'ignore_sticky_posts' => true,
            );                    

        // Run The Loop.
        $query = new WP_Query( $args );
        if ( $query->have_posts() ) : 
            while ( $query->have_posts() ) : $query->the_post();
                $page_post['id']        = get_the_id();
                $page_post['title']     = get_the_title();
                $page_post['url']       = get_the_permalink();
                $page_post['image']     = has_post_thumbnail() ? get_the_post_thumbnail_url( get_the_id(), 'full' ) : '';

                // Push to the main array.
                array_push( $content, $page_post );
            endwhile;
        endif;
        wp_reset_postdata();
            
        if ( ! empty( $content ) )
            $input = $content;
       
        return $input;
    }
endif;
// slider section content details.
add_filter( 'mik_travel_filter_slider_section_details', 'mik_travel_get_slider_section_details' );

if ( ! function_exists( 'mik_travel_render_slider_section' ) ) :
  /**
   * Start slider section
   *
   * @return string slider content
   * @since Mik 1.0.0
   *
   */
   function mik_travel_render_slider_section( $content_details = array() ) {
        if ( empty( $content_details ) )
            return;

        $slider_control = mik_theme_option( 'slider_arrow' );
        $auto_slide = mik_theme_option('slider_auto_slide', false );
        $readmore = mik_theme_option( 'slider_btn_label', '' );
        ?>
    	<div id="custom-header" class="homepage-section">
            <div class="section-content banner-slider left-align column-1" data-slick='{"slidesToShow": 1, "slidesToScroll": 1, "infinite": true, "speed": 1200, "dots": false, "arrows":<?php echo $slider_control ? 'true' : 'false'; ?>, "autoplay": <?php echo $auto_slide ? 'true' : 'false'; ?>, "fade": false, "draggable": true }'>
                <?php foreach ( $content_details as $content ) : ?>
                    <div class="custom-header-content-wrapper slide-item">
                        <div class="overlay"></div>
                        <?php if ( ! empty( $content['image'] ) ) : ?>
                            <img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>">
                        <?php endif; ?>

                        <div class="wrapper">
                            <div class="custom-header-content">
                                <span class="cat-links">
                                    <?php the_category( ', ', '', $content['id'] ); ?>
                                </span>

                                <?php if ( ! empty( $content['title'] ) ) : ?>
                                    <h2><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                <?php endif; 

                                if ( ! empty( $content['url'] ) && ! empty( $readmore ) ) : ?>
                                    <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn btn-transparent"><?php echo esc_html( $readmore ); ?></a>
                                <?php endif; ?>
                            </div><!-- .custom-header-content -->
                        </div><!-- .wrapper -->
                    </div><!-- .custom-header-content-wrapper -->
                <?php endforeach; ?>
            </div><!-- .banner-slider -->
        </div><!-- #custom-header -->
    <?php 
    }
endif;

if ( ! function_exists( 'mik_travel_add_cta_section' ) ) :
    /**
    * Add cta section
    *
    *@since Mik 1.0.0
    */
    function mik_travel_add_cta_section() {

        // Check if cta is enabled on frontpage
        $cta_enable = apply_filters( 'mik_section_status', 'enable_cta', '' );

        if ( ! $cta_enable )
            return false;

        if ( ! is_singular() ) {
            $paged = get_query_var( 'paged' );
            if ( $paged !== 0 )
                return false;
        }

        // Get cta section details
        $section_details = array();
        $section_details = apply_filters( 'mik_filter_cta_section_details', $section_details );

        if ( empty( $section_details ) ) 
            return;

        // Render cta section now.
        mik_travel_render_cta_section( $section_details );
    }
endif;
add_action( 'mik_primary_content_action', 'mik_travel_add_cta_section', 40 );

if ( ! function_exists( 'mik_travel_render_cta_section' ) ) :
  /**
   * Start cta section
   *
   * @return string cta content
   * @since Mik 1.0.0
   *
   */
   function mik_travel_render_cta_section( $content_details = array() ) {
        $readmore = mik_theme_option( 'cta_btn_label', '' );

        if ( empty( $content_details ) )
            return;

        foreach ( $content_details as $content ) : ?>
            <div id="cta-section" class="relative homepage-section align-center wrapper" <?php if ( ! empty( $content['image'] ) ) { echo 'style=" background-image: url( ' . esc_url( $content['image'] ) . ' ) "'; } ?> >
                <div class="overlay"></div>
                <div class="entry-container">
                    <header class="entry-header">
                        <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                    </header>
                    <?php if ( ! empty( $readmore ) ) : ?>
                        <a href="<?php echo esc_url( $content['url'] ); ?>" class="btn btn-transparent"><?php echo esc_html( $readmore ); ?></a>
                    <?php endif; ?>
                </div>
            </div><!-- #cta-section -->
        <?php endforeach;
    }
endif;

if ( ! function_exists( 'mik_travel_add_featured_section' ) ) :
    /**
    * Add featured section
    *
    *@since Mik 1.0.0
    */
    function mik_travel_add_featured_section() {

        // Check if featured is enabled on frontpage
        $featured_enable = apply_filters( 'mik_section_status', 'enable_featured', '' );

        if ( ! $featured_enable )
            return false;

        if ( ! is_singular() ) {
            $paged = get_query_var( 'paged' );
            if ( $paged !== 0 )
                return false;
        }

        // Get featured section details
        $section_details = array();
        $section_details = apply_filters( 'mik_filter_featured_section_details', $section_details );

        if ( empty( $section_details ) ) 
            return;

        // Render featured section now.
        mik_travel_render_featured_section( $section_details );
    }
endif;
add_action( 'mik_primary_content_action', 'mik_travel_add_featured_section', 30 );

if ( ! function_exists( 'mik_travel_render_featured_section' ) ) :
  /**
   * Start featured section
   *
   * @return string featured content
   * @since Mik 1.0.0
   *
   */
   function mik_travel_render_featured_section( $content_details = array() ) {
        if ( empty( $content_details ) )
            return;

        $dot = mik_theme_option( 'enable_featured_dot' );
        $title = mik_theme_option( 'featured_title', '' );
        ?>
        <div id="featured-posts" class="relative homepage-section">
            <div class="wrapper page-section">
                <?php if ( ! empty( $title ) ) : ?>
                    <header class="page-header">
                        <h2 class="section-title <?php echo $dot ? 'add-separator' : ''; ?>"><?php echo esc_html( $title ); ?></h2>
                    </header>
                <?php endif; ?>

                <div class="section-content left-align column-3">
                    <?php foreach ( $content_details as $content ) : ?>
                            <article class="hentry">
                                <div class="post-wrapper">
                                    <?php if ( ! empty( $content['image'] ) ) : ?>
                                        <div class="featured-image">
                                            <a href="<?php echo esc_url( $content['url'] ); ?>">
                                                <img src="<?php echo esc_url( $content['image'] ); ?>" alt="<?php echo esc_attr( $content['title'] ); ?>">
                                            </a>
                                        </div><!-- .recent-image -->
                                    <?php endif; ?>

                                    <div class="entry-container">
                                        <div class="entry-meta">
                                            <span class="posted-on">
                                                <a href="<?php echo esc_url( $content['url'] ); ?>">
                                                    <time>
                                                        <?php 
                                                            echo mik_get_svg( array( 'icon' => 'calendar' ) );
                                                            echo date_i18n( get_option('date_format'), strtotime ( get_the_date( '', $content['id'] ) ) ); 
                                                        ?>
                                                    </time>
                                                </a>
                                            </span>
                                        </div>

                                        <header class="entry-header">
                                            <h2 class="entry-title"><a href="<?php echo esc_url( $content['url'] ); ?>"><?php echo esc_html( $content['title'] ); ?></a></h2>
                                        </header>

                                        <div class="entry-content">
                                            <p><?php echo esc_html( $content['excerpt'] ); ?></p>
                                        </div><!-- .entry-content -->

                                    </div><!-- .entry-container -->
                                </div><!-- .post-wrapper -->
                            </article>
                        <?php endforeach; ?>
                </div><!-- .section-content -->
            </div><!-- .wrapper -->
        </div><!-- #featured-posts -->
    <?php 
    }
endif;


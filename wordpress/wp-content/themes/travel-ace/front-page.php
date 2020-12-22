<?php
/**
 * The template for displaying home page.
 * @package Travel Ace
 */

if ( 'posts' != get_option( 'show_on_front' ) ){ 
    get_header(); ?>
    <?php $enabled_sections = travel_ace_get_sections();
    if( is_array( $enabled_sections ) ) {
        foreach( $enabled_sections as $section ) {

            if( ( $section['id'] == 'featured-slider' ) ){ ?>
                <?php $enable_featured_slider = travel_ace_get_option( 'enable_featured_slider' );
                if( true ==$enable_featured_slider): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>">
                        <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'our-services' ) { ?>
                <?php $enable_our_services_section = travel_ace_get_option( 'enable_our_services_section' );
                if( true ==$enable_our_services_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section white-background">
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'popular-destinations' ) { ?>
                <?php $enable_popular_destinations_section = travel_ace_get_option( 'enable_popular_destinations_section' );
                if(true ==$enable_popular_destinations_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section white-background">  
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
            <?php endif; ?>

            <?php } elseif( $section['id'] == 'cta' ) { ?>
                <?php $enable_cta_section   = travel_ace_get_option( 'enable_cta_section' );
                $background_cta_section     = travel_ace_get_option( 'background_cta_section' );
                if( true ==$enable_cta_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="page-section white-background">
                        <div class="wrapper">
                            <div class="cta-wrapper">
                                <div class="featured-image" style="background-image: url('<?php echo esc_url( $background_cta_section );?>');"></div>
                                <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                            </div><!-- .cta-wrapper -->
                        </div><!-- .wrapper -->
                    </section>
            <?php endif; ?>

            <?php } elseif( ( $section['id'] == 'blog' ) ){ ?>
                <?php $enable_blog_section = travel_ace_get_option( 'enable_blog_section' );
                if(true ==$enable_blog_section): ?>
                    <section id="<?php echo esc_attr( $section['id'] ); ?>" class="blog-posts-wrapper page-section white-background">
                        <div class="wrapper">
                            <?php get_template_part( 'sections/section', esc_attr( $section['id'] ) ); ?>
                        </div>
                    </section>
                <?php endif;
            }
        }
    }
    if( true == travel_ace_get_option('enable_frontpage_content') ) { ?>
        <div class="wrapper page-section">
            <?php include( get_page_template() ); ?>
        </div>
    <?php }
    get_footer();
} 
elseif ('posts' == get_option( 'show_on_front' ) ) {
    include( get_home_template() );
} 
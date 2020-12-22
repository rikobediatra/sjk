<?php 
/**
 * Template part for displaying Popular Destinations Section
 *
 *@package Travel Ace
 */
    $popular_destinations_section_title    = travel_ace_get_option( 'popular_destinations_section_title' );
    $cs_content_type                       = travel_ace_get_option( 'cs_content_type' );
    $number_of_cs_items                    = travel_ace_get_option( 'number_of_cs_items' );

    if( $cs_content_type == 'cs_page' ) :
        for( $i=1; $i<=$number_of_cs_items; $i++ ) :
            $popular_destinations_posts[] = travel_ace_get_option( 'popular_destinations_page_'.$i );
        endfor;  
    elseif( $cs_content_type == 'cs_post' ) :
        for( $i=1; $i<=$number_of_cs_items; $i++ ) :
            $popular_destinations_posts[] = travel_ace_get_option( 'popular_destinations_post_'.$i );
        endfor;
    endif;
    ?>

    <?php if( !empty($popular_destinations_section_title) ):?>
        <div class="section-header">
            <h2 class="section-title"><?php echo esc_html($popular_destinations_section_title);?></h2>
        </div><!-- .section-header -->
    <?php endif;?>

    <?php if( $cs_content_type == 'cs_page' ) : ?>
        <div class="section-content col-3 clear">
            <?php $args = array (
                'post_type'     => 'page',
                'post_per_page' => count( $popular_destinations_posts ),
                'post__in'      => $popular_destinations_posts,
                'orderby'       =>'post__in',
            );        
            $loop = new WP_Query($args);                        
                if ( $loop->have_posts() ) :
                    $i=-1;  
                    while ($loop->have_posts()) : $loop->the_post(); $i++;?>
                    
                    <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                        <div class="popular-destination-wrapper">
                        
                            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                            </div><!-- .featured-image -->

                            <div class="overlay-one"></div>
                            <div class="overlay-two"></div>

                            <div class="entry-container">
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                </header>

                                <div class="entry-content">
                                    <?php
                                        $excerpt = travel_ace_the_excerpt( 20 );
                                        echo wp_kses_post( wpautop( $excerpt ) );
                                    ?>
                                </div><!-- .entry-content -->

                                <div class="read-more">
                                    <?php $readmore_text = travel_ace_get_option( 'readmore_text' );?>
                                    <a href="<?php the_permalink();?>" class="more-link"><?php echo esc_html($readmore_text);?></a>
                                </div><!-- .read-more -->
                            </div><!-- .entry-container -->
                        </div><!-- .popular-destination-wrapper -->
                    </article>
                  <?php endwhile;?>
                <?php endif;?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    
    <?php else: ?>
        <div class="section-content col-3 clear">
            <?php $args = array (
                'post_type'     => 'post',
                'post_per_page' => count( $popular_destinations_posts ),
                'post__in'      => $popular_destinations_posts,
                'orderby'       =>'post__in',
                'ignore_sticky_posts' => true,
            );        
            $loop = new WP_Query($args);                        
                if ( $loop->have_posts() ) :
                    $i=-1;  
                    while ($loop->have_posts()) : $loop->the_post(); $i++;?>     
                    
                    <article class="<?php echo has_post_thumbnail() ? 'has-post-thumbnail' : 'no-post-thumbnail'; ?>">
                        <div class="popular-destination-wrapper">
                        
                            <div class="featured-image" style="background-image: url('<?php the_post_thumbnail_url( 'full' ); ?>');">
                                <a href="<?php the_permalink();?>" class="post-thumbnail-link"></a>
                            </div><!-- .featured-image -->

                            <div class="overlay-one"></div>
                            <div class="overlay-two"></div>

                            <div class="entry-container">
                                <header class="entry-header">
                                    <h2 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                                </header>

                                <div class="entry-content">
                                    <?php
                                        $excerpt = travel_ace_the_excerpt( 20 );
                                        echo wp_kses_post( wpautop( $excerpt ) );
                                    ?>
                                </div><!-- .entry-content -->

                                <div class="read-more">
                                    <?php $readmore_text = travel_ace_get_option( 'readmore_text' );?>
                                    <a href="<?php the_permalink();?>" class="more-link"><?php echo esc_html($readmore_text);?></a>
                                </div><!-- .read-more -->
                            </div><!-- .entry-container -->
                        </div><!-- .popular-destination-wrapper -->
                    </article>

                  <?php endwhile;?>
                <?php endif;?>
            <?php wp_reset_postdata(); ?>
        </div><!-- .section-content -->
    <?php endif;
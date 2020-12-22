<?php 
/**
 * Template part for displaying CTA Section
 *
 *@package Travel Ace
 */
?>
    <?php 
        $cta_title              = travel_ace_get_option( 'cta_title' );
        $cta_button_label       = travel_ace_get_option( 'cta_button_label' );
        $cta_button_url         = travel_ace_get_option( 'cta_button_url' );
    ?>

    <div class="entry-container">
        <?php if ( !empty($cta_title ) )  :?>
            <div class="section-header">
                <h2 class="section-title"><?php echo esc_html($cta_title); ?></h2>
            </div><!-- .section-header -->
        <?php endif;?>

        <?php if ( !empty($cta_button_label ) )  :?>
            <div class="read-more">
                <a href="<?php echo esc_url($cta_button_url); ?>" class="btn"><?php echo esc_html($cta_button_label); ?></a>
            </div><!-- .read-more -->
        <?php endif;?>
    </div><!-- .entry-container -->


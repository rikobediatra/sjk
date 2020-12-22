<?php
/**
 * Active callback functions.
 *
 * @package Travel Ace
 */

function travel_ace_slider_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_featured_slider]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function travel_ace_slider_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[slider_content_type]' )->value();
    return ( travel_ace_slider_active( $control ) && ( 'slider_page' == $content_type ) );
}

function travel_ace_slider_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[slider_content_type]' )->value();
    return ( travel_ace_slider_active( $control ) && ( 'slider_post' == $content_type ) );
}

function travel_ace_our_services_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_our_services_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function travel_ace_our_services_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[services_content_type]' )->value();
    return ( travel_ace_our_services_active( $control ) && ( 'services_page' == $content_type ) );
}

function travel_ace_our_services_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[services_content_type]' )->value();
    return ( travel_ace_our_services_active( $control ) && ( 'services_post' == $content_type ) );
}

function travel_ace_popular_destinations_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_popular_destinations_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function travel_ace_popular_destinations_page( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[cs_content_type]' )->value();
    return ( travel_ace_popular_destinations_active( $control ) && ( 'cs_page' == $content_type ) );
}

function travel_ace_popular_destinations_post( $control ) {
    $content_type = $control->manager->get_setting( 'theme_options[cs_content_type]' )->value();
    return ( travel_ace_popular_destinations_active( $control ) && ( 'cs_post' == $content_type ) );
}

function travel_ace_cta_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_cta_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

function travel_ace_blog_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[enable_blog_section]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}

/**
 * Active Callback for top bar section
 */
function travel_ace_contact_info_ac( $control ) {

    $show_contact_info = $control->manager->get_setting( 'theme_options[show_header_contact_info]')->value();
    $control_id        = $control->id;
         
    if ( $control_id == 'theme_options[header_location]' && $show_contact_info ) return true;
    if ( $control_id == 'theme_options[header_phone]' && $show_contact_info ) return true;

    return false;
}

function travel_ace_social_links_active( $control ) {
    if( $control->manager->get_setting( 'theme_options[show_header_social_links]' )->value() == true ) {
        return true;
    }else{
        return false;
    }
}
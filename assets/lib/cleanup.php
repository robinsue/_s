<?php

/**
 * Remove Meta Generator
 */
function disable_version() {
return ”;
}
add_filter('the_generator','remove_wp_version_rss');
remove_action('wp_head', 'wp_generator');



/**
 * Removes file version queries from script/stylesheet calls.
 * http://wordpress.stackexchange.com/a/96325/23011
 * 
 * Enhanced to keep query of google font stylesheets:
 * Removes “?ver=3.5.1” from http://domain.tld/wp-content/themes/theme/stlye.css?ver=3.5.1
 * Leaves http://fonts.googleapis.com/css?family=MyFont untouched.
 */
add_filter( 'script_loader_src', 'gp130419_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', 'gp130419_remove_script_version', 15, 1 );
function gp130419_remove_script_version( $src ){
    $url = explode( '?', $src );

    if( 'http://fonts.googleapis.com/css' == $url[0] ) :
        $version = explode( '&ver=', $url[1] );
        $url[1] = $version[0];
    endif;

    return ( 'http://fonts.googleapis.com/css' == $url[0] ) ? $url[0] . '?' . $url[1] : $url[0];

}

?>


<?php
function _s_scripts() {
  /**
   * Add in Header
   */

  // Style Sheet
    wp_enqueue_style( '_s-css', get_template_directory_uri() . '/assets/dist/css/style.css', array(), '', 'all' );

  // Modernizr
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/dist/js/modernizr.js', array(), '2.8.3', false );

  // Remove WP version of jQuery
    wp_deregister_script('jquery');


  /**
   * Add in Footer
   */

  // Load jQuery from assets
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/assets/dist/js/jquery.min.js', array(), '2.1.3', true );

  // Foundation
   wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/assets/dist/js/foundation.min.js', array( 'jquery' ), '', true );
    
  // Custom (initialise foundation & holds all custom scripts)
    wp_enqueue_script( '_s-js', get_template_directory_uri() . '/assets/dist/js/app.js', array( 'jquery' ), '', true );


  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );
?>
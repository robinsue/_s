<?php
/**
 * _s functions and definitions.
 *
 * @link https://codex.wordpress.org/Functions_File_Explained
 *
 * @package _s
 */

if ( ! function_exists( '_s_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function _s_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on _s, use a find and replace
	 * to change '_s' to the name of your theme in all the template files.
	 */
	load_theme_textdomain( '_s', get_template_directory() . '/languages' );

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

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', '_s' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See https://developer.wordpress.org/themes/functionality/post-formats/
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( '_s_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // _s_setup
add_action( 'after_setup_theme', '_s_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function _s_content_width() {
	$GLOBALS['content_width'] = apply_filters( '_s_content_width', 640 );
}
add_action( 'after_setup_theme', '_s_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function _s_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', '_s' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', '_s_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function _s_scripts() {
	// wp_enqueue_style( '_s-style', get_stylesheet_uri() );

	// Register consolidated style sheet
    wp_enqueue_style( '_s-css', get_template_directory_uri() . '/assets/css/style.css', array(), '', 'all' );

	// wp_enqueue_script( '_s-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

    // Loads Modernizr from bower_components
    wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/bower_components/foundation/js/vendor/modernizr.js', array(), '2.8.3', false );

	// Removes WP version of jQuery
	wp_deregister_script('jquery');

	// Loads jQuery from bower_components
    wp_enqueue_script( 'jquery', get_template_directory_uri() . '/bower_components/foundation/js/vendor/jquery.js', array(), '2.1.3', true );

    // Adding Foundation scripts file in the footer
   wp_enqueue_script( 'foundation-js', get_template_directory_uri() . '/assets/js/min/foundation.min.js', array( 'jquery' ), '', true );
    
    // Adding custom scripts file in the footer
    wp_enqueue_script( '_s-js', get_template_directory_uri() . '/assets/js/app.js', array( 'jquery' ), '', true );

	wp_enqueue_script( '_s-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );


	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', '_s_scripts' );



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



/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

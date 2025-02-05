<?php
/**
 * Bloomsbury Starter Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Bloomsbury_Theme
 */

if ( ! function_exists( 'bloomsbury_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 */
function bloomsbury_setup() {
	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Let WordPress manage the document title.
	add_theme_support( 'title-tag' );

	// Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html( 'Primary Menu' ),
	) );

	// Switch search form, comment form, and comments to output valid HTML5.
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

}
endif; // bloomsbury_setup
add_action( 'after_setup_theme', 'bloomsbury_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * @global int $content_width
 */

function bloomsbury_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'bloomsbury_content_width', 640 );
}
add_action( 'after_setup_theme', 'bloomsbury_content_width', 0 );


/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function bloomsbury_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html( 'Sidebar' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'bloomsbury_widgets_init' );

add_action('woocommerce_before_customer_login_form', 'load_register_form', 2);


// Loading the Register Form as Function to by-pass WooCommerce override
function load_register_form(){
if(isset($_GET['action'])=='register'){
woocommerce_get_template( 'myaccount/form-register.php' );
}}

/**
 * Filter the stylesheet_uri to output the minified CSS file.
 */
function bloomsbury_minified_css( $stylesheet_uri, $stylesheet_dir_uri ) {
	if ( file_exists( get_template_directory() . '/build/css/style.min.css' ) ) {
		$stylesheet_uri = $stylesheet_dir_uri . '/build/css/style.min.css';
	}

	return $stylesheet_uri;
}
add_filter( 'stylesheet_uri', 'bloomsbury_minified_css', 10, 2 );

/**
 * Enqueue scripts and styles.
 */
function bloomsbury_scripts(){
	wp_enqueue_style( 'red-starter-style', get_stylesheet_uri() );
  	wp_enqueue_style('font-awesome-cdn', 'https://use.fontawesome.com/releases/v5.7.2/css/all.css', array(), '5.7.2');
  	wp_enqueue_script( 'contact-form', get_template_directory_uri() . '/build/js/request.min.js', array(), '1.0.1', true);
	wp_enqueue_script('edit-account-script', get_template_directory_uri() . '/build/js/edit-account-script.min.js', array(), '1.0.1', true);
	wp_enqueue_script( 'login-register', get_template_directory_uri() . '/build/js/login-script.min.js', array(), '1.0.1', true );
	wp_enqueue_script( 'red-starter-navigation', get_template_directory_uri() . '/build/js/navigation.min.js', array(), '20151215', true );
	wp_enqueue_script( 'red-starter-skip-link-focus-fix', get_template_directory_uri() . '/build/js/skip-link-focus-fix.min.js', array(), '20151215', true );
	// font awsome
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'bloomsbury_scripts' );

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';


// Adding custom fields in wordpress
add_filter('acf/settings/remove_wp_meta_box', '__return_false');

// Adding image sizes
function bloomsbury_features() {
    add_image_size('pageBanner', 1500, 350, true);
}

<?php
//* Start the engine
require_once( get_template_directory() . '/lib/init.php' );

//* Child theme (do not remove)
define( 'CHILD_THEME_NAME', 'Genesis Sample Theme' );
define( 'CHILD_THEME_URL', 'http://www.studiopress.com/' );

//* Enqueue Lato Google font
add_action( 'wp_enqueue_scripts', 'genesis_sample_google_fonts' );
function genesis_sample_google_fonts() {
	wp_enqueue_style( 'google-font', '//fonts.googleapis.com/css?family=Lato:700', array(), PARENT_THEME_VERSION );
}

//* Add HTML5 markup structure
add_theme_support( 'genesis-html5' );

//* Add viewport meta tag for mobile browsers
add_theme_support( 'genesis-responsive-viewport' );

//* Add support for custom background
add_theme_support( 'custom-background' );

//* Add support for 3-column footer widgets
add_theme_support( 'genesis-footer-widgets', 3 );

// Custom menu.
remove_theme_support('genesis-menus');
add_theme_support('genesis-menus', array(
    'primary'   => 'Primary Navigation Menu',
    'secondary' => 'Secondary Navigation Menu',
    'tertiary'  => 'Tertiary Navigation Menu'
));

add_action('genesis_after_header', 'tertiary_nav');
function tertiary_nav() {
    require(CHILD_DIR . '/tertiary-nav.php');
}
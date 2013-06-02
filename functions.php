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

add_theme_support('post-thumbnails');

add_action('genesis_after_header', 'tertiary_nav');
function tertiary_nav() {
    require(CHILD_DIR . '/tertiary-nav.php');
}

add_image_size('grid-thumbnail', 300, 300, TRUE);

function new_post_info() {
    global $post;
    if (get_post_type($post->ID) == 'page') {
        return;
    }

    $post_info = '[post_date] ' . __('by', 'genesis') . ' [post_author_posts_link] [post_edit]';
    printf('<div class="post-info">%s</div>', apply_filters('genesis_post_info', $post_info));
}

remove_action('genesis_entry_content', 'genesis_do_post_image');
add_action('genesis_entry_content', 'do_post_image_placeholder');
function do_post_image_placeholder() {
	if (!is_singular() && genesis_get_option('content_archive_thumbnail')) {
		$img = genesis_get_image(array( 
			'format'  => 'html',
			'size'    => genesis_get_option('image_size'),
			'context' => 'archive',
			'attr'    => genesis_attr('entry-image', array('output' => 'array'))
		));

		if (empty($img)) {
            $attrs = genesis_attr('entry-image', array('output' => 'array'));
            $img = '<img src="' . get_stylesheet_directory_uri() . '/images/placeholder.jpg" class="' . $attrs['class'] . '" />';
        }

        printf('<a href="%s" title="%s">%s</a>', get_permalink(), the_title_attribute('echo=0'), $img);
	}
}

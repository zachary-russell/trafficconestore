<?php
/** Set up grid and force full content width. */
add_filter('genesis_pre_get_option_site_layout', 'child_do_layout');
add_filter('post_class', 'home_archive_post_class');

/** Customise post display for the grid. */
remove_action('genesis_entry_header', 'genesis_do_post_title');
remove_action('genesis_entry_header', 'genesis_post_info');
remove_action('genesis_entry_footer', 'genesis_post_meta');
remove_action('genesis_entry_content', 'genesis_do_post_content');
// remove_action('genesis_entry_content', 'genesis_do_post_image'); // Already done in functions.php
add_action('genesis_entry_footer', 'genesis_do_post_title');
add_action('genesis_entry_footer', 'new_post_info');
add_action('genesis_entry_content', 'do_post_image_placeholder');

/** Move pagination to after the content. */
remove_action('genesis_after_endwhile', 'genesis_posts_nav');
add_action('genesis_after_content', 'genesis_posts_nav');

/**
 * Force full width content layout.
 */
function child_do_layout() {
    $opt = 'full-width-content'; 
    return $opt;
}

/**
 * Set the class of the homepage posts for grid layout.
 */
function home_archive_post_class($classes) {
    $classes[] = 'one-third';
    global $wp_query;
    if (!$wp_query->current_post or !($wp_query->current_post % 3)) {
        $classes[] = 'first';
    }

    return $classes;
}

/**
 * Display a default image if no featured image is set.
 */
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

genesis();

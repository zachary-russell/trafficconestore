<?php
add_filter('genesis_pre_get_option_site_layout', 'child_do_layout');
add_filter('pre_get_posts', 'home_archive_query');
add_filter('post_class', 'home_archive_post_class');

function child_do_layout() {
    $opt = 'full-width-content'; 
    return $opt;
}

function home_archive_query($query) {
    if ($query->is_main_query() && $query->is_archive()) {
        $query->set('posts_per_page', 15);
    }
}

function home_archive_post_class($classes) {
    $classes[] = 'one-third';
    global $wp_query;
    if (!$wp_query->current_post or !($wp_query->current_post % 3)) {
        $classes[] = 'first';
    }

    return $classes;
}

remove_action('genesis_entry_header', 'genesis_do_post_title');
remove_action('genesis_entry_header', 'genesis_post_info');
remove_action('genesis_entry_footer', 'genesis_post_meta');
remove_action('genesis_entry_content', 'genesis_do_post_content');
remove_action('genesis_entry_content', 'genesis_do_post_image');
add_action('genesis_entry_footer', 'genesis_do_post_title');
add_action('genesis_entry_footer', 'new_post_info');
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

genesis();

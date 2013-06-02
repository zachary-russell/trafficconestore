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
    if (!$wp_query->current_post or !$wp_query->current_post % 3) {
        $classes[] = 'first';
    }

    return $classes;
}

genesis();

<?php

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function pagename_class($classes = '') {
    if (is_single()) {
        $classes[] = 'news_detail';
  }
  return $classes;
}
add_filter('body_class', 'pagename_class');


function homename_class($classes_home = '') {
    if (is_front_page()) {
        $classes_home[] = 'news';
  }
  return $classes_home;
}
add_filter('body_class', 'homename_class');

// remove version
remove_action('wp_head','wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// add thumbnails
add_theme_support( 'post-thumbnails' );


// remove autoformat
add_action('init', function() {
remove_filter('the_title', 'wpautop');
remove_filter('the_content', 'wpautop');
remove_filter('the_excerpt', 'wpautop');
remove_filter('the_editor_content', 'wp_richedit_pre');
});

// remove yoast
// add_filter( 'wpseo_canonical', '__return_false' );


//remove width and height
function remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

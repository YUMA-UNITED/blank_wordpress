<?php

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

// remove version
remove_action('wp_head','wp_generator');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

// add thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size('thumbnail',150,150,true);
add_image_size('thumbnail-large',500,500,true);

// remove autoformat
add_action('init', function() {
    remove_filter('the_title', 'wptexturize');
    remove_filter('the_content', 'wptexturize');
    remove_filter('the_excerpt', 'wptexturize');
    remove_filter('the_title', 'wpautop');
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('the_editor_content', 'wp_richedit_pre');
});

add_filter('tiny_mce_before_init', function($init) {
    $init['wpautop'] = false;
    $init['apply_source_formatting'] = ture;
    return $init;
});

function remove_p_on_images($content){
    return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);
}
add_filter('the_content', 'remove_p_on_images');


// remove yoast
add_filter( 'wpseo_canonical', '__return_false' );


//remove width and height for image
function remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );

// remove visual editor
function disable_visual_editor_mypost(){
add_filter('user_can_richedit', 'disable_visual_editor_filter');
}
function disable_visual_editor_filter(){
return false;
}
add_action( 'load-post.php', 'disable_visual_editor_mypost' );
add_action( 'load-post-new.php', 'disable_visual_editor_mypost' );


// REMOVE WP EMOJI
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// delete yet another css
// add_action('wp_print_styles','lm_dequeue_header_styles');
// function lm_dequeue_header_styles(){ wp_dequeue_style('yarppWidgetCss'); }
// add_action('get_footer','lm_dequeue_footer_styles');
// function lm_dequeue_footer_styles(){ wp_dequeue_style('yarppRelatedCss'); }
// add_action('wp_print_styles','lm_dequeue_header_styles1');
// function lm_dequeue_header_styles1(){ wp_dequeue_style('yarpp-thumbnails-yarpp-thumbnail'); }
// add_action('get_footer','lm_dequeue_footer_styles1');
// function lm_dequeue_footer_styles1(){ wp_dequeue_style('yarpp-thumbnails-yarpp-thumbnail'); }


// Article Edit Button
function edit($the_content) {
    if (is_single() && is_user_logged_in()) {
        $return = $the_content;
        $return .= '<a target="_blank" href="'.get_edit_post_link().'" style="display: block;border: 3px solid #000;margin: 20px 0;text-align: center;padding: 10px;letter-spacing: 1px;font-weight: bold;">Edit Article</a>';
        return $return;
    } else {
        return $the_content;
    }
}
add_filter('the_content','edit');


// delete pingback
function no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );


// delete admin bar
add_filter('show_admin_bar','__return_false');

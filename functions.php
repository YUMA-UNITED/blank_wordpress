<?php

// *****************************************
//
// BASIC SETTING
//
// *****************************************

// head情報を削除
remove_action('wp_print_styles','print_emoji_styles'); // remove emoji
remove_action('wp_head','wp_generator');
remove_action('wp_head','rsd_link');
remove_action('wp_head','wlwmanifest_link');
remove_action('wp_head','wp_shortlink_wp_head');
remove_action('wp_head','wp_oembed_add_discovery_links');
remove_action('wp_head','rest_output_link_wp_head');
remove_action('wp_head','wp_site_icon', 99);
remove_action('wp_head','parent_post_rel_link', 10, 0);
remove_action('wp_head','start_post_rel_link', 10, 0);
remove_action('wp_head','adjacent_posts_rel_link_wp_head');
remove_action('wp_head','feed_links_extra', 3);
remove_action('wp_head','wp_oembed_add_host_js');


// add thumbnails
add_theme_support( 'post-thumbnails' );
add_image_size('thumbnail',150,150,true);
add_image_size('thumbnail-large',500,500,true);


// svgファイルをアップロードできるようにする
function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// デフォルトで読み込むjqueryを削除
function remove_jquery_load_google_hosted_jquery() {
  if (!is_admin()) {
    wp_deregister_script('jquery');
    wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js', false, null);
    wp_enqueue_script('jquery');
  }
}
add_action('init', 'remove_jquery_load_google_hosted_jquery');
function mv_to_foot_jquery_scripts() {
  wp_scripts()->add_data('jquery','group',1);
  wp_scripts()->add_data('jquery-core','group',1);
  wp_scripts()->add_data('jquery-migrate','group',1);
}
add_action( 'wp_enqueue_scripts', 'mv_to_foot_jquery_scripts' );
function delete_local_jquery() {};
add_action('wp_enqueue_scripts','delete_local_jquery', 100);


// pingbackを削除
function no_self_ping( &$links ) {
    $home = get_option( 'home' );
    foreach ( $links as $l => $link )
        if ( 0 === strpos( $link, $home ) )
            unset($links[$l]);
}
add_action( 'pre_ping', 'no_self_ping' );


// プレビュー中の管理バーを非表示にする
add_filter('show_admin_bar','__return_false');


// RSSにサムネイル画像を表示
function post_thumbnail_feeds($content) {
    global $post;
    if(has_post_thumbnail($post->ID)) {
        $content = '<image><url>' . get_the_post_thumbnail($post->ID) . '</image></url>' . $content;
    }
    return $content;
}
add_filter('the_excerpt_rss', 'post_thumbnail_feeds');
add_filter('the_content_feed', 'post_thumbnail_feeds');


// if(is_mobile())を使えるようにする
function is_mobile(){
  $useragents = array(
    'iPhone', // iPhone
    'iPod', // iPod touch
    'Android.*Mobile', // 1.5+ Android *** Only mobile
    'Windows.*Phone', // *** Windows Phone
    'dream', // Pre 1.5 Android
    'CUPCAKE', // 1.5+ Android
    'webOS', // Palm Pre Experimental
    'incognito', // Other iPhone browser
    'webmate' // Other iPhone browser
  );
  $pattern = '/'.implode('|', $useragents).'/i';
  return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}


// *****************************************
//
// CONTENTS FORMAT
//
// *****************************************

// サムネイルを追加
add_theme_support( 'post-thumbnails' );
add_image_size('thumbnail',150,150,true);
add_image_size('thumbnail-large',500,500,true);


// 最新の投稿にis-newを付与
function add_new($date,$days){
  $today = date_i18n('U');
  $elapsed = date('U',($today - $date)) / 86400;
  if( $days > $elapsed ){
    echo 'new_icon';
  }
}


// contentのオートフォーマットを削除
remove_filter('the_title', 'wptexturize');
remove_filter('the_content', 'wptexturize');
add_action('init', function() {
  remove_filter('the_title', 'wptexturize');
  remove_filter('the_content', 'wptexturize');
  remove_filter('the_excerpt', 'wptexturize');
  remove_filter('the_title', 'wpautop');
  remove_filter('the_content', 'wpautop');
  remove_filter('the_excerpt', 'wpautop');
  remove_filter('the_editor_content', 'wp_richedit_pre');
});


// 画像に自動付与されるwidthをheightを削除
function remove_width_attribute( $html ) {
    $html = preg_replace( '/(width|height)="\d*"\s/', "", $html );
    return $html;
}
add_filter( 'post_thumbnail_html', 'remove_width_attribute', 10 );
add_filter( 'image_send_to_editor', 'remove_width_attribute', 10 );


// 絵文字を削除する
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );


// imgタグに付与されるpタグを削除
function remove_p_on_images($content){
    return preg_replace('/<p>(\s*)(<img .* \/>)(\s*)<\/p>/iU', '\2', $content);
}
add_filter('the_content', 'remove_p_on_images');


// contentsに挿入されるobjectとiframeにdivを付与
function wrap_div( $content ) {

  $content = preg_replace( "/<object/Si", '<div><object', $content );
  $content = preg_replace( "/<\/object>/Si", '</object></div>', $content );

  // Added iframe filtering, iframes are bad.
  $content = preg_replace( "/<iframe.+?src=\"(.+?)\"/Si", '<div><iframe src="\1" frameborder="0" allowfullscreen>', $content );
  $content = preg_replace( "/<\/iframe>/Si", '</iframe></div>', $content );
  return $content;
}
add_filter( 'the_content', 'wrap_div' );


// contentsに挿入されるpタグにdivを付与
function wrap_div_p($content) {
    $pattern = '~<p.*?</p>~';
    return preg_replace_callback($pattern, function($matches) {
        return '<div class="p-article-body__text">' . $matches[0] . '</div>';
    }, $content);
}
add_filter('the_content', 'wrap_div_p');

// contentsに挿入されるh2タグにdivを付与
function wrap_div_h2($content) {
    $pattern = '~<h2.*?</h2>~';
    return preg_replace_callback($pattern, function($matches) {
        return '<div class="p-article-body__heading">' . $matches[0] . '</div>';
    }, $content);
}
add_filter('the_content', 'wrap_div_h2');

// contentsに挿入されるcaptionタグにdivを付与
function wrap_div_caption($content) {
    $pattern = '~wp-caption.*?~';
    return preg_replace_callback($pattern, function($matches) {
        return 'aaaa' . $matches[0] . 'dddd';
    }, $content);
}
add_filter('the_content', 'wrap_div_caption');




// *****************************************
//
// PLUGIN SETTING
//
// *****************************************

// YOAST SEOがcanonicalを読み込むのを削除
// add_filter( 'wpseo_canonical', '__return_false' );


// プラグインのCSSを削除
add_action('wp_enqueue_scripts','my_delete_plugin_styles');
function my_delete_plugin_styles(){
  wp_deregister_style('wp-pagenavi');
  wp_deregister_style('yarppWidgetCss');
  wp_deregister_style('wordfenceAJAXcss');
}


// yet another related postsが読み込むcssを削除
add_action('wp_print_styles','lm_dequeue_header_styles');
function lm_dequeue_header_styles(){ wp_dequeue_style('yarppWidgetCss'); }
add_action('get_footer','lm_dequeue_footer_styles');
function lm_dequeue_footer_styles(){ wp_dequeue_style('yarppRelatedCss'); }
add_action('wp_print_styles','lm_dequeue_header_styles1');
function lm_dequeue_header_styles1(){ wp_dequeue_style('yarpp-thumbnails-yarpp-thumbnail'); }
add_action('get_footer','lm_dequeue_footer_styles1');
function lm_dequeue_footer_styles1(){ wp_dequeue_style('yarpp-thumbnails-yarpp-thumbnail'); }


// ACF Optionsの設定
if( function_exists('acf_add_options_page') ) {

  acf_add_options_page();
  acf_add_options_sub_page( 'オプション設定' );

  acf_add_options_page(array(
    'page_title'  => 'Theme General Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'オプション設定',
    'menu_title'  => 'Option',
    'parent_slug' => 'theme-general-settings',
  ));

}
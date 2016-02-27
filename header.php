<!DOCTYPE html <?php language_attributes(); ?>>
<html lang="jp">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
  <meta name="robots" content="index,follow,noarchive">
  <meta name="googlebot" content="index,follow,noarchive">

  <link rel="apple-touch-icon-precomposed" href="<?php bloginfo('url'); ?>/assets/images/favicon/webclip.png">
  <meta name="msapplication-TileImage" content="<?php bloginfo('url'); ?>/assets/images/favicon/webclip.png">
  <link rel="icon" href="<?php bloginfo('url'); ?>/assets/images/favicon/favicon.ico" sizes="32x32">
  <meta name="msapplication-TileColor" content="#ef9fc2">
  <meta name="theme-color" content="#ef9fc2">

  <link rel="stylesheet" href="<?php bloginfo('url'); ?>/assets/stylesheets/application.css">

  <?php wp_head(); ?>

  <?php if ( is_single() ) : ?>
    <script type="application/ld+json">
    <?php
    $image_id = get_post_thumbnail_id();
    $image_url = wp_get_attachment_image_src($image_id, 'thumbs');
    ?>
    {
        "@context": "http://schema.org",
        "@type": "NewsArticle",
        "url": "<?php the_permalink(); ?>",
        "mainEntityOfPage":{
            "@type":"WebPage",
            "@id":"<?php the_permalink(); ?>"
        },
        "headline": "<?php wp_title(); ?> ",
        "name": "<?php wp_title(); ?> ",
        "description": "<?php the_field('subtitle'); ?>",
        "alternateName": "<?php the_field('subtitle'); ?>",
        "ArticleSection": "Fashion",
        "image": {
            "@type": "ImageObject",
            "url": "<?php echo $image_url[0]; ?>",
            "height": "<?php echo $image_url[2]; ?>",
            "width": "<?php echo $image_url[1]; ?>" // under 696px
        },
        "datePublished": "<?php echo get_the_date('c'); ?>",
        "dateModified": "<?php echo get_the_modified_date('c'); ?>",
        "author": {
            "@type": "Person",
            "name": "<?php the_author(); ?>"
        },
        "publisher": {
            "@type": "Organization",
            "name": "<?php bloginfo('name'); ?>",
            "logo": {
                "@type": "ImageObject",
                "url": "<?php bloginfo('url'); ?>/assets/images/favicon/webclip.png",
                "width": 60, // under 600px
                "height": 60 //under 60px
            }
        }
    }
    </script>
  <?php endif; ?>

<body>

  <!--
    Category Link
    <?php echo get_category_link( '1' ); ?>
    <?php echo get_category_link( $category_id ); ?>

    Thumbnails
    <?php the_post_thumbnail('thumbnail'); ?>

    ACF
    <?php the_field('subtitle'); ?>

    Author Name
    <?php the_author_posts_link(); ?>

    Author Image form ACF
    <?php $author_id = get_the_author_meta( 'ID' ); ?>
    URL : <?php echo get_author_posts_url( $author_id ); ?>
    Image : <?php the_field('author-image', 'user_'. $author_id ); ?>

    Get Category List
    <?php echo get_the_category_list( ' ,' ); ?>

    Social Buttons
    <div class="l-share-area">
      <?php
        $url_encode=urlencode(get_permalink());
        $title=strip_tags(get_the_title());
        $subtitle=strip_tags(get_field('subtitle'));
        $twitter_text=mb_substr($subtitle.' '.$title,0,87);
      ?>
      <h3 class="small-headline">Share of This page!!</h3>
      <div class="l-sns-share-area">
        <a href="http://www.facebook.com/share.php?u=<?php echo $url_encode; ?>" onclick="window.open(this.href, 'FBwindow', 'width=650, height=450, menubar=no, toolbar=no, scrollbars=yes'); return false;" target="_blank" class="p-share-button facebook-share">
          Share
        </a>
        <a href="http://twitter.com/share?url=<?php echo $url_encode; ?>&amp;text=<?php echo $twitter_text; ?>" target="_blank" class="p-share-button twitter-share">
          Tweet
        </a>
      </div>
    </div>

    Related Article by Yet Another
    <?php related_posts(); ?>

  -->
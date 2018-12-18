<!DOCTYPE html <?php language_attributes(); ?>>
<html lang="jp">
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

  <link rel="apple-touch-icon-precomposed" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/webclip.png">
  <meta name="msapplication-TileImage" content="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/webclip.png">
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon/favicon.ico" sizes="32x32">
  <meta name="msapplication-TileColor" content="#ef9fc2">
  <meta name="theme-color" content="#ef9fc2">

  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/stylesheets/application.css">

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
        "description": "<?php the_content(); ?>",
        "alternateName": "<?php the_content(); ?>",
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

</head>

<body>
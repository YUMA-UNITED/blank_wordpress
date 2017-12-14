<?php get_header(); ?>
  <div>

      <?php if ( have_posts()): ?>

        <?php while ( have_posts() ) : the_post(); ?>

          <article class="post">

            <h1><?php the_title(); ?></h1>
              <?php the_content(); ?>
              <?php wp_link_pages(); ?>

          </article>

        <?php endwhile; ?>

      <?php else: ?>

        <article>
          <h1>Nothing posted yet</h1>
        </article>

      <?php endif; ?>


  </div>
<?php get_footer(); ?>
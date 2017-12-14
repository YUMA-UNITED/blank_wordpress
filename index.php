<?php get_header(); ?>


      <?php if ( have_posts()): ?>
        <?php while ( have_posts() ) : the_post(); ?>

          <article class="post">

            <h1>
              <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php the_title(); ?>
              </a>
            </h1>
            <div>
              <?php the_time('m/d/Y'); ?>
            </div>

            <div class="the-content">
              <?php the_content(); ?>

              <?php wp_link_pages(); ?>
            </div>

            <div class="meta clearfix">
              <div class="category"><?php echo get_the_category_list(); ?></div>
              <div class="tags"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
            </div>

          </article>

        <?php endwhile; ?>

      <?php else: ?>

        <article class="post error">
          <h1>Nothing has been posted like that yet</h1>
        </article>

      <?php endif; ?>

<?php get_footer(); ?>
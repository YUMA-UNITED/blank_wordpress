<?php get_header(); ?>

			<?php if(have_posts()):while(have_posts()):the_post(); ?>

					<article class="post">

						<h1 class="title">
							<?php the_title(); ?></h1>
						<div class="post-meta">
							<?php the_time('m.d.Y'); ?>
						</div>

						<div class="the-content">
							<?php the_content();?>
							<?php wp_link_pages(); ?>
						</div>

						<div class="meta clearfix">
							<div class="category"><?php echo get_the_category_list(); ?></div>
							<div class="tags"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
						</div>

					</article>

				<?php endwhile; ?>

			<?php else : ?>

				<article class="post error">
					<h1 class="404">Nothing has been posted like that yet</h1>
				</article>

			<?php endif; ?>

<?php get_footer(); ?>

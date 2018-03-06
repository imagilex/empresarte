<?php get_header(); ?>

<main id="static-page" class="content fullwidth-layout">

	<?php if( have_posts() ): ?>

		<?php while( have_posts() ): the_post(); ?>

			<article class="post">
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- #entry-content -->

			</article>

		<?php endwhile; ?>

	<?php endif; ?>

</main><!-- #static-page -->

<?php get_footer(); ?>
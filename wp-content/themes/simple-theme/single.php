<?php get_header(); ?>

<main id="single-page" class="content col-layout">

	<?php if( have_posts() ): ?>

		<?php while( have_posts() ): the_post(); ?>

			<article class="post">
				<header class="entry-header">
					<h2><?php the_title(); ?></h2>
				</header>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- #entry-content -->

				<footer class="entry-meta">
					<p>Por <?php the_author(); ?></p>
					<p><?php the_date(); ?></p>
				</footer>

			</article>

		<?php endwhile; ?>

	<?php endif; ?>

</main><!-- #single-page -->

<?php get_sidebar( 'Sidebar principal' ); ?>

<?php get_footer() ?>
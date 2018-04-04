<?php get_header(); ?>

<main id="post-page" class="content col-layout">

	<?php if( have_posts() ): ?>

		<?php while( have_posts() ): the_post(); ?>

			<article class="post">
				<header class="entry-header">
					<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				</header>
				<div class="entry-excerpt">
					<?php the_excerpt(); ?>
				</div><!-- #entry-excerpt -->
			</article>

		<?php endwhile; ?>

		<?php if ( get_previous_posts_link() || get_next_posts_link() ): ?>
			<div class="navigation">
				<div class="previous">
					<?php previous_posts_link( __( '&laquo; Anterior', 'simple-theme' ) ) ?>
				</div>
				<div class="next">
					<?php next_posts_link( __( 'Siguiente &raquo;', 'simple-theme' ) ) ?>
				</div>
			</div><!-- .navigation -->
		<?php endif ?>

	<?php endif; ?>

</main><!-- #post-page -->

<?php get_sidebar( 'Sidebar principal' ); ?>

<?php get_footer(); ?>
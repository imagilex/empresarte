<?php get_header(); ?>

<main id="post-page" class="content col-layout">

	<?php if( have_posts() ): ?>

		<?php while( have_posts() ): the_post(); 
			$metas = new MyMetas( get_the_ID() );
			$prefijo = $wpdb->prefix;
			?>

			<article class="post">
				<header class="entry-header">
					<?php if ( '' != $metas->getMeta( 'proyecto') ): ?>
						<?php
						$proyecto = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid from {$prefijo}posts where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'proyecto' and  meta_key = 'guid' and meta_value = %s )", $metas->getMeta( 'proyecto' ) ) );
						if( count( $proyecto ) > 0 ) : 
							$metasProy = new MyMetas( $proyecto[ 0 ]->id ); ?>
							<a href="<?php 
								bloginfo( 'url' );
								echo '/?p=' . $proyecto[ 0 ]->id;
								?>" title="<?php echo $proyecto[ 0 ]->post_title; ?>" class="tag-title alignright">
								<?php echo $metasProy->getMeta( 'abreviatura' ); ?>
							</a>
						<?php endif ?>
					<?php endif ?>
					<h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2>
				</header>
				<div class="entry-excerpt-scrum">
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
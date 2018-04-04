<?php 
if( ! is_user_logged_in() ) {
	auth_redirect();
}
get_header(); ?>

<main id="single-page" class="content col-layout">

	<?php if( have_posts() ): ?>

		<?php while( have_posts() ): the_post(); ?>
			<?php 
			$metas = new MyMetas( get_the_ID() ); 
			$clase_snowflake = ( $metas->getMeta( 'activo' ) == 'true' ? 'enabled' : 'disabled' );
			?>

			<article class="post">
				<header class="entry-header">
					<h2>
						<?php if ( '' != $metas->getMeta( 'urltrello' ) ): ?>
							<a href="<?php echo $metas->getMeta( 'urltrello' ); ?>" target="_blank" title="Ver Tablero en Trello" class="alignright"><i class="fab fa-trello"></i></a>
						<?php endif ?>
						<i class="fas fa-snowflake <?php echo $clase_snowflake; ?>"></i>
						<?php if ( '' != $metas->getMeta( 'abreviatura' ) ): ?>
							<?php echo $metas->getMeta( 'abreviatura' ); ?> - 
						<?php endif ?>
						<?php the_title(); ?>
						<?php if ( '' != $metas->getMeta( 'empresa' ) ): ?>
							(<?php echo $metas->getMeta( 'empresa' ); ?>)
						<?php endif ?>
					</h2>
				</header>
				<div class="entry-content">
					
					<?php the_content(); ?>

					<?php
					$current_post = $post;
					$current_wp_query = $wp_query;
					$args = array(
						'post_type'		=> 'epica',
						'post_status'	=> 'publish',
						'nopaging'		=> true,
						'meta_query'	=> array(
											array( 
												'key'	=>	'proyecto',
												'value'	=>	$metas->getMeta( 'guid' )
												)
											),
						'order'			=> 'ASC',
						'orderby'		=> 'meta_value_num',
						'meta_key'		=> 'numero'
					);
					$epicas = new WP_Query( $args );
					if ( $epicas->have_posts() ) {
						?>
						<nav id="proyecto-epicas">
							<h3>Épicas del Proyecto</h3>
							<?php while( $epicas->have_posts() ): 
								$epicas->the_post();
								$metas_epica = new MyMetas( get_the_ID() );
								?>
								<section class="proyecto-epica">
									<h4>
										<a href="<?php the_permalink(); ?>">
											<?php if ( '' != $metas_epica->getMeta( 'numero' ) ): ?>
												<?php echo $metas_epica->getMeta( 'numero' ); ?>. 
											<?php endif ?>
											<?php if ( '' != $metas_epica->getMeta( 'abreviatura' ) ): ?>
												<?php echo $metas_epica->getMeta( 'abreviatura' ); ?> - 
											<?php endif ?>
											<?php the_title(); ?>		
										</a>
									</h4>
									<?php the_excerpt(); ?>
									<p><a class="read-more-btn" href="<?php the_permalink(); ?>">Leer Más</a></p>
								</section>
							<?php endwhile; ?>
						</nav>
						<?php
					}
					wp_reset_postdata();
					$post = $current_post;
					$wp_query = $current_wp_query;
					?>

				</div><!-- #entry-content -->

			</article>

		<?php endwhile; ?>

	<?php endif; ?>

</main><!-- #single-page -->

<?php get_sidebar( 'Sidebar principal' ); ?>

<?php get_footer() ?>
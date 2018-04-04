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
			$prefijo = $wpdb->prefix;
			?>

			<article class="post">
				<header class="entry-header">
					<h2>
						<?php if ( '' != $metas->getMeta( 'numero' ) ): ?>
							<?php echo $metas->getMeta( 'numero' ); ?>. 
						<?php endif ?>
						<?php if ( '' != $metas->getMeta( 'abreviatura' ) ): ?>
							<?php echo $metas->getMeta( 'abreviatura' ); ?> - 
						<?php endif ?>
						<?php the_title(); ?>		
					</h2>
					<?php if ( '' != $metas->getMeta( 'proyecto') ): ?>
						<?php
						$proyecto = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid from {$prefijo}posts where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'proyecto' and  meta_key = 'guid' and meta_value = %s )", $metas->getMeta( 'proyecto' ) ) );
						if( count( $proyecto ) > 0 ) : 
							$metasProy = new MyMetas( $proyecto[ 0 ]->id ); ?>
							<p>
								<small class="disabled">
									<i class="fas fa-chevron-right"></i> 
									<a href="<?php 
									bloginfo( 'url' );
									echo '/?p=' . $proyecto[ 0 ]->id;
									?>">
										<?php echo $proyecto[ 0 ]->post_title; ?>
									</a>
								</small>
							</p>
						<?php endif ?>
					<?php endif ?>
				</header>
				<div class="entry-content">

					<?php the_content(); ?>

					<?php
					$current_post = $post;
					$current_wp_query = $wp_query;
					$args = array(
						'post_type'		=> 'tarea',
						'post_statuts'	=> 'publish',
						'nopaging'		=> true,
						'meta_query'	=> array(
											array(
												'key'	=> 'epica',
												'value'	=> $metas->getMeta( 'guid' )
											),
						'order'			=> 'ASC',
						'orderby'		=> 'meta_value_num',
						'meta_key'		=> 'numero'
						)
					);
					$tareas = new WP_Query( $args );
					if( $tareas->have_posts() ) {
						?>
						<nav id="epicas-tareas">
							<h3>Tareas de la Épica</h3>
							<ul>
								<?php while( $tareas->have_posts() ):
									$tareas->the_post();
									$metas_tarea = new MyMetas( get_the_ID() );
								?>
								<li>
									<a href="<?php the_permalink(); ?>">
										<?php
										switch ( $metas_tarea->getMeta( 'tipo' ) ) {
											case 'cambio':
												?><span title="Cambio" class="tag-btn tag-cambio"><i class="far fa-circle"></i></span><?php
												break;
											case 'configuracion':
												?><span title="Configuración" class="tag-btn tag-configuracion"><i class="fas fa-sliders-h"></i></span><?php
												break;
											case 'error':
												?><span title="Error" class="tag-btn tag-error"><i class="fas fa-circle"></i></span><?php
												break;
											case 'historia':
												?><span title="Historia" class="tag-btn tag-historia"><i class="fas fa-bookmark"></i></span><?php
												break;
											case 'mejora':
												?><span title="Mejora" class="tag-btn tag-mejora"><i class="fas fa-arrow-up"></i></span><?php
												break;
											case 'tarea':
												?><span title="Tarea" class="tag-btn tag-tarea"><i class="fab fa-audible"></i></span><?php
												break;
										}
										switch ( $metas_tarea->getMeta( 'prioridad' ) ) {
											case 'bloqueadora':
												?><span title="Bloqueadora" class="tag-btn tag-bloqueadora"><i class="fas fa-ban"></i></span><?php
												break;
											case 'critica':
												?><span title="Crítica" class="tag-btn tag-critica"><i class="fas fa-long-arrow-alt-up"></i></span><?php
												break;
											case 'mayor':
												?><span title="Mayor" class="tag-btn tag-mayor"><i class="fas fa-angle-double-up"></i></span><?php
												break;
											case 'menor':
												?><span title="Menor" class="tag-btn tag-menor"><i class="fas fa-angle-double-down"></i></span><?php
												break;
											case 'trivial':
												?><span title="Trivial" class="tag-btn tag-trivial"><i class="fas fa-long-arrow-alt-down"></i></span><?php
												break;
										}
										?>
										<?php if ( '' != $metasProy->getMeta( 'abreviatura' ) ): ?>
											<?php echo $metasProy->getMeta( 'abreviatura' ) . $metas_tarea->getMeta( 'numero' ) . ". "; ?>
										<?php endif ?>
										<?php the_title(); ?>			
									</a>
								</li>
								<?php endwhile; ?>
							</ul>
						</nav>
						<?php
					}

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
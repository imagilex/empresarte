<?php get_header(); ?>

<main id="post-page" class="content col-layout">

	<?php if( have_posts() ): ?>

		<?php while( have_posts() ): the_post(); 
			$metas = new MyMetas( get_the_ID() );
			$prefijo = $wpdb->prefix;
			$proyecto_abreviatura = '';
			$proyecto_id = '';
			$proyecto_name = '';
			$epica_id = '';
			$epica_name = '';
			$epica_abreviatura = '';
			$epica = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid, meta_value as 'proyecto' from {$prefijo}posts p inner join {$prefijo}postmeta pm on pm.post_id = p.id and pm.meta_key = 'proyecto' where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'epica' and  meta_key = 'guid' and meta_value = %s )", $metas->getMeta( 'epica' ) ) );
			if( count( $epica ) > 0 ) {
				$epica = $epica[ 0 ];
				$epica_id = $epica->id;
				$epica_name = $epica->post_title;
				$metasEpica = new MyMetas( $epica->id );
				$epica_abreviatura = $metasEpica->getMeta( 'abreviatura' );
				$proyecto = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid from {$prefijo}posts where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'proyecto' and  meta_key = 'guid' and meta_value = %s )", $epica->proyecto ) );
				if( count( $proyecto ) > 0 ) {
					$proyecto = $proyecto[ 0 ];
					$metasProy = new MyMetas( $proyecto->id );
					$proyecto_abreviatura = $metasProy->getMeta( 'abreviatura' );
					$proyecto_id = $proyecto->id;
					$proyecto_name = $proyecto->post_title;
				}
			}
			?>

			<article class="post">
				<header class="entry-header">
					<a href="<?php
						bloginfo( 'url' );
						echo '/?p=' . $epica_id;
						?>" title="Épica: <?php echo $epica_name; ?>" class="tag-title alignright">
						<?php echo $epica_abreviatura; ?>
					</a>
					<a href="<?php
						bloginfo( 'url' );
						echo '/?p=' . $proyecto_id;
						?>" title="Proyecto: <?php echo $proyecto_name; ?>" class="tag-title alignright">
						<?php echo $proyecto_abreviatura; ?>
					</a>
					<h2>
						<?php
						switch ( $metas->getMeta( 'tipo' ) ) {
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
						switch ( $metas->getMeta( 'prioridad' ) ) {
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
						<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
					</h2>
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
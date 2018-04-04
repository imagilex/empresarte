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
			$proyecto_abreviatura = '';
			$proyecto_numero = '';
			$proyecto_id = '';
			$proyecto_name = '';
			$epica_id = '';
			$epica_name = '';
			$epica = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid, meta_value as 'proyecto' from {$prefijo}posts p inner join {$prefijo}postmeta pm on pm.post_id = p.id and pm.meta_key = 'proyecto' where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'epica' and  meta_key = 'guid' and meta_value = %s )", $metas->getMeta( 'epica' ) ) );
			if( count( $epica ) > 0 ) {
				$epica = $epica[ 0 ];
				$epica_id = $epica->id;
				$epica_name = $epica->post_title;
				$proyecto = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid from {$prefijo}posts where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'proyecto' and  meta_key = 'guid' and meta_value = %s )", $epica->proyecto ) );
				if( count( $proyecto ) > 0 ) {
					$proyecto = $proyecto[ 0 ];
					$metasProy = new MyMetas( $proyecto->id );
					$proyecto_abreviatura = $metasProy->getMeta( 'abreviatura' );
					$proyecto_numero = $metasProy->getMeta( 'numero' );
					$proyecto_id = $proyecto->id;
					$proyecto_name = $proyecto->post_title;
				}
			}
			
			?>

			<article class="post">
				<header class="entry-header">
					<?php if ( '' != $metas->getMeta( 'idtrello' ) ): ?>
						<a href="https://trello.com/c/<?php echo $metas->getMeta( 'idtrello' ); ?>" target="_blank" title="Ver Tarjeta en Trello" class="alignright"><i class="fab fa-trello"></i></a>
					<?php endif;?>
					<?php if ( 'true' == $metas->getMeta( 'cambiosdb' ) ): ?>
						<a href="" title="Requiere cambios en Base de Datos" class="alignright"><i class="fas fa-database"></i></a>
					<?php endif ?>
					<a href="" class="alignright">
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
					</a>
					<h2>
						<?php if ( '' != $proyecto_abreviatura ): ?>
							<?php echo "$proyecto_abreviatura{$metas->getMeta( 'numero' )}. "; ?>
						<?php endif ?>
						<?php the_title(); ?>
						<small class="disabled">(<?php echo $metas->getMeta( 'puntos' ) . ( 'sin puntuación' != $metas->getMeta( 'puntos' ) ? ' puntos' : '' ); ?>)</small>
					</h2>
					<?php if ( '' != $metas->getMeta( 'epica' ) ): ?>
						<p>
							<small class="disabled">
								<i class="fas fa-chevron-right"></i>
								<a href="<?php
								bloginfo( 'url' );
								echo '/?p=' . $proyecto_id;
								?>">
									<?php echo $proyecto_name; ?>
								</a>
								<i class="fas fa-chevron-right"></i>
								<a href="<?php
								bloginfo( 'url' );
								echo '/?p=' . $epica_id;
								?>">
									<?php echo $epica_name; ?>
								</a>
							</small>
						</p>
					<?php endif ?>
				</header>

				<div class="entry-content">
					<div id="dataTask">
						<p>Informador: <?php the_author(); ?></p>
						<p>Responsable: </p>
						<p>Fecha de Creación: <?php the_date(); ?></p>
					</div>
					<?php the_content(); ?>
				</div><!-- #entry-content -->

				<?php
				if ( comments_open() || get_comments_number() ) {
					comments_template();
				}
				?>

			</article>

		<?php endwhile; ?>

	<?php endif; ?>

</main><!-- #single-page -->

<?php get_sidebar( 'Sidebar principal' ); ?>

<?php get_footer() ?>
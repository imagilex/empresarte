<?php

add_action( 'init', 'IMGX_Register_SCEpica' );
add_action( 'add_meta_boxes', 'IMGX_SCEpica_MetaBox' );
add_action( 'save_post', 'IMGX_SCEpica_Save' );
add_filter( 'manage_epica_posts_columns', 'Epica_AddAdminColumnList_head');
add_action( 'manage_epica_posts_custom_column', 'Epica_AddAdminColumnList_content', 10, 2);
add_action( 'restrict_manage_posts', 'Epica_FiltroControl' );
add_filter( 'parse_query', 'Epica_Filtro' );

function IMGX_Register_SCEpica() {
	register_post_type( "epica", array(
		'labels' 		=> array(
							"name" 					=> "SCRUM Épica",
							"singularname" 			=> "Épica",
							"add_new" 				=> "Nueva",
							"add_new_item" 			=> "Nueva Épica",
							"edit_item" 			=> "Editar Épica",
							"new_item" 				=> "Nueva Épica",
							"view_item" 			=> "Ver Épica",
							"view_items" 			=> "Ver Épicas",
							"search_item" 			=> "Buscar Épica",
							"not_found" 			=> "Sin Épicas para Mostrar",
							"not_found_in_trash" 	=> "Épica No Encontrada en Papelera",
							"all_items"				=> "Todas los Épicas"
						),
		'public' 		=> true,
		'has_archive'	=> true,
		'menu_icon'		=> get_stylesheet_directory_uri() . "/assets/task_list.png",
		'menu_position'	=> 20,
		'hierarchical'	=> true,
		'supports'		=> array( 'title', 'editor' ),
		'description'	=> 'Épicas a manejar con SCRUM',
		'show_in_menu'	=> true,
		'show_ui'		=> true,
	) );
}

function IMGX_SCEpica_MetaBox() {
	add_meta_box( 'scepica_metabox', 'Información de la Épica', 'IMGX_SCEpica_MetaBox_Callback', 'epica' );
}

function IMGX_SCEpica_MetaBox_Callback( $post ) {
	global $wpdb;
	$metas = new MyMetas( $post->ID );
	$prefijo = $wpdb->prefix;
	$proyectos = $wpdb->get_results( $wpdb->prepare( "select p.id, p.post_title, p.post_name, pg.meta_value as 'guid', pa.meta_value as 'abreviatura' from {$prefijo}posts p inner join {$prefijo}postmeta pg on p.id = pg.post_id inner join {$prefijo}postmeta pa on p.id = pa.post_id where p.post_type = %s and p.post_status = 'publish' and pg.meta_key = 'guid' and pa.meta_key = 'abreviatura' order by pa.meta_value, p.post_title;", 'proyecto' ) );
	?>
	<input type="hidden" name="guid" id="guid" value="<?php echo esc_attr( $metas->getMeta( 'guid' ) ); ?>" />
	<input type="hidden" name="save_custom_fields" id="save_custom_fields" value="true" />
	<div class="custom-meta-box">
		<table>
			<tbody>
				<tr>
					<td class="label">No. Épica</td>
					<td class="control">
						<input type="number" name="numero" id="numero" value="<?php echo esc_attr( $metas->getMeta( 'numero' ) ); ?>" min="0" />
					</td>
				</tr>
				<tr>
					<td class="label">Abreviatura</td>
					<td class="control">
						<input type="text" name="abreviatura" id="abreviatura" value="<?php echo esc_attr( $metas->getMeta( 'abreviatura' ) ); ?>" />
					</td>
				</tr>
				<tr>
					<td class="label">Proyecto</td>
					<td class="control">
						<select name="proyecto" id="proyecto">
							<?php foreach ( $proyectos as $p ): ?>
								<option value="<?php echo esc_attr( $p->guid ); ?>"  <?php echo ( $p->guid == $metas->getMeta( 'proyecto' ) ? 'selected="selected"' : '' ); ?> ><?php echo ( '' != $p->abreviatura ? $p->abreviatura . ' - ' : '' ) . $p->post_title; ?></option>
							<?php endforeach ?>
						</select>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

function IMGX_SCEpica_Save( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if( ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	if( "epica" !== get_post_type( $post_id ) ) {
		return;
	}
	if( isset( $_POST[ "save_custom_fields" ] ) && 'true' == $_POST[ "save_custom_fields" ] ) {
		update_post_meta( $post_id, 'guid', esc_attr( isset( $_POST[ 'guid' ] ) && '' != $_POST[ 'guid' ] ? $_POST[ 'guid' ] : CreateGUID() ) );
		update_post_meta( $post_id, 'numero', esc_attr( isset( $_POST[ 'numero' ] ) && '' != $_POST[ 'numero' ] ? $_POST[ 'numero' ] : '' ) );
		update_post_meta( $post_id, 'abreviatura', esc_attr( isset( $_POST[ 'abreviatura' ] ) && '' != $_POST[ 'abreviatura' ] ? $_POST[ 'abreviatura' ] : '' ) );
		update_post_meta( $post_id, 'proyecto', esc_attr( isset( $_POST[ 'proyecto' ] ) && '' != $_POST[ 'proyecto' ] ? $_POST[ 'proyecto' ] : '' ) );
	}
}

function Epica_AddAdminColumnList_head( $defaults ) {
	$defaults[ "epica_proyecto" ] = "Proyecto";
	return $defaults;
}

function Epica_AddAdminColumnList_content( $columna, $post_id ) {
	global $wpdb;
	$prefijo = $wpdb->prefix;
	$metas = new MyMetas( $post_id );
	if( "epica_proyecto" == $columna ) {
		$proyecto = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid from {$prefijo}posts where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'proyecto' and  meta_key = 'guid' and meta_value = %s )", $metas->getMeta( 'proyecto' ) ) );
		$proyecto_name = "";
		if( count( $proyecto ) > 0 ) {
			$proyecto_name = $proyecto[ 0 ]->post_title;
		}
		echo $proyecto_name;
	}
}

function Epica_FiltroControl() {
	global $wpdb;
	$prefijo = $wpdb->prefix;
	if( 'epica' == ( isset( $_GET[ "post_type" ] ) ? $_GET[ "post_type" ] : "post" ) ) {
		$data = $wpdb->get_results( $wpdb->prepare( "select p.id, p.post_title, p.post_name, pg.meta_value as 'guid' from {$prefijo}posts p inner join {$prefijo}postmeta pg on p.id = pg.post_id where p.post_type = %s and p.post_status = 'publish' and pg.meta_key = 'guid' order by p.post_title;", 'proyecto' ) );
		$current = ( isset( $_GET[ "proyecto_post_filtro" ] ) ? $_GET[ "proyecto_post_filtro" ] : '' );
		?>
		<select name="proyecto_post_filtro" id="proyecto_post_filtro" title="Proyectos">
			<option value="">Todos los Proyectos</option>
			<?php foreach ( $data as $opt ) : ?>
				<option value="<?php echo $opt->guid; ?>" <?php echo ( $opt->guid == $current ? 'selected="selected"' : '' ); ?>><?php echo $opt->post_title; ?></option>
			<?php endforeach; ?>
		</select>
		<?php
	}
}

function Epica_Filtro( $query ) {
	global $pagenow;
	if( 'epica' == ( isset( $_GET[ "post_type" ] ) ? $_GET[ "post_type" ] : "post" ) && is_admin() && $pagenow =='edit.php' && isset( $_GET[ 'proyecto_post_filtro' ] ) && $_GET[ 'proyecto_post_filtro' ] != '' ) {
		$query->query_vars['meta_key'] = 'proyecto';
        $query->query_vars['meta_value'] = $_GET['proyecto_post_filtro'];
	}
}

?>
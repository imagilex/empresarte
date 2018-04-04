<?php

add_action( 'init', 'IMGX_Register_SCTarea' );
add_action( 'add_meta_boxes', 'IMGX_SCTarea_MetaBox' );
add_action( 'save_post', 'IMGX_SCTarea_Save' );
add_filter( 'manage_tarea_posts_columns', 'Tarea_AddAdminColumnList_head');
add_action( 'manage_tarea_posts_custom_column', 'Tarea_AddAdminColumnList_content', 10, 2);
add_action( 'restrict_manage_posts', 'Tarea_FiltroControl' );
add_filter( 'parse_query', 'Tarea_Filtro' );

function IMGX_Register_SCTarea() {
	register_taxonomy( "Tipo_tarea", "tarea", array(
		"label"			=> "Tipo_tarea",
		"public"		=> true,
		"hierarchical"	=> true
	) );
	register_post_type( "tarea", array(
		'labels' 		=> array(
							"name" 					=> "SCRUM Tarea",
							"singularname" 			=> "Tarea",
							"add_new" 				=> "Nueva Tarea",
							"add_new_item" 			=> "Nueva Tarea",
							"edit_item" 			=> "Editar Tarea",
							"new_item" 				=> "Nueva Tarea",
							"view_item" 			=> "Ver Tarea",
							"view_items" 			=> "Ver Tareas",
							"search_item" 			=> "Buscar Tareas",
							"not_found" 			=> "Sin Tareas para Mostrar",
							"not_found_in_trash" 	=> "Tarea No Encontrada en Papelera",
							"all_items"				=> "Todas las Tareas"
						),
		'public' 		=> true,
		'has_archive'	=> true,
		'menu_icon'		=> get_stylesheet_directory_uri() . "/assets/task.png",
		'menu_position'	=> 20,
		'hierarchical'	=> true,
		'supports'		=> array( 'title', 'comments', 'author', 'editor' ),
		'description'	=> 'Tareas a manejar con SCRUM',
		'show_in_menu'	=> true,
		'show_ui'		=> true,
	) );
}

function IMGX_SCTarea_MetaBox() {
	add_meta_box( 'sctarea_metabox', 'Información de la Tarea', 'IMGX_SCTarea_MetaBox_Callback', 'tarea' );
}

function IMGX_SCTarea_MetaBox_Callback( $post ) {
	global $wpdb;
	$metas = new MyMetas( $post->ID );
	$prefijo = $wpdb->prefix;
	$proyectos = $wpdb->get_results( $wpdb->prepare( "select p.id, p.post_title, p.post_name, pg.meta_value as 'guid', pa.meta_value as 'abreviatura' from {$prefijo}posts p inner join {$prefijo}postmeta pg on p.id = pg.post_id inner join {$prefijo}postmeta pa on p.id = pa.post_id where p.post_type = %s and p.post_status = 'publish' and pg.meta_key = 'guid' and pa.meta_key = 'abreviatura' order by pa.meta_value, p.post_title;", 'proyecto' ) );
	foreach ($proyectos as $key => $proy) {
		$proyectos[ $key ]->epicas = $wpdb->get_results( $wpdb->prepare( "select p.id, p.post_title, p.post_name, pg.meta_value as 'guid', pa.meta_value as 'abreviatura', pn.meta_value as 'numero', pp.meta_value as 'proyecto' from {$prefijo}posts p inner join {$prefijo}postmeta pg on p.id = pg.post_id inner join {$prefijo}postmeta pa on p.id = pa.post_id inner join {$prefijo}postmeta pn on p.id = pn.post_id inner join {$prefijo}postmeta pp on p.id = pp.post_id where p.post_type = %s and p.post_status = 'publish' and pg.meta_key = 'guid' and pa.meta_key = 'abreviatura' and pn.meta_key = 'numero' and pp.meta_key = 'proyecto' and pp.meta_value = %s order by pn.meta_value, pa.meta_value, p.post_title;", 'epica', $proy->guid ) );
	}
	?>
	<input type="hidden" name="guid" id="guid" value="<?php echo esc_attr( $metas->getMeta( 'guid' ) ); ?>" />
	<input type="hidden" name="save_custom_fields" id="save_custom_fields" value="true" />
	<div class="custom-meta-box">
		<table>
			<tbody>
				<tr>
					<td class="label">Épica</td>
					<td class="control">
						<select name="epica" id="epica">
							<?php foreach ( $proyectos as $proy ): ?>
								<optgroup label="<?php echo $proy->abreviatura . " - " . $proy->post_title; ?>">
									<?php foreach ( $proy->epicas as $epica ): ?>
										<option <?php echo ( $epica->guid == $metas->getMeta( 'epica' ) ? 'selected="selected"' : '' ); ?> value="<?php echo esc_attr($epica->guid ); ?>">
											<?php echo $epica->numero . ". ". $epica->abreviatura . " - " . $epica->post_title; ?>
										</option>
									<?php endforeach ?>
								</optgroup>
							<?php endforeach ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="label">ID Trello</td>
					<td class="control">
						<input type="text" name="idtrello" id="idtrello" value="<?php echo esc_attr( $metas->getMeta( 'idtrello' ) ); ?>" />
					</td>
				</tr>
				<tr>
					<td class="label">No. Tarea</td>
					<td class="control">
						<input type="text" name="numero" id="numero" value="<?php echo esc_attr( $metas->getMeta( 'numero' ) ); ?>" />
					</td>
				</tr>
				<tr>
					<td class="label">Puntos</td>
					<td class="control">
						<select name="puntos" id="puntos">
							<option value="sin puntuación">Sin puntuacion</option>
							<?php for( $x = 2; $x <= 7; $x++ ): ?>
								<option <?php echo ( Fibonacci( $x ) == $metas->getMeta( 'puntos' ) ? 'selected="selected"' : '' ); ?> value="<?php echo Fibonacci( $x ); ?>">
									<?php echo Fibonacci( $x ); ?>
								</option>
							<?php endfor; ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="label">Tipo de Tarea</td>
					<td class="control">
						<select name="tipo" id="tipo">
							<option <?php echo ( 'historia' == $metas->getMeta( 'tipo' ) ? 'selected="selected"' : '' ); ?> value="historia">Historia</option>
							<option <?php echo ( 'cambio' == $metas->getMeta( 'tipo' ) ? 'selected="selected"' : '' ); ?> value="cambio">Cambio</option>
							<option <?php echo ( 'configuracion' == $metas->getMeta( 'tipo' ) ? 'selected="selected"' : '' ); ?> value="configuracion">Configuración</option>
							<option <?php echo ( 'error' == $metas->getMeta( 'tipo' ) ? 'selected="selected"' : '' ); ?> value="error">Error</option>
							<option <?php echo ( 'mejora' == $metas->getMeta( 'tipo' ) ? 'selected="selected"' : '' ); ?> value="mejora">Mejora</option>
							<option <?php echo ( 'tarea' == $metas->getMeta( 'tipo' ) ? 'selected="selected"' : '' ); ?> value="tarea">Tarea</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="label">Prioridad</td>
					<td class="control">
						<select name="prioridad" id="prioridad">
							<option <?php echo ( 'mayor' == $metas->getMeta( 'prioridad' ) ? 'selected="selected"' : '' ); ?> value="mayor">Mayor</option>
							<option <?php echo ( 'menor' == $metas->getMeta( 'prioridad' ) ? 'selected="selected"' : '' ); ?> value="menor">Menor</option>
							<option <?php echo ( 'trivial' == $metas->getMeta( 'prioridad' ) ? 'selected="selected"' : '' ); ?> value="trivial">Trivial</option>
							<option <?php echo ( 'critica' == $metas->getMeta( 'prioridad' ) ? 'selected="selected"' : '' ); ?> value="critica">Crítica</option>
							<option <?php echo ( 'bloqueadora' == $metas->getMeta( 'prioridad' ) ? 'selected="selected"' : '' ); ?> value="bloqueadora">Bloqueadora</option>
						</select>
					</td>
				</tr>
				<tr>
					<td class="label"></td>
					<td class="control">
						<label>
							<input type="checkbox" name="cambiosdb" id="cambiosdb" value="true" <?php echo ( "true" == $metas->getMeta( 'cambiosdb' ) ? 'checked="checked"' : '' ); ?> />
							Requiere Cambios en Base de Datos
						</label>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

function IMGX_SCTarea_Save( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if( ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	if( "tarea" !== get_post_type( $post_id ) ) {
		return;
	}
	if( isset( $_POST[ "save_custom_fields" ] ) && 'true' == $_POST[ "save_custom_fields" ] ) {
		update_post_meta( $post_id, 'guid', esc_attr( isset( $_POST[ "guid" ] ) && '' != $_POST[ "guid" ] ? $_POST[ "guid" ] : CreateGUID() ) );
		update_post_meta( $post_id, 'epica', esc_attr( isset( $_POST[ "epica" ] ) && '' != $_POST[ "epica" ] ? $_POST[ "epica" ] : '' ) );
		update_post_meta( $post_id, 'idtrello', esc_attr( isset( $_POST[ "idtrello" ] ) && '' != $_POST[ "idtrello" ] ? $_POST[ "idtrello" ] : '' ) );
		update_post_meta( $post_id, 'numero', esc_attr( isset( $_POST[ "numero" ] ) && '' != $_POST[ "numero" ] ? $_POST[ "numero" ] : '' ) );
		update_post_meta( $post_id, 'puntos', esc_attr( isset( $_POST[ "puntos" ] ) && '' != $_POST[ "puntos" ] ? $_POST[ "puntos" ] : '' ) );
		update_post_meta( $post_id, 'tipo', esc_attr( isset( $_POST[ "tipo" ] ) && '' != $_POST[ "tipo" ] ? $_POST[ "tipo" ] : '' ) );
		update_post_meta( $post_id, 'prioridad', esc_attr( isset( $_POST[ "prioridad" ] ) && '' != $_POST[ "prioridad" ] ? $_POST[ "prioridad" ] : '' ) );
		update_post_meta( $post_id, 'cambiosdb', esc_attr( isset( $_POST[ "cambiosdb" ] ) && '' != $_POST[ "cambiosdb" ] ? $_POST[ "cambiosdb" ] : 'false' ) );
	}
}

function Tarea_AddAdminColumnList_head( $defaults ) {
	$defaults[ "tarea_epica" ] = "Épica";
	$defaults[ "tarea_proyecto" ] = "Proyecto";
	return $defaults;
}

function Tarea_AddAdminColumnList_content( $columna, $post_id ) {
	global $wpdb;
	$prefijo = $wpdb->prefix;
	$metas = new MyMetas( $post_id );
	$epica_name = "";
	$proyecto_name = "";
	$epica = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid, meta_value as 'proyecto' from {$prefijo}posts p inner join {$prefijo}postmeta pm on pm.post_id = p.id and pm.meta_key = 'proyecto' where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'epica' and  meta_key = 'guid' and meta_value = %s )", $metas->getMeta( 'epica' ) ) );
	if( count( $epica ) > 0 ) {
		$epica_name = $epica[ 0 ]->post_title;
		$proyecto = $wpdb->get_results( $wpdb->prepare( "select id, post_title, post_name, guid from {$prefijo}posts where id in ( select post_id from {$prefijo}postmeta where post_status = 'publish' and post_type = 'proyecto' and  meta_key = 'guid' and meta_value = %s )", $epica[ 0 ]->proyecto ) );
		if( count( $proyecto ) > 0 ) {
			$proyecto_name = $proyecto[ 0 ]->post_title;
		}
	}
	if( "tarea_epica" == $columna ) {
		echo $epica_name;
	}
	if( "tarea_proyecto" == $columna ) {
		echo $proyecto_name;
	}
}

function Tarea_FiltroControl() {
	global $wpdb;
	$prefijo = $wpdb->prefix;
	if( 'tarea' == ( isset( $_GET[ "post_type" ] ) ? $_GET[ "post_type" ] : "post" ) ) {
		$data = $wpdb->get_results( $wpdb->prepare( "select p.id as proyecto_id, p.post_title as proyecto_name, p.guid as proyecto_guid, p.abreviatura as proyecto_abreviatura,
e.post_title as epica_name, e.guid as epica_guid, e.abreviatura as epica_abreviatura, e.numero as epica_numero
from (
select p.id, p.post_title, pg.meta_value as 'guid', pa.meta_value as 'abreviatura' 
from {$prefijo}posts p 
inner join {$prefijo}postmeta pg on p.id = pg.post_id 
inner join {$prefijo}postmeta pa on p.id = pa.post_id 
where p.post_type = %s and p.post_status = 'publish' and pg.meta_key = 'guid' and pa.meta_key = 'abreviatura' 
order by pa.meta_value, p.post_title
) p
inner join (
select p.post_title, pg.meta_value as 'guid', pa.meta_value as 'abreviatura', pn.meta_value as 'numero', pp.meta_value as 'proyecto' 
from {$prefijo}posts p 
inner join {$prefijo}postmeta pg on p.id = pg.post_id 
inner join {$prefijo}postmeta pa on p.id = pa.post_id 
inner join {$prefijo}postmeta pn on p.id = pn.post_id 
inner join {$prefijo}postmeta pp on p.id = pp.post_id 
where p.post_type = %s and p.post_status = 'publish' and pg.meta_key = 'guid' and pa.meta_key = 'abreviatura' and pn.meta_key = 'numero' and pp.meta_key = 'proyecto'
) e on p.guid = e.proyecto
order by p.abreviatura, p.post_title, e.numero, e.abreviatura, e.post_title", 'proyecto', 'epica' ) );
		$current = ( isset( $_GET[ "epica_post_filtro" ] ) ? $_GET[ "epica_post_filtro" ] : '' );
		$curret_proy_id = '';
		$optiongroup_opened = false;
		?>
		<select name="epica_post_filtro" id="epica_post_filtro" title="Épicas">
			<option value="">Todas las Épicas</option>
			<?php foreach ( $data as $opt ) : ?>
				<?php if ( $curret_proy_id != $opt->proyecto_id ): 
					$curret_proy_id = $opt->proyecto_id;
					?>
					<?php if ( true == $optiongroup_opened ): ?>
						</optgroup>
					<?php endif ?>
					<optgroup label="<?php echo "{$opt->proyecto_abreviatura} - {$opt->proyecto_name}"; ?>">
				<?php endif ?>
				<option value="<?php echo $opt->epica_guid; ?>" <?php echo ( $current == $opt->epica_guid ? 'selected="selected"' : '' ); ?>><?php echo "{$opt->epica_abreviatura}{$opt->epica_numero} - {$opt->epica_name}"; ?></option>
			<?php endforeach; ?>
			<?php if ( true == $optiongroup_opened ): ?>
				</optgroup>
			<?php endif ?>
		</select>
		<?php
	}
}

function Tarea_Filtro( $query ) {
	global $pagenow;
	if( 'tarea' == ( isset( $_GET[ "post_type" ] ) ? $_GET[ "post_type" ] : "post" ) && is_admin() && $pagenow =='edit.php' && isset( $_GET[ 'epica_post_filtro' ] ) && $_GET[ 'epica_post_filtro' ] != '') {
		$query->query_vars['meta_key'] = 'epica';
		$query->query_vars[ 'meta_value' ] = $_GET[ 'epica_post_filtro' ];
	}
}

?>
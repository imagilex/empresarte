<?php

add_action( 'init', 'IMGX_Register_SCProyecto' );
add_action( 'add_meta_boxes', 'IMGX_SCProyecto_MetaBox' );
add_action( 'save_post', 'IMGX_SCProyecto_Save' );

function IMGX_Register_SCProyecto() {
	register_taxonomy( "Estado_proyecto", "proyecto", array(
		"label"			=> "Estado_proyecto",
		"public"		=> true,
		"hierarchical"	=> true
	) );
	register_post_type( "proyecto", array(
		'labels' 		=> array(
							"name" 					=> "SCRUM Proyectos",
							"singularname" 			=> "Proyecto",
							"add_new" 				=> "Nuevo",
							"add_new_item" 			=> "Nuevo Proyecto",
							"edit_item" 			=> "Editar Proyecto",
							"new_item" 				=> "Nuevo Proyecto",
							"view_item" 			=> "Ver Proyecto",
							"view_items" 			=> "Ver Proyectos",
							"search_item" 			=> "Buscar Proyectos",
							"not_found" 			=> "Proyecto No Encontrado",
							"not_found_in_trash" 	=> "Proyecto No Encontrado en Papelera",
							"all_items"				=> "Todos los Proyectos"
						),
		'public' 		=> true,
		'has_archive'	=> true,
		'menu_icon'		=> get_stylesheet_directory_uri() . "/assets/project.png",
		'menu_position'	=> 20,
		'hierarchical'	=> true,
		'supports'		=> array( 'title', 'editor', 'thumbnail' ),
		'description'	=> 'Proyectos a manejar con SCRUM',
		'show_in_menu'	=> true,
		'show_ui'		=> true,
	) );
}

function IMGX_SCProyecto_MetaBox() {
	add_meta_box( 'scpuesto_metabox', 'Información del Proyecto', 'IMGX_SCProyecto_MetaBox_Callback', 'proyecto' );
}

function IMGX_SCProyecto_MetaBox_Callback( $post ) {
	$metas = new MyMetas( $post->ID );
	?>
	<input type="hidden" name="guid" id="guid" value="<?php echo esc_attr( $metas->getMeta( 'guid' ) ); ?>" />
	<input type="hidden" name="save_custom_fields" id="save_custom_fields" value="true" />
	<div class="custom-meta-box">
		<table>
			<tbody>
				<tr>
					<td class="label"></td>
					<td class="control">
						<label>
							<input type="checkbox" name="activo" id="activo" value="true" <?php echo ( "true" == $metas->getMeta( 'activo' ) ? 'checked="checked"' : '' ); ?> />
							Activo
						</label>
					</td>
				</tr>
				<tr>
					<td class="label">Empresa</td>
					<td class="control">
						<input type="text" name="empresa" id="empresa" value="<?php echo esc_attr( $metas->getMeta( 'empresa' ) ); ?>" />
					</td>
				</tr>
				<tr>
					<td class="label">Abreviatura</td>
					<td class="control">
						<input type="text" name="abreviatura" id="abreviatura" value="<?php echo esc_attr( $metas->getMeta( 'abreviatura' ) ); ?>" />
					</td>
				</tr>
				<tr>
					<td class="label">URL Tablero Trello</td>
					<td class="control">
						<input type="url" name="urltrello" id="urltrello" value="<?php echo esc_attr( $metas->getMeta( 'urltrello' ) ); ?>" />
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<?php
}

function IMGX_SCProyecto_Save( $post_id ) {
	if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	if( ! current_user_can( 'edit_posts' ) ) {
		return;
	}
	if( "proyecto" !== get_post_type( $post_id ) ) {
		return;
	}
	if( isset( $_POST[ "save_custom_fields" ] ) && 'true' == $_POST[ "save_custom_fields" ] ) {
		update_post_meta( $post_id, 'guid', esc_attr( isset( $_POST[ "guid" ] ) && '' != $_POST[ "guid" ] ? $_POST[ "guid" ] : CreateGUID() ) );
		update_post_meta( $post_id, 'activo', esc_attr( isset( $_POST[ "activo" ] ) && '' != $_POST[ "activo" ] ? $_POST[ "activo" ] : 'false' ) );
		update_post_meta( $post_id, 'empresa', esc_attr( isset( $_POST[ "empresa" ] ) && '' != $_POST[ "empresa" ] ? $_POST[ "empresa" ] : '' ) );
		update_post_meta( $post_id, 'abreviatura', esc_attr( isset( $_POST[ "abreviatura" ] ) && '' != $_POST[ "abreviatura" ] ? $_POST[ "abreviatura" ] : '' ) );
		update_post_meta( $post_id, 'urltrello', esc_url( isset( $_POST[ "urltrello" ] ) && '' != $_POST[ "urltrello" ] ? $_POST[ "urltrello" ] : '' ) );
	}
}

?>
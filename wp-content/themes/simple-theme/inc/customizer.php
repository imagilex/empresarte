<?php

function simpleTheme_add_setting_and_control( $wp_customize, $id, $control_type, $label, $section, $default = null, $sanitize_callback = null, $control_description = null, $choices = null ) {
	$array_setting = array(
		'capability' => 'edit_theme_options',
		'type' => 'theme_mod',
		'transport' => 'refresh'
	);
	$array_control = array(
		'label' => __( $label, 'simple-theme' ),
		'section' => $section,
		'settings' => $id
	);
	if( null != $default ) {
		$array_setting[ 'default' ] = $default;
	}
	if( null != $sanitize_callback ) {
		$array_setting[ 'sanitize_callback' ] = $sanitize_callback;
	}
	if( null != $control_description ) {
		$array_control[ 'description' ] = $control_description;
	}
	$wp_customize->add_setting( $id, $array_setting );
	if( "color" === $control_type ) {
		$wp_customize->add_Control( new WP_Customize_Color_Control( $wp_customize, $id, $array_control ) );
	} else if( ( "radio" == $control_type || "select" == $control_type ) && null != $choices ) {
		$array_control[ 'choices' ] = $choices;
		$array_control[ 'type' ] = $control_type;
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $id, $array_control ) );
	} else if( "image" == $control_type ) {
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, $id, $array_control ) );
	} else {
		$array_control[ 'type' ] = $control_type;
		$wp_customize->add_control( new WP_Customize_Control( $wp_customize, $id, $array_control ) );
	}
}

function simpleTheme_theme_customize_register( $wp_customize ) {

	/***** Colores del Tema *****/

	$wp_customize->add_section( 'simple-theme_seccion_colores', array(
		'title' => __( 'Colores', 'simple-theme' ),
		'description' => __( 'Selección de colores del tema', 'simple-theme' ),
		'priority' => 31
	) );

	simpleTheme_add_setting_and_control( $wp_customize, 'color_titulos_pagina', 'color', 'Títulos', 'simple-theme_seccion_colores', '#85a461', 'sanitize_hex_color' );
	simpleTheme_add_setting_and_control( $wp_customize, 'color_fuente_pagina', 'color', 'Texto', 'simple-theme_seccion_colores', '#000', 'sanitize_hex_color' );
	simpleTheme_add_setting_and_control( $wp_customize, 'color_fondo_encabezado', 'color', 'Fondo de Encabezado', 'simple-theme_seccion_colores', '#000', 'sanitize_hex_color' );
	simpleTheme_add_setting_and_control( $wp_customize, 'color_texto_encabezado', 'color', 'Texto de Encabezado', 'simple-theme_seccion_colores', '#fff', 'sanitize_hex_color' );
	simpleTheme_add_setting_and_control( $wp_customize, 'color_fondo_pie_pagina', 'color', 'Fondo del Pie de Página', 'simple-theme_seccion_colores', '#000', 'sanitize_hex_color' );
	simpleTheme_add_setting_and_control( $wp_customize, 'color_texto_pie_pagina', 'color', 'Texto de Pie de Página', 'simple-theme_seccion_colores', '#fff', 'sanitize_hex_color' );
	simpleTheme_add_setting_and_control( $wp_customize, 'color_social_media', 'color', 'Vinculos Social Media', 'simple-theme_seccion_colores', '#000', 'sanitize_hex_color' );

	/***** Cotacto, Ubicacion & SocialMedia *****/

	$wp_customize->add_section( 'simple-theme_seccion_social_media', array(
		'title' => __( 'Contacto, Social Media y Ubicación', 'simple-theme' ),
		'description' => __( 'Datos de Contacto, vínculos Social Media y ubicación', 'simple-theme' ),
		'priority' => 30
	) );

	simpleTheme_add_setting_and_control( $wp_customize, 'sm_tipo_desplegado', 'radio', 'Mostrar Iconos', 'simple-theme_seccion_social_media', 'data', null, null, array(
		'icon' => __( 'Mostrar sólo iconos', 'simple-theme' ),
		'data' => __( 'Mostrar iconos y datos', 'simple-theme' ),
		'all' => __( 'Mostrar icono, red social y datos', 'simple-theme' )
	) );

	simpleTheme_add_setting_and_control( $wp_customize, 'sm_email', 'email', 'Correo Electrónico', 'simple-theme_seccion_social_media', null, 'sanitize_email' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_telefono', 'number', 'Teléfono', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Teléfono a 10 dígitos, sólo numeros' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_whatsapp', 'number', 'What\'sApp', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Teléfono a 10 dígitos, sólo numeros' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_direccion', 'textarea', 'Dirección', 'simple-theme_seccion_social_media', null, 'sanitize_textarea_field' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_skype_chat', 'text', 'Skype (chat)', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Usuario de Skype' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_skype_videollamada', 'text', 'Skype (videollamada)', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Usuario de Skype' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_messenger', 'text', 'Facebook Messenger', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://www.facebook.com/usuario debes llenar con <strong>usuario</strong>' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_instagram', 'text', 'Instagram', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://www.instagram.com/usuario/ debes llenar con <strong>usuario</strong>' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_facebook', 'text', 'Facebook', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://www.facebook.com/usuario debes llenar con <strong>usuario</strong>' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_twitter', 'text', 'Twitter', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://twitter.com/usuario debes llenar con <strong>usuario</strong>' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_youtube', 'url', 'YouTube', 'simple-theme_seccion_social_media', null, 'sanitize_url', 'URL al canal de Youtube, ejemplo https://www.youtube.com/user/DTPMETROPOLITANO o https://www.youtube.com/channel/UC3BOlZPi13YMREKHYkJPTAA' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_vimeo', 'text', 'Vimeo', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://vimeo.com/user99999999 debes llenar con <strong>user99999999</strong>' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_pinterest', 'text', 'Pinterest', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://www.pinterest.com.mx/usuario/ debes llenar con <strong>usuario</strong>' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_vine', 'text', 'Vine', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://vine.co/u/999999999999999999 debes llenar con <strong>999999999999999999</strong>' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_linkedin', 'text', 'LinkedIn', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://www.linkedin.com/in/usuario/ debes llenar con <strong>usuario</strong>' );
	simpleTheme_add_setting_and_control( $wp_customize, 'sm_googleplus', 'text', 'Google+', 'simple-theme_seccion_social_media', null, 'sanitize_text_field', 'Para https://plus.google.com/u/0/+usuario debes llenar con <strong>usuario</strong>' );

	/***** Pie de Página *****/

	$wp_customize->add_section( 'simple-theme_seccion_pie_pagina', array(
		'title' => __( 'Pie de Página', 'simple-theme' ),
		'description' => __( 'Texto en pie de página', 'simple-theme' ),
		'priority' => 32
	) );

	simpleTheme_add_setting_and_control( $wp_customize, 'content_footer', 'textarea', 'Texto en Pie de Página', 'simple-theme_seccion_pie_pagina', '' );

	/***** Imagen de Encabezado *****/

	simpleTheme_add_setting_and_control( $wp_customize, 'header_img', 'image', 'Imagen de Encabezado', 'title_tagline' );

}

add_action( 'customize_register', 'simpleTheme_theme_customize_register' );

/***** Aplicacion de Personalización *****/

function simpleTheme_theme_customize_css() {

	$color_fuente_pagina = get_theme_mod( 'color_fuente_pagina', '#000' );
	$color_titulos_pagina = get_theme_mod( 'color_titulos_pagina', '#85a461' );
	$color_fondo_encabezado = get_theme_mod( 'color_fondo_encabezado', '#000' );
	$color_texto_encabezado = get_theme_mod( 'color_texto_encabezado', "#fff" );
	$color_fondo_pie_pagina = get_theme_mod( 'color_fondo_pie_pagina', '#000' );
	$color_texto_pie_pagina = get_theme_mod( 'color_texto_pie_pagina', "#fff" );
	$color_social_media = get_theme_mod( 'color_social_media', "#000" );

	?>
	<style type="text/css">
		body {
			color: <?php echo $color_fuente_pagina; ?>;
		}

		h1, h2, h3, h4, h5, h6 {
			color: <?php echo $color_titulos_pagina; ?>;
		}

		#main-header,
		#main-header h1, #main-header h2,#main-header h3, #main-header h4, #main-header h5, #main-header h6 {
			color: <?php echo $color_texto_encabezado; ?>;
		}

		#main-footer h4 {
			color: <?php echo $color_texto_pie_pagina; ?>;
		}

		#main-header {
			background-color: <?php echo $color_fondo_encabezado; ?>;
		}

		#main-footer {
			background-color: <?php echo $color_fondo_pie_pagina; ?>;
		}

		#social-navbar ul li {
			border-color: <?php echo $color_social_media; ?>;
			color: <?php echo $color_social_media; ?>;
		}

		@media screen and ( max-width: 500px ) {
			.main-menu-btn {
				color: <?php echo $color_texto_encabezado; ?>;
			}
		}

	</style>
	<?php

}

add_action( 'wp_head', 'simpleTheme_theme_customize_css' );

?>
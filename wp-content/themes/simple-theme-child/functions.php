<?php

/***** Theme Styles *****/

function simpleTheme_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}

add_action( 'wp_enqueue_scripts', 'simpleTheme_enqueue_styles' );

/***** Admin Styles *****/

function simpleTheme_enqueue_styles_admin() {
	wp_enqueue_style( 'simpleThemeStyleAdmin', get_stylesheet_directory_uri() .'/assets/admin.css' );
}

add_action( 'admin_enqueue_scripts', 'simpleTheme_enqueue_styles_admin' );

/***** PostTypes *****/

require_once get_stylesheet_directory() . "/inc/generic_functions.php";
require_once get_stylesheet_directory() . "/inc/MyMetas.php";
require_once get_stylesheet_directory() . "/post_type/scrum_proyecto.php";
require_once get_stylesheet_directory() . "/post_type/scrum_epica.php";
require_once get_stylesheet_directory() . "/post_type/scrum_tarea.php";

/****** Personalizacion *****/

function color_theme_customize_css() {
	$color_titulos_pagina = get_theme_mod( 'color_titulos_pagina', '#85a461' );
	?>
	<style type="text/css">
		.proyecto-epica {
			border-color: <?php echo $color_titulos_pagina; ?>;
		}
		.read-more-btn {
			border-color: <?php echo $color_titulos_pagina; ?>;
			background-color: <?php echo $color_titulos_pagina; ?>;
		}
		#epicas-tareas ul li {
			border-color: <?php echo $color_titulos_pagina; ?>; 
		}
		.tag-title {
			background-color: <?php echo $color_titulos_pagina; ?>;
		}
	</style>
	<?php
}

add_action( 'wp_head', 'color_theme_customize_css' );

?>
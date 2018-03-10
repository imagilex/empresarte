<?php

/***** SetUp *****/
function simpleTheme_setup() {
	add_theme_support( 'title-tag' );
	/***** Menu de Navegación *****/
	register_nav_menus( array( 'principal' => __( "Menú Principal", 'simple-theme' ) ) );
}

add_action( 'after_setup_theme', 'simpleTheme_setup' );

/***** Sidebar *****/

if( function_exists( 'register_sidebar' ) ) {
	register_sidebar( array(
		'id'			=> 'sidebar-1',
		'name'			=> __( 'Sidebar principal', 'simple-theme' ),
		'before_widget'	=> '<section id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</section>'
	) );
}

/***** Holas de Estilo *****/

function simpleTheme_enqueue_style() {
	wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/css/fontawesome-all.min.css' );
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/assets/css/normalize.css' );
	wp_enqueue_style( 'simple-theme-style', get_stylesheet_uri(), array( 'font-awesome', 'normalize' ), 1.0, 'all' );
}

add_action( 'wp_enqueue_scripts', 'simpleTheme_enqueue_style' );

/***** Scripts *****/

function simpleTheme_enqueue_scripts() {
	wp_enqueue_script( 'simple-theme-script', get_template_directory_uri() . '/assets/js/functions.js', array( 'jquery' ), 1.0, true );
}

add_action( 'wp_enqueue_scripts' , 'simpleTheme_enqueue_scripts' );

?>
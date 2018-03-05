<?php

if( function_exists( 'register_nav_menus' ) ) {
	register_nav_menus( array( 'principal' => "Menú Principal" ) );
}

if( function_exists( 'register_sidebar' ) ) {
	
	register_sidebar( array(
		'id'			=> 'sidebar-1',
		'name'			=> 'Sidebar principal',
		'before_widget'	=> '<section id="%1$s" class="widget %2$s">',
		'after_widget'	=> '</section>'
	) );
	
}

?>
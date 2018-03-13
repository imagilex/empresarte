<?php

function simpleTheme_shortcode_contacto_ubicacion_socialmedia( $args, $content ) {
	
}

function simpleTheme_registro_shortcode_contacto_ubicacion_socialmedia() {
	add_shortcode( 'ContactoUbicacionSocialMedia', 'simpleTheme_shortcode_contacto_ubicacion_socialmedia' );
}

add_action( 'init', 'simpleTheme_registro_shortcode_contacto_ubicacion_socialmedia' );

?>
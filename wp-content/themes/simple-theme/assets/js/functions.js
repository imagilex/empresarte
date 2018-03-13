jQuery( document ).ready( function() {
	if( 0 == jQuery( "#main-navbar li" ).length ) {
		jQuery( "#main-navbar" ).hide();
	}
	if( jQuery( "#main-header" ).height() + 5 > parseInt( jQuery( "#main-container" ).css( 'margin-top' ) ) ) {
		jQuery( "#main-container" ).css( 'margin-top', jQuery( "#main-header" ).height() + 15 );
	}
} );
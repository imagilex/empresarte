<?php
function CreateGUID() {
	return sha1( time() );
}

function Fibonacci( $number ) {
	if( $number < 0 ) {
		throw new Exception( "Invalid Number for fibonacci: $number" );
	}
	return ( 0 == $number || 1 == $number ? $number : Fibonacci( $number - 1 ) + Fibonacci( $number - 2 ) );
}
?>
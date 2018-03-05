<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>..:: <?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?> ::..</title>
		<?php wp_head(); ?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />	
		<link href="https://fonts.googleapis.com/css?family=Glegoo|Roboto" rel="stylesheet" />
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
		<script type="text/javascript">
			jQuery( document ).ready( function() {
				if( jQuery( "#header-title" ).height() > jQuery( "#main-navbar" ).height() ) {
					jQuery( "#main-header" ).height( jQuery( "#header-title" ).height() + 20 );
				} else {
					jQuery( "#main-navbar" ).height( jQuery( "#header-title" ).height() + 20 );
				}
			} );
		</script>
	</head>
	<body>
		
		<header id="main-header">

			<div id="header-title">
				<h1><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/img/logo.png" /></h1>
				<h3><?php bloginfo( 'description' ); ?></h3>
			</div>

			<nav id="main-navbar">
				<?php wp_nav_menu( array( 'theme_location' => 'principal' ) ); ?>
			</nav><!-- #main-navbar -->

		</header><!-- #main-header -->

		<div id="main-container">


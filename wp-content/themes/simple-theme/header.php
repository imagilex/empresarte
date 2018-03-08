<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<title>..:: <?php bloginfo( 'name' ); ?> - <?php bloginfo( 'description' ); ?> ::..</title>
		<?php wp_head(); ?>
		<link rel="stylesheet" type="text/css" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
		<script defer src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>	
		<link href="https://fonts.googleapis.com/css?family=Glegoo|Roboto" rel="stylesheet" />
		<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	</head>
	<body>
		
		<header id="main-header">

			<div id="header-title">
				<h1><img src="<?php bloginfo( 'stylesheet_directory' ); ?>/img/logo.png" /></h1>
				<h3><?php bloginfo( 'description' ); ?></h3>
			</div>

			<nav id="main-navbar">
				<button type="button" class="main-menu-btn" onclick="jQuery( '.menu-menumain-container' ).toggle( 1000 )"><span class="fa fa-2x fa-bars"></span></button>
				<?php wp_nav_menu( array( 'theme_location' => 'principal' ) ); ?>
			</nav><!-- #main-navbar -->

		</header><!-- #main-header -->

		<div id="main-container">


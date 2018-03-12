<!DOCTYPE html>
<html <?php language_attributes(); ?> >
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<link rel="profile" href="http://gmpg.org/xfn/11" />
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ) ?>" />
		
		<link href="https://fonts.googleapis.com/css?family=Glegoo|Roboto" rel="stylesheet" />
		
		<?php wp_head(); ?>

	</head>
	<body <?php body_class(); ?> >
		<header id="main-header">

			<div id="header-title">
				<?php
				$header_img = get_theme_mod( 'header_img', '' );
				?>
				<h1>
					<?php
					if( '' != $header_img ) {
						?>
						<img src="<?php echo $header_img; ?>" />
						<?php
					} else { 
						bloginfo( 'name' ); 
					}
					?>
					</h1>
				<h3><?php bloginfo( 'description' ); ?></h3>
			</div>

			<nav id="main-navbar">
				<button type="button" class="main-menu-btn" onclick="jQuery( '.menu-menumain-container' ).toggle( 1000 )"><span class="fa fa-2x fa-bars"></span></button>
				<?php wp_nav_menu( array( 'theme_location' => 'principal', 'depth' => -1 ) ); ?>
			</nav><!-- #main-navbar -->

		</header><!-- #main-header -->

		<div id="main-container">


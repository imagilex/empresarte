		</div><!-- #main-container -->

		<?php
		$content_footer = get_theme_mod( 'content_footer', '' );
		echo do_shortcode( '[ContactoUbicacionSocialMedia id="social-navbar"]' );
		?>

		<footer id="main-footer">
			<h4>
				<?php 
					if( '' != $content_footer ) {
						echo $content_footer;
					} else {
						bloginfo( 'name' ); 
					}
				?> &copy; 2018
			</h4>
		</footer><!-- #main-footer -->

		<?php wp_footer(); ?>
	</body>
</html>
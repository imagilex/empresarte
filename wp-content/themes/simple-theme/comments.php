<section id="comments" class="comments">
	<div class="comments-number">
		<h4>
			<?php
			comments_number( __( 'Sin Comentarios', 'simple-theme' ), __( 'Un comentario', 'simple-theme' ), __( '% comentarios', 'simple-theme' ) );
			?>
		</h4>
	</div><!-- .comments-number -->
	<ol class="comment-list">

		<?php wp_list_comments( array( 'callback' => 'simpleTheme_comment' ) ); ?>

	</ol><!-- .comment-list -->

	<?php comment_form(); ?>
	<!-- #respond -->

</section><!-- #comments -->
<?php
/**
 * Idyllic Clone — comentários.
 *
 * @package JSN_Idyllic_Clone
 */

defined( 'ABSPATH' ) || exit;
?>
<div id="comments" class="comments-area">
	<?php
	if ( have_comments() ) :
		$comment_count = (int) get_comments_number();
		?>
		<h2 class="comments-title">
			<?php
			printf(
				/* translators: %s: quantidade */
				esc_html( _n( '1 comentário', '%s comentários', $comment_count, 'jsn-idyllic-clone' ) ),
				esc_html( number_format_i18n( $comment_count ) )
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size'=> 60,
			) );
			?>
		</ol>

		<?php
		the_comments_pagination( array(
			'prev_text' => '←',
			'next_text' => '→',
		) );
	endif;

	if ( ! comments_open() && 0 !== (int) get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
		?>
		<p class="no-comments"><?php esc_html_e( 'Os comentários estão fechados.', 'jsn-idyllic-clone' ); ?></p>
		<?php
	endif;

	comment_form( array(
		'title_reply'        => __( 'Deixe um comentário', 'jsn-idyllic-clone' ),
		'comment_notes_before' => '',
		'label_submit'       => __( 'Enviar comentário', 'jsn-idyllic-clone' ),
	) );
	?>
</div>

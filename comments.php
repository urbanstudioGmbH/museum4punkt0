<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package urbanstudio
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<section id="comments-wrap">
<div class="center">
<section id="comments">

	<?php if ( have_comments() ) : ?>

		<h3>
			<?php comments_number( '', __("Ein Kommentar", "uslang"), __("Kommentare", "uslang"));?>
		</h3>

		<?php /* the_comments_navigation(); */ ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'callback'      => 'urbanstudio_comments',
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 60,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="no-comments"><?php esc_html_e( 'Kommentare nicht zugelassen.', 'uslang' ); ?></p>
	<?php endif; ?>

	<?php comment_form( array(
		'title_reply' => __('Kommentar verfassen', "uslang"),
		'title_reply_before' => '<h3>',
		'title_reply_after' => '</h3>',
		'comment_notes_after' => '',
		'comment_notes_before' => '<p class="comment-notes"><span id="email-notes">Ihre E-Mail-Adresse wird nicht veröffentlicht.</span> Erforderliche Felder sind mit <span class="required">*</span> markiert.</p>'
		)
	);
	//echo '<p class="comments-note">'.__('Kommentare werden sorgfältig von unserer Redaktion geprüft und freigeschaltet.<br>Eine Freischaltung kann 1–2 Tage in Anspruch nehmen.').'</p>';
	?>

</section><!-- #comments -->
</div>
</section><!-- #comments-wrap -->

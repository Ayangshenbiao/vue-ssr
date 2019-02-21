<?php
/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

if ( have_comments() ) : ?>

	<div id="comments" class="comments-container">
		<?php
		ob_start();
		comments_number( __( 'No Comments', 'Avada' ), __( 'One Comment', 'Avada' ), '% ' . __( 'Comments', 'Avada' ) );
		echo Avada()->template->title_template( ob_get_clean(), '3' );

		if( function_exists( 'the_comments_navigation' ) ) {
			the_comments_navigation();
		}
		?>

		<ol class="comment-list commentlist">
			<?php wp_list_comments( 'callback=avada_comment' ); ?>
		</ol><!-- .comment-list -->

		<?php
		if( function_exists( 'the_comments_navigation' ) ) {
			the_comments_navigation();
		}
		?>
	</div>

<?php endif;

if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

	<p class="no-comments"><?php echo __( 'Comments are closed.', 'Avada' ); ?></p>

<?php endif;

if ( comments_open() ) :

	$commenter = wp_get_current_commenter();
	$req      = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	$html_req = ( $req ? " required='required'" : '' );
	$html5    = 'html5' === current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';

	$fields = array();

	$fields['author'] = '<div id="comment-input"><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . __( 'Name (required)', 'Avada' ) . '" size="30"' . $aria_req . $html_req . ' />';
	$fields['email'] = '<input id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" placeholder="' . __( 'Email (required)', 'Avada' ) . '" size="30" aria-describedby="email-notes"' . $aria_req . $html_req  . ' />';
	$fields['url'] = '<input id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . __( 'Website', 'Avada' ) . '" size="30" /></div>';

	$comments_args = array(
		'fields'				=> apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field' 		=> '<div id="comment-textarea"><textarea name="comment" id="comment" cols="45" rows="8" aria-required="true" required="required" tabindex="4" class="textarea-comment" placeholder="' . __( 'Comment...', 'Avada' ) . '"></textarea></div>',
		'title_reply' 			=> __( 'Leave A Comment', 'Avada' ),
		'title_reply_to' 		=> __( 'Leave A Comment', 'Avada' ),
		'must_log_in' 			=> '<p class="must-log-in">' .  sprintf( __( 'You must be %slogged in%s to post a comment.', 'Avada' ), '<a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">', '</a>' ) . '</p>',
		'logged_in_as' 			=> '<p class="logged-in-as">' . __( 'Logged in as', 'Avada' ) . ' <a href="' . admin_url( 'profile.php' ) . '">' . $user_identity . '</a>. <a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" title="' . __( 'Log out of this account', 'Avada' ) . '">' . __( 'Log out &raquo;', 'Avada' ) . '</a></p>',
		'comment_notes_before' 	=> '',
		'id_submit' 			=> 'comment-submit',
		'class_submit' 			=> 'fusion-button fusion-button-default',
		'label_submit'			=> __( 'Post Comment', 'Avada' ),
	);

	comment_form( $comments_args );

endif;

// Omit closing PHP tag to avoid "Headers already sent" issues.

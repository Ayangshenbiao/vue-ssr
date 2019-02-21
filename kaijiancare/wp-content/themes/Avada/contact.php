<?php
// Template Name: Contact
get_header();

$re_captcha = '';

// Setup reCaptcha
if ( Avada()->settings->get( 'recaptcha_public' ) && Avada()->settings->get( 'recaptcha_private' ) && ! function_exists( 'recaptcha_get_html' ) ) {
	if ( ! class_exists( 'ReCaptcha' ) ) {
		require_once( 'framework/recaptchalib.php' );
	}

	// Instantiate ReCaptcha object
	$re_captcha = new ReCaptcha( Avada()->settings->get( 'recaptcha_private' ) );
}

//If the form is submitted
if(isset($_POST['submit'])) {
	//Check to make sure that the name field is not empty
	if(trim($_POST['contact_name']) == '' || trim($_POST['contact_name']) == 'Name (required)') {
		$hasError = true;
	} else {
		$name = trim($_POST['contact_name']);
	}

	//Subject field is not required
	if(function_exists('stripslashes')) {
		$subject = stripslashes(trim($_POST['url']));
	} else {
		$subject = trim($_POST['url']);
	}

	//Check to make sure sure that a valid email address is submitted
	$pattern = '/^(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){255,})(?!(?:(?:\\x22?\\x5C[\\x00-\\x7E]\\x22?)|(?:\\x22?[^\\x5C\\x22]\\x22?)){65,}@)(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22))(?:\\.(?:(?:[\\x21\\x23-\\x27\\x2A\\x2B\\x2D\\x2F-\\x39\\x3D\\x3F\\x5E-\\x7E]+)|(?:\\x22(?:[\\x01-\\x08\\x0B\\x0C\\x0E-\\x1F\\x21\\x23-\\x5B\\x5D-\\x7F]|(?:\\x5C[\\x00-\\x7F]))*\\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-+[a-z0-9]+)*\\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-+[a-z0-9]+)*)|(?:\\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\\]))$/iD';

	if(trim($_POST['email']) == '' || trim($_POST['email']) == 'Email (required)')  {
		$hasError = true;
	} else if ( preg_match($pattern, $_POST['email']) === 0 ) {
		$hasError = true;
	} else {
		$email = trim($_POST['email']);
	}

	//Check to make sure comments were entered
	if(trim($_POST['msg']) == '' || trim($_POST['msg']) == 'Message') {
		$hasError = true;
	} else {
		if(function_exists('stripslashes')) {
			$comments = stripslashes(trim($_POST['msg']));
		} else {
			$comments = trim($_POST['msg']);
		}
	}

	// Check if recaptcha is used
	if ( $re_captcha ) {
		$re_captcha_response = null;
		// Was there a reCAPTCHA response?
		if ( $_POST["g-recaptcha-response"] ) {
			$re_captcha_response = $re_captcha->verifyResponse(
				$_SERVER["REMOTE_ADDR"],
				$_POST["g-recaptcha-response"]
			);
		}

		// Check the reCaptcha response
		if ( $re_captcha_response == null ||
			 ! $re_captcha_response->success
		) {
			$hasError = true;
		}
	}

	//If there is no error, send the email
	if(!isset($hasError)) {
		$name = wp_filter_kses( $name );
		$email = wp_filter_kses( $email );
		$subject = wp_filter_kses( $subject );
		$comments = wp_filter_kses( $comments );

		if(function_exists('stripslashes')) {
			$subject = stripslashes($subject);
			$comments = stripslashes($comments);
		}

		$emailTo = Avada()->settings->get( 'email_address' ); //Put your own email address here
		$body = __('Name:', 'Avada')." $name \n\n";
		$body .= __('Email:', 'Avada')." $email \n\n";
		$body .= __('Subject:', 'Avada')." $subject \n\n";
		$body .= __('Comments:', 'Avada')."\n $comments";
		$headers = 'Reply-To: ' . $name . ' <' . $email . '>' . "\r\n";

		$mail = wp_mail($emailTo, $subject, $body, $headers);

		$emailSent = true;

		if($emailSent == true) {
			$_POST['contact_name'] = '';
			$_POST['email'] = '';
			$_POST['url'] = '';
			$_POST['msg'] = '';
		}
	}
}
?>
	<div id="content" <?php Avada()->layout->add_style( 'content_style' ); ?>>
		<?php while(have_posts()): the_post(); ?>
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php echo avada_render_rich_snippets_for_pages(); ?>
			<?php echo avada_featured_images_for_pages(); ?>
			<div class="post-content">
				<?php the_content(); ?>

				<?php if( ! Avada()->settings->get( 'email_address' ) ) { // Email address not set
					$email_address_notice = __( 'Form email address is not set in Theme Options. Please fill in a valid address to make contact form work.', 'Avada' );
					if ( shortcode_exists( 'alert' ) ) {
						echo do_shortcode( '[alert type="error" accent_color="" background_color="" border_size="1px" icon="" box_shadow="yes" animation_type="0" animation_direction="down" animation_speed="0.1" class="" id=""]' . $email_address_notice . '[/alert]' );
					} else {
					?>
						<h2 style="color:#b94a48;"><?php echo $email_address_notice; ?></h2>
					<?php } ?>
					<br />
				<?php } ?>

				<?php if ( isset( $hasError ) ) { //If errors are found
					$field_error_notice = __( 'Please check if you\'ve filled all the fields with valid information. Thank you.', 'Avada' );
					if ( shortcode_exists( 'alert' ) ) {
						echo do_shortcode( '[alert type="error" accent_color="" background_color="" border_size="1px" icon="" box_shadow="yes" animation_type="0" animation_direction="down" animation_speed="0.1" class="" id=""]' . $field_error_notice . '[/alert]' );
					} else {
					?>
						<h3 style="color:#b94a48;"><?php echo $field_error_notice; ?></h3>
					<?php } ?>
					<br />
				<?php } ?>

				<?php if( isset( $emailSent ) && $emailSent == true ) { //If email is sent
					$message_success_notice = __( 'Thank you', 'Avada' ) . ' <strong>' . $name . '</strong> ' . __( 'for using our contact form! Your email was successfully sent!', 'Avada' );
					if ( shortcode_exists( 'alert' ) ) {				
						echo do_shortcode( '[alert type="success" accent_color="" background_color="" border_size="1px" icon="" box_shadow="yes" animation_type="0" animation_direction="down" animation_speed="0.1" class="" id=""]' . $message_success_notice . '[/alert]' );
					} else {
					?>
						<h3 style="color:#468847;"><?php echo $message_success_notice; ?></h3>
					<?php } ?>
					<br />
				<?php } ?>
			</div>
			<form action="" method="post" class="avada-contact-form">

				<?php if( Avada()->settings->get( 'contact_comment_position' ) == 'above' ): ?>
				<div id="comment-textarea" class="fusion-contact-comment-above">

					<textarea name="msg" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment" placeholder="<?php echo __('Message', 'Avada'); ?>"><?php if(isset($_POST['msg']) && !empty($_POST['msg'])) { echo esc_html( $_POST['msg'] ); } ?></textarea>

				</div>
				<?php endif; ?>
				
				<div id="comment-input">

					<input type="text" name="contact_name" id="author" value="<?php if(isset($_POST['contact_name']) && !empty($_POST['contact_name'])) { echo esc_html( $_POST['contact_name'] ); } ?>" placeholder="<?php echo __('Name (required)', 'Avada'); ?>" size="22" tabindex="1" aria-required="true" class="input-name">

					<input type="text" name="email" id="email" value="<?php if(isset($_POST['email']) && !empty($_POST['email'])) { echo esc_html( $_POST['email'] ); } ?>" placeholder="<?php echo __('Email (required)', 'Avada'); ?>" size="22" tabindex="2" aria-required="true" class="input-email">

					<input type="text" name="url" id="url" value="<?php if(isset($_POST['url']) && !empty($_POST['url'])) { echo esc_html( $_POST['url'] ); } ?>" placeholder="<?php echo __('Subject', 'Avada'); ?>" size="22" tabindex="3" class="input-website">

				</div>
				
				<?php if( Avada()->settings->get( 'contact_comment_position' ) != 'above' ): ?>
				<div id="comment-textarea" class="fusion-contact-comment-below">

					<textarea name="msg" id="comment" cols="39" rows="4" tabindex="4" class="textarea-comment" placeholder="<?php echo __('Message', 'Avada'); ?>"><?php if(isset($_POST['msg']) && !empty($_POST['msg'])) { echo esc_html( $_POST['msg'] ); } ?></textarea>

				</div>
				<?php endif; ?>				

				<?php if( Avada()->settings->get( 'recaptcha_public' ) && Avada()->settings->get( 'recaptcha_private' ) ): ?>

				<div id="comment-recaptcha">

					<div class="g-recaptcha" data-type="audio" data-theme="<?php echo Avada()->settings->get( 'recaptcha_color_scheme' ); ?>" data-sitekey="<?php echo Avada()->settings->get( 'recaptcha_public' ); ?>"></div>
					<script type="text/javascript"
						src="https://www.google.com/recaptcha/api.js?hl=<?php echo get_locale(); ?>">
					</script>

				</div>

				<?php endif; ?>

				<div id="comment-submit-container">
					<input name="submit" type="submit" id="submit" tabindex="5" value="<?php echo __('Submit Form', 'Avada'); ?>" class="<?php echo sprintf( 'comment-submit fusion-button fusion-button-default fusion-button-%s fusion-button-%s fusion-button-%s', strtolower( Avada()->settings->get( 'button_size' ) ), strtolower( Avada()->settings->get( 'button_shape' ) ), strtolower( Avada()->settings->get( 'button_type' ) ) ); ?>">
				</div>
			</form>
		</div>
		<?php endwhile; ?>
	</div>
	<?php do_action( 'fusion_after_content' ); ?>
<?php get_footer();

// Omit closing PHP tag to avoid "Headers already sent" issues.

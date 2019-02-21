<div class='pyre_metabox'>

	<?php

	$this->select(
		'type',
		__( 'Background Type', 'Avada' ),
		array(
			'image'             => __( 'Image', 'Avada' ),
			'self-hosted-video' => __( 'Self-Hosted Video', 'Avada' ),
			'youtube'           => __( 'Youtube', 'Avada' ),
			'vimeo'             => __( 'Vimeo', 'Avada' )
		),
		__( 'Select an image or video slide. If using an image, please select the image in the "Featured Image" box on the right hand side.', 'Avada' )
	);
	?>

	<div class="video_settings" style="display: none;">

		<h2><?php _e( 'Video Options:', 'Avada' ); ?></h2>

		<?php
		$this->text(
			'youtube_id',
			__( 'Youtube Video ID', 'Avada' ),
			__( 'For example the Video ID for http://www.youtube.com/<strong>LOfeCR7KqUs</strong> is <strong>LOfeCR7KqUs</strong>', 'Avada' )
		);	
		$this->text(
			'vimeo_id',
			__( 'Vimeo Video ID', 'Avada' ),
			__( 'For example the Video ID for http://vimeo.com/<strong>75230326</strong> is <strong>75230326</strong>', 'Avada' )
		);
		$this->upload(
			'webm',
			__( 'Video WebM Upload', 'Avada' ),
			__( 'Video must be in a 16:9 aspect ratio. Add your WebM video file. WebM and MP4 format must be included to render your video with cross browser compatibility. OGV is optional.', 'Avada' )
		);
		$this->upload(
			'mp4',
			__( 'Video MP4 Upload', 'Avada' ),
			__( 'Video must be in a 16:9 aspect ratio. Add your MP4 video file. MP4 and WebM format must be included to render your video with cross browser compatibility. OGV is optional.', 'Avada' )
		);
		$this->upload(
			'ogv',
			__( 'Video OGV Upload', 'Avada' ),
			__( 'Add your OGV video file. This is optional.', 'Avada' )
		);
		$this->upload(
			'preview_image',
			__( 'Video Preview Image', 'Avada' ),
			__( 'IMPORTANT: This field must be used for self hosted videos. Self hosted videos do not work correctly on mobile devices. The preview image will be seen in place of your video on older browsers or mobile devices.', 'Avada' )
		);
		$this->text(
			'aspect_ratio',
			__( 'Video Aspect Ratio', 'Avada' ),
			__( 'The video will be resized to maintain this aspect ratio, this is to prevent the video from showing any black bars. Enter an aspect ratio here such as: "16:9", "4:3" or "16:10". The default is "16:9"', 'Avada' )
		);			
		$this->text(
			'video_bg_color',
			__( 'Video Color Overlay', 'Avada' ),
			__( 'Select a color to show over the video as an overlay. Hex color code, <strong>ex: #fff</strong>', 'Avada' )
		);
		$this->select(
			'mute_video',
			__( 'Mute Video', 'Avada' ),
			array( 'yes' => __( 'Yes', 'Avada' ), 'no' => __( 'No', 'Avada' ) ),
			''
		);
		$this->select(
			'autoplay_video',
			__( 'Autoplay Video', 'Avada' ),
			array( 'yes' => __( 'Yes', 'Avada' ), 'no' => __( 'No', 'Avada' ) ),
			''
		);
		$this->select(
			'loop_video',
			__( 'Loop Video', 'Avada' ),
			array( 'yes' => __( 'Yes', 'Avada' ), 'no' => __( 'No', 'Avada' ) ),
			''
		);
		$this->select(
			'hide_video_controls',
			__( 'Hide Video Controls', 'Avada' ),
			array( 'yes' => __( 'Yes', 'Avada' ), 'no' => __( 'No', 'Avada' ) ),
			__( 'If this is set to yes, then autoplay must be enabled for the video to work.', 'Avada' )
		);
		?>

	</div>

	<h2><?php _e( 'Slider Content Settings:', 'Avada' ); ?></h2>

	<?php

	$this->select(
		'content_alignment',
		__( 'Content Alignment', 'Avada' ),
		array( 'left' => __( 'Left', 'Avada' ), 'center' => __( 'Center', 'Avada' ), 'right' => __( 'Right', 'Avada' ) ),
		__( 'Select how the heading, caption and buttons will be aligned.', 'Avada' )
	);
	$this->textarea(
		'heading',
		__( 'Heading Area', 'Avada' ),
		__( 'Enter the heading for your slide. This field can take HTML markup and Fusion Shortcodes.', 'Avada' )
	);
	$this->select(
		'heading_separator',
		__( 'Heading Separator', 'Avada' ),
		array(	'none'				=> __( 'None', 'Avada' ),
				'single solid'		=> __( 'Single Solid', 'Avada' ),
				'single dashed'		=> __( 'Single Dashed', 'Avada' ),
				'single dotted'		=> __( 'Single Dotted', 'Avada' ),
				'double solid'	 	=> __( 'Double Solid', 'Avada' ),
				'double dashed'		=> __( 'Double Dashed', 'Avada' ),
				'double dotted'		=> __( 'Double Dotted', 'Avada' ),
				'underline solid'	=> __( 'Underline Solid', 'Avada' ),
				'underline dashed'	=> __( 'Underline Dashed', 'Avada' ),
				'underline dotted'	=> __( 'Underline Dotted', 'Avada' ),
				
		),
		__( 'Choose the heading separator you want to use.', 'Avada' )
	);	
	$this->text(
		'heading_font_size',
		__( 'Heading Font Size', 'Avada' ),
		__( 'Enter heading font size without px unit. In pixels, ex: 50 instead of 50px. <strong>Default: 60</strong>', 'Avada' )
	);
	$this->text(
		'heading_color',
		__( 'Heading Color', 'Avada' ),
		__( 'Select a color for the heading font. Hex color code, ex: #fff. <strong>Default: #fff</strong>', 'Avada' )
	);
	$this->select(
		'heading_bg',
		__( 'Heading Background', 'Avada' ),
		array( 'yes' => __( 'Yes', 'Avada' ), 'no' => __( 'No', 'Avada' ) ),
		__( 'Select this option if you would like a semi-transparent background behind your heading.', 'Avada' )
	);
	$this->text(
		'heading_bg_color',
		__( 'Heading Background Color', 'Avada' ),
		__( 'Select a color for the heading background. Hex color code, ex: #000. <strong>Default: #000</strong>', 'Avada' )
	);
	$this->textarea(
		'caption',
		__( 'Caption Area', 'Avada' ),
		__( 'Enter the caption for your slide. This field can take HTML markup and Fusion Shortcodes.', 'Avada' )
	);
	$this->select(
		'caption_separator',
		__( 'Caption Separator', 'Avada' ),
		array(	'none'				=> __( 'None', 'Avada' ),
				'single solid'		=> __( 'Single Solid', 'Avada' ),
				'single dashed'		=> __( 'Single Dashed', 'Avada' ),
				'single dotted'		=> __( 'Single Dotted', 'Avada' ),
				'double solid'	 	=> __( 'Double Solid', 'Avada' ),
				'double dashed'		=> __( 'Double Dashed', 'Avada' ),
				'double dotted'		=> __( 'Double Dotted', 'Avada' ),
				'underline solid'	=> __( 'Underline Solid', 'Avada' ),
				'underline dashed'	=> __( 'Underline Dashed', 'Avada' ),
				'underline dotted'	=> __( 'Underline Dotted', 'Avada' ),
				
		),
		__( 'Choose the caption separator you want to use.', 'Avada' )
	);	
	$this->text(
		'caption_font_size',
		__( 'Caption Font Size', 'Avada' ),
		__( 'Enter caption font size without px unit. In pixels, ex: 24 instead of 24px. <strong>Default: 24</strong>', 'Avada' )
	);
	$this->text(
		'caption_color',
		__( 'Caption Color', 'Avada' ),
		__( 'Select a color for the caption font. Hex color code, ex: #fff. <strong>Default: #fff</strong>', 'Avada' )
	);
	$this->select(
		'caption_bg',
		__( 'Caption Background', 'Avada' ),
		array( 'yes' => __( 'Yes', 'Avada' ), 'no' => __( 'No', 'Avada' ) ),
		__( 'Select this option if you would like a semi-transparent background behind your caption.', 'Avada' )
	);
	$this->text(
		'caption_bg_color',
		__( 'Caption Background Color', 'Avada' ),
		__( 'Select a color for the caption background. Hex color code, ex: #000. <strong>Default: #000</strong>', 'Avada' )
	);
	?>

	<h2><?php _e( 'Slide Link Settings:', 'Avada' ); ?></h2>

	<?php

	$this->select(
		'link_type',
		__( 'Slide Link Type', 'Avada' ),
		array( 'button' => __( 'Button', 'Avada' ), 'full' => __( 'Full Slide', 'Avada' ) ),
		__( 'Select how the slide will link.', 'Avada' )
	);
	$this->text(
		'slide_link',
		__( 'Slide Link', 'Avada' ),
		__( 'Please enter your URL that will be used to link the full slide.', 'Avada' )
	);
	$this->select(
		'slide_target',
		__( 'Open Slide Link In New Window', 'Avada' ),
		array( 'yes' => __( 'Yes', 'Avada' ), 'no' => __( 'No', 'Avada' ) )
	);
	$this->textarea(
		'button_1',
		__( 'Button #1', 'Avada' ) . '<br/><a href="http://theme-fusion.com/knowledgebase/avada-shortcode-list/#buttons" target="_blank">' . __( 'Click here to view button option descriptions.', 'Avada' ) . '</a>',
		__( 'Adjust the button shortcode parameters for the first button.', 'Avada' ),
		'[button link="" color="default" size="" type="" shape="" target="_self" title="" gradient_colors="|" gradient_hover_colors="|" accent_color="" accent_hover_color="" bevel_color="" border_width="1px" shadow="" icon="" icon_divider="yes" icon_position="left" modal="" animation_type="0" animation_direction="down" animation_speed="0.1" class="" id=""]Button Text[/button]'
	);
	$this->textarea(
		'button_2',
		__( 'Button #2', 'Avada' ) . '<br/><a href="http://theme-fusion.com/knowledgebase/avada-shortcode-list/#buttons" target="_blank">' . __( 'Click here to view button option descriptions.', 'Avada' ) . '</a>',
		__( 'Adjust the button shortcode parameters for the second button.', 'Avada' ),
		'[button link="" color="default" size="" type="" shape="" target="_self" title="" gradient_colors="|" gradient_hover_colors="|" accent_color="" accent_hover_color="" bevel_color="" border_width="1px" shadow="" icon="" icon_divider="yes" icon_position="left" modal="" animation_type="0" animation_direction="down" animation_speed="0.1" class="" id=""]Button Text[/button]'
	);
	?>

</div>
<div class="clear"></div>

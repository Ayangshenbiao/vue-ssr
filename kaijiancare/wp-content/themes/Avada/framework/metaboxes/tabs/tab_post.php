<?php

$this->select(
	'show_first_featured_image',
	__( 'Disable First Featured Image', 'Avada' ),
	array(
		'no'  => __( 'No', 'Avada' ),
		'yes' => __( 'Yes', 'Avada' )
	),
	__( 'Disable the 1st featured image on single post pages.', 'Avada' )
);

$this->select(
	'portfolio_width_100',
	__( 'Use 100% Width Page', 'Avada' ),
	array(
		'default' 	=> __( 'Default', 'Avada' ),
		'no'  		=> __( 'No', 'Avada' ),
		'yes' 		=> __( 'Yes', 'Avada' )
	),
	__( 'Choose to set this post to 100% browser width.', 'Avada' )
);

$this->textarea(
	'video',
	__( 'Video Embed Code', 'Avada' ),
	__( 'Insert Youtube or Vimeo embed code.', 'Avada' )
);

$this->text(
	'fimg_width',
	__( 'Featured Image Width', 'Avada' ),
	__( 'In pixels or percentage, ex: 100% or 100px. Use "auto" if you set a fixed height, to make sure the image is resized respecting the aspect ratio. Value cannot exceed original image width.', 'Avada' )
);

$this->text(
	'fimg_height',
	__( 'Featured Image Height', 'Avada' ),
	__( 'In pixels or percentage, ex: 100% or 100px. Use "auto" if you set a fixed height, to make sure the image is resized respecting the aspect ratio. Value cannot exceed original image height.', 'Avada' )
);

$this->select(
	'image_rollover_icons',
	__( 'Image Rollover Icons', 'Avada' ),
	array(
		'default'  => __( 'Default', 'Avada' ),
		'linkzoom' => __( 'Link + Zoom', 'Avada' ),
		'link'     => __( 'Link', 'Avada' ),
		'zoom'     => __( 'Zoom', 'Avada' ),
		'no'       => __( 'No Icons', 'Avada' )
	),
	__( 'Choose which icons display on this post.', 'Avada' )
);

$this->text(
	'link_icon_url',
	__( 'Link Icon URL', 'Avada' ),
	__( 'Leave blank for post URL.', 'Avada' )
);

$this->select(
	'post_links_target',
	__( 'Open Post Links In New Window', 'Avada' ),
	array(
		'no'  => __( 'No', 'Avada' ),
		'yes' => __( 'Yes', 'Avada' )
	),
	__( 'Choose to open the single post page link in a new window.', 'Avada' )
);

$this->select(
	'related_posts',
	__( 'Show Related Posts', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Show', 'Avada' ),
		'no'      => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide related posts on this post.', 'Avada' )
);

$this->select(
	'share_box',
	__( 'Show Social Share Box', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Show', 'Avada' ),
		'no'      => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide the social share box', 'Avada' )
);

$this->select(
	'post_pagination',
	__( 'Show Previous/Next Pagination', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Show', 'Avada' ),
		'no'      => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide the post navigation', 'Avada' )
);

$this->select(
	'author_info',
	__( 'Show Author Info Box', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Show', 'Avada' ),
		'no'      => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide the author info box', 'Avada' )
);

$this->select(
	'post_meta',
	__( 'Show Post Meta', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Show', 'Avada' ),
		'no'      => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide the post meta', 'Avada' )
);

$this->select(
	'post_comments',
	__( 'Show Comments', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Show', 'Avada' ),
		'no'      => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide comments area', 'Avada' )
);

// Omit closing PHP tag to avoid "Headers already sent" issues.

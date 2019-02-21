<?php

$this->select(
	'width',
	__( 'Width (Content Columns for Featured Image)', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'full'    => __( 'Full Width', 'Avada' ),
		'half'    => __( 'Half Width', 'Avada' )
	),
	__( 'Choose if the featured image is full or half width.', 'Avada' )
);

$this->select(
	'portfolio_width_100',
	__( 'Use 100% Width Page', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'no'      => __( 'No', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' )
	),
	__( 'Choose to set this post to 100% browser width.', 'Avada' )
);

$this->select(
	'project_desc_title',
	__( 'Show Project Description Title', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' ),
		'no'      => __( 'No', 'Avada' )
	),
	__( 'Choose to show or hide the project description title.', 'Avada' )
);

$this->select(
	'project_details',
	__( 'Show Project Details', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' ),
		'no'      => __( 'No', 'Avada' )
	),
	__( 'Choose to show or hide the project details text.', 'Avada' )
);

$this->select(
	'show_first_featured_image',
	__( 'Disable First Featured Image', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'no'      => __( 'No', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' )
	),
	__( 'Disable the 1st featured image on single post pages.', 'Avada' )
);

$this->textarea(
	'video',
	__( 'Video Embed Code', 'Avada' ),
	__( 'Insert Youtube or Vimeo embed code.', 'Avada' )
);

$this->text(
	'video_url',
	__( 'Youtube/Vimeo Video URL for Lightbox', 'Avada' ),
	__( 'Insert the video URL that will show in the lightbox.', 'Avada' )
);

$this->text(
	'project_url',
	__( 'Project URL', 'Avada' ),
	__( 'The URL the project text links to.', 'Avada' )
);

$this->text(
	'project_url_text',
	__( 'Project URL Text', 'Avada' ),
	__( 'The custom project text that will link.', 'Avada' )
);

$this->text(
	'copy_url',
	__( 'Copyright URL', 'Avada' ),
	__( 'The URL the copyright text links to.', 'Avada' )
);

$this->text(
	'copy_url_text',
	__( 'Copyright URL Text', 'Avada' ),
	__( 'The custom copyright text that will link.', 'Avada' )
);

$this->text(
	'fimg_width',
	__( 'Featured Image Width', 'Avada' ),
	__( 'In pixels or percentage, ex: 100% or 100px. Or Use "auto" for automatic resizing if you added either width or height.', 'Avada' )
);

$this->text(
	'fimg_height',
	__( 'Featured Image Height', 'Avada' ),
	__( 'In pixels or percentage, ex: 100% or 100px. Or Use "auto" for automatic resizing if you added either width or height.', 'Avada' )
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
	'link_icon_target',
	__( 'Open Post Links In New Window', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'no'      => __( 'No', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' )
	),
	__( 'Choose to open the single post page, project url and copyright url links in a new window.', 'Avada' )
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

// Omit closing PHP tag to avoid "Headers already sent" issues.

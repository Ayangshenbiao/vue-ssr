<?php

$this->select(
	'page_title',
	__( 'Page Title Bar', 'Avada' ),
	array(
		'default'         => __( 'Default', 'Avada' ),
		'yes'             => __( 'Show Bar and Content', 'Avada' ),
		'yes_without_bar' => __( 'Show Content Only', 'Avada' ),
		'no'              => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide the page title bar.', 'Avada' )
);

$this->select(
	'page_title_text',
	__( 'Page Title Bar Text', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Show', 'Avada' ),
		'no'      => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide the page title bar text.', 'Avada' )
);

$this->select(
	'page_title_text_alignment',
	__( 'Page Title Bar Text Alignment', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'left'    => __( 'Left', 'Avada' ),
		'center'  => __( 'Center', 'Avada' ),
		'right'   => __( 'Right', 'Avada' )
	),
	__( 'Choose the title and subhead text alignment', 'Avada' )
);

$this->select(
	'page_title_100_width',
	__( '100% Page Title Width', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' ),
		'no'      => __( 'No', 'Avada' )
	),
	__( 'Choose to set the page title content to 100% of the browser width. Select "No" for site width. Only works with wide layout mode.', 'Avada' )
);

$this->textarea(
	'page_title_custom_text',
	__( 'Page Title Bar Custom Text', 'Avada' ),
	__( 'Insert custom text for the page title bar.', 'Avada' )
);

$this->text(
	'page_title_text_size',
	__( 'Page Title Bar Text Size', 'Avada' ),
	__( 'In pixels, default is 18px.', 'Avada' )
);

$this->textarea(
	'page_title_custom_subheader',
	__( 'Page Title Bar Custom Subheader Text', 'Avada' ),
	__( 'Insert custom subhead text for the page title bar.', 'Avada' )
);

$this->text(
	'page_title_custom_subheader_text_size',
	__( 'Page Title Bar Subhead Text Size', 'Avada' ),
	__( 'In pixels, default is 10px.', 'Avada' )
);

$this->text(
	'page_title_font_color',
	__( 'Page Title Font Color', 'Avada' ),
	__( 'Controls the text color of the page title fonts.', 'Avada' )
);

$this->text(
	'page_title_height',
	__( 'Page Title Bar Height', 'Avada' ),
	__( 'Set the height of the page title bar. In pixels ex: 100px.', 'Avada' )
);

$this->text(
	'page_title_mobile_height',
	__( 'Page Title Bar Mobile Height', 'Avada' ),
	__( 'Set the height of the page title bar on mobile. In pixels ex: 100px.', 'Avada' )
);

$this->upload(
	'page_title_bar_bg',
	__( 'Page Title Bar Background', 'Avada' ),
	__( 'Select an image to use for the page title bar background.', 'Avada' )
);

$this->upload(
	'page_title_bar_bg_retina',
	__( 'Page Title Bar Background Retina', 'Avada' ),
	__( 'Select an image to use for retina devices.', 'Avada' )
);

$this->text(
	'page_title_bar_bg_color',
	__( 'Page Title Bar Background Color', 'Avada' ),
	__( 'Controls the background color of the page title bar. Hex code, ex: #000', 'Avada' )
);

$this->text(
	'page_title_bar_borders_color',
	__( 'Page Title Bar Borders Color', 'Avada' ),
	__( 'Controls the border color of the page title bar. Hex code, ex: #000', 'Avada' )
);

$this->select(
	'page_title_bar_bg_full',
	__( '100% Background Image', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'no'      => __( 'No', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' )
	),
	__( 'Choose to have the background image display at 100%.', 'Avada' )
);

$this->select(
	'page_title_bg_parallax',
	__( 'Parallax Background Image', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'no'      => __( 'No', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' )
	),
	__( 'Choose a parallax scrolling effect for the background image.', 'Avada' )
);

$this->select(
	'page_title_breadcrumbs_search_bar',
	__( 'Breadcrumbs/Search Bar', 'Avada' ),
	array(
		'default'     => __( 'Default', 'Avada' ),
		'breadcrumbs' => __( 'Breadcrumbs', 'Avada' ),
		'searchbar'   => __( 'Search Bar', 'Avada' ),
		'none'        => __( 'None', 'Avada' )
	),
	__( 'Choose to display the breadcrumbs, search bar or none.', 'Avada' )
);

// Omit closing PHP tag to avoid "Headers already sent" issues.

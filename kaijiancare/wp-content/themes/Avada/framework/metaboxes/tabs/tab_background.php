<?php

$this->select(
	'page_bg_layout',
	__('Layout', 'Avada'),
	array(
		'default' => __( 'Default', 'Avada' ),
		'wide'    => __( 'Wide', 'Avada' ),
		'boxed'   => __( 'Boxed', 'Avada' )
	),
	__( 'Select boxed or wide layout.', 'Avada' )
);

printf( '<h3>%s</h3>', __( 'Following options only work in boxed mode:', 'Avada' ) );

$this->upload(
	'page_bg',
	__( 'Background Image for Outer Area', 'Avada' ),
	__( 'Select an image to use for the outer background.', 'Avada' )
);

$this->text(
	'page_bg_color',
	__( 'Background Color', 'Avada' ),
	__( 'Controls the background color for the outer background. Hex code, ex: #000', 'Avada' )
);

$this->select(
	'page_bg_full',
	__( '100% Background Image', 'Avada' ),
	array(
		'no'  => __( 'No', 'Avada' ),
		'yes' => __( 'Yes', 'Avada' )
	),
	__( 'Choose to have the background image display at 100%.', 'Avada' )
);

$this->select(
	'page_bg_repeat',
	__( 'Background Repeat', 'Avada' ),
	array(
		'repeat'    => __( 'Tile', 'Avada' ),
		'repeat-x'  => __( 'Tile Horizontally', 'Avada' ),
		'repeat-y'  => __( 'Tile Vertically', 'Avada' ),
		'no-repeat' => __( 'No Repeat', 'Avada' )
	),
	__( 'Select how the background image repeats.', 'Avada' )
);

printf( '<h3>%s</h3>', __( 'Following options work in boxed and wide mode:', 'Avada' ) );

$this->upload(
	'wide_page_bg',
	__( 'Background Image for Main Content Area', 'Avada' ),
	__( 'Select an image to use for the main content area.', 'Avada' )
);

$this->text(
	'wide_page_bg_color',
	__( 'Background Color', 'Avada' ),
	__( 'Controls the background color for the main content area. Hex code, ex: #000', 'Avada' )
);

$this->select(
	'wide_page_bg_full',
	__( '100% Background Image', 'Avada' ),
	array(
		'no'  => __( 'No', 'Avada' ),
		'yes' => __( 'Yes', 'Avada' )
	),
	__( 'Choose to have the background image display at 100%.', 'Avada' )
);

$this->select(
	'wide_page_bg_repeat',
	__( 'Background Repeat', 'Avada' ),
	array(
		'repeat'    => __( 'Tile', 'Avada' ),
		'repeat-x'  => __( 'Tile Horizontally', 'Avada' ),
		'repeat-y'  => __( 'Tile Vertically', 'Avada' ),
		'no-repeat' => __( 'No Repeat', 'Avada' )
	),
	__( 'Select how the background image repeats.', 'Avada' )
);

// Omit closing PHP tag to avoid "Headers already sent" issues.

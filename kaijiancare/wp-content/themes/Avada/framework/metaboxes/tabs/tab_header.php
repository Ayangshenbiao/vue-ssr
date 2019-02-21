<?php
$this->select(
	'display_header',
	__( 'Display Header', 'Avada' ),
	array(
		'yes' => __( 'Yes', 'Avada' ),
		'no'  => __( 'No', 'Avada' )
	),
	__( 'Choose to show or hide the header.', 'Avada' )
);

$this->select(
	'header_100_width',
	__( '100% Header Width', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' ),
		'no'      => __( 'No', 'Avada' )
	),
	__( 'Choose to set header width to 100% of the browser width. Select "No" for site width.', 'Avada' )
);

$this->upload(
	'header_bg',
	__( 'Background Image', 'Avada' ),
	__( 'Select an image to use for the header background.', 'Avada' )
);

$this->text(
	'header_bg_color',
	__( 'Background Color', 'Avada' ),
	__( 'Controls the background color of the header. Hex code, ex: #000', 'Avada' )
);

$this->text(
	'header_bg_opacity',
	__( 'Background Opacity', 'Avada' ),
	__( 'Controls the opacity of the header background color when using the top position. Ranges between 0 (transparent) and 1 (opaque). ex: .4', 'Avada' )
);

$this->select(
	'header_bg_full',
	__( '100% Background Image', 'Avada' ),
	array(
		'no'  => __( 'No', 'Avada' ),
		'yes' => __( 'Yes', 'Avada' )
	),
	__( 'Choose to have the background image display at 100%.', 'Avada' )
);

$this->select(
	'header_bg_repeat',
	__( 'Background Repeat', 'Avada' ),
	array(
		'repeat'    => __( 'Tile', 'Avada' ),
		'repeat-x'  => __( 'Tile Horizontally', 'Avada' ),
		'repeat-y'  => __( 'Tile Vertically', 'Avada' ),
		'no-repeat' => __( 'No Repeat', 'Avada' )
	),
	__( 'Select how the background image repeats.', 'Avada' )
);

$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
$menu_select['default'] = 'Default Menu';

foreach ( $menus as $menu ) {
	$menu_select[$menu->term_id] = $menu->name;
}

$this->select(
	'displayed_menu',
	__( 'Main Navigation Menu', 'Avada' ),
	$menu_select,
	__( 'Select which menu displays on this page.', 'Avada' )
);

// Omit closing PHP tag to avoid "Headers already sent" issues.

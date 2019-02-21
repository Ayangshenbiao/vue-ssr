<?php

$this->select(
	'display_footer',
	__( 'Display Footer Widget Area', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' ),
		'no'      => __( 'No', 'Avada' )
	),
	__( 'Choose to show or hide the footer.', 'Avada' )
);

$this->select(
	'display_copyright',
	__( 'Display Copyright Area', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' ),
		'no'      => __( 'No', 'Avada' )
	),
	__( 'Choose to show or hide the copyright area.', 'Avada' )
);

$this->select(
	'footer_100_width',
	__( '100% Footer Width', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'yes'     => __( 'Yes', 'Avada' ),
		'no'      => __( 'No', 'Avada' )
	),
	__( 'Choose to set footer width to 100% of the browser width. Select "No" for site width.', 'Avada' )
);

// Omit closing PHP tag to avoid "Headers already sent" issues.

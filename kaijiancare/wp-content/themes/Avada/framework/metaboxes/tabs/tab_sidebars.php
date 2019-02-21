<?php

sidebar_generator::edit_form();

$this->select(
	'sidebar_position',
	__( 'Sidebar 1 Position', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'right'   => __( 'Right', 'Avada' ),
		'left'    => __( 'Left', 'Avada' )
	),
	__( 'Select the sidebar 1 position. If sidebar 2 is selected, it will display on the opposite side.', 'Avada' )
);

$this->text(
	'sidebar_bg_color',
	__( 'Sidebar Background Color', 'Avada' ),
	__( 'Controls the background color of the sidebar. Hex code, ex: #000', 'Avada' )
);

// Omit closing PHP tag to avoid "Headers already sent" issues.

<?php

$this->select(
	'portfolio_width_100',
	__( 'Use 100% Width Page', 'Avada' ),
	array(
		'no'  => __( 'No', 'Avada' ),
		'yes' => __( 'Yes', 'Avada' )
	),
	__( 'Choose to set a portfolio template page to 100% browser width.', 'Avada' )
);

$this->select(
	'portfolio_content_length',
	__( 'Excerpt or Full Portfolio Content', 'Avada' ),
	array(
		'default'      => __( 'Default', 'Avada' ),
		'excerpt'      => __( 'Excerpt', 'Avada' ),
		'full_content' => __( 'Full Content', 'Avada' )
	),
	__( 'Choose to show a text excerpt or full content.', 'Avada' )
);

$this->text(
	'portfolio_excerpt',
	__( 'Excerpt Length', 'Avada' ),
	__( 'Insert the number of words you want to show in the post excerpts.', 'Avada' )
);

$types = get_terms( 'portfolio_category', 'hide_empty=0' );
$types_array[0] = __( 'All categories', 'Avada' );

if( $types ) {

	foreach( $types as $type ) {
		$types_array[$type->term_id] = $type->name;
	}

	$this->multiple(
		'portfolio_category',
		__( 'Portfolio Type', 'Avada' ),
		$types_array,
		__( 'Choose what portfolio category you want to display on this page. Leave blank for all categories.', 'Avada' )
	);

}

$this->select(
	'portfolio_filters',
	__( 'Show Portfolio Filters', 'Avada' ),
	array(
		'yes'             => __( 'Show', 'Avada' ),
		'yes_without_all' => __( 'Show without "All"', 'Avada' ),
		'no'              => __( 'Hide', 'Avada' )
	),
	__( 'Choose to show or hide the portfolio filters.', 'Avada' )
);

$this->select(
	'portfolio_text_layout',
	__( 'Portfolio Text Layout', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'boxed'   => __( 'Boxed', 'Avada' ),
		'unboxed' => __( 'Unboxed', 'Avada' )
	),
	__( 'Select if the portfolio text layouts are boxed or unboxed.', 'Avada' )
);

$this->select(
	'portfolio_featured_image_size',
	__( 'Portfolio Featured Image Size', 'Avada' ),
	array(
		'default' => __( 'Default', 'Avada' ),
		'cropped' => __( 'Fixed', 'Avada' ),
		'full'    => __( 'Auto', 'Avada' )
	),
	__( 'Choose if the featured images are fixed (cropped) or auto (full image ratio) for all portfolio column page templates. IMPORTANT: Fixed images work best with smaller site widths. Auto images work best with larger site widths.', 'Avada' )
);

$this->text(
	'portfolio_column_spacing',
	__( 'Column Spacing', 'Avada' ),
	__( 'Insert the amount of spacing between portfolio items. ex: 7px', 'Avada' )
);

// Omit closing PHP tag to avoid "Headers already sent" issues.

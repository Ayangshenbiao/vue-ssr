<?php
$weight 	= array(__('Default','avia_framework') => '' , __('Normal','avia_framework') =>'normal', __('Bold','avia_framework')=>'bold', __('Light','avia_framework')=>'lighter');
$transform 	= array(__('Default','avia_framework') => '' , __('None'  ,'avia_framework') =>'none', __('Uppercase','avia_framework')=>'uppercase', __('Lowercase','avia_framework')=>'lowercase');
$align 	= array(__('Default','avia_framework') => '' , __('Left'  ,'avia_framework') =>'left', __('Center','avia_framework')=>'center', __('Right','avia_framework')=>'right');


$advanced = array();

$advanced['strong'] = array(
	"id"			=> "strong", //needs to match array key
	"name"			=> "&lt;strong&gt;",
	"group" 		=> __("Tags",'avia_framework'),
	"description"	=> __("Change the styling for all &lt;strong&gt; tags",'avia_framework'),
	"selector"		=> array("#top [sections] strong" => ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
							)
);

$advanced['blockquote'] = array(
	"id"			=> "blockquote", //needs to match array key
	"name"			=> "&lt;blockquote&gt;",
	"group" 		=> __("Tags",'avia_framework'),
	"description"	=> __("Change the styling for all &lt;blockquote&gt; tags",'avia_framework'),
	"selector"		=> array("#top [sections] blockquote"=> ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'border_color' 		=> array('type' => 'colorpicker', 'name'=> __("Border Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-80', 'name'=> __("Font Size",'avia_framework')),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
							)
);



$advanced['headings_all'] = array(
	"id"			=> "headings_all", //needs to match array key
	"name"			=> "All Headings (H1-H6)",
	"group" 		=> __("Headings",'avia_framework'),
	"description"	=> __("Change the styling for all Heading tags",'avia_framework'),
	"selector"		=> array("#top #wrap_all [sections] h1, #top #wrap_all [sections] h2, #top #wrap_all [sections] h3, #top #wrap_all [sections] h4, #top #wrap_all [sections] h5, #top #wrap_all [sections] h6"=> ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),							
								)

);

$advanced['h1'] = array(
	"id"			=> "h1", //needs to match array key
	"name"			=> "H1",
	"group" 		=> __("Headings",'avia_framework'),
	"description"	=> __("Change the styling for your H1 Tag",'avia_framework'),
	"selector"		=> array("#top #wrap_all [sections] h1"=> ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-80', 'name'=> __("Font Size",'avia_framework')),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),
							)

);





$advanced['h2'] = array(
	"id"			=> "h2", //needs to match array key
	"name"			=> "H2",
	"group" 		=> __("Headings",'avia_framework'),
	"description"	=> __("Change the styling for your H2 Tag",'avia_framework'),
	"selector"		=> array("#top #wrap_all [sections] h2"=> ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-80', 'name'=> __("Font Size",'avia_framework')),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),		
								)
);

$advanced['h3'] = array(
	"id"			=> "h3", //needs to match array key
	"name"			=> "H3",
	"group" 		=> __("Headings",'avia_framework'),
	"description"	=> __("Change the styling for your H3 Tag",'avia_framework'),
	"selector"		=> array("#top #wrap_all [sections] h3"=> ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-80', 'name'=> __("Font Size",'avia_framework')),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),		
							)
);

$advanced['h4'] = array(
	"id"			=> "h4", //needs to match array key
	"name"			=> "H4",
	"group" 		=> __("Headings",'avia_framework'),
	"description"	=> __("Change the styling for your H4 Tag",'avia_framework'),
	"selector"		=> array("#top #wrap_all [sections] h4"=> ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-80', 'name'=> __("Font Size",'avia_framework')),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),		
							)
);

$advanced['h5'] = array(
	"id"			=> "h5", //needs to match array key
	"name"			=> "H5",
	"group" 		=> __("Headings",'avia_framework'),
	"description"	=> __("Change the styling for your H5 Tag",'avia_framework'),
	"selector"		=> array("#top #wrap_all [sections] h5"=> ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-80', 'name'=> __("Font Size",'avia_framework')),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),		
							)
);

$advanced['h6'] = array(
	"id"			=> "h6", //needs to match array key
	"name"			=> "H6",
	"group" 		=> __("Headings",'avia_framework'),
	"description"	=> __("Change the styling for your H6 Tag",'avia_framework'),
	"selector"		=> array("#top #wrap_all [sections] h6"=> ""),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-80', 'name'=> __("Font Size",'avia_framework')),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),		
							)
);



$advanced['main_menu'] = array(
	"id"			=> "main_menu", //needs to match array key
	"name"			=> __("Main Menu Links",'avia_framework'),
	"group" 		=> __("Main Menu",'avia_framework'),
	"description"	=> __("Change the styling for your main menu links",'avia_framework'),
	"selector"		=> array(
		/*trick: hover is used inside the selector to prevent it from beeing applied when :hover is checked*/
		"#top #header[hover]_main_alternate" => array(  "background_color" => "background-color: %background_color%;" ),
		"#top #header .av-main-nav > li[hover] " => array(  "font_family" => "font-family: %font_family%;" ),
		"#top #header .av-main-nav > li[hover] > a" => "",
		".av_seperator_small_border .av-main-nav > li[hover] > a > .avia-menu-text,
		#top #wrap_all #header #menu-item-search[hover]>a
		
		"=> array(  "border_color" => "border-color: %border_color%;" ),
		"#top #header .av-main-nav > li[hover] > a .avia-menu-text, #top #header .av-main-nav > li[hover] > a .avia-menu-subtext"=> array(  "color" => "color: %color%;" )
	),
	"sections"		=> false,
	"hover"			=> true,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'border_color' 		=> array('type' => 'colorpicker', 'name'=> __("Border Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-30', 'name'=> __("Font Size",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
							)						
);


$advanced['main_menu_dropdown'] = array(
	"id"			=> "main_menu_dropdown", //needs to match array key
	"name"			=> __("Main Menu sublevel Links",'avia_framework'),
	"group" 		=> __("Main Menu",'avia_framework'),
	"description"	=> __("Change the styling for your main menu dropdown links",'avia_framework'),
	"selector"		=> array("#top #wrap_all .av-main-nav ul > li[hover] > a, #top #wrap_all .avia_mega_div, #top #wrap_all .avia_mega_div ul, #top #wrap_all .av-main-nav ul ul"=> ""),
	"sections"		=> false,
	"hover"			=> true,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'border_color' 		=> array('type' => 'colorpicker', 'name'=> __("Border Color",'avia_framework')),
								'font_size' 		=> array('type' => 'size', 'range' => '10-30', 'name'=> __("Font Size",'avia_framework')),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-3', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
							)						
);

$advanced['top_bar'] = array(
	"id"			=> "top_bar", //needs to match array key
	"name"			=> __("Small bar above Main Menu",'avia_framework'),
	"group" 		=> __("Main Menu",'avia_framework'),
	"description"	=> __("Change the styling for the small bar above the main menu which can contain social icons, a second menu and a phone number ",'avia_framework'),
	"selector"		=> array(
							 	"#top #header_meta, #top #header_meta nav ul ul li, #top #header_meta nav ul ul a, #top #header_meta nav ul ul" => array("background_color" => "background-color: %background_color%;"), 
							 	"#top #header_meta a, #top #header_meta li, #top #header_meta .phone-info" => array( "border_color" => "border-color: %border_color%;", "color" => "color: %color%;"),
							 	"#top #header_meta" => array("font_family" => "font-family: %font_family%;"), 
							 	
							 ),
	"sections"		=> false,
	"hover"			=> false,
	"edit"			=> array(	'color' 			=> array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework')), 
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework')),
								'border_color' 		=> array('type' => 'colorpicker', 'name'=> __("Border Color",'avia_framework')),
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
							)						
);


$advanced['hover_overlay'] = array(
	"id"			=> "hover_overlay", //needs to match array key
	"name"			=> __("Linked Image Overlay",'avia_framework'),
	"group" 		=> __("Misc",'avia_framework'),
	"description"	=> __("Change the styling for the overlay that appears when you place your mouse cursor above a linked image",'avia_framework'),
	"selector"		=> array(  
								"#top [sections] .image-overlay-inside" => array("overlay_style" => array( "none" , "display: none;") ),
								"#top [sections] .image-overlay" 		=> array("background_color" => "background-color: %background_color%;", "overlay_style" => array( "hide" , "visibility: hidden;")),   
								"#top [sections] .image-overlay .image-overlay-inside:before" => array( "icon_color" => "background-color: %icon_color%;", "color" => "color: %color%;" )
							),
							
							
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	'overlay_style' 	=> array('type' => 'select', 'name'=> __("Overlay Style",'avia_framework'), 'options' => array(__('Default','avia_framework') => '' , __('Minimal Overlay (No Icon)','avia_framework') =>'none' , __('Disable Overlay','avia_framework') =>'hide' )) ,		
								'color' 			=> array('type' => 'colorpicker', 'name'=> __("Icon Color",'avia_framework')), 
								'icon_color' 		=> array('type' => 'colorpicker', 'name'=> __("Icon background",'avia_framework')),
								'background_color' 	=> array('type' => 'colorpicker', 'name'=> __("Overlay Color",'avia_framework')),
							)						
);


$advanced['buttons'] = array(
	"id"			=> "buttons", //needs to match array key
	"name"			=> "Buttons",
	"group" 		=> __("Misc",'avia_framework'),
	"description"	=> __("Change the styling of your buttons",'avia_framework'),
	"selector"		=> array("#top #wrap_all .avia-slideshow-button, #top .avia-button, .html_elegant-blog .more-link, .avia-slideshow-arrows a:before, #top .av-menu-button > a .avia-menu-text"=> ""),
	"sections"		=> false,
	"hover"			=> false,
	"edit"			=> array(	
								'border_radius' => array('type' => 'size', 'range' => '0-100', 'name'=> __("Border Radius",'avia_framework')),
							)
);


$advanced['widget_title'] = array(
	"id"			=> "widget_title", //needs to match array key
	"name"			=> "Widget title",
	"group" 		=> __("Misc",'avia_framework'),
	"description"	=> __("Change the styling of your widget title",'avia_framework'),
	"selector"		=> array(
						"#top [sections] .widgettitle" => array("style" => array( "border" , "border-style:solid; border-width:1px; padding:10px; text-align:center; margin-bottom:15px") ),
						"html #top [sections] .widgettitle" => array("style" => array( "border-tp" , "border-style:solid; border-width:1px; padding:10px 0; border-left:none; border-right:none; margin-bottom:15px") ),
						"body#top [sections] .widgettitle" => array( "border_color" => "border-color: %border_color%;", "background_color" => "background-color: %background_color%;", "color" => "color: %color%;", "text_align" => "text-align: %text_align%;"),
						
							),
	"sections"		=> true,
	"hover"			=> false,
	"edit"			=> array(	
								'style' 	=> array(
													'type' => 'select', 
													'name'=> __("Overlay Style",'avia_framework'), 
													'options' => array(
														__('No Border','avia_framework') => '' , 
														__('Border on top and bottom','avia_framework') =>'border-tp' , 
														__('Border around the widget title','avia_framework') =>'border' , 
													)
												) ,
								'border_color' => array('type' => 'colorpicker', 'name'=> __("Border Color",'avia_framework') ),
								'background_color' => array('type' => 'colorpicker', 'name'=> __("Background Color",'avia_framework') ),
								'color' => array('type' => 'colorpicker', 'name'=> __("Font Color",'avia_framework') ),
								'text_align' 	=> array('type' => 'select', 'name'=> __("Text Align",'avia_framework'), 'options' => $align ),							
							)
);

$advanced['slideshow_titles'] = array(
	"id"			=> "slideshow_titles", //needs to match array key
	"name"			=> "Slideshow titles",
	"group" 		=> __("Misc",'avia_framework'),
	"description"	=> __("Change the styling for your fullscreen, fullwidth and easy slider title",'avia_framework'),
	"selector"		=> array("#top #wrap_all .slideshow_caption h2.avia-caption-title, #top #wrap_all .av-slideshow-caption h2.avia-caption-title"=> ""),
	"sections"		=> false,
	"hover"			=> false,
	"edit"			=> array(	
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'letter_spacing' 	=> array('type' => 'size', 'range' => array(-10,20), 'increment' => 1, 'unit' => 'px',  'name'=> __("Letter Spacing",'avia_framework')),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),
							)
);


$advanced['slideshow_caption'] = array(
	"id"			=> "slideshow_caption", //needs to match array key
	"name"			=> "Slideshow caption",
	"group" 		=> __("Misc",'avia_framework'),
	"description"	=> __("Change the styling for your fullscreen, fullwidth and easy slider caption",'avia_framework'),
	"selector"		=> array("#top #wrap_all .avia-caption-content p"=> ""),
	"sections"		=> false,
	"hover"			=> false,
	"edit"			=> array(	
								'font_family' 		=> array('type' => 'font', 'name'=> __("Font Family",'avia_framework'), 'options' => $google_fonts),
								'font_weight' 		=> array('type' => 'select', 'name'=> __("Font Weight",'avia_framework'), 'options' => $weight),
								'line_height' 		=> array('type' => 'size', 'range' => '0.7-2', 'increment' => 0.1, 'unit' => 'em',  'name'=> __("Line Height",'avia_framework')),
								'letter_spacing' 	=> array('type' => 'size', 'range' => array(-10,20), 'increment' => 1, 'unit' => 'px',  'name'=> __("Letter Spacing",'avia_framework')),
								'text_transform' 	=> array('type' => 'select', 'name'=> __("Text Transform",'avia_framework'), 'options' => $transform ),
							)
);




//body font size
//dropdown menu
//icon colors
//hover states
//links
// all sections/specific section
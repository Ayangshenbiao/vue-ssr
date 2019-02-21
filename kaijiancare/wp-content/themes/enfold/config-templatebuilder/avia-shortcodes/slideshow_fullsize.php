<?php
/**
 * Slider
 * Shortcode that allows to display a simple slideshow
 */

if ( !class_exists( 'avia_sc_slider_full' ) ) 
{
	class avia_sc_slider_full extends aviaShortcodeTemplate
	{
			static $slide_count = 0;
	
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']			= __('Fullwidth Easy Slider', 'avia_framework' );
				$this->config['tab']			= __('Media Elements', 'avia_framework' );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-slideshow-full.png";
				$this->config['order']			= 80;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'av_slideshow_full';
				$this->config['shortcode_nested'] = array('av_slide_full');
				$this->config['tooltip'] 	    = __('Display a simple fullwidth slideshow element', 'avia_framework' );
				$this->config['tinyMCE'] 		= array('disable' => "true");
				$this->config['drag-level'] 	= 1;
			}

			/**
			 * Popup Elements
			 *
			 * If this function is defined in a child class the element automatically gets an edit button, that, when pressed
			 * opens a modal window that allows to edit the element properties
			 *
			 * @return void
			 */
			function popup_elements()
			{
				$this->elements = array(
					
					
					array(	
							"type" 			=> "modal_group", 
							"id" 			=> "content",
							'container_class' =>"avia-element-fullwidth avia-multi-img",
							"modal_title" 	=> __("Edit Form Element", 'avia_framework' ),
							"add_label"		=>  __("Add single image or video", 'avia_framework' ),
							"std"			=> array(),
							
							'creator'		=>array(
								
										"name" => __("Add Images", 'avia_framework' ),
										"desc" => __("Here you can add new Images to the slideshow.", 'avia_framework' ),
										"id" 	=> "id",
										"type" 	=> "multi_image",
										"title" => __("Add multiple Images",'avia_framework' ),
										"button" => __("Insert Images",'avia_framework' ),
										"std" 	=> ""
										),
															
							'subelements' 	=> array(
							
									array(
											"type" 	=> "tab_container", 'nodescription' => true
										),
										
									array(
											"type" 	=> "tab",
											"name"  => __("Slide" , 'avia_framework'),
											'nodescription' => true
										),
									
									array(	
										"name" 	=> __("Which type of slide is this?",'avia_framework' ),
										"id" 	=> "slide_type",
										"type" 	=> "select",
										"std" 	=> "",
										"subtype" => array(   __('Image Slide','avia_framework' )	=>'image',
										                      __('Video Slide','avia_framework' )	=>'video',
										                      )
								    ),
									
									array(	
									"name" 	=> __("Choose another Image",'avia_framework' ),
									"desc" 	=> __("Either upload a new, or choose an existing image from your media library",'avia_framework' ),
									"id" 	=> "id",
									"fetch" => "id",
									"type" 	=> "image",
									"required"=> array('slide_type','is_empty_or','image'),
									"title" => __("Change Image",'avia_framework' ),
									"button" => __("Change Image",'avia_framework' ),
									"std" 	=> ""),
									
									array(	
									"name" 	=> __("Video URL", 'avia_framework' ),
									"desc" 	=> __('Enter the URL to the Video. Currently supported are Youtube, Vimeo and direct linking of web-video files (mp4, webm, ogv)', 'avia_framework' ) .'<br/><br/>'.
									__('Working examples Youtube & Vimeo:', 'avia_framework' ).'<br/>
								<strong>http://vimeo.com/1084537</strong><br/> 
								<strong>http://www.youtube.com/watch?v=5guMumPFBag</strong><br/><br/>',
									"required"=> array('slide_type','equals','video'),
									"id" 	=> "video",
									"std" 	=> "http://",
									"type" 	=> "video",
									"title" => __("Upload Video",'avia_framework' ),
									"button" => __("Use Video",'avia_framework' ),
									),
									
									array(	
									"name" 	=> __("Choose fallback image for mobile devices",'avia_framework' ),
									"desc" 	=> __("Either upload a new, or choose an existing image from your media library",'avia_framework' )."<br/><small>".__("Video on most mobile devices can't be controlled properly with JavaScript, which is mandatory here, therefore you are required to select a fallback image which can be displayed instead", 'avia_framework' ) ."</small>" ,
									"id" 	=> "mobile_image",
									"fetch" => "id",
									"type" 	=> "image",
									"required"=> array('slide_type','equals','video'),
									"title" => __("Choose Image",'avia_framework' ),
									"button" => __("Choose Image",'avia_framework' ),
									"std" 	=> ""),
									
									array(	
									"name" 	=> __("Video Size", 'avia_framework' ),
									"desc" 	=> __("By default the video will try to match the default slideshow size that was selected in the slider settings at 'Slideshow Image and Video Size'", 'avia_framework' ),
									"id" 	=> "video_format",
									"type" 	=> "select",
									"std" 	=> "",
									"required"=> array('slide_type','equals','video'),
									"subtype" => array( 
														__('Try to match the default slideshow size (Video will not be cropped, but black borders will be visible at each side)',  'avia_framework' ) 	=>'',
														__('Try to match the default slideshow size but stretch the video to fill the whole slider (video will be cropped at top and bottom)',  'avia_framework' ) 	=>'stretch',
														__('Show the full Video without cropping',  'avia_framework' ) =>'full',
														)		
									),
									
									array(	
									"name" 	=> __("Video Aspect Ratio", 'avia_framework' ),
									"desc" 	=> __("In order to calculate the correct height and width for the video slide you need to enter a aspect ratio (width:height). usually: 16:9 or 4:3.", 'avia_framework' )."<br/>".__("If left empty 16:9 will be used", 'avia_framework' ) ,
									"id" 	=> "video_ratio",
									"required"=> array('video_format','not',''),
									"std" 	=> "16:9",
									"type" 	=> "input"),
									
									
									 array(	
									"name" 	=> __("Hide Video Controls", 'avia_framework' ),
									"desc" 	=> __("Check if you want to hide the controls (works for youtube and self hosted videos)", 'avia_framework' ) ,
									"id" 	=> "video_controls",
									"required"=> array('slide_type','equals','video'),
									"std" 	=> "",
									"type" 	=> "checkbox"),
									
									array(	
									"name" 	=> __("Mute Video Player", 'avia_framework' ),
									"desc" 	=> __("Check if you want to mute the video", 'avia_framework' ) ,
									"id" 	=> "video_mute",
									"required"=> array('slide_type','equals','video'),
									"std" 	=> "",
									"type" 	=> "checkbox"),
									
									array(	
									"name" 	=> __("Loop Video Player", 'avia_framework' ),
									"desc" 	=> __("Check if you want to loop the video (instead of showing the next slide the video will play from the beginning again)", 'avia_framework' ) ,
									"id" 	=> "video_loop",
									"required"=> array('slide_type','equals','video'),
									"std" 	=> "",
									"type" 	=> "checkbox"),
									
									array(	
									"name" 	=> __("Disable Autoplay", 'avia_framework' ),
									"desc" 	=> __("Check if you want to disable video autoplay when this slide shows", 'avia_framework' ) ,
									"id" 	=> "video_autoplay",
									"required"=> array('slide_type','equals','video'),
									"std" 	=> "",
									"type" 	=> "checkbox"),
									
									
									
									
									array(
									"type" 	=> "close_div",
									'nodescription' => true
										),
									
									array(
											"type" 	=> "tab",
											"name"	=> __("Caption",'avia_framework' ),
											'nodescription' => true
										),
									
									
									array(	
									"name" 	=> __("Caption Title", 'avia_framework' ),
									"desc" 	=> __("Enter a caption title for the slide here", 'avia_framework' ) ,
									"id" 	=> "title",
									"std" 	=> "",
									"container_class" => 'av_half av_half_first',
									"type" 	=> "input"),
									
									array(	
									"name" 	=> __("Caption Title Font Size", 'avia_framework' ),
									"desc" 	=> __("Select a custom font size. Leave empty to use the default", 'avia_framework' ),
									"id" 	=> "custom_title_size",
									"type" 	=> "select",
									"std" 	=> "",
									"container_class" => 'av_half',
									"subtype" => AviaHtmlHelper::number_array(10,120,1, array( __("Default Size", 'avia_framework' )=>''), 'px'),
										),
									
									 array(	
									"name" 	=> __("Caption Text", 'avia_framework' ),
									"desc" 	=> __("Enter some additional caption text", 'avia_framework' ) ,
									"id" 	=> "content",
									"type" 	=> "textarea",
									"container_class" => 'av_half av_half_first',
									"std" 	=> "",
									),
									
									array(	
									"name" 	=> __("Caption Text Font Size", 'avia_framework' ),
									"desc" 	=> __("Select a custom font size. Leave empty to use the default", 'avia_framework' ),
									"id" 	=> "custom_content_size",
									"type" 	=> "select",
									"std" 	=> "",
									"container_class" => 'av_half av_no_bottom',
									"subtype" => AviaHtmlHelper::number_array(10,90,1, array( __("Default Size", 'avia_framework' )=>''), 'px'),
									),	
									
									
									array(	
									"name" 	=> __("Caption Positioning",'avia_framework' ),
									"id" 	=> "caption_pos",
									"type" 	=> "select",
									"std" 	=> "caption_bottom",
									"subtype" => array(
                                        __('Right Framed',  		'avia_framework' )=>'caption_right caption_right_framed caption_framed',
										__('Left Framed',  			'avia_framework' )=>'caption_left caption_left_framed caption_framed', 
										__('Bottom Framed',  		'avia_framework' )=>'caption_bottom caption_bottom_framed caption_framed',
										__('Center Framed',  		'avia_framework' )=>'caption_center caption_center_framed caption_framed',
										__('Right without Frame',  	'avia_framework' )=>'caption_right',
										__('Left without Frame',  	'avia_framework' )=>'caption_left',
										__('Bottom without Frame',  'avia_framework' )=>'caption_bottom',
										__('Center without Frame',  'avia_framework' )=>'caption_center'
											),
									),
									
									array(	
									"name" 	=> __("Apply a link or buttons to the slide?", 'avia_framework' ),
									"desc" 	=> __("You can choose to apply the link to the whole image or to add 'Call to Action Buttons' that get appended to the caption", 'avia_framework' ),
									"id" 	=> "link_apply",
									"type" 	=> "select",
									"std" 	=> "",
									"subtype" => array(
										__('No Link for this slide',  	'avia_framework' ) =>'',
										__('Apply Link to Image',  		'avia_framework' ) =>'image',
										__('Attach one button',  		'avia_framework' ) =>'button',
										__('Attach two buttons',  		'avia_framework' ) =>'button button-two')),
									
									
									array(	
									"name" 	=> __("Image Link?", 'avia_framework' ),
									"desc" 	=> __("Where should the Image link to?", 'avia_framework' ),
									"id" 	=> "link",
									"required"=> array('link_apply','equals','image'),
									"type" 	=> "linkpicker",
									"fetchTMPL"	=> true,
									"subtype" => array(	
														__('Open Image in Lightbox', 'avia_framework' ) =>'lightbox',
														__('Set Manually', 'avia_framework' ) =>'manually',
														__('Single Entry', 'avia_framework' ) => 'single',
														__('Taxonomy Overview Page',  'avia_framework' ) => 'taxonomy',
														),
									"std" 	=> ""),
							
									array(	
									"name" 	=> __("Open Link in new Window?", 'avia_framework' ),
									"desc" 	=> __("Select here if you want to open the linked page in a new window", 'avia_framework' ),
									"id" 	=> "link_target",
									"type" 	=> "select",
									"std" 	=> "",
									"required"=> array('link','not_empty_and','lightbox'),
									"subtype" => AviaHtmlHelper::linking_options()),   
										
									
										
									array(	"name" 	=> __("Button 1 Label", 'avia_framework' ),
											"desc" 	=> __("This is the text that appears on your button.", 'avia_framework' ),
								            "id" 	=> "button_label",
								            "type" 	=> "input",
								            "container_class" => 'av_half av_half_first',
											"required"=> array('link_apply','contains','button'),
								            "std" 	=> "Click me"),	
								            
								   	array(	
											"name" 	=> __("Button 1 Color", 'avia_framework' ),
											"desc" 	=> __("Choose a color for your button here", 'avia_framework' ),
											"id" 	=> "button_color",
											"type" 	=> "select",
											"std" 	=> "light",
								    		"container_class" => 'av_half',
											"required"=> array('link_apply','contains','button'),
											"subtype" => array(	
														__('Translucent Buttons', 'avia_framework' ) => array(
															__('Light Transparent', 'avia_framework' )=>'light',
															__('Dark Transparent', 'avia_framework' )=>'dark',
														),
														
														__('Colored Buttons', 'avia_framework' ) => array(
															__('Theme Color', 'avia_framework' )=>'theme-color',
															__('Theme Color Subtle', 'avia_framework' )=>'theme-color-subtle',
															__('Blue', 'avia_framework' )=>'blue',
															__('Red',  'avia_framework' )=>'red',
															__('Green', 'avia_framework' )=>'green',
															__('Orange', 'avia_framework' )=>'orange',
															__('Aqua', 'avia_framework' )=>'aqua',
															__('Teal', 'avia_framework' )=>'teal',
															__('Purple', 'avia_framework' )=>'purple',
															__('Pink', 'avia_framework' )=>'pink',
															__('Silver', 'avia_framework' )=>'silver',
															__('Grey', 'avia_framework' )=>'grey',
															__('Black', 'avia_framework' )=>'black',
														)
														
														)),
								array(	
									"name" 	=> __("Button 1 Link?", 'avia_framework' ),
									"desc" 	=> __("Where should the Button link to?", 'avia_framework' ),
									"id" 	=> "link1",
									"container_class" => 'av_half av_half_first',
									"required"=> array('link_apply','contains','button'),
									"type" 	=> "linkpicker",
									"fetchTMPL"	=> true,
									"subtype" => array(	
														__('Set Manually', 'avia_framework' ) =>'manually',
														__('Single Entry', 'avia_framework' ) => 'single',
														__('Taxonomy Overview Page',  'avia_framework' ) => 'taxonomy',
														),
									"std" 	=> ""),					
								
								array(	
									"name" 	=> __("Button 1 Link Target?", 'avia_framework' ),
									"desc" 	=> __("Select here if you want to open the linked page in a new window", 'avia_framework' ),
									"id" 	=> "link_target1",
									"type" 	=> "select",
									"std" 	=> "",
									"container_class" => 'av_half',
									"required"=> array('link_apply','contains','button'),
									"subtype" => AviaHtmlHelper::linking_options()),   						
								
								array(	"name" 	=> __("Button 2 Label", 'avia_framework' ),
											"desc" 	=> __("This is the text that appears on your second button.", 'avia_framework' ),
								            "id" 	=> "button_label2",
								            "type" 	=> "input",
								            "container_class" => 'av_half av_half_first',
											"required"=> array('link_apply','contains','button-two'),
								            "std" 	=> "Click me"),	
								            
								   	array(	
											"name" 	=> __("Button 2 Color", 'avia_framework' ),
											"desc" 	=> __("Choose a color for your second button here", 'avia_framework' ),
											"id" 	=> "button_color2",
											"type" 	=> "select",
											"std" 	=> "light",
								    		"container_class" => 'av_half',
											"required"=> array('link_apply','contains','button-two'),
											"subtype" => array(	
														__('Translucent Buttons', 'avia_framework' ) => array(
															__('Light Transparent', 'avia_framework' )=>'light',
															__('Dark Transparent', 'avia_framework' )=>'dark',
														),
														
														__('Colored Buttons', 'avia_framework' ) => array(
															__('Theme Color', 'avia_framework' )=>'theme-color',
															__('Theme Color Subtle', 'avia_framework' )=>'theme-color-subtle',
															__('Blue', 'avia_framework' )=>'blue',
															__('Red',  'avia_framework' )=>'red',
															__('Green', 'avia_framework' )=>'green',
															__('Orange', 'avia_framework' )=>'orange',
															__('Aqua', 'avia_framework' )=>'aqua',
															__('Teal', 'avia_framework' )=>'teal',
															__('Purple', 'avia_framework' )=>'purple',
															__('Pink', 'avia_framework' )=>'pink',
															__('Silver', 'avia_framework' )=>'silver',
															__('Grey', 'avia_framework' )=>'grey',
															__('Black', 'avia_framework' )=>'black',
														)
														
														)),
								array(	
									"name" 	=> __("Button 2 Link?", 'avia_framework' ),
									"desc" 	=> __("Where should the Button link to?", 'avia_framework' ),
									"id" 	=> "link2",
									"container_class" => 'av_half av_half_first',
									"required"=> array('link_apply','contains','button-two'),
									"type" 	=> "linkpicker",
									"fetchTMPL"	=> true,
									"subtype" => array(	
														__('Set Manually', 'avia_framework' ) =>'manually',
														__('Single Entry', 'avia_framework' ) => 'single',
														__('Taxonomy Overview Page',  'avia_framework' ) => 'taxonomy',
														),
									"std" 	=> ""),						
								
								array(	
									"name" 	=> __("Button 2 Link Target?", 'avia_framework' ),
									"desc" 	=> __("Select here if you want to open the linked page in a new window", 'avia_framework' ),
									"id" 	=> "link_target2",
									"type" 	=> "select",
									"std" 	=> "",
									"container_class" => 'av_half',
									"required"=> array('link_apply','contains','button-two'),
									"subtype" => AviaHtmlHelper::linking_options()), 
									
									
								array(
										"type" 	=> "close_div",
										'nodescription' => true
									),
								
								array(
										"type" 	=> "tab",
										"name"	=> __("Colors",'avia_framework' ),
										'nodescription' => true
									),
									
								array(
										"name" 	=> __("Font Colors", 'avia_framework' ),
										"desc" 	=> __("Either use the themes default colors or apply some custom ones", 'avia_framework' ),
										"id" 	=> "font_color",
										"type" 	=> "select",
										"std" 	=> "",
										"subtype" => array( __('Default', 'avia_framework' )=>'',
															__('Define Custom Colors', 'avia_framework' )=>'custom'),
								),	
								
								array(	
									"name" 	=> __("Custom Caption Title Font Color", 'avia_framework' ),
									"desc" 	=> __("Select a custom font color. Leave empty to use the default", 'avia_framework' ),
									"id" 	=> "custom_title",
									"type" 	=> "colorpicker",
									"std" 	=> "",
									"container_class" => 'av_half av_half_first',
									"required" => array('font_color','equals','custom')
										),	
										
								array(	
										"name" 	=> __("Custom Caption Content Font Color", 'avia_framework' ),
										"desc" 	=> __("Select a custom font color. Leave empty to use the default", 'avia_framework' ),
										"id" 	=> "custom_content",
										"type" 	=> "colorpicker",
										"std" 	=> "",
										"container_class" => 'av_half',
										"required" => array('font_color','equals','custom')
								
								),	
									
								array(
										"type" 	=> "close_div",
										'nodescription' => true
									),

								array(
										"type" 	=> "tab",
										"name"  => __("Slide Overlay" , 'avia_framework'),
										'nodescription' => true
									),
					
								array(	
										"name" 	=> __("Enable Overlay?", 'avia_framework' ),
										"desc" 	=> __("Check if you want to display a transparent color and/or pattern overlay above your slideshow image/video", 'avia_framework' ),
										"id" 	=> "overlay_enable",
										"std" 	=> "",
										"type" 	=> "checkbox"),
								
								 array(
									"name" 	=> __("Overlay Opacity",'avia_framework' ),
									"desc" 	=> __("Set the opacity of your overlay: 0.1 is barely visible, 1.0 is opaque ", 'avia_framework' ),
									"id" 	=> "overlay_opacity",
									"type" 	=> "select",
									"std" 	=> "0.5",
			                        "required" => array('overlay_enable','not',''),
									"subtype" => array(   __('0.1','avia_framework' )=>'0.1',
									                      __('0.2','avia_framework' )=>'0.2',
									                      __('0.3','avia_framework' )=>'0.3',
									                      __('0.4','avia_framework' )=>'0.4',
									                      __('0.5','avia_framework' )=>'0.5',
									                      __('0.6','avia_framework' )=>'0.6',
									                      __('0.7','avia_framework' )=>'0.7',
									                      __('0.8','avia_framework' )=>'0.8',
									                      __('0.9','avia_framework' )=>'0.9',
									                      __('1.0','avia_framework' )=>'1',
									                      )
							  		),
							  		
							  	array(
										"name" 	=> __("Overlay Color", 'avia_framework' ),
										"desc" 	=> __("Select a custom  color for your overlay here. Leave empty if you want no color overlay", 'avia_framework' ),
										"id" 	=> "overlay_color",
										"type" 	=> "colorpicker",
			                        	"required" => array('overlay_enable','not',''),
										"std" 	=> "",
									),
							  	
							  	array(
			                        "required" => array('overlay_enable','not',''),
									"id" 	=> "overlay_pattern",
									"name" 	=> __("Background Image", 'avia_framework'),
									"desc" 	=> __("Select an existing or upload a new background image", 'avia_framework'),
									"type" 	=> "select",
									"subtype" => array(__('No Background Image', 'avia_framework')=>'',__('Upload custom image', 'avia_framework')=>'custom'),
									"std" 	=> "",
									"folder" => "images/background-images/",
									"folderlabel" => "",
									"group" => "Select predefined pattern",
									"exclude" => array('fullsize-', 'gradient')
								),
							  	
							  	
							  	array(
										"name" 	=> __("Custom Pattern",'avia_framework' ),
										"desc" 	=> __("Upload your own seamless pattern",'avia_framework' ),
										"id" 	=> "overlay_custom_pattern",
										"type" 	=> "image",
										"fetch" => "url",
										"secondary_img"=>true,
			                        	"required" => array('overlay_pattern','equals','custom'),
										"title" => __("Insert Pattern",'avia_framework' ),
										"button" => __("Insert",'avia_framework' ),
										"std" 	=> ""),
								
								array(
										"type" 	=> "close_div",
										'nodescription' => true
									),
								
								
		
									
								array(
										"type" 	=> "close_div",
										'nodescription' => true
									),
				
							)	          
										
					),
							
					array(	
							"name" 	=> __("Slideshow Image and Video Size", 'avia_framework' ),
							"desc" 	=> __("Choose image and Video size for your slideshow.", 'avia_framework' ),
							"id" 	=> "size",
							"type" 	=> "select",
							"std" 	=> "featured",
							"subtype" =>  AviaHelper::get_registered_image_sizes(1000)		
							),
					
					array(	
						"name" 	=> __("Stretch image to fit the slideshow size?",'avia_framework' ),
						"desc" 	=> __("By default the image stretches across the full width of the screen. You can deactivate this behavior and simply align it in the center of the slider",'avia_framework' ),
						"id" 	=> "stretch",
						"type" 	=> "select",
						"std" 	=> "",
						"subtype" => array(__('Yes, stretch the image','avia_framework' ) =>'',__('No, dont stretch the image. If the browser window is bigger than the image simply align it centered','avia_framework' ) =>'image_no_stretch')),	
								
					array(	
							"name" 	=> __("Slideshow Transition", 'avia_framework' ),
							"desc" 	=> __("Choose the transition for your Slideshow.", 'avia_framework' ),
							"id" 	=> "animation",
							"type" 	=> "select",
							"std" 	=> "slide",
							"subtype" => array(__('Slide sidewards','avia_framework' ) =>'slide', __('Slide up/down','avia_framework' ) =>'slide_up', __('Fade','avia_framework' ) =>'fade'),
							),
							
					array(	
						"name" 	=> __("Autorotation active?",'avia_framework' ),
						"desc" 	=> __("Check if the slideshow should rotate by default",'avia_framework' ),
						"id" 	=> "autoplay",
						"type" 	=> "select",
						"std" 	=> "false",
						"subtype" => array(__('Yes','avia_framework' ) =>'true',__('No','avia_framework' ) =>'false')),	
						
					array(	
						"name" 	=> __("Stop Autorotation with the last slide", 'avia_framework' ),
						"desc" 	=> __("Check if you want to disable autorotation when this last slide is displayed", 'avia_framework' ) ,
						"id" 	=> "autoplay_stopper",
						"required"=> array('autoplay','equals','true'),
						"std" 	=> "",
						"type" 	=> "checkbox"),
			
					array(	
						"name" 	=> __("Slideshow autorotation duration",'avia_framework' ),
						"desc" 	=> __("Images will be shown the selected amount of seconds.",'avia_framework' ),
						"id" 	=> "interval",
						"type" 	=> "select",
						"std" 	=> "5",
						"subtype" => 
						array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7','8'=>'8','9'=>'9','10'=>'10','15'=>'15','20'=>'20','30'=>'30','40'=>'40','60'=>'60','100'=>'100')),
					
					
					array(	
						"name" 	=> __("Slideshow control styling?",'avia_framework' ),
						"desc" 	=> __("Here you can select if and how to display the slideshow controls",'avia_framework' ),
						"id" 	=> "control_layout",
						"type" 	=> "select",
						"std" 	=> "av-control-default",
						"subtype" => array(__('Default','avia_framework' ) =>'av-control-default',__('Minimal','avia_framework' ) =>'av-control-minimal',__('Hidden','avia_framework' ) =>'av-control-hidden')),	
						
					array(	
						"name" 	=> __("Use first slides caption as permanent caption", 'avia_framework' ),
						"desc" 	=> __("If checked the caption will be placed on top of the slider. Please be aware that all slideshow link settings and other captions will be ignored then", 'avia_framework' ) ,
						"id" 	=> "perma_caption",
						"std" 	=> "",
						"type" 	=> "checkbox"),
				     
					array(	
							"name" 	=> __("Slideshow Background Image",'avia_framework' ),
							"desc" 	=> __("If you are displaying transparent images like pngs you can set a static background image or pattern that will appear behind those pngs.",'avia_framework' ),
							"id" 	=> "src",
							"type" 	=> "image",
							"title" => __("Insert Image",'avia_framework' ),
							"button" => __("Insert",'avia_framework' ),
							"std" 	=> ""),
							
                    array(	
						"name" 	=> __("Background Image Position",'avia_framework' ),
						"id" 	=> "position",
						"type" 	=> "select",
						"std" 	=> "top left",
                        "required" => array('src','not',''),
						"subtype" => array(   __('Top Left','avia_framework' )       =>'top left',
						                      __('Top Center','avia_framework' )     =>'top center',
						                      __('Top Right','avia_framework' )      =>'top right', 
						                      __('Bottom Left','avia_framework' )    =>'bottom left',
						                      __('Bottom Center','avia_framework' )  =>'bottom center',
						                      __('Bottom Right','avia_framework' )   =>'bottom right', 
						                      __('Center Left','avia_framework' )    =>'center left',
						                      __('Center Center','avia_framework' )  =>'center center',
						                      __('Center Right','avia_framework' )   =>'center right'
						                      )
				    ),
						
	               array(	
						"name" 	=> __("Background Repeat",'avia_framework' ),
						"id" 	=> "repeat",
						"type" 	=> "select",
						"std" 	=> "no-repeat",
                        "required" => array('src','not',''),
						"subtype" => array(   __('No Repeat','avia_framework' )          =>'no-repeat',
						                      __('Repeat','avia_framework' )             =>'repeat',
						                      __('Tile Horizontally','avia_framework' )  =>'repeat-x',
						                      __('Tile Vertically','avia_framework' )    =>'repeat-y',
						                      __('Stretch to fit','avia_framework' )     =>'stretch'
						                      )
				  ),
						
	               array(	
						"name" 	=> __("Background Attachment",'avia_framework' ),
						"id" 	=> "attach",
						"type" 	=> "select",
						"std" 	=> "scroll",
                        "required" => array('src','not',''),
						"subtype" => array(__('Scroll','avia_framework' )=>'scroll',__('Fixed','avia_framework' ) =>'fixed')
						),
						
					
				);

			}
			
			/**
			 * Editor Element - this function defines the visual appearance of an element on the AviaBuilder Canvas
			 * Most common usage is to define some markup in the $params['innerHtml'] which is then inserted into the drag and drop container
			 * Less often used: $params['data'] to add data attributes, $params['class'] to modify the className
			 *
			 *
			 * @param array $params this array holds the default values for $content and $args. 
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_element($params)
			{	
				$params['innerHtml'] = "<img src='".$this->config['icon']."' title='".$this->config['name']."' />";
				$params['innerHtml'].= "<div class='avia-element-label'>".$this->config['name']."</div>";
				return $params;
			}
			
			/**
			 * Editor Sub Element - this function defines the visual appearance of an element that is displayed within a modal window and on click opens its own modal window
			 * Works in the same way as Editor Element
			 * @param array $params this array holds the default values for $content and $args. 
			 * @return $params the return array usually holds an innerHtml key that holds item specific markup.
			 */
			function editor_sub_element($params)
			{	
			
				$img_template 		= $this->update_template("img_fakeArg", "{{img_fakeArg}}");
				$template 			= $this->update_template("title", "{{title}}");
				$content 			= $this->update_template("content", "{{content}}");
				$video 				= $this->update_template("video", "{{video}}");
				$thumbnail = isset($params['args']['id']) ? wp_get_attachment_image($params['args']['id']) : "";
				
		
				$params['innerHtml']  = "";
				$params['innerHtml'] .= "<div class='avia_title_container'>";
				$params['innerHtml'] .=	"	<div ".$this->class_by_arguments('slide_type' ,$params['args']).">";
				$params['innerHtml'] .= "		<span class='avia_slideshow_image' {$img_template} >{$thumbnail}</span>";
				$params['innerHtml'] .= "		<div class='avia_slideshow_content'>";
				$params['innerHtml'] .= "			<h4 class='avia_title_container_inner' {$template} >".$params['args']['title']."</h4>";
				$params['innerHtml'] .= "			<p class='avia_content_container' {$content}>".stripslashes($params['content'])."</p>";
				$params['innerHtml'] .= "			<small class='avia_video_url' {$video}>".stripslashes($params['args']['video'])."</small>";
				$params['innerHtml'] .= "		</div>";
				$params['innerHtml'] .= "	</div>";
				$params['innerHtml'] .= "</div>";
				
				
				
				return $params;
			}
			
			
			
			/**
			 * Frontend Shortcode Handler
			 *
			 * @param array $atts array of attributes
			 * @param string $content text within enclosing form of shortcode element 
			 * @param string $shortcodename the shortcode found, when == callback name
			 * @return string $output returns the modified html string 
			 */
			function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
			{
				$atts = shortcode_atts(array(
				'size'			=> 'featured',
				'animation'		=> 'slide',
				'ids'    	 	=> '',
				'autoplay'		=> 'false',
				'interval'		=> 5,
				'handle'		=> $shortcodename,
				'src' 			=> '', 
				'position'	 	=> 'top left', 
				'repeat' 		=> 'no-repeat', 
				'attach' 		=> 'scroll',
				//'easing'		=> 'easeInOutQuint',
				'stretch'		=> '',
				'control_layout'=> 'av-control-default',
				'perma_caption'	=> '',
				'autoplay_stopper'=>'',
				'content'		=> ShortcodeHelper::shortcode2array($content, 1)
				
				), $atts, $this->config['shortcode']);
				
				extract($atts);
				$output  	= "";
				$background  = "";
			    $class = "";
			    
			    if($src != "")
			    {
			         if($repeat == 'stretch')
			         {
			             $background .= "background-repeat: no-repeat; ";
			             $class .= " avia-full-stretch";
			         }
			         else
			         {
			             $background .= "background-repeat: {$repeat}; ";
			         }
			    
			         $background .= "background-image: url({$src}); ";
			         $background .= "background-attachment: {$attach}; ";
			         $background .= "background-position: {$position}; ";
			    }
			    
			    if($background) $params['bg'] = "style = '{$background}'";
			    
				$skipSecond = false;
				avia_sc_slider_full::$slide_count++;
				
				$params['class'] = "avia-fullwidth-slider main_color avia-shadow ".$meta['el_class'].$class;
				$params['open_structure'] = false;
				
				//we dont need a closing structure if the element is the first one or if a previous fullwidth element was displayed before
				if(isset($meta['index']) && $meta['index'] == 0) $params['close'] = false;
				if(!empty($meta['siblings']['prev']['tag']) && in_array($meta['siblings']['prev']['tag'], AviaBuilder::$full_el_no_section )) $params['close'] = false;
				
				if(isset($meta['index']) && $meta['index'] != 0) $params['class'] .= " slider-not-first";
				
				$params['id'] = "full_slider_".avia_sc_slider_full::$slide_count;
				
				$output .=  avia_new_section($params);
				
				$slider  = new avia_slideshow($atts);
				$slider->set_extra_class($stretch);
				$output .= $slider->html();
				
				$output .= "</div>"; //close section
				
				
				//if the next tag is a section dont create a new section from this shortcode
				if(!empty($meta['siblings']['next']['tag']) && in_array($meta['siblings']['next']['tag'],  AviaBuilder::$full_el ))
				{
				    $skipSecond = true;
				}

				//if there is no next element dont create a new section.
				if(empty($meta['siblings']['next']['tag']))
				{
				    $skipSecond = true;
				}
				
				if(empty($skipSecond)) {
				
				$output .= avia_new_section(array('close'=>false, 'id' => "after_full_slider_".avia_sc_slider_full::$slide_count));
				
				}
				
				return $output;

			}
			
	}
}




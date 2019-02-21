<?php
/**
 * Slider
 * Shortcode that allows to display a simple slideshow
 */

if ( !class_exists( 'avia_sc_gmaps' ) ) 
{
	class avia_sc_gmaps extends aviaShortcodeTemplate
	{
			static $map_count = 0;
			static $js_vars   = array();
			
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']			= __('Google Map', 'avia_framework' );
				$this->config['tab']			= __('Media Elements', 'avia_framework' );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-maps.png";
				$this->config['order']			= 5;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'av_google_map';
				$this->config['shortcode_nested'] = array('av_gmap_location');
				$this->config['tooltip'] 	    = __('Display a google map with one or multiple locations', 'avia_framework' );
				$this->config['drag-level'] 	= 3;
			}
			
			
			function extra_assets()
			{
				if(is_admin() && isset($_POST['action']) && $_POST['action'] == "avia_ajax_av_google_map" )
				{
					$prefix  = is_ssl() ? "https" : "http";
					
            		wp_register_script( 'avia-google-maps-api', $prefix.'://maps.google.com/maps/api/js', array('jquery'), '3', true);
					
					$load_google_map_api = apply_filters('avf_load_google_map_api', true, 'av_google_map');
					            
					if($load_google_map_api) wp_enqueue_script(  'avia-google-maps-api' );
					
					$args = array(
		                'toomanyrequests'	=> __("Too many requests at once, please wait a few seconds before requesting coordinates again",'avia_framework'),
		                'notfound'			=> __("Address couldn't be found by Google, please add it manually",'avia_framework'),
		                'insertaddress' 	=> __("Please insert a valid address in the fields above",'avia_framework')
		            );
	
		            if($load_google_map_api) wp_localize_script( 'avia-google-maps-api', 'avia_gmaps_L10n', $args );
					
				}
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
							"name" => __("Add/Edit Map Locations", 'avia_framework' ),
							"desc" => __("Here you can add, remove and edit the map locations for your Google Map.", 'avia_framework' )."<br/>",
							"type" 			=> "modal_group",
							"id" 			=> "content",
							"modal_title" 	=> __("Edit Location", 'avia_framework' ),
							"std"			=> array( array('address'=>"", 'type'=>'text', 'check'=>'is_empty'), ),
							'subelements' 	=> array(

									array(
									"name" 	=> __("Full Adress", 'avia_framework' ),
									"desc" 	=> __("Enter the Address, then hit the 'Fetch Coordinates' Button. If the address was found the coordinates will be displayed", 'avia_framework' ),
									"id" 	=> "address",
									"std" 	=> "",
									"type" 	=> "gmap_adress"),
									
									 array(
			                            "name" 	=> __("Marker Tooltip", 'avia_framework' ),
			                            "desc" 	=> __("Enter some text here. If the user clicks on the marker the text will be displayed", 'avia_framework' ) ,
			                            "id" 	=> "content",
			                            "type" 	=> "textarea",
			                            "std" 	=> "",
			                        ),
			                        
			                        array(	
										"name" 	=> __("Display Tooltip by default", 'avia_framework' ),
										"desc" 	=> __("Check to display the tooltip by default. If unchecked user must click the marker to show the tooltip", 'avia_framework' ) ,
										"id" 	=> "tooltip_display",
										"std" 	=> "",
                            			"required" 	=> array('content', 'not', ''),
										"type" 	=> "checkbox"),
			                        
		
									array(
									"name" 	=> __("Custom Map Marker Image",'avia_framework' ),
									"desc" 	=> __("Use a custom Image as marker. (make sure that you use a square image, otherwise it will be cropped)",'avia_framework' )."<br/><small>".__("Leave empty if you want to use the default marker",'avia_framework' )."</small>",
									"id" 	=> "marker",
									"fetch" => 'id',
									"type" 	=> "image",
									"title" => __("Insert Marker Image",'avia_framework' ),
									"button" => __("Insert",'avia_framework' ),
									"std" 	=> ""),
									
									array(
									"name" 	=> __("Custom Map Marker Image Size", 'avia_framework' ),
									"desc" 	=> __("How big should the marker image be displayed in height and width. ", 'avia_framework' ),
									"id" 	=> "imagesize",
									"type" 	=> "select",
									"std" 	=> "40",
                            		"required" 	=> array('marker', 'not', ''),
									"subtype" => array(
									
										__('20px * 20px',  'avia_framework' ) =>'20',
										__('30px * 30px',  'avia_framework' ) =>'30',
										__('40px * 40px',  'avia_framework' ) =>'40',
										__('50px * 50px',  'avia_framework' ) =>'50',
										__('60px * 60px',  'avia_framework' ) =>'60',
										__('70px * 70px',  'avia_framework' ) =>'70',
										__('80px * 80px',  'avia_framework' ) =>'80',
									
									),),
									
								),
						
						),
						
						array(
							"name" 	=> __("Map height", 'avia_framework' ),
							"desc" 	=> __("You can either define a fixed height in pixel like '300px' or enter a width/height ratio like 16:9", 'avia_framework' ),
							"id" 	=> "height",
							"type" 	=> "input",
							"std" 	=> "400px",
						),
						
						array(
						"name" 	=> __("Zoom Level", 'avia_framework' ),
						"desc" 	=> __("Choose the zoom of the map on a scale from  1 (very far away) to 19 (very close)", 'avia_framework' ),
						"id" 	=> "zoom",
						"type" 	=> "select",
						"std" 	=> "16",
						"subtype" => AviaHtmlHelper::number_array(1,19,1,array(__("Set Zoom level automatically to show all markers", 'avia_framework' ) => 'auto' ))),
						
						
						array(
						"name" 	=> __("Color Saturation", 'avia_framework' ),
						"desc" 	=> __("Choose the saturation of your map", 'avia_framework' ),
						"id" 	=> "saturation",
						"type" 	=> "select",
						"std" 	=> "",
						"subtype" => array(
						
							__('Oversaturated',  'avia_framework' ) =>'100',
							__('Slightly oversaturated',  'avia_framework' ) =>'50',
							__('Normal Saturation',   'avia_framework' ) =>'',
							__('Muted colors',  'avia_framework' ) =>'-50',
							__('Greyscale',  'avia_framework' ) =>'-100'),
						
						),
						
						array(
							"name" 	=> __("Custom Overlay Color", 'avia_framework' ),
							"desc" 	=> __("Select a custom color for your Map here. The map will be tinted with that color. Leave empty if you want to use the default map color", 'avia_framework' ),
							"id" 	=> "hue",
							"type" 	=> "colorpicker",
							"std" 	=> "",
						),
						
						array(	
							"name" 	=> __("Display Zoom Control?", 'avia_framework' ),
							"desc" 	=> __("Check to display the controls at the left side of the map", 'avia_framework' ) ,
							"id" 	=> "zoom_control",
							"std" 	=> "active",
							"type" 	=> "checkbox"),
							
						array(	
							"name" 	=> __("Display Pan Control?", 'avia_framework' ),
							"desc" 	=> __("Check to display the Pan control wheel at the top left side of the map", 'avia_framework' )  ,
							"id" 	=> "pan_control",
							"std" 	=> "",
							"type" 	=> "checkbox"),
							
						array(	
							"name" 	=> __("Map dragging on mobile", 'avia_framework' ),
							"desc" 	=> __("Check to disable the users ability to drag the map on mobile devices. This ensures that the user can scroll down the page, even if the map fills the whole viewport of the mobile device", 'avia_framework' )  ,
							"id" 	=> "mobile_drag_control",
							"std" 	=> "",
							"type" 	=> "checkbox"),
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
				
				$params['innerHtml'].= "<div class='avia-flex-element'>"; 
				$params['innerHtml'].= 		__('This element will stretch across the whole screen by default.','avia_framework')."<br/>";
				$params['innerHtml'].= 		__('If you put it inside a color section or column it will only take up the available space','avia_framework');
				$params['innerHtml'].= "	<div class='avia-flex-element-2nd'>".__('Currently:','avia_framework');
				$params['innerHtml'].= "	<span class='avia-flex-element-stretched'>&laquo; ".__('Stretch fullwidth','avia_framework')." &raquo;</span>";
				$params['innerHtml'].= "	<span class='avia-flex-element-content'>| ".__('Adjust to content width','avia_framework')." |</span>";
				$params['innerHtml'].= "</div></div>";
				
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
				$template = $this->update_template("address", __("Address", 'avia_framework' ). ": {{address}}");

				$params['innerHtml']  = "";
				$params['innerHtml'] .= "<div class='avia_title_container' {$template}>".__("Address", 'avia_framework' ).": ".$params['args']['address']."</div>";

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
				'id'    	 	=> '',
				'height'		=> '',
				'hue'			=> '',
				'saturation'	=> '',
				'zoom'			=> '',
				'zoom_control'  => '',
				'pan_control'  	=> '',
				'mobile_drag_control' =>'',
				'handle'		=> $shortcodename,
				'content'		=> ShortcodeHelper::shortcode2array($content, 1)
				
				), $atts, $this->config['shortcode']);
				
				$atts['zoom_control'] 			= empty($atts['zoom_control']) ? false : true;
				$atts['pan_control']  			= empty($atts['pan_control']) ? false : true;
				$atts['mobile_drag_control']  	= empty($atts['mobile_drag_control']) ? true : false;
				
				extract($atts);
				$output  		= "";
			    $class 			= "";
				$skipSecond 	= false;
				avia_sc_gmaps::$map_count++;
				
				$params['class'] 							= "avia-google-maps avia-google-maps-section main_color ".$meta['el_class'].$class;
				$params['open_structure'] 					= false;
				$params['id'] 								= empty($id) ? "avia-google-map-nr-".avia_sc_gmaps::$map_count : $id;

				
				//we dont need a closing structure if the element is the first one or if a previous fullwidth element was displayed before
				if(isset($meta['index']) && $meta['index'] == 0) $params['close'] = false;
				if(!empty($meta['siblings']['prev']['tag']) && in_array($meta['siblings']['prev']['tag'], AviaBuilder::$full_el_no_section )) $params['close'] = false;
				
				
				//print the javascript vars necessary in the frontend footer
				$this->generate_js_vars($content, $atts);
				add_action('wp_footer', array($this, 'send_var_to_frontend'), 2, 100000);
				
				
				//create the map div that will be used to insert the google map
				$map = "<div id='av_gmap_".avia_sc_gmaps::$map_count."' class='avia-google-map-container' data-mapid='".avia_sc_gmaps::$map_count."' ".$this->define_height($height)."></div>";
				
				
				//if the element is nested within a section or a column dont create the section shortcode around it
				if(!ShortcodeHelper::is_top_level()) return $map;
				
				
				
				
				
				$output .=  avia_new_section($params);
				$output .= $map;
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
				
					$output .= avia_new_section(array('close'=>false, 'id' => "after_full_slider_".avia_sc_gmaps::$map_count));
				}
				
				return $output;

			}
			
			function define_height($height)
			{	
				$style = "";
				
				//apply a ratio via bottom padding
				if(strpos($height, ':') !== false)
				{
					$height = explode(':', $height);
					$height = (100 / (int) $height[0]) * $height[1];
					$style = "style='padding-bottom: {$height}%;'";
				}
				else // set a fixed height
				{
					$height = (int) $height;
					$style = "style='height: {$height}px;'";
				}
				
				return $style;
			}
			
			
			function generate_js_vars($shortcodes, $atts)
			{
				$index = avia_sc_gmaps::$map_count - 1;
				
				if(empty(self::$js_vars[$this->config['shortcode']]))
				{
					self::$js_vars[$this->config['shortcode']] = array();
				}
				
				foreach($shortcodes as $key =>$shortcode)
				{
					foreach ($shortcode['attr'] as $attr_key => $attr)
					{
						self::$js_vars[$this->config['shortcode']][$index]['marker'][$key][$attr_key] = $attr;
					}
					
					//get attachment data
					if(!empty($shortcode['content'])) 
					{	
						self::$js_vars[$this->config['shortcode']][$index]['marker'][$key]['content'] = wpautop(ShortcodeHelper::avia_remove_autop($shortcode['content'], true));
					}
					
					//get attachment data
					if(!empty($shortcode['attr']['marker'])) 
					{
						$image = wp_get_attachment_image_src($shortcode['attr']['marker'], 'thumbnail');
						if(!empty($image[0]))
						{
							self::$js_vars[$this->config['shortcode']][$index]['marker'][$key]['icon'] = $image[0];
						}
					}
				}
				
				$first_level = array('hue', 'zoom', 'saturation', 'zoom_control' , 'pan_control', 'mobile_drag_control');
				foreach($first_level as $var)
				{
					self::$js_vars[$this->config['shortcode']][$index][$var] = $atts[$var];
				}
				
			}
			
			
			function send_var_to_frontend()
			{	
				//filter to add new map marker programmatically before they are passed to the frontend
				self::$js_vars = apply_filters('avf_gmap_vars', self::$js_vars);
				AviaHelper::print_javascript(self::$js_vars);
			}
			
			
			
	}
}




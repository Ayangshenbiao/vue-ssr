<?php
/**
 * Display Numbers that count from 0 to the number you entered
 */
 
 if( !class_exists( 'Tribe__Events__Main' ) )
{
	function av_countdown_events_fallback()
	{
		return "<p>Please install the <a href='https://wordpress.org/plugins/the-events-calendar/'>The Events Calendar</a> or <a href='http://mbsy.co/6cr37'>The Events Calendar Pro</a> Plugin to display the countdown</p>";
	}
	
	add_shortcode('av_events_countdown', 'av_countdown_events_fallback');
	return;
}

 
if ( !class_exists( 'avia_sc_events_countdown' ) ) 
{
	
	class avia_sc_events_countdown extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']		= __('Events Countdown', 'avia_framework' );
				$this->config['tab']		= __('Plugin Additions', 'avia_framework' );
				$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-countdown.png";
				$this->config['order']		= 14;
				$this->config['target']		= 'avia-target-insert';
				$this->config['shortcode'] 	= 'av_events_countdown';
				$this->config['tooltip'] 	= __('Display a countdown to the next upcoming event', 'avia_framework' );
				
				$this->time_array = array(
								__('Second',  	'avia_framework' ) 	=>'1',
								__('Minute',  	'avia_framework' ) 	=>'2',	
								__('Hour',  	'avia_framework' ) 	=>'3',
								__('Day',  		'avia_framework' ) 	=>'4',
								__('Week',  	'avia_framework' ) 	=>'5',
								/*
								__('Month',  	'avia_framework' ) 	=>'6',
								__('Year',  	'avia_framework' ) 	=>'7'
								*/
							);
							
				
			}
			
			function fetch_upcoming()
			{
				$query 		= array('paged'=> false, 'posts_per_page' => 1, 'eventDisplay' => 'list');
				$upcoming 	= Tribe__Events__Query::getEvents( $query, true);
				
				return $upcoming;
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
							"type" 	=> "tab_container", 'nodescription' => true
						),
						
					array(
							"type" 	=> "tab",
							"name"  => __("Content" , 'avia_framework'),
							'nodescription' => true
						),
					
					
					array(	
							"name" 	=> __("Smallest time unit", 'avia_framework' ),
							"desc" 	=> __("The smallest unit that will be displayed", 'avia_framework' ),
							"id" 	=> "min",
							"type" 	=> "select",
							"std" 	=> "1",
							"subtype" => $this->time_array),
					
					
					array(	
							"name" 	=> __("Largest time unit", 'avia_framework' ),
							"desc" 	=> __("The largest unit that will be displayed", 'avia_framework' ),
							"id" 	=> "max",
							"type" 	=> "select",
							"std" 	=> "5",
							"subtype" => $this->time_array),
					
					
					
							
					array(
							"name" 	=> __("Text Alignment", 'avia_framework' ),
							"desc" 	=> __("Choose here, how to align your text", 'avia_framework' ),
							"id" 	=> "align",
							"type" 	=> "select",
							"std" 	=> "center",
							"subtype" => array(
												__('Center',  'avia_framework' ) =>'av-align-center',
												__('Right',  'avia_framework' ) =>'av-align-right',
												__('Left',  'avia_framework' ) =>'av-align-left',
												)
							),
							
					array(	"name" 	=> __("Number Font Size", 'avia_framework' ),
							"desc" 	=> __("Size of your numbers in Pixel", 'avia_framework' ),
				            "id" 	=> "size",
				            "type" 	=> "select",
				            "subtype" => AviaHtmlHelper::number_array(20,90,1, array( __("Default Size", 'avia_framework' )=>'')),
				            "std" => ""),
				   
				   array(
							"name" 	=> __("Display Event Title?", 'avia_framework' ),
							"desc" 	=> __("Choose here, if you want to display the event title", 'avia_framework' ),
							"id" 	=> "title",
							"type" 	=> "select",
							"std" 	=> "",
							"subtype" => array(
												__('No Title, timer only',  'avia_framework' ) =>'',
												__('Title on top',  'avia_framework' ) 	=>'top',
												__('Title below',  'avia_framework' ) 	=>'bottom',
												)
							),
				   
				   
				   
				            
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
							"name" 	=> __("Colors", 'avia_framework' ),
							"desc" 	=> __("Choose the colors here", 'avia_framework' ),
							"id" 	=> "style",
							"type" 	=> "select",
							"std" 	=> "center",
							"subtype" => array(
												__('Default',	'avia_framework' ) 	=>'av-default-style',
												__('Theme colors',	'avia_framework' ) 	=>'av-colored-style',
												__('Transparent Light', 'avia_framework' ) 	=>'av-trans-light-style',
												__('Transparent Dark',  'avia_framework' )  =>'av-trans-dark-style',
												)
							),
					array(
							"type" 	=> "close_div",
							'nodescription' => true
						),
						
					array(
							"type" 	=> "close_div",
							'nodescription' => true
						),
				);

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
				
				$next = $this->fetch_upcoming();
				
				if(empty( $next->posts[0] ) || empty( $next->posts[0]->EventStartDate)) return;
				
				$events_date = explode(" ", $next->posts[0]->EventStartDate );
				
				if(isset($events_date[0]))
				{
					$atts['date'] = date("m/d/Y", strtotime($events_date[0]));
				}
				
				if(isset($events_date[1]))
				{
					$events_date = explode(":", $events_date[1] );
					$atts['hour'] = $events_date[0];
					$atts['minute'] = $events_date[1];
				}
				
				$atts['link'] 	= get_permalink( $next->posts[0]->ID );
				$title 			= get_the_title( $next->posts[0]->ID );
				
				if(!empty( $atts['title'] ))
				{
					$atts['title']  = array( $atts['title'] => __("Upcoming",'avia_framework') .": " . $title );
				}
				
				$timer  = new avia_sc_countdown( $this->builder );
				$output = $timer->shortcode_handler( $atts , $content, $shortcodename, $meta);
				
				
				return $output;
			}
	}
}






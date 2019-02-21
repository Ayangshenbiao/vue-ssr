<?php  if ( ! defined('AVIA_FW')) exit('No direct script access allowed');
/**
 * This file holds the class that creates styles for the theme based on the backend options
 *
 *
 * @author		Christian "Kriesi" Budschedl
 * @copyright	Copyright (c) Christian Budschedl
 * @link		http://kriesi.at
 * @link		http://aviathemes.com
 * @since		Version 1.0
 * @package 	AviaFramework
 */

/**
 *
 */


if( !class_exists( 'avia_style_generator' ) )
{


	/**
	 *  The avia_style_generator class holds all methods necessary to create and overwrite the default css styles with those set in the wordpress backend
	 *  @package 	AviaFramework
	 */

	class avia_style_generator
	{

		/**
		 * This array hold all styledata defined for the theme that should be overwriten dynamically
		 * @var array
		 */
		var $rules;

		/**
		 * $output contains the html string that is printed in the frontend
		 * @var string
		 */
		var $output = "";

		/**
		 * $extra_output contains html content that should be printed after the actual css rules. for example a javascript with cufon rules
		 * @var string
		 */
		var $extra_output = "";

        /*
         * Add print var to check if we need to output style tags or not
         */
        var $print_styles = '';
        var $print_extra_output = '';
        var $used_fonts = array();
        var $google_fontlist = "";
        
        var $stylewizard = array();	// holds all available styling rules that are defined in the config files 
        var $stylewizardIDs = array(); // holds all saved elements that contain rules

        public function __construct(&$avia_superobject, $print_styles = true, $print_extra_output = true, $addaction = true)
        {
            $this->print_styles = $print_styles;
            $this->print_extra_output = $print_extra_output;
            

            //check if stylesheet exists...
			$safe_name = avia_backend_safe_string($avia_superobject->base_data['prefix']);
			
            if( get_option('avia_stylesheet_exists'.$safe_name) == 'true' ) $this->print_styles = false;
		
			$this->get_style_wizard_additions($avia_superobject->option_page_data);	

            if($addaction) 
            {
            	add_action('wp_head',array(&$this, 'create_styles'),5);
            	add_action('wp_head',array(&$this, 'print_extra_output'),5);
            	add_action('wp_head',array(&$this, 'print_styles'),1000);
            	add_action('wp_footer',array(&$this, 'print_footer'),1000);
        	}
        }

        public function __destruct()
        {
            unset($this->print_styles);
            unset($this->print_extra_output);
        }
        
        // gather styling wizard elements so the rules can be converted as well
        function get_style_wizard_additions($option_page_data)
        {
        	foreach($option_page_data as $data)
        	{
        		if($data['type'] == 'styling_wizard') 
        		{
        			$this->stylewizardIDs[] = $data['id'];
        			$this->stylewizard = array_merge($this->stylewizard, $data['elements']);
        		}
        	}
        }


		function create_styles()
		{
			global $avia_config;
			if(!isset($avia_config['font_stack'])) $avia_config['font_stack'] = "";
			if(!isset($avia_config['style'])) return;

			$avia_config['style'] = apply_filters('avia_style_filter',$avia_config['style']);
			$this->rules = $avia_config['style'];
			
			//default styling rules
			if(is_array($this->rules))
			{
				foreach($this->rules as $rule)
				{
					
					$rule['value'] = str_replace('{{AVIA_BASE_URL}}', AVIA_BASE_URL, $rule['value']);
					$rule['value'] = preg_replace('/(http|https):\/\//', '//', $rule['value']);
					
					//check if a executing method was passed, if not simply put the string together based on the key and value array
					if(isset($rule['key']) && method_exists($this, $rule['key']) && $rule['value'] != "")
					{
						$this->output .= $this->{$rule['key']}($rule)."\n";
					}
					else if($rule['value'] != "")
					{
						$this->output .= $rule['elements']."{\n".$rule['key'].":".$rule['value'].";\n}\n\n";
					}

				}
			}
			
			
			//css wizard styling rules
			$this->create_wizard_styles();
			
				
            //output inline css in head section or return the style code
            if( !empty($this->output) )
            {
                if( !empty($this->print_styles) )
                {
                    
                }
                else
                {
                    $return = $this->output;
                }
            }
            
            if(!empty($return)) return $return;
		}
		
		
		
		function create_wizard_styles()
		{
			if(empty($this->stylewizardIDs)) return;
			
			global $avia_config;
			
			foreach($this->stylewizardIDs as $id)
			{
				$options = avia_get_option($id);
				if(empty($options)) continue;
				
				foreach($options as $style)
				{
				
					if(empty($this->stylewizard[$style['id']]['selector'])) continue;
				
					//first of all we need to build the selector string
					$selectorArray 	= $this->stylewizard[$style['id']]['selector'];
					$sectionCheck	= $this->stylewizard[$style['id']]['sections'];
					
					foreach($selectorArray as $selector => $ruleset)
					{
						$temp_selector  = "";
						$rules			= "";
						$sectionActive  = strpos($selector, '[sections]') !== false ? true : false;
					
						//hover check
						if(isset($style['hover_active']) && $style['hover_active'] != 'disabled')
						{
							$selector = str_replace("[hover]", ":hover", $selector);
						}
						else
						{
							$selector = str_replace("[hover]", "", $selector);
						}
						
						
						//if sections are enabled make sure that the selector string gets generated for each section
						if($sectionActive && $sectionCheck && isset($avia_config['color_sets']))
						{
							foreach($avia_config['color_sets'] as $key => $name)
							{
								if( isset($style[$key]) && $style[$key] != 'disabled')
								{
									if(!empty($temp_selector)) $temp_selector .= ", ";
									$temp_selector .= str_replace("[sections]", ".".$key, $selector);
								}
							}
							
							if(empty($temp_selector)) continue;
						}
						
						//apply modified rules to the selector
						if(!empty($temp_selector)) $selector = $temp_selector;
						
						
						//we got the selector stored in $selector, now we need to generate the rules
						foreach($style as $key => $value)
						{
							
							
							
							
							if($value != "" && $value != "true" && $value != "disabled" && $key != "id")
							{
								if( is_array( $ruleset ) )
								{
									foreach($ruleset as $rule_key => $rule_val)
									{
										//if the $rule_val is an array we only apply the rules if the user selected value is the same as the first rule_val entry
										if(is_array($rule_val))
										{
											if($rule_val[0] !== $value)
											{
												continue;
											}
											else
											{
												$rule_val = $rule_val[1];
											}
										}
										
										if($rule_key == $key )
										{
											if(str_replace('_','-',$rule_key) == "font-family")
											{
												$font = explode(':',($value));
												$value = $font[0];
											}
											
											$rules .= str_replace("%{$key}%", $value, $rule_val);
											
										}
									}
								}
								else
								{
									$key = str_replace('_','-',$key);
								
									switch($key)
									{
										case "font-family": 
		
										$font   = explode(':',($value));
										$font_family = $font[0];
										$font_size	 = isset($font[1]) ? $font[1] : "";
										$this->add_google_font($font_family, $font_size);
										$rules .= "font-family:'{$font_family}', 'Helvetica Neue', Helvetica, Arial, sans-serif;"; break;
										default: 			$rules .= "{$key}:{$value};"; break;
									}
								}
							}
						}
						
						if(!empty($rules))
						{
							$this->output .= $selector.'{'.$rules.'}';
						}
					}
				}
			}
		}
		
		




		function print_styles()
		{	
			if(empty($this->print_styles)) return;
		
			echo "\n<!-- custom styles set at your backend-->\n";
			echo "<style type='text/css' id='dynamic-styles'>\n";
			echo $this->output;
			echo "</style>\n";
			echo "\n<!-- end custom styles-->\n\n";
		}


        function print_extra_output()
        {
        	if($this->print_extra_output) 
        	{
        		$this->link_google_font();
        		
        		echo $this->extra_output;
        	}
        }
        
        function print_footer()
        {
        	if(!empty($this->footer)) 
        	{
        		echo $this->footer;
        	}
        }


		function cufon($rule)
		{
			if(empty($this->footer)) $this->footer = "";
			
			$rule_split = explode('__',$rule['value']);
			if(!isset($rule_split[1])) $rule_split[1] = 1;
			$this->footer .= "\n<!-- cufon font replacement -->\n";
			$this->footer .= "<script type='text/javascript' src='".AVIA_BASE_URL."fonts/cufon.js'></script>\n";
			$this->footer .= "<script type='text/javascript' src='".AVIA_BASE_URL."fonts/".$rule_split[0].".font.js'></script>\n";
			$this->footer .= "<script type='text/javascript'>\n\t
			var avia_cufon_size_mod = '".$rule_split[1]."'; \n\tCufon.replace('".$rule['elements']."',{  fontFamily: 'cufon', hover:'true' }); \n</script>\n";
		}

		function google_webfont($rule)
		{
			global $avia_config;

			//check if the font has a weight applied to it and extract it. eg: "Yanone Kaffeesatz:200"
			$font_weight = "";
			$get_google_font = true;

			if(strpos($rule['value'], ":") !== false)
			{
				$data = explode(':',$rule['value']);
				$rule['value'] = $data[0];
				$font_weight = $data[1];
			}

			$rule_split = explode('__',$rule['value']);

			if(!isset($rule_split[1])) $rule_split[1] = 1;

			if(strpos($rule_split[0], 'websave') !== false)
			{

				$rule_split = explode(',',$rule_split[0]);
				$rule_split = strtolower(" ".$rule_split[0]);
				$rule_split = str_replace('"','',$rule_split);
				$rule_split = str_replace("'",'',$rule_split);
				$rule_split = str_replace("-websave",'',$rule_split);

				$avia_config['font_stack'] .= $rule_split.'-websave';
				$rule_split = array(str_replace( "-", " " , $rule_split ), 1);
				$get_google_font = false;
			}
			

			if($get_google_font)
			{
				$this->add_google_font($rule_split[0], $font_weight);
			
				if(!empty($font_weight) && strpos($font_weight,',') === false) { $font_weight = "font-weight:".$font_weight.";";} else { $font_weight = ""; }
			}

			$this->output .= $rule['elements']."{font-family:'".$rule_split[0]."', 'HelveticaNeue', 'Helvetica Neue', Helvetica, Arial, sans-serif;".$font_weight."}";
			if($rule_split[1] !== 1 && $rule_split[1]) $this->output .= $rule['elements']."{font-size:".$rule_split[1]."em;}";

			$avia_config['font_stack'] .= " ".strtolower( str_replace( " ", "_" , $rule_split[0] ))." ";
		}
		
		
		//add the font to the query string
		function add_google_font($font_family, $font_weight = "")
		{
			if(!in_array($font_family.$font_weight, $this->used_fonts))
			{
				$this->used_fonts[] = $font_family.$font_weight;
				if(!empty($this->google_fontlist)) $this->google_fontlist .= "%7C";
				if(!empty($font_weight)) $font_weight = ":".$font_weight;
				
				$this->google_fontlist .= str_replace(' ','+',$font_family).$font_weight;
			}
		}
		
		
		//write the link tag with the $this->google_fontlist
		function link_google_font()
		{
			if(empty($this->google_fontlist)) return;
		
			$this->extra_output .= "\n<!-- google webfont font replacement -->\n";
			$this->extra_output .= "<link rel='stylesheet' id='avia-google-webfont' href='//fonts.googleapis.com/css?family=".apply_filters('avf_google_fontlist', $this->google_fontlist)."' type='text/css' media='all'/> \n";
		}
		
		
		

		function direct_input($rule)
		{
			return $rule['value'];
		}

		function backgroundImage($rule)
		{
			return $rule['elements']."{\nbackground-image:url(".$rule['value'].");\n}\n\n";
		}


	}
}


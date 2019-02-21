<?php
/**
 * Textblock
 * Shortcode which creates a text element wrapped in a div
 */

if ( !class_exists( 'avia_sc_text' ) )
{
	class avia_sc_text extends aviaShortcodeTemplate
	{
			/**
			 * Create the config array for the shortcode button
			 */
			function shortcode_insert_button()
			{
				$this->config['name']			= __('Text Block', 'avia_framework' );
				$this->config['tab']			= __('Content Elements', 'avia_framework' );
				$this->config['icon']			= AviaBuilder::$path['imagesURL']."sc-text_block.png";
				$this->config['order']			= 100;
				$this->config['target']			= 'avia-target-insert';
				$this->config['shortcode'] 		= 'av_textblock';
				$this->config['tinyMCE'] 	    = array('disable' => true);
				$this->config['tooltip'] 	    = __('Creates a simple text block', 'avia_framework' );

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
							"name" 	=> __("Content",'avia_framework' ),
							"desc" 	=> __("Enter some content for this textblock",'avia_framework' ),
							"id" 	=> "content",
							"type" 	=> "tiny_mce",
							"std" 	=> __("Click here to add your own text", "avia_framework" )
							),
							
					array(	"name" 	=> __("Font Size", 'avia_framework' ),
							"desc" 	=> __("Size of the text in px", 'avia_framework' ),
				            "id" 	=> "size",
				            "type" 	=> "select",
				            "subtype" => AviaHtmlHelper::number_array(10,40,1, array( __("Default Size", 'avia_framework' )=>'')),
				            "std" => ""),
							
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
							"name" 	=> __("Custom Font Color", 'avia_framework' ),
							"desc" 	=> __("Select a custom font color. Leave empty to use the default", 'avia_framework' ),
							"id" 	=> "color",
							"type" 	=> "colorpicker",
							"std" 	=> "",
							"required" => array('font_color','equals','custom')
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
				$params['class'] = "";
				$params['innerHtml'] = "<div class='avia_textblock avia_textblock_style' data-update_with='content'>".stripslashes(wpautop(trim(html_entity_decode( $params['content']) )))."</div>";
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
				extract(shortcode_atts(array( 
				
				'font_color' => "",
				'color' => '',
				'size' => '',
				
				), $atts, $this->config['shortcode']));
				
				
				
				
				$custom_class = !empty($meta['custom_class']) ? $meta['custom_class'] : "";
                $output = '';
                $markup = avia_markup_helper(array('context' => 'entry','echo'=>false, 'custom_markup'=>$meta['custom_markup']));
                $markup_text = avia_markup_helper(array('context' => 'entry_content','echo'=>false, 'custom_markup'=>$meta['custom_markup']));
				
				$extra_styling = "";
				
				if($size)
				{
					$extra_styling .= "font-size:{$size}px; ";
				}
				
				if($font_color == "custom")
				{
					$custom_class  .= " av_inherit_color";
					$extra_styling .= !empty($color) ? "color:{$color}; " : "";
				}
				
				if($extra_styling) $extra_styling = " style='{$extra_styling}'" ;
				
				
                $output .= '<section class="av_textblock_section" '.$markup.'>';
                $output .= "<div class='avia_textblock {$custom_class}' {$extra_styling} {$markup_text}>".ShortcodeHelper::avia_apply_autop(ShortcodeHelper::avia_remove_autop($content) )."</div>";
                $output .= '</section>';

                return $output;
			}

	}
}

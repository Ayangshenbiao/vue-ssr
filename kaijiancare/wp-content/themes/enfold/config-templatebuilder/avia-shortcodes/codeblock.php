<?php
/**
 * Code Block
 * Shortcode which creates a code element wrapped in a div - useful for text withour formatting like pre/code tags or scripts.
 */

if ( !class_exists( 'avia_sc_codeblock' ) )
{
    class avia_sc_codeblock extends aviaShortcodeTemplate
    {
        static $codeblock_id = 0;
        static $codeblocks = array();
        
        /**
         * Create the config array for the shortcode button
         */
        function shortcode_insert_button()
        {
            $this->config['name']           = __('Code Block', 'avia_framework' );
            $this->config['tab']            = __('Content Elements', 'avia_framework' );
            $this->config['icon']           = AviaBuilder::$path['imagesURL']."sc-codeblock.png";
            $this->config['order']          = 1;
            $this->config['target']         = 'avia-target-insert';
            $this->config['shortcode']      = 'av_codeblock';
            $this->config['tinyMCE']        = array('disable' => true);
            $this->config['tooltip']        = __('Add text or code to your website without any formatting or text optimization. Can be used for HTML/CSS/Javascript', 'avia_framework' );

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
            $this->elements =  array(
                array(
                    "name"  => __("Code Block Content. Add your own HTML/CSS/Javascript here", 'avia_framework'),
                    "desc"  => __("Enter some text/code. You can also add plugin shortcodes here. (Adding theme shortcodes is not recommended though)", 'avia_framework'),
                    "id"    => "content",
					'container_class' =>"avia-element-fullwidth",
                    "type"  => "textarea",
                    "std"   => "",
                ),

                array(
                    "name"  => __("Code Wrapper Element", 'avia_framework' ),
                    "desc"  => __("Wrap your code into a html tag (i.e. pre or code tag). Insert the tag without <>", 'avia_framework' ) ,
                    "id"    => "wrapper_element",
                    "std"   => '',
                    "type"  => "input"),

                array(
                    "name"  => __("Code Wrapper Element Attributes", 'avia_framework' ),
                    "desc"  => __("Enter one or more attribute values which should be applied to the wrapper element. Leave the field empty if no attributes are required.", 'avia_framework' ) ,
                    "id"    => "wrapper_element_attributes",
                    "std"   => '',
                    "required" => array('wrapper_element', 'not', ''),
                    "type"  => "input"),

                array(
                    "name"  => __("Escape HTML Code", 'avia_framework' ),
                    "desc"  => __("WordPress will convert the html tags to readable text.", 'avia_framework' ) ,
                    "id"    => "escape_html",
                    "std"   => false,
                    "type"  => "checkbox"),

                array(
                    "name"  => __("Disable Shortcode Processing", 'avia_framework' ),
                    "desc"  => __("Check if you want to disable the shortcode processing for this code block", 'avia_framework' ) ,
                    "id"    => "deactivate_shortcode",
                    "std"   => false,
                    "type"  => "checkbox"),

                array(
                    "name"  => __("Deactivate schema.org markup", 'avia_framework' ),
                    "desc"  => __("Output the code without any additional wrapper elements. (not recommended)", 'avia_framework' ) ,
                    "id"    => "deactivate_wrapper",
                    "std"   => false,
                    "type"  => "checkbox"),
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
         * Frontend Shortcode Handler
         *
         * @param array $atts array of attributes
         * @param string $content text within enclosing form of shortcode element
         * @param string $shortcodename the shortcode found, when == callback name
         * @return string $output returns the modified html string
         */
        function shortcode_handler($atts, $content = "", $shortcodename = "", $meta = "")
        {
            $custom_class = !empty($meta['custom_class']) ? $meta['custom_class'] : "";

            $atts = shortcode_atts(array(
                'wrapper_element' => '',
                'deactivate_wrapper' => false,
                'wrapper_element_attributes' => '',
            ), $atts, $this->config['shortcode']);

            $content = ' [avia_codeblock_placeholder uid="'.avia_sc_codeblock::$codeblock_id.'"] ';
            if(!empty($atts['wrapper_element'])) $content = "<{$atts['wrapper_element']} {$atts['wrapper_element_attributes']}>{$content}</{$atts['wrapper_element']}>";

            if(empty($atts['deactivate_wrapper']))
            {
                $output = '';
                $markup = avia_markup_helper(array('context' => 'entry', 'echo' => false, 'custom_markup'=>$meta['custom_markup']));
                $markup_text = avia_markup_helper(array('context' => 'entry_content', 'echo' => false, 'custom_markup'=>$meta['custom_markup']));

                $output .= '<section class="avia_codeblock_section avia_code_block_' . avia_sc_codeblock::$codeblock_id . '" ' . $markup . '>';
                $output .= "<div class='avia_codeblock {$custom_class}' $markup_text>" . $content . "</div>";
                $output .= '</section>';
                $content = $output;
            }

            avia_sc_codeblock::$codeblock_id++;
            return $content;
        }
        
        function extra_assets()
		{
			add_filter('avia_builder_precompile', array($this, 'code_block_extraction'), 1, 1);
    		add_filter('avf_template_builder_content', array($this, 'code_block_injection'), 10, 1);
		}
        
		function code_block_extraction($content)
		{	
			if ( strpos( $content, '[av_codeblock' ) === false) return $content;
			
			$pattern = '\[(\[?)(av_codeblock)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
			preg_match_all('/'.$pattern.'/s', $content, $matches);
			
			if(!empty($matches[0]) && is_array($matches))
			{
			    foreach($matches[0] as $key => $data)
			    {
			        $codeblock = !empty($matches[5][$key]) ? $matches[5][$key] : '';
					$codeblock = trim($codeblock);
					
			        if(!empty($matches[3][$key]))
			        {
			            $atts = shortcode_parse_atts($matches[3][$key]);
			            
			            $codeblock = !empty($atts['escape_html']) ? esc_html($codeblock) : $codeblock;
			            $codeblock = !empty($atts['escape_html']) && empty($atts['wrapper_element']) ? nl2br($codeblock) : $codeblock;
			            $codeblock = empty($atts['deactivate_shortcode']) ? do_shortcode($codeblock) : $codeblock;
			        }
			
			        self::$codeblocks[$key] = $codeblock;
			    }
			}
			
			return $content;
		}
	    
		function code_block_injection($content)
		{	
			if( empty(self::$codeblocks) ) return $content;
			
			$pattern = '\[(\[?)(avia_codeblock_placeholder)(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)';
			preg_match_all('/'.$pattern.'/s', $content, $matches);
			
			if(!empty($matches) && is_array($matches))
			{
			    foreach($matches[0] as $key => $placeholder)
			    {
			        if(!empty($matches[3][$key])) $atts = shortcode_parse_atts($matches[3][$key]);
			        $id = !empty($atts['uid']) ? $atts['uid'] : 0;
			
			        $codeblock = !empty(self::$codeblocks[$id]) ? self::$codeblocks[$id] : '';
			        $content = str_replace($placeholder, $codeblock, $content);
			    }
			}
			
			return $content;
		}
	}
  }






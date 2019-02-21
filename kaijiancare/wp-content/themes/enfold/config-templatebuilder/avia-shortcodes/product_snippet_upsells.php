<?php

if( !class_exists( 'woocommerce' ) )
{
	add_shortcode('av_product_upsells', 'avia_please_install_woo');
	return;
}

if ( !class_exists( 'avia_sc_product_upsells' ) )
{
	class avia_sc_product_upsells extends aviaShortcodeTemplate
	{
		/**
		 * Create the config array for the shortcode button
		 */
		function shortcode_insert_button()
		{
			$this->config['name']		= __('Related Products', 'avia_framework' );
			$this->config['tab']		= __('Plugin Additions', 'avia_framework' );
			$this->config['icon']		= AviaBuilder::$path['imagesURL']."sc-tabs.png";
			$this->config['order']		= 15;
			$this->config['target']		= 'avia-target-insert';
			$this->config['shortcode'] 	= 'av_product_upsells';
			$this->config['tooltip'] 	= __('Display a list of related products and/or up-sells', 'avia_framework' );
			$this->config['drag-level'] = 3;
			$this->config['tinyMCE'] 	= array('disable' => "true");
			$this->config['posttype'] 	= array('product',__('This element can only be used on single product pages','avia_framework'));
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
							"name" 	=> __("Display options", 'avia_framework' ),
							"desc" 	=> __("Choose which products you want to display", 'avia_framework' ),
							"id" 	=> "display",
							"type" 	=> "select",
							"std" 	=> "upsells related",
							"subtype" => array(
								__('Display up-sells and related products',  'avia_framework' ) =>'upsells related',
								__('Display up-sells only',  'avia_framework' ) =>'upsells',	
								__('Display related products only',  'avia_framework' ) =>'related')),	
								
					array(	
							"name" 	=> __("Number of items", 'avia_framework' ),
							"desc" 	=> __("Choose the maximum number of products to display", 'avia_framework' ),
							"id" 	=> "count",
							"type" 	=> "select",
							"std" 	=> "4",
							"subtype" => array(
								'1' =>'1','2' =>'2','3' =>'3','4' =>'4','5' =>'5'))
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
			$params['content'] 	 = NULL; //remove to allow content elements
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
			
			extract(shortcode_atts(array('display' => 'upsells related', 'count' => 4)
											 , $atts));
			
			$output = "";
			$meta['el_class'];
			
			global $woocommerce, $product;
			if(!is_object($woocommerce) || !is_object($woocommerce->query) || empty($product)) return;
			
			
			// $product = wc_get_product();
			$output .= "<div class='av-woo-product-related-upsells  ".$meta['el_class']."'>";
			if(strpos($display, 'upsells') !== false) $output .= avia_woocommerce_output_upsells($count,$count);
			if(strpos($display, 'related') !== false) $output .= avia_woocommerce_output_related_products($count,$count);
			$output .= "</div>";
			
			return $output;
		}
	}
}




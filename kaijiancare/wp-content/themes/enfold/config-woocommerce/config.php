<?php


function avia_woocommerce_enabled()
{
	if ( class_exists( 'woocommerce' ) ){ return true; }
	return false;
}

global $avia_config;

//product thumbnails
$avia_config['imgSize']['shop_thumbnail'] 	= array('width'=>120, 'height'=>120);
$avia_config['imgSize']['shop_catalog'] 	= array('width'=>450, 'height'=>450);
$avia_config['imgSize']['shop_single'] 		= array('width'=>450, 'height'=>999, 'crop' => false);

avia_backend_add_thumbnail_size($avia_config);

include('admin-options.php');
include('admin-import.php');
include( 'woocommerce-mod-css-dynamic.php');

add_theme_support( 'woocommerce' );

//check if the plugin is enabled, otherwise stop the script
if(!avia_woocommerce_enabled()) { return false; }


//register my own styles, remove wootheme stylesheet
if(!is_admin()){
	add_action('init', 'avia_woocommerce_register_assets');
}



function avia_woocommerce_register_assets()
{
	wp_enqueue_style( 'avia-woocommerce-css', AVIA_BASE_URL.'config-woocommerce/woocommerce-mod.css');
	wp_enqueue_script( 'avia-woocommerce-js', AVIA_BASE_URL.'config-woocommerce/woocommerce-mod.js', array('jquery'), 1, true);
}





global $woocommerce;

if(version_compare($woocommerce->version, "2.1", "<"))
{
	define('WOOCOMMERCE_USE_CSS', false);
}
else
{
	add_filter( 'woocommerce_enqueue_styles', 'avia_woocommerce_enqueue_styles' );
	function avia_woocommerce_enqueue_styles($styles)
	{
		$styles = array();
		return $styles;
	}
}


if ( class_exists( 'WC_Bookings' ) )
{
	require_once( 'config-woocommerce-bookings/config.php' ); //compatibility with woocommerce plugin
}








######################################################################
# config
######################################################################

//add avia_framework config defaults

$avia_config['shop_overview_column']  = get_option('avia_woocommerce_column_count');  // columns for the overview page
$avia_config['shop_overview_products']= get_option('avia_woocommerce_product_count'); // products for the overview page

$avia_config['shop_single_column'] 	 	 = 4;			// columns for related products and upsells
$avia_config['shop_single_column_items'] = 4;	// number of items for related products and upsells
$avia_config['shop_overview_excerpt'] = false;		// display excerpt

if(!$avia_config['shop_overview_column']) $avia_config['shop_overview_column'] = 3;


######################################################################
# Create the correct template html structure
######################################################################

//remove woo defaults
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10);
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_pagination', 'woocommerce_catalog_ordering', 20 );
remove_action( 'woocommerce_pagination', 'woocommerce_pagination', 10 );
remove_action( 'woocommerce_before_single_product', array($woocommerce, 'show_messages'), 10);



//add theme actions && filter
add_action( 'woocommerce_after_shop_loop_item_title', 'avia_woocommerce_overview_excerpt', 10);
add_filter( 'loop_shop_columns', 'avia_woocommerce_loop_columns');
add_filter( 'loop_shop_per_page', 'avia_woocommerce_product_count' );

//single page adds
add_action( 'avia_add_to_cart', 'woocommerce_template_single_add_to_cart', 30, 2 );



/*update woocommerce v2*/

remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 ); /*remove result count above products*/
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 ); /*remove woocommerce ordering dropdown*/
remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 ); //remove rating
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 ); //remove woo pagination


######################################################################
# FUNCTIONS
######################################################################

#
# set the shop page id, otherwise avia_get_the_ID() can return a wrong id on the shop page
#
add_filter('avf_avia_get_the_ID','avia_set_shop_page_id', 10, 1);
function avia_set_shop_page_id($id)
{
    if(is_shop()) $id = woocommerce_get_page_id('shop');
    return $id;
}

#
# removes the default post image from shop overview pages and replaces it with this image
#
add_action( 'woocommerce_before_shop_loop_item_title', 'avia_woocommerce_thumbnail', 10);
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);

function avia_woocommerce_thumbnail($asdf)
{
	global $product, $avia_config;
	$rating = $product->get_rating_html(); //get rating

	$id = get_the_ID();
	$size = 'shop_catalog';

	echo "<div class='thumbnail_container'>";
		echo avia_woocommerce_gallery_first_thumbnail( $id , $size);
		echo get_the_post_thumbnail( $id , $size );
		if(!empty($rating)) echo "<span class='rating_container'>".$rating."</span>";
		if($product->product_type == 'simple') echo "<span class='cart-loading'></span>";
	echo "</div>";
}


function avia_woocommerce_gallery_first_thumbnail($id, $size, $id_only = false)
{
	$active_hover = get_post_meta( $id, '_product_hover', true );

	if(!empty($active_hover))
	{
		$product_gallery = get_post_meta( $id, '_product_image_gallery', true );

		if(!empty($product_gallery))
		{
			$gallery	= explode(',',$product_gallery);
			$image_id 	= $gallery[0];
			
			//return id only
			if(!empty($id_only)) return $image_id;
			
			$image 		= wp_get_attachment_image( $image_id, $size, false, array( 'class' => "attachment-$size avia-product-hover" ));
			
			//return image
			if(!empty($image)) return $image;
		}
	}
}




#
# add ajax cart / options buttons to the product
#

add_action( 'woocommerce_after_shop_loop_item', 'avia_add_cart_button', 16);
function avia_add_cart_button()
{
	global $product, $avia_config;

	if ($product->product_type == 'bundle' ){
		$product = new WC_Product_Bundle($product->id);
	}

	$extraClass  = "";

	ob_start();
	woocommerce_template_loop_add_to_cart();
	$output = ob_get_clean();

	if(!empty($output))
	{
		$pos = strpos($output, ">");

		if ($pos !== false) {
		    $output = substr_replace($output,"><span ".av_icon_string('cart')."></span> ", $pos , strlen(1));
		}
	}


	if($product->product_type == 'variable' && empty($output))
	{
		$output = '<a class="add_to_cart_button button product_type_variable" href="'.get_permalink($product->id).'"><span '.av_icon_string("details").'></span> '.__("Select options","avia_framework").'</a>';
	}

	if(in_array($product->product_type, array('subscription', 'simple', 'bundle')))
	{
		$output .= '<a class="button show_details_button" href="'.get_permalink($product->id).'"><span '.av_icon_string("details").'></span>  '.__("Show Details","avia_framework").'</a>';
	}
	else
	{
		$extraClass  = "single_button";
	}

	if(empty($extraClass)) $output .= " <span class='button-mini-delimiter'></span>";


	if($output && !post_password_required() && '' == avia_get_option('product_layout',''))
	{
		echo "<div class='avia_cart_buttons $extraClass'>$output</div>";
	}
}





#
# wrap products on overview pages into an extra div for improved styling options. adds "product_on_sale" class if prodct is on sale
#

add_action( 'woocommerce_before_shop_loop_item', 'avia_shop_overview_extra_div', 5);
function avia_shop_overview_extra_div()
{
	global $product;
	$product_class = $product->is_on_sale() ? "product_on_sale" : "";
	$product_class.= " av-product-class-".avia_get_option('product_layout');

	echo "<div class='inner_product main_color wrapped_style noLightbox $product_class'>";
}

add_action( 'woocommerce_after_shop_loop_item',  'avia_close_div', 1000);
function avia_close_div()
{
	echo "</div>";
}


#
# wrap product titles and sale number on overview pages into an extra div for improved styling options
#

add_action( 'woocommerce_before_shop_loop_item_title', 'avia_shop_overview_extra_header_div', 20);
function avia_shop_overview_extra_header_div()
{
	echo "<div class='inner_product_header'><div class='avia-arrow'></div>";
	echo 	"<div class='inner_product_header_table'>";
	echo 		"<div class='inner_product_header_cell'>";
}

add_action( 'woocommerce_after_shop_loop_item_title',  'avia_close_div', 1000);
add_action( 'woocommerce_after_shop_loop_item_title',  'avia_close_div', 1001);
add_action( 'woocommerce_after_shop_loop_item_title',  'avia_close_div', 1002);


#
# remove on sale badge from usual location and add it to the bottom of the product
#
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);


#
# create the shop navigation with account links, as well as cart and checkout, called as fallback function by the wp_nav_menu function in header.php
#
function avia_shop_nav($args)
{
	$output = "";
	$url = avia_collect_shop_urls();

	$output .= "<ul>";

	if( is_user_logged_in() )
	{
		$current = $sub1 = $sub2 = $sub3 = "";
		if(is_account_page()) $current = "current-menu-item";
		if(is_page(get_option('woocommerce_change_password_page_id'))) $sub1 = "current-menu-item";
		if(is_page(get_option('woocommerce_edit_address_page_id'))) $sub2 = "current-menu-item";
		if(is_page(get_option('woocommerce_view_order_page_id'))) $sub3 = "current-menu-item";


		$output .= "<li class='$current account_overview_link'><a href='".$url['account_overview']."'>".__('My Account', 'avia_framework')."</a>";
			$output .= "<ul>";
			$output .= "<li class='$sub1 account_change_pw_link'><a href='".$url['account_change_pw']."'>".__('Change Password', 'avia_framework')."</a></li>";
			$output .= "<li class='$sub2 account_edit_adress_link'><a href='".$url['account_edit_adress']."'>".__('Edit Address', 'avia_framework')."</a></li>";
			$output .= "<li class='$sub3 account_view_order_link'><a href='".$url['account_view_order']."'>".__('View Order', 'avia_framework')."</a></li>";
			$output .= "</ul>";
		$output .= "</li>";
		$output .= "<li class='account_logout_link'><a href='".$url['logout']."'>".__('Log Out', 'avia_framework')."</a></li>";
	}
	else
	{
		$sub1 = $sub2 = "";
		if(is_page(get_option('woocommerce_myaccount_page_id')))
		{
			if(isset($_GET['account_visible']) && $_GET['account_visible'] == 'register') $sub1 = "current-menu-item";
			if(isset($_GET['account_visible']) && $_GET['account_visible'] == 'login') $sub2 = "current-menu-item";
		}

		$url_param = strpos($url['account_overview'], '?') === false ? "?" : "&";

		if (get_option('woocommerce_enable_myaccount_registration') =='yes')
		{
			$output .= "<li class='register_link $sub1'><a href='".$url['account_overview'].$url_param."account_visible=register'>".__('Register', 'avia_framework')."</a></li>";
		}

		$output .= "<li class='login_link $sub2'><a href='".$url['account_overview'].$url_param."account_visible=login'>".__('Log In', 'avia_framework')."</a></li>";
	}

	$output .= "</ul>";

	if($args['echo'] == true)
	{
		echo $output;
	}
	else
	{
		return $output;
	}
}


#
# helper function that collects all the necessary urls for the shop navigation
#

function avia_collect_shop_urls()
{
	global $woocommerce;

	$url['cart']				= $woocommerce->cart->get_cart_url();
	$url['checkout']			= $woocommerce->cart->get_checkout_url();
	$url['account_overview'] 	= get_permalink(get_option('woocommerce_myaccount_page_id'));
	$url['account_edit_adress']	= get_permalink(get_option('woocommerce_edit_address_page_id'));
	$url['account_view_order']	= get_permalink(get_option('woocommerce_view_order_page_id'));
	$url['account_change_pw'] 	= get_permalink(get_option('woocommerce_change_password_page_id'));
	$url['logout'] 				= wp_logout_url(home_url('/'));

	return $url;
}




#
# check which page is displayed and if the automatic sidebar menu for subpages should be prevented
#
add_filter( 'avf_sidebar_menu_filter', 'avia_woocommerce_sidebar_filter');

function avia_woocommerce_sidebar_filter($menu)
{
	$id = avia_get_the_ID();
	if(is_cart() || is_checkout() || get_option('woocommerce_thanks_page_id') == $id){$menu = "";}
	return $menu;
}


#
# check if a single product is displayed and always set the sidebar styling to that of a right sidebar
#
add_filter( 'avf_sidebar_position', 'avia_woocommerce_sidebar_pos');

function avia_woocommerce_sidebar_pos($sidebar)
{
	if(is_product())
	{
		$sidebar = "sidebar_right";
	}

	return $sidebar;
}



function avia_add_to_cart($post, $product )
{
	echo "<div class='avia_cart avia_cart_".$product->product_type."'>";
	do_action( 'avia_add_to_cart', $post, $product );
	echo "</div>";
}



#
# replace thumbnail image size with full size image on single pages
#
/*

add_filter( 'single_product_small_thumbnail_size', 'avia_woocommerce_thumb_size');

function avia_woocommerce_thumb_size()
{
	return 'shop_single';
}
*/




#
# if we are viewing a woocommerce page modify the breadcrumb nav
#

if(!function_exists('avia_woocommerce_breadcrumb'))
{
	add_filter('avia_breadcrumbs_trail','avia_woocommerce_breadcrumb');

	function avia_woocommerce_breadcrumb($trail)
	{
		global $avia_config;

		if(is_woocommerce())
		{

			$home 		= $trail[0];
			$last 		= array_pop($trail);
			$shop_id 	= woocommerce_get_page_id('shop');
			$taxonomy 	= "product_cat";

			// on the shop frontpage simply display the shop name, rather than shop name + "All Products"
			if(is_shop())
			{
				if(!empty($shop_id) && $shop_id  != -1)  $trail = array_merge( $trail, avia_breadcrumbs_get_parents( $shop_id ) );
				$last = "";

				if(is_search())
				{
					$last = __('Search results for:','avia_framework').' '.esc_attr($_GET['s']);
				}
			}

			// on the product page single page modify the breadcrumb to read [home] [if available:parent shop pages] [shop] [if available:parent categories] [category] [title]
			if(is_product())
			{
				//fetch all product categories and search for the ones with parents. if none are avalaible use the first category found
				$product_category = $parent_cat = array();
				$temp_cats = get_the_terms(get_the_ID(), $taxonomy);

				if(!empty($temp_cats))
				{
					foreach($temp_cats as $key => $cat)
					{
						if($cat->parent != 0 && !in_array($cat->term_taxonomy_id, $parent_cat))
						{
							$product_category[] = $cat;
							$parent_cat[] = $cat->parent;
						}
					}

					//if no categories with parents use the first one
					if(empty($product_category)) $product_category[] = reset($temp_cats);

				}
				//unset the trail and build our own
				unset($trail);

				$trail[0] = $home;
				if(!empty($shop_id) && $shop_id  != -1)    $trail = array_merge( $trail, avia_breadcrumbs_get_parents( $shop_id ) );
				if(!empty($parent_cat)) $trail = array_merge( $trail, avia_breadcrumbs_get_term_parents( $parent_cat[0] , $taxonomy ) );
				if(!empty($product_category)) $trail[] = '<a href="' . get_term_link( $product_category[0]->slug, $taxonomy ) . '" title="' . esc_attr( $product_category[0]->name ) . '">' . $product_category[0]->name . '</a>';

			}


			// add the [shop] trail to category/tag pages: [home] [if available:parent shop pages] [shop] [if available:parent categories] [category/tag]
			if(is_product_category() || is_product_tag())
			{
				if(!empty($shop_id) && $shop_id  != -1)
				{
					$shop_trail = avia_breadcrumbs_get_parents( $shop_id ) ;
					array_splice($trail, 1, 0, $shop_trail);
				}
			}

			if(is_product_tag())
			{
				$last = __("Tag",'avia_framework').": ".$last;
			}


			if(!empty($last)) $trail[] = $last;
		}

		return $trail;
	}

}



#
# creates the avia framework container arround the shop pages
#
add_action( 'woocommerce_before_main_content', 'avia_woocommerce_before_main_content', 10);


function avia_woocommerce_before_main_content()
{
	global $avia_config;

	if(!isset($avia_config['shop_overview_column'])) $avia_config['shop_overview_column'] = "auto";
	
	$id = get_option('woocommerce_shop_page_id');
	$layout = get_post_meta($id, 'layout', true);
	
	if(!empty($layout))
	{
        	$avia_config['layout']['current'] = $avia_config['layout'][$layout];
        	$avia_config['layout']['current']['main'] = $layout;
	}

    	$avia_config['layout'] = apply_filters('avia_layout_filter', $avia_config['layout'], $id);

	$title_args = array();

	if(is_woocommerce())
	{
		$t_link = "";

		if(is_shop()) $title  = get_option('woocommerce_shop_page_title');

		$shop_id = woocommerce_get_page_id('shop');
		if($shop_id && $shop_id != -1)
		{
			if(empty($title)) $title = get_the_title($shop_id);
			$t_link = get_permalink($shop_id);
		}

		if(empty($title)) $title  = __("Shop",'avia_framework');

		if(is_product_category() || is_product_tag())
        {
            global $wp_query;
            $tax = $wp_query->get_queried_object();
            $title = $tax->name;
            $t_link = '';
        }

		$title_args = array('title' => $title, 'link' => $t_link);
	}

	if( get_post_meta(get_the_ID(), 'header', true) != 'no') echo avia_title($title_args);
	
	
	if(is_singular()) { 
		
		$result = 'sidebar_right';
		$avia_config['layout']['current'] = $avia_config['layout'][$result];
		$avia_config['layout']['current']['main'] = $result;
		
	}
	$sidebar_setting = avia_layout_class( 'main' , false );
	echo "<div class='container_wrap container_wrap_first main_color {$sidebar_setting} template-shop shop_columns_".$avia_config['shop_overview_column']."'>";

		echo "<div class='container'>";

		if(!is_singular()) { $avia_config['overview'] = true; }
}

#
# closes the avia framework container arround the shop pages
#

add_action( 'woocommerce_after_main_content', 'avia_woocommerce_after_main_content', 10);
function avia_woocommerce_after_main_content()
{

	global $avia_config;
	$avia_config['currently_viewing'] = "shop";

			//reset all previous queries
			wp_reset_query();

			//get the sidebar
			if(!is_singular())
			get_sidebar();

	//	echo "</div>"; // end container - gets already closed at the top of footer.php

		echo "</div>"; // end tempate-shop content
		echo "</div>"; // close default .container_wrap element
}


add_action( 'avf_custom_sidebar', 'avia_woocommerce_custom_sidebar', 10);
function avia_woocommerce_custom_sidebar($sidebar)
{
	if(is_shop())
	{
		$the_id = woocommerce_get_page_id('shop');
		$sidebar = get_post_meta($the_id, 'sidebar', true);	
	}
	
	return $sidebar;
}




#
# wrap an empty product search into extra div
#
add_action( 'woocommerce_before_main_content', 'avia_woocommerce_404_search', 9111);
function avia_woocommerce_404_search()
{
	global $wp_query;

	if( (is_search() || is_archive()) && empty($wp_query->found_posts) )
	{
		echo "<div class='template-page template-search template-search-none content ".avia_layout_class( 'content', false )." units'>";
		echo "<div class='entry entry-content-wrapper' id='search-fail'>";
	}
}

add_action( 'woocommerce_after_main_content', 'avia_woocommerce_404_search_close', 1);
function avia_woocommerce_404_search_close()
{
	global $wp_query;

	if( (is_search() || is_shop() || is_archive()) && empty($wp_query->found_posts) )
	{
		get_template_part('includes/error404');
		echo "</div>";
		echo "</div>"; // close default .container_wrap element
	}
}




#
# modifies the class of a page so we can display single login and single register
#
add_filter( 'avia_layout_class_filter_main', 'avia_register_login_class');

function avia_register_login_class($layout)
{
	if(isset($_GET['account_visible']))
	{
		if($_GET['account_visible'] == 'register') $layout .= " template-register";
		if($_GET['account_visible'] == 'login') $layout .= " template-login";
	}

	return $layout;
}







#
# creates the avia framework content container arround the shop loop
#
add_action( 'woocommerce_before_shop_loop', 'avia_woocommerce_before_shop_loop', 1);

function avia_woocommerce_before_shop_loop()
{

	global $avia_config;
	if(isset($avia_config['dynamic_template'])) return;
    $markup = avia_markup_helper(array('context' => 'content','echo'=>false,'post_type'=>'products'));
	echo "<main class='template-shop content ".avia_layout_class( 'content' , false)." units' $markup><div class='entry-content-wrapper'>";
}

#
# closes the avia framework content container arround the shop loop
#
add_action( 'woocommerce_after_shop_loop', 'avia_woocommerce_after_shop_loop', 10);

function avia_woocommerce_after_shop_loop()
{
			global $avia_config;
			if(isset($avia_config['dynamic_template'])) return;
			if(isset($avia_config['overview'] )) echo avia_pagination('', 'nav');
			echo "</div></main>"; //end content
}



#
# echo the excerpt
#
function avia_woocommerce_overview_excerpt()
{
	global $avia_config;

	if(!empty($avia_config['shop_overview_excerpt']))
	{
		echo "<div class='product_excerpt'>";
		the_excerpt();
		echo "</div>";
	}
}



#
# creates the preview images based on page/category image
#
remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );
remove_action( 'woocommerce_product_archive_description', 'woocommerce_product_archive_description', 10 );

add_action( 'woocommerce_before_shop_loop', 'avia_woocommerce_overview_banner_image', 10);
add_action( 'woocommerce_before_shop_loop', 'woocommerce_taxonomy_archive_description', 11 );
//add_action( 'woocommerce_before_shop_loop', 'woocommerce_product_archive_description', 12 ); //causes warning


function avia_woocommerce_overview_banner_image()
{
	global $avia_config;
	if(avia_is_dynamic_template() || is_paged() || is_search() ) return false;

	$image_size = "entry_with_sidebar";
	$layout = avia_layout_class( 'main' , false );
	if($layout == 'fullsize') $image_size = 'entry_without_sidebar';

	if(is_shop())
	{
		$shop_id = woocommerce_get_page_id('shop');
		if($shop_id != -1)
		{
			$image = get_the_post_thumbnail($shop_id, $image_size);
			if($image) echo "<div class='page-thumb'>{$image}</div>";
		}
	}
	
	

	if(is_product_category())
	{
		global $wp_query;
		$image	= "";
		if(isset($wp_query->query_vars['taxonomy']))
		{
			$term = get_term_by( 'slug', get_query_var($wp_query->query_vars['taxonomy']), $wp_query->query_vars['taxonomy']);

			if(!empty($term->term_id))
			{
				$attachment_id 	= get_woocommerce_term_meta($term->term_id, 'thumbnail_id');
				$style 			= get_woocommerce_term_meta($term->term_id, 'av_cat_styling');
				
				if(!empty($attachment_id) && empty($style))
				{
					$image = wp_get_attachment_image( $attachment_id, $image_size, false, array('class'=>'category_thumb'));
					if($image) echo "<div class='page-thumb'>{$image}</div>";
				}
				
			}
		}
	}

}



add_action( 'ava_after_main_container', 'avia_woocommerce_big_cat_banner', 11 );


function avia_woocommerce_big_cat_banner()
{
	if(is_product_category())
	{
		global $wp_query, $avia_config;
		
		if(isset($wp_query->query_vars['taxonomy']))
		{	
			$term = get_term_by( 'slug', get_query_var($wp_query->query_vars['taxonomy']), $wp_query->query_vars['taxonomy']);
			if(!empty($term->term_id))
			{
				$description 	= term_description() ;
				$style 			= get_woocommerce_term_meta($term->term_id, 'av_cat_styling');
				$attachment_id 	= get_woocommerce_term_meta($term->term_id, 'thumbnail_id');
				
				$overlay 	= get_woocommerce_term_meta($term->term_id, 'av-banner-overlay');
				$font 		= get_woocommerce_term_meta($term->term_id, 'av-banner-font');
				$opacity 	= get_woocommerce_term_meta($term->term_id, 'av-banner-overlay-opacity');
				
				if(!empty($style))
				{
					remove_action( 'woocommerce_before_shop_loop', 'woocommerce_taxonomy_archive_description', 11 );
					echo avia_woocommerce_parallax_banner($attachment_id, $overlay, $opacity, $description, $font);
					$avia_config['woo-banner'] = true;
				}
			}
		}
	}
}



add_action( 'ava_after_main_container', 'avia_woocommerce_shop_banner', 11 );

function avia_woocommerce_shop_banner()
{
	global $avia_config;
	
	if(is_shop() || (is_product_category() && avia_get_option('shop_banner_global') == "shop_banner_global") && !isset($avia_config['woo-banner']))
	{
		$options = avia_get_option();
		
		if( isset( $options['shop_banner'] )  && ( $options['shop_banner'] == 'av-active-shop-banner' ) )
		{
			$bg 		= $options['shop_banner_image'];
			$overlay 	= $options['shop_banner_overlay_color'];
			$opacity 	= $options['shop_banner_overlay_opacity'];
			$description= wpautop($options['shop_banner_message']);
			$font 		= $options['shop_banner_message_color'];
			
			echo avia_woocommerce_parallax_banner($bg, $overlay, $opacity, $description, $font);
		}
	}
}


function avia_woocommerce_parallax_banner($bg, $overlay, $opacity, $description, $font)
{
	
	if(is_numeric($bg)) 
	{
		$bg = wp_get_attachment_image_src($bg, 'extra_large');
		if(is_array($bg) && $bg[0] != "") $bg = $bg[0];
	}
	
	if($font) $font = "style='color:{$font};'";
	if($bg) $bg = "background-image: url(".$bg.");";
	
	
	
	
	$output = "";
					
	$output .='<div id="av_product_description" class="avia-section main_color avia-section-large avia-no-border-styling avia-full-stretch av-parallax-section av-section-color-overlay-active avia-bg-style-parallax container_wrap fullsize" data-section-bg-repeat="stretch" '.$font.'>';
	$output .='<div class="av-parallax  avia-full-stretch" data-avia-parallax-ratio="0.3">';
	$output .='<div class="av-parallax-inner" style="'.$bg.' main_color background-attachment: scroll; background-position: 50% 50%; background-repeat: no-repeat;">';
	$output .='</div>';
	$output .='</div>';
	
	
	$output .='<div class="av-section-color-overlay-wrap">';
	if(!empty($overlay))
	{
		$output .='<div class="av-section-color-overlay" style="opacity: '.$opacity.'; background-color: '.$overlay.'; "></div>';
	}
	
	$output .='<div class="container">';
	$output .='<main class="template-page content av-content-full alpha units">';
	if($description) $output .= "<h1>".$description."</h1>";
	$output .='</main></div></div></div>';
	
	return $output;
}


#
# creates the title + description for overview pages
#
function avia_woocommerce_advanced_title()
{

	global $wp_query;
	$titleClass 	= "";
	$image		 	= "";


	if(!empty($attachment_id))
	{
		$titleClass .= "title_container_image ";
		$image		= wp_get_attachment_image( $attachment_id, 'thumbnail', false, array('class'=>'category_thumb'));
	}

	echo "<div class='extralight-border title_container shop_title_container $titleClass'>";
	//echo avia_breadcrumbs();
	woocommerce_catalog_ordering();
	echo $image;
}









#
# modify shop overview column count
#
function avia_woocommerce_loop_columns()
{
	global $avia_config;
	return $avia_config['shop_overview_column'];
}


#
# modify shop overview product count
#

function avia_woocommerce_product_count()
{
	global $avia_config;
	return $avia_config['shop_overview_products'];
}


#
# filter cross sells on the cart page. display 4 on fullwidth pages and 3 on carts with sidebar
#

add_filter('woocommerce_cross_sells_total', 'avia_woocommerce_cross_sale_count');
add_filter('woocommerce_cross_sells_columns', 'avia_woocommerce_cross_sale_count');

function avia_woocommerce_cross_sale_count($count)
{
	return 4;
}

#
# move cross sells below the shipping
#

remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' , 10);




#
# display tabs and related items within the summary wrapper
#
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
add_action(    'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1 );



#
# display upsells and related products within dedicated div with different column and number of products
#
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products',20);
remove_action( 'woocommerce_after_single_product', 'woocommerce_output_related_products',10);
add_action( 'woocommerce_after_single_product_summary', 'avia_woocommerce_output_related_products', 20);

function avia_woocommerce_output_related_products($items = false, $columns = false)
{
	global $avia_config;
	$output = "";
	
	if(!$items) 	$items 	 = $avia_config['shop_single_column_items'];
	if(!$columns) 	$columns = $avia_config['shop_single_column'];

	ob_start();
	woocommerce_related_products(array('posts_per_page'=>$items, 'columns'=>$columns)); // X products, X columns
	$content = ob_get_clean();
	if($content)
	{
		$output .= "<div class='product_column product_column_".$columns."'>";
		//$output .= "<h3>".(__('Related Products', 'avia_framework'))."</h3>";
		$output .= $content;
		$output .= "</div>";
	}

	$avia_config['woo_related'] = $output;
	return $output;

}

remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
remove_action( 'woocommerce_after_single_product', 'woocommerce_upsell_display',10);
add_action( 'woocommerce_after_single_product_summary', 'avia_woocommerce_output_upsells', 21); // needs to be called after the "related product" function to inherit columns and product count

function avia_woocommerce_output_upsells($items = false, $columns = false)
{
	global $avia_config;

	$output = "";
	
	if(!$items) 	$items 	 = $avia_config['shop_single_column_items'];
	if(!$columns) 	$columns = $avia_config['shop_single_column'];
	
	ob_start();
	woocommerce_upsell_display($items,$columns); // 4 products, 4 columns
	$content = ob_get_clean();
	if($content)
	{
		$output .= "<div class='product_column product_column_".$columns."'>";
		//$output .= "<h3>".(__('You may also like', 'avia_framework'))."</h3>";
		$output .= $content;
		$output .= "</div>";
	}

	$avia_config['woo_upsells'] = $output;
	return $output;

}

add_action( 'woocommerce_after_single_product_summary', 'avia_woocommerce_display_output_upsells', 30); //display the related products and upsells

function avia_woocommerce_display_output_upsells()
{
	global $avia_config;

	$products = $avia_config['woo_upsells'].$avia_config['woo_related'];

	if(!empty($products))
	{

		$output  = "</div></div></div>";
		$output .= '<div id="av_section_1" class="avia-section alternate_color avia-section-small  container_wrap fullsize"><div class="container"><div class="template-page content  twelve alpha units">';
		$output .= $products;

		echo $output;
	}
}



#
# wrap single product image in an extra div
#
add_action( 'woocommerce_before_single_product_summary', 'avia_add_image_div', 2);
add_action( 'woocommerce_before_single_product_summary',  'avia_close_image_div', 20);
if(!function_exists('avia_add_image_div'))
{
	function avia_add_image_div()
	{
		echo "<div class='single-product-main-image alpha'>";
	}
}



if(!function_exists('avia_close_image_div'))
{
	function avia_close_image_div()
	{
		global $avia_config;
		if(is_product()) {
		$avia_config['currently_viewing'] = "shop_single";
		get_sidebar();
		}
		echo "</div>";
	}
}



#
# wrap single product summary in an extra div
#
add_action( 'woocommerce_before_single_product_summary', 'avia_add_summary_div', 25);
add_action( 'woocommerce_after_single_product_summary',  'avia_close_div', 3);

if(!function_exists('avia_add_summary_div'))
{
	function avia_add_summary_div()
	{
		echo "<div class='single-product-summary'>";
	}
}

//remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );




#
# displays a front end interface for modifying the shoplist query parameters like sorting order, product count etc
#
if(!function_exists('avia_woocommerce_frontend_search_params'))
{
	add_action( 'woocommerce_before_shop_loop', 'avia_woocommerce_frontend_search_params', 20);

	function avia_woocommerce_frontend_search_params()
	{
		global $avia_config;

		if(!empty($avia_config['woocommerce']['disable_sorting_options'])) return false;

		$product_order['default'] 	= __("Default Order",'avia_framework');
		$product_order['title'] 	= __("Name",'avia_framework');
		$product_order['price'] 	= __("Price",'avia_framework');
		$product_order['date'] 		= __("Date",'avia_framework');
		$product_order['popularity'] = __("Popularity",'avia_framework');

		$product_sort['asc'] 		= __("Click to order products ascending",  'avia_framework');
		$product_sort['desc'] 		= __("Click to order products descending",  'avia_framework');

		$per_page_string 		 	= __("Products per page",'avia_framework');


		$per_page 		 		 	= get_option('avia_woocommerce_product_count');
		if(!$per_page) $per_page 	= get_option('posts_per_page');
		if(!empty($avia_config['woocommerce']['default_posts_per_page'])) $per_page = $avia_config['woocommerce']['default_posts_per_page'];


		parse_str($_SERVER['QUERY_STRING'], $params);

		$po_key = !empty($avia_config['woocommerce']['product_order']) ? $avia_config['woocommerce']['product_order'] : 'default';
		$ps_key = !empty($avia_config['woocommerce']['product_sort'])  ? $avia_config['woocommerce']['product_sort'] : 'asc';
		$pc_key = !empty($avia_config['woocommerce']['product_count']) ? $avia_config['woocommerce']['product_count'] : $per_page;

		$ps_key = strtolower($ps_key);
		
		$nofollow = 'rel="nofollow"';

		//generate markup
		$output  = "";
		$output .= "<div class='product-sorting'>";
		$output .= "    <ul class='sort-param sort-param-order'>";
		$output .= "    	<li><span class='currently-selected'>".__("Sort by",'avia_framework')." <strong>".$product_order[$po_key]."</strong></span>";
		$output .= "    	<ul>";
		$output .= "    	<li".avia_woo_active_class($po_key, 'default')."><a href='".avia_woo_build_query_string($params, 'product_order', 'default')."' {$nofollow}>	<span class='avia-bullet'></span>".$product_order['default']."</a></li>";
		$output .= "    	<li".avia_woo_active_class($po_key, 'title')."><a href='".avia_woo_build_query_string($params, 'product_order', 'title')."' {$nofollow}>	<span class='avia-bullet'></span>".$product_order['title']."</a></li>";
		$output .= "    	<li".avia_woo_active_class($po_key, 'price')."><a href='".avia_woo_build_query_string($params, 'product_order', 'price')."' {$nofollow}>	<span class='avia-bullet'></span>".$product_order['price']."</a></li>";
		$output .= "    	<li".avia_woo_active_class($po_key, 'date')."><a href='".avia_woo_build_query_string($params, 'product_order', 'date')."' {$nofollow}>	<span class='avia-bullet'></span>".$product_order['date']."</a></li>";
		$output .= "    	<li".avia_woo_active_class($po_key, 'popularity')."><a href='".avia_woo_build_query_string($params, 'product_order', 'popularity')."' {$nofollow}>	<span class='avia-bullet'></span>".$product_order['popularity']."</a></li>";
		$output .= "    	</ul>";
		$output .= "    	</li>";
		$output .= "    </ul>";

		$output .= "    <ul class='sort-param sort-param-sort'>";
		$output .= "    	<li>";
		if($ps_key == 'desc') 	$output .= "    		<a title='".$product_sort['asc']."' class='sort-param-asc'  href='".avia_woo_build_query_string($params, 'product_sort', 'asc')."' {$nofollow}>".$product_sort['desc']."</a>";
		if($ps_key == 'asc') 	$output .= "    		<a title='".$product_sort['desc']."' class='sort-param-desc' href='".avia_woo_build_query_string($params, 'product_sort', 'desc')."' {$nofollow}>".$product_sort['asc']."</a>";
		$output .= "    	</li>";
		$output .= "    </ul>";

		$output .= "    <ul class='sort-param sort-param-count'>";
		$output .= "    	<li><span class='currently-selected'>".__("Display",'avia_framework')." <strong>".$pc_key." ".$per_page_string."</strong></span>";
		$output .= "    	<ul>";
		$output .= "    	<li".avia_woo_active_class($pc_key, $per_page).">  <a href='".avia_woo_build_query_string($params, 'product_count', $per_page)."' {$nofollow}>		<span class='avia-bullet'></span>".$per_page." ".$per_page_string."</a></li>";
		$output .= "    	<li".avia_woo_active_class($pc_key, $per_page*2)."><a href='".avia_woo_build_query_string($params, 'product_count', $per_page * 2)."' {$nofollow}>	<span class='avia-bullet'></span>".($per_page * 2)." ".$per_page_string."</a></li>";
		$output .= "    	<li".avia_woo_active_class($pc_key, $per_page*3)."><a href='".avia_woo_build_query_string($params, 'product_count', $per_page * 3)."' {$nofollow}>	<span class='avia-bullet'></span>".($per_page * 3)." ".$per_page_string."</a></li>";
		$output .= "    	</ul>";
		$output .= "    	</li>";
		$output .= "	</ul>";



		$output .= "</div>";
		echo $output;
	}
}

//helper function to create the active list class
if(!function_exists('avia_woo_active_class'))
{
	function avia_woo_active_class($key1, $key2)
	{
		if($key1 == $key2) return " class='current-param'";
	}
}


//helper function to build the query strings for the catalog ordering menu
if(!function_exists('avia_woo_build_query_string'))
{
	function avia_woo_build_query_string($params = array(), $overwrite_key, $overwrite_value)
	{
		$params[$overwrite_key] = $overwrite_value;
		$paged = (array_key_exists('product_count', $params)) ? 'paged=1&' : '';
		return "?" . $paged . http_build_query($params);
	}
}

//function that actually overwrites the query parameters
if(!function_exists('avia_woocommerce_overwrite_catalog_ordering'))
{
	add_action( 'woocommerce_get_catalog_ordering_args', 'avia_woocommerce_overwrite_catalog_ordering', 20);

	function avia_woocommerce_overwrite_catalog_ordering($args)
	{
		global $avia_config;

		if(!empty($avia_config['woocommerce']['disable_sorting_options'])) return $args;

		//check the folllowing get parameters and session vars. if they are set overwrite the defaults
		$check = array('product_order', 'product_count', 'product_sort');
		if(empty($avia_config['woocommerce'])) $avia_config['woocommerce'] = array();

		foreach($check as $key)
		{
			if(isset($_GET[$key]) ) $_SESSION['avia_woocommerce'][$key] = esc_attr($_GET[$key]);
			if(isset($_SESSION['avia_woocommerce'][$key]) ) $avia_config['woocommerce'][$key] = $_SESSION['avia_woocommerce'][$key];
		}


		// is user wants to use new product order remove the old sorting parameter
		if(isset($_GET['product_order']) && !isset($_GET['product_sort']) && isset($_SESSION['avia_woocommerce']['product_sort']))
		{
			unset($_SESSION['avia_woocommerce']['product_sort'], $avia_config['woocommerce']['product_sort']);
		}

		extract($avia_config['woocommerce']);

		// set the product order
		if(!empty($product_order))
		{
			switch ( $product_order ) {
				case 'date'  : $orderby = 'date'; $order = 'desc'; $meta_key = '';  break;
				case 'price' : $orderby = 'meta_value_num'; $order = 'asc'; $meta_key = '_price'; break;
				case 'popularity' : $orderby = 'meta_value_num'; $order = 'desc'; $meta_key = 'total_sales'; break;
				case 'title' : $orderby = 'title'; $order = 'asc'; $meta_key = ''; break;
				case 'default':
				default : $orderby = 'menu_order title'; $order = 'asc'; $meta_key = ''; break;
			}
		}



		// set the product count
		if(!empty($product_count) && is_numeric($product_count))
		{
			$avia_config['shop_overview_products_overwritten'] = true;
			$avia_config['shop_overview_products'] = (int) $product_count;
		}

		//set the product sorting
		if(!empty($product_sort))
		{
			switch ( $product_sort ) {
				case 'desc' : $order = 'desc'; break;
				case 'asc' : $order = 'asc'; break;
				default : $order = 'asc'; break;
			}
		}


		if(isset($orderby)) $args['orderby'] = $orderby;
		if(isset($order)) 	$args['order'] = $order;
		if (!empty($meta_key))
		{
			$args['meta_key'] = $meta_key;
		}


		$avia_config['woocommerce']['product_sort'] = $args['order'];

		return $args;
	}


}

//remove produt information on password protected products
if(!function_exists('avia_woocommerce_remove_hooks'))
{
	add_action('woocommerce_before_single_product', 'avia_woocommerce_remove_hooks');

	function avia_woocommerce_remove_hooks()
	{
		/*remove content from password protected products*/
		if(post_password_required())
		{
			add_action( 'woocommerce_after_single_product_summary', 'avia_woocommerce_echo_password', 1 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 1 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20 );
			remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			remove_action( 'woocommerce_simple_add_to_cart', 'woocommerce_simple_add_to_cart', 30 );
			remove_action( 'woocommerce_grouped_add_to_cart', 'woocommerce_grouped_add_to_cart', 30 );
			remove_action( 'woocommerce_variable_add_to_cart', 'woocommerce_variable_add_to_cart', 30 );
			remove_action( 'woocommerce_external_add_to_cart', 'woocommerce_external_add_to_cart', 30 );

			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
		}
	}
}

if(!function_exists('avia_woocommerce_echo_password'))
{
	add_action('ava_woocomemrce_password_protection_remove_hooks', 'avia_woocommerce_remove_hooks');

	function avia_woocommerce_echo_password()
	{
		/*remove content from password protected products*/
		if(post_password_required())
		{
			echo get_the_password_form();
		}
	}
}




if(!function_exists('avia_woocommerce_post_thumbnail_description'))
{
	add_filter('woocommerce_single_product_image_html','avia_woocommerce_post_thumbnail_description', 10, 2);
	function avia_woocommerce_post_thumbnail_description($img, $post_id)
	{
		global $post, $woocommerce, $product;

		if(has_post_thumbnail())
		{
			$image_title = esc_attr(get_post_field('post_content', get_post_thumbnail_id()));
			$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
			$image  = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
				) );
			$attachment_count = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			return sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image);
		}

		return $img;
	}
}

if(!function_exists('avia_woocommerce_gallery_thumbnail_description'))
{
	add_filter('woocommerce_single_product_image_thumbnail_html','avia_woocommerce_gallery_thumbnail_description', 10, 4);
	function avia_woocommerce_gallery_thumbnail_description($img, $attachment_id, $post_id, $image_class )
	{
			$image_link = wp_get_attachment_url( $attachment_id );

			if(!$image_link) return $img;

			$image = wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ) );
			$image_title = esc_attr(get_post_field('post_content', $attachment_id));

			$img = sprintf( '<a href="%s" class="%s" title="%s"  rel="prettyPhoto[product-gallery]">%s</a>', $image_link, $image_class, $image_title, $image );

		return $img;
	}
}


if(!function_exists('avia_title_args_woopage'))
{
	add_filter('avf_title_args','avia_title_args_woopage', 10, 4);
	function avia_title_args_woopage($args)
	{
		if(is_single() && is_product())
		{
			$args['heading'] = "strong";
		}

		return $args;
	}
}


/*
Function that is able to overwrite the default "shop" page used by woocommerce so the template builder can be used
Will only be executed if the user has switched the "shop" page to advanced layout builder. Default products are no longer displayed 
and the user needs to add a product grid element

Can be activated by adding 

add_theme_support( 'avia_custom_shop_page' );

to your functions.php file
*/
if(!function_exists('avia_woocommerce_default_page'))
{
	add_filter( 'pre_get_posts', 'avia_woocommerce_default_page' );
		
	function avia_woocommerce_default_page($query)
	{
	    if(current_theme_supports('avia_custom_shop_page'))
	    {
		    if(!$query->is_admin && $query->is_main_query() && !$query->is_tax && $query->is_archive && $query->is_post_type_archive)
		    {
		    	$vars = $query->query_vars;
		    
		    	if(isset($vars['post_type']) && 'product' == $vars['post_type'] )
		    	{
		    		$shop_page_id 	= wc_get_page_id( 'shop' );
		    		$builder_active = AviaHelper::builder_status($shop_page_id);
		    		
		    		if($builder_active == "active")
		    		{
		    			$query->set( 'post_type', 'page' );
		    			$query->set( 'p', $shop_page_id  );
		    			$query->set( 'meta_query', array() );
		    			
		    			$query->is_singular = true;
		    			$query->is_page 	= true;
		    			$query->is_archive  = false;
		    			$query->is_post_type_archive  = false;
		    			$query->query = array('p'=>$shop_page_id, 'post_type' => 'page');
		    		}
		    	}
		    }
		}  
		
	return $query;
		
	}
}



if(!function_exists('avia_woocommerce_disable_editor'))
{
	add_filter( 'avf_builder_button_params', 'avia_woocommerce_disable_editor' );
    
    
    function avia_woocommerce_disable_editor($params)
    {
    	if(!current_theme_supports('avia_custom_shop_page'))
    	{
    		global $post_ID;
    		$shop_page_id = wc_get_page_id( 'shop' );
    		
    		if($post_ID == $shop_page_id)
    		{
    			$disabled = __('(disabled)', 'avia_framework');
    		
    			$params['visual_label'] 	= $params['visual_label']  . " ".$disabled;
    			$params['default_label'] 	= $params['default_label'] . " ".$disabled;
    			$params['button_class'] 	= "av-builer-button-disabled";
    			$params['disabled'] 		= true;
    			$params['note'] 			= __('This page is set as the default WooCommerce Shop Overview and therefore does not support the Enfold advanced layout editor', 'avia_framework')." <br/><a href='http://www.kriesi.at/documentation/enfold/custom-woocommerce-shop-overview/' target='_blank'>(".__('Learn more').")</a>";
    			
    		}
    	}
    	
    	
    	if(avia_backend_get_post_type() == "product")
    	{
	    	$params['noteclass'] = "av-notice av-only-active";	
	    	$params['note'] = __('Please note that the Advanced Layout Builder for products will not work with all WooCommerce Extensions', 'avia_framework');
    	}
    	
    	
    	
    	
    	return $params;
    }

}

if(!function_exists('avia_woocommerce_disable_editor_option'))
{
	add_filter( 'avf_builder_active', 'avia_woocommerce_disable_editor_option' , 10 , 2);
    
    function avia_woocommerce_disable_editor_option($params, $post_id)
    {
    	if(!current_theme_supports('avia_custom_shop_page'))
    	{
    		if($post_id == wc_get_page_id( 'shop' ))
    		{
    			$params = false;
    		}
    	}
    	
    	return $params;
    }

}






#
# place the cart button according to the header layout (top/sidebar)
#

if(!function_exists('avia_woocommerce_cart_placement'))
{
	add_action( 'init', 'avia_woocommerce_cart_placement', 10);
	
	function avia_woocommerce_cart_placement()
	{
		$position 	= avia_get_option('header_position',  'header_top') == "header_top" ? "ava_main_header" : "ava_inside_main_menu";
		if(avia_get_option('cart_icon') == "always_display_menu") 
		{
			$position = "ava_inside_main_menu";
			if( strpos( avia_get_option('header_layout'), 'bottom_nav_header') !== false && avia_get_option('header_position') == 'header_top')
			{
				$position = "ava_before_bottom_main_menu";
			}
		}
		
		add_action( $position, 'avia_woocommerce_cart_dropdown', 10);
	}
}

	




#
# permanent display of cart button
#

	

if(!function_exists('avia_woocommerce_cart_pos'))
{
	add_filter( 'avf_header_classes', 'avia_woocommerce_cart_pos' , 10 , 3);
    
    function avia_woocommerce_cart_pos($class, $necessary, $prefix)
    {
    	if($prefix == 'html_') // only for the html tag
    	{
	    	global $woocommerce;
	    	$cart = $woocommerce->cart->get_cart();
	    	$cart_pos = avia_get_option('cart_icon');
	    	
	    	if($cart_pos == "always_display" || (!empty($cart) && !avia_active_caching()))
	    	{
				$class[] = "visible_cart";
			}
			
			if($cart_pos == "always_display_menu")
			{
				$class[] = "cart_at_menu";
			}
    	}
    	
    	return $class;
    }

}



function avia_woocommerce_cart_dropdown()
{
	global $woocommerce, $avia_config;
	$cart_subtotal = $woocommerce->cart->get_cart_subtotal();
	$link = $woocommerce->cart->get_cart_url();
	$id = "";
	$added = wc_get_notices('success');
	$trigger = !empty($added) ? "av-display-cart-on-load" : "";
	
	if(avia_get_option('cart_icon') == "always_display_menu")
	{
		$id = 'id="menu-item-shop"';
	}	

	$output = "";
	$output .= "<ul {$id} class = 'cart_dropdown {$trigger}' data-success='".__('was added to the cart', 'avia_framework')."'><li class='cart_dropdown_first'>";
	$output .= "<a class='cart_dropdown_link' href='".$link."'><span ".av_icon_string('cart')."></span><span class='av-cart-counter'>0</span><span class='avia_hidden_link_text'>".__('Shopping Cart','avia_framework')."</span></a><!--<span class='cart_subtotal'>".$cart_subtotal."</span>-->";
	$output .= "<div class='dropdown_widget dropdown_widget_cart'><div class='avia-arrow'></div>";
	$output .= '<div class="widget_shopping_cart_content"></div>';
	$output .= "</div>";
	$output .= "</li></ul>";
	
	
	echo $output;
	
}

/*
	after importing demo pages make sure that if we got multiple shop/my account/etc pages (happens if the user used default woocommerce setup)
	to remove the duplicates and set the theme options properly	
*/

add_action('avia_after_import_hook', 'avia_woocommerce_set_pages');
// add_action('ava_after_main_container', 'avia_woocommerce_set_pages');

function avia_woocommerce_set_pages()
{
	global $wpdb;
	
	$pages = array(
			'shop' => array(
				'title'   => 'Shop',
				'slug'    => 'shop',
			),
			'cart' => array(
				'title'   => 'Cart',
				'slug'    => 'cart',
			),
			'checkout' => array(
				'title'   => 'Checkout',
				'slug'    => 'checkout',
			),
			'myaccount' => array(
				'title'   => 'My Account',
				'slug'    => 'my-account',
			)
		);
	
	/*query string to get multiple posts with the same name*/	
	$pagequery = "SELECT ID FROM $wpdb->posts WHERE post_title = %s AND post_type='page'";
	
	
	foreach ($pages as $page)
	{
		$entries = $wpdb->get_results( $wpdb->prepare( $pagequery , $page['title'] )); 
	
		if(!empty($entries))
		{
			$keep	= 0;
			$delete	= array();
			
			//we got one post of that name. the user did not yet activate woocommerce setup or no page with that name was imported
			if(count($entries) === 1)
			{
				$keep = $entries[0]->ID;
			}
			else //we got 2 or more entries. keep the one with the highest id as woocommerce setting and delete the other ones
			{	
				foreach($entries as $entry)
				{
					if($entry->ID > $keep)
					{
						if($keep) $delete[] = $keep;
						$keep = $entry->ID;
					}
					else
					{
						$delete[] = $entry->ID;
					}
				}
			} 
			
			//delete the not required posts
			foreach($delete as $delete_id)
			{
				wp_delete_post( $delete_id, true );
			}
			
			if($keep > 0)
			{
				//store the value of the $keep as the default woo setting
				$setting = str_replace("-", "", $page['slug']);
				update_option('woocommerce_' . $setting . '_page_id' , $keep);
				
				//modify the page slug and remove any numbers if necessary
				$update_post = array(
				      'ID' 			=> $keep,
				      'post_name' 	=> $page['slug']
				  );
				
				wp_update_post( $update_post );
			}
		}
	}		
}







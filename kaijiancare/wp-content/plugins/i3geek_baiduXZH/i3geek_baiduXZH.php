<?php  
/*
Plugin Name: BaiduXZH Submit PRO(百度熊掌号)
Plugin URI: http://www.i3geek.com/archives/1684
Description: 百度熊掌号wordpress插件，自动推送最新文章或历史文章至百度，以及原创保护文章推送，并支持页面改造SEO优化。
Version: 2.0.1
Author: yan.i3geek
Author URI: http://www.i3geek.com/
License: GPL
*/
require_once("i3geek_baiduXZH_function.php"); 
add_action( 'admin_init', 'i3geek_xzh_admin_init' );
add_action( 'plugins_loaded', 'i3geek_xzh_plugin_setup' );
set_transient('I3GEEK_XZH_MSG_STATUS', 0, 86400);
require_once 'plugin-updates/plugin-update-checker.php';
$MyUpdateChecker = new PluginUpdateChecker(
     'http://xzh.i3geek.com/update-pro.json',
     __FILE__,
     'i3geek_baiduXZH'
 );
function i3geek_xzh_admin_init() {
  i3geek_xzh_default_options();
  i3geek_baiduXZH_function::getNoticeMsg();
  if( @get_transient('I3GEEK_XZH_VIP_FLAG')!=1 ) return;
  add_action( 'do_meta_boxes', 'i3geek_xzh_do_meta_box', 20, 2 );
  add_action( 'admin_enqueue_scripts', 'i3geek_xzh_scripts' );
}
function i3geek_xzh_default_options(){
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if( $Settings == '' ){   
    $Settings = array(
      'Appid'   => '',
      'Token' => '',
      'Types'   => '',
      'auto'  => 'y',
      'original'  => 'y',
    );
    update_option('I3GEEK_XZH_SETTING', $Settings);
  }
}
function i3geek_xzh_plugin_setup(){
  i3geek_baiduXZH_function::getNoticeMsg();
  if( @get_transient('I3GEEK_XZH_VIP_FLAG')!=1 ) return;
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if ( is_array($Settings['Types']) ) {
    foreach($Settings['Types'] as $type) {
      add_action('publish_'.$type, 'i3geek_xzh_publish');
      add_filter('manage_'.$type.'_posts_columns', 'i3geek_xzh_add_post_columns');
      add_action('manage_'.$type.'s_custom_column', 'i3geek_xzh_render_post_columns', 10, 2);
    } 
  }
  $PageSettings = get_option('I3GEEK_XZH_PAGEREFORM');
  if(is_array($PageSettings)){
      remove_action( 'wp_head', 'rel_canonical' );
      add_action( 'wp_head', 'i3geek_xzh_reform_common', 10 );
      if($PageSettings['Pagetype'] == 'h5'){
        add_action( 'wp_head', 'i3geek_xzh_reform_h5', 10 );
        add_filter( 'the_content', 'i3geek_xzh_reform_h5_content', 10 );
      }else{
        add_filter( 'the_content', 'i3geek_xzh_reform_mip_content', 0 );
        add_action( 'wp_footer', 'i3geek_xzh_reform_mip', 10 );
      }
  }
  add_filter( 'the_content', 'i3geek_xzh_common', 10 );
}
function i3geek_xzh_do_meta_box( $type, $context ) {
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if( !is_array($Settings) ) return;
  if ( $Settings['auto'] !== 'y' || !@in_array( $type, $Settings['Types'] ) )
      return;
  if ( 'side' == $context && in_array( $type, array_keys( get_post_types() ) )  )
    add_meta_box( 'sd-i3geek-xzh', '百度熊掌号', 'i3geek_xzh_meta_box', $type, 'side', 'high' );
}
function i3geek_xzh_meta_box() {
    $Settings = get_option('I3GEEK_XZH_SETTING');
    global $post;
    $screen = get_current_screen();
    $lefttimes = i3geek_baiduXZH_function::submit_left();
    $real=-1;$orig=-1;
    if(empty($lefttimes)) $lefttimes="充足（当日尚未提交）<br> <i>每日首次提交成功后，自动更新剩余配额</i>";
    else {$arr = explode("&",$lefttimes);
    if(''==$arr[0]) $arr[0]=-1;if(''==$arr[1]) $arr[1]=-1;
    $real = (int)$arr[0];$orig = (int)$arr[1];$lefttimes="";
    if($real>=0) $lefttimes=$lefttimes."实时：".$real;
    if($orig>=0) $lefttimes=$lefttimes." 原创：".$orig;
   }
    wp_nonce_field( 'i3geek-xzh-post', '_i3geek_xzh_post_nonce', false, true );
    if ( 'add' !== $screen->action ){
      if( get_post_meta( $post->ID, 'i3geek_xzh_submit', TRUE)>='1'){
        echo '<p><input type="checkbox" name="original" id="original" value="1" disabled="disabled" checked/><label for="original">已成功提交至百度熊掌号！</label></p>';
      }else{
        if( get_post_time('G', true, $post)>0 && time() - get_post_time('G', true, $post) > 3600*24){
          echo '<p>超过提交有效时间</p><p>* 注意：请在内容发布24小时内提交数据</p>';
          echo '<p><input type="checkbox" name="original" id="original" value="1" disabled="disabled" /><label for="original">原创提交</label></p>';
        }else i3geek_xzh_meta_box_html($real,$orig,$lefttimes,$Settings);
      }
    }else i3geek_xzh_meta_box_html($real,$orig,$lefttimes,$Settings);
    echo '<input name="i3geek_xzh_submit_CHECK" type="hidden" value="true">';
}
function i3geek_xzh_meta_box_html($real,$orig,$lefttimes,$Settings){
  if($real==0 && $orig==0){
    echo '<p>今日熊掌号提交已达上限</p><p>* 注意：实时与原创保护配额均达上限</p>';
    echo '<p><input type="checkbox" name="original" id="original" value="1" disabled="disabled" /><label for="original">原创提交</label></p>';
  }else if($real==0){
    echo '<p>今日剩余配额：'.$lefttimes.'</p><p>* 注意：实时与原创保护配额独立</p>';
    echo '<p><input type="checkbox" name="original" id="original" value="1" ';
    checked( true );
    echo '/><label for="original">原创提交</label></p>';
  }else if($orig==0){
    echo '<p>今日剩余配额：'.$lefttimes.'</p><p>* 注意：实时与原创保护配额独立</p>';
    echo '<p><input type="checkbox" name="original" id="original" value="1" disabled="disabled" /><label for="original">原创提交</label></p>';
  }else{
    echo '<p>今日剩余配额：'.$lefttimes.'</p><p>* 注意：实时与原创保护配额独立</p>';
    echo '<p><input type="checkbox" name="original" id="original" value="1" ';
    checked( $Settings['original']=='y' );
    echo ' /> <label for="original">' . '原创提交'. '</label></p>';
  }
}
function i3geek_xzh_add_post_columns($columns) {
    $columns['i3geek_xzh'] = '推送至熊掌号';
    return $columns;
}
function i3geek_xzh_render_post_columns($column_name, $id) {
    switch ($column_name) {
    case 'i3geek_xzh':
      if(get_post_meta( $id, 'i3geek_xzh_submit', TRUE)=='1')
        echo '提交成功';
      else if(get_post_meta( $id, 'i3geek_xzh_submit', TRUE)=='2')
        echo '[原创]提交成功';
      else if(get_post_meta( $id, 'i3geek_xzh_submit', TRUE)== '-1')
        echo '历史内容提交成功';
      else if(get_post($id)->post_status == 'publish')
        echo '<div id="i3geek_content'.$id.'">未提交'.'>><a href="javascript:void(0);" onclick="i3geek_xzh_submit('.$id.',\''.wp_create_nonce( 'i3geek-xzh-post' ).'\')">提交</a></div>';
      break;
    }
}
function i3geek_xzh_future_post( $post ) {
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if( in_array($post->post_type,$Settings['Types']) ){
    i3geek_xzh_publish($post->ID,TRUE);
  }
}
function i3geek_xzh_publish($post_ID ,$manual = false) {
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if( is_array($Settings) && !empty($Settings['Appid']) && !empty($Settings['Token']) ){
    if( $manual || $Settings['auto'] == 'y' ){
      if( sanitize_text_field($_POST['i3geek_xzh_submit_CHECK']) )
      i3geek_baiduXZH_function::submit2baidu($post_ID, sanitize_text_field($_POST['original']), $Settings);
      else i3geek_baiduXZH_function::submit2baidu($post_ID, $Settings['original']=='y'?'1':'', $Settings);
    }
  }
}
function i3geek_xzh_history($urls) {
  $urls=trim($urls);
  if(empty($urls)) return;
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if( is_array($Settings) && !empty($Settings['Appid']) && !empty($Settings['Token']) ){
      i3geek_baiduXZH_function::postHistory2baidu($urls, $Settings);
  }
}
function i3geek_xzh_scripts(){
  wp_register_script( 'i3geek_xzh_js', plugins_url('scripts/xzh.js',__FILE__) );  
  wp_enqueue_script( 'i3geek_xzh_js' );  
  wp_register_style( 'i3geek_xzh_css', plugins_url('scripts/xzh.css',__FILE__) );  
  wp_enqueue_style( 'i3geek_xzh_css' );
}
function i3geek_xzh_reform_common(){
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if(is_array($Settings) && is_singular() ){

    global $post;
    if ($post->post_excerpt) {
      $excerpt  = $post->post_excerpt;
    } else {
      if(preg_match('/<p>(.*)<\/p>/iU',trim(strip_tags($post->post_content,"<p>")),$result)){
        $post_content = $result['1'];
      } else {
        $post_content_r = explode("\n",trim(strip_tags($post->post_content)));
        $post_content = $post_content_r['0'];
      }
      $excerpt = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,0}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,120}).*#s','$1',$post_content);
    }
    $temp1 =  str_replace(array("\r\n", "\r", "\n"), "", $excerpt);

  $content = $post->post_content;  
  preg_match_all('/<img .*?src=[\"|\'](.+?)[\"|\'].*?>/', $content, $strResult, PREG_PATTERN_ORDER);  
  $n = count($strResult[1]);  
  $src='';
  if($n >= 3){
    $src = $strResult[1][0].'","'.$strResult[1][1].'","'.$strResult[1][2];
  }else{
    if( $values = get_post_custom_values("thumb") ) {
      $values = get_post_custom_values("thumb");
      $src = $values [0];
    } elseif( has_post_thumbnail() ){
      $thumbnail_src = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'full');
      $src = $thumbnail_src [0];
    } else {
      if($n > 0){ 
        $src = $strResult[1][0];
      } 
    }
  }
  $temp2 = $src;

    echo '<link rel="canonical" href="'.get_the_permalink().'"/>';
    echo '<script type="application/ld+json">{
      "@context": "https://ziyuan.baidu.com/contexts/cambrian.jsonld",
      "@id": "'.get_the_permalink().'",
      "appid": "'.$Settings['Appid'].'",
      "title": "'.get_the_title().'",
      "images": ["'.$temp2.'"],
      "description": "'.$temp1.'",
      "pubDate": "'.get_the_time('Y-m-d\TH:i:s').'"
    }</script>';
  }
}
function i3geek_xzh_reform_h5(){
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if(is_array($Settings) && is_singular() ){
    echo '<script src="//msite.baidu.com/sdk/c.js?appid='.$Settings['Appid'].'"></script>';
  }
}
function i3geek_xzh_reform_h5_content( $content ) {
  if( !is_singular() ) return $content;
  $PageSettings = get_option('I3GEEK_XZH_PAGEREFORM');
  if(is_array($PageSettings) && is_array($PageSettings['CTypes']) && in_array(get_post_type(),$PageSettings['CTypes']) ){
    $Fans = $PageSettings['Fans'];
    if(is_array($Fans))
      foreach ($Fans as $fan) {
        $content = i3geek_baiduXZH_function::fans_location($content, $fan);//日志
      }
  }
  return $content;
}
function i3geek_xzh_reform_mip(){
  if( is_singular() ){
    echo '<script src="https://mipcache.bdstatic.com/extensions/platform/v1/mip-cambrian/mip-cambrian.js"></script>';
  }
}
function i3geek_xzh_reform_mip_content( $content ){
  $Settings = get_option('I3GEEK_XZH_SETTING');
  if(is_array($Settings) && is_singular() ){
    $content = '<mip-cambrian site-id="'.$Settings['Appid'].'"></mip-cambrian>'.$content;
  }
  return $content;
}
function i3geek_xzh_common($content){
  if( is_singular() ){
    $i3geek_xzh_notice = get_option( 'I3GEEK_XZH_NOTICE');
    $tag = is_array($i3geek_xzh_notice)?$i3geek_xzh_notice['htmlcontent']:'http://xzh.i3geek.com';
    return $content.$tag.'<!-- Page reform for Baidu by 爱上极客熊掌号 (i3geek.com) -->';
  }
  return $content;
}
add_filter( 'plugin_action_links', 'i3geek_xzh_add_link', 10, 2 );
function i3geek_xzh_add_link( $actions, $plugin_file ) {
  static $plugin;
  if (!isset($plugin))
    $plugin = plugin_basename(__FILE__);
  if ($plugin == $plugin_file) {
      $settings = array('settings' => '<a href="admin.php?page=i3geek_xzh">' . __('Settings') . '</a>');
      $site_link  = array('support' => '<a href="http://xzh.i3geek.com" target="_blank">官网</a>');
      $actions  = array_merge($settings, $actions);
      $actions  = array_merge($site_link, $actions);
  }
  return $actions;
}
if( is_admin() ) {
    add_action('admin_menu', 'i3geek_xzh_menu');
}
function i3geek_xzh_menu() {
    add_menu_page('百度熊掌号设置', '百度熊掌号', 'manage_options','i3geek_xzh', 'i3geek_xzh_html_page', 'data:image/svg+xml;base64,CjxzdmcgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHhtbG5zOnhsaW5rPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5L3hsaW5rIiB4PSIwcHgiIHk9IjBweCIgdmlld0JveD0iMCAwIDEwMDAgMTAwMCIgZW5hYmxlLWJhY2tncm91bmQ9Im5ldyAwIDAgMTAwMCAxMDAwIiB4bWw6c3BhY2U9InByZXNlcnZlIj4KPG1ldGFkYXRhPiDnn6Lph4/lm77moIfkuIvovb0gOiBodHRwOi8vd3d3LnNmb250LmNuLyA8L21ldGFkYXRhPjxnPjxwYXRoIGQ9Ik0xODYuMyw1MjYuNGMxMDYuNi0yMi45LDkyLjEtMTUwLjIsODguOS0xNzguMWMtNS4yLTQyLjktNTUuNy0xMTcuOS0xMjQuMi0xMTJjLTg2LjIsNy43LTk4LjgsMTMyLjMtOTguOCwxMzIuM0M0MC41LDQyNi4zLDgwLDU0OS4zLDE4Ni4zLDUyNi40eiBNMjk5LjUsNzQ3LjljLTMuMSw5LTEwLjEsMzEuOS00LDUxLjhjMTEuOSw0NC43LDUwLjcsNDYuNyw1MC43LDQ2LjdINDAyVjcxMGgtNTkuN0MzMTUuNCw3MTgsMzAyLjQsNzM4LjksMjk5LjUsNzQ3Ljl6IE0zODQuMSwzMTIuOGM1OC45LDAsMTA2LjQtNjcuNywxMDYuNC0xNTEuNUM0OTAuNSw3Ny43LDQ0MywxMCwzODQuMSwxMGMtNTguOCwwLTEwNi41LDY3LjctMTA2LjUsMTUxLjRDMjc3LjcsMjQ1LjEsMzI1LjQsMzEyLjgsMzg0LjEsMzEyLjh6IE02MzcuNiwzMjIuOWM3OC43LDEwLjIsMTI5LjItNzMuNywxMzkuMy0xMzcuNGMxMC4zLTYzLjUtNDAuNS0xMzcuNC05Ni4yLTE1MGMtNTUuOC0xMi44LTEyNS41LDc2LjYtMTMxLjgsMTM0LjlDNTQxLjMsMjQxLjYsNTU5LjEsMzEyLjgsNjM3LjYsMzIyLjl6IE04MzAuMyw2OTYuOWMwLDAtMTIxLjctOTQuMi0xOTIuNy0xOTUuOWMtOTYuMy0xNTAuMS0yMzMuMS04OS0yNzguOS0xMi43Yy00NS42LDc2LjMtMTE2LjYsMTI0LjYtMTI2LjcsMTM3LjRDMjIxLjgsNjM4LjIsODUsNzEyLDExNS40LDg0Ni45YzMwLjQsMTM0LjgsMTM3LDEzMi4yLDEzNywxMzIuMnM3OC42LDcuNywxNjkuOC0xMi43YzkxLjItMjAuMiwxNjkuNyw1LjEsMTY5LjcsNS4xczIxMy4xLDcxLjMsMjcxLjQtNjZDOTIxLjUsNzY4LjEsODMwLjMsNjk2LjksODMwLjMsNjk2Ljl6IE00NjUuOCw5MDEuM0gzMjcuM2MtNTkuOC0xMS45LTgzLjYtNTIuNy04Ni43LTU5LjdjLTIuOS03LjEtMTkuOS0zOS45LTEwLjktOTUuN2MyNS44LTgzLjYsOTkuNi04OS42LDk5LjYtODkuNkg0MDN2LTkwLjZsNjIuOCwxTDQ2NS44LDkwMS4zTDQ2NS44LDkwMS4zeiBNNzIzLjgsOTAwLjNINTY0LjRjLTYxLjgtMTUuOS02NC43LTU5LjgtNjQuNy01OS44VjY2NC4ybDY0LjctMXYxNTguNGMzLjksMTYuOSwyNC45LDIwLDI0LjksMjBINjU1VjY2NC4yaDY4LjhMNzIzLjgsOTAwLjNMNzIzLjgsOTAwLjN6IE05NDkuNCw0MjkuN2MwLTMwLjQtMjUuMy0xMjIuMS0xMTkuMS0xMjIuMWMtOTMuOSwwLTEwNi41LDg2LjUtMTA2LjUsMTQ3LjdjMCw1OC40LDQuOSwxMzkuOCwxMjEuNiwxMzcuMkM5NjIuMiw1ODkuOSw5NDkuNCw0NjAuMyw5NDkuNCw0MjkuN3oiIHN0eWxlPSJmaWxsOiNhOWI3YjciPjwvcGF0aD48L2c+PC9zdmc+ICA=');
}
function i3geek_xzh_html_page() {
  $plugin_data = get_plugin_data( __FILE__ );
  $i3geek_xzh_notice = i3geek_baiduXZH_function::getNoticeMsg();
  if( @get_transient('I3GEEK_XZH_VIP_FLAG')!=1){
    if(!empty($_POST['action']) && $_POST['action']== 'i3geek_xzh_active'){
      $result = i3geek_baiduXZH_function::active($_POST['i3geek_xzh_key']);
      if($result <0) echo '<div id="message" class="updated" style="border-left-color: #d54e21;background: #fef7f1;"><p>请检查网络连接</p></div>';
      else if($result == 0) echo '<div id="message" class="updated" style="border-left-color: #d54e21;background: #fef7f1;"><p>激活码不正确</p></div>';
      else if($result == 1){ echo '<div id="message" class="updated" ><p>激活成功！ 请刷新页面</p></div>'; i3geek_baiduXZH_function::getNoticeMsg(true);}
    }
    echo '<h3>百度熊掌号 专业版</h3>';
    echo '<form method="post" action >';
    echo '<p>请输入激活码：<input type="text" name="i3geek_xzh_key" class="type-text regular-text"></p>';
    echo '<input type="hidden" name="action" value="i3geek_xzh_active" />';
    echo '<p><input type="submit" value="提交" class="button-primary" /></p></form>';
    echo '<p>购买激活码：<a href="http://xzh.i3geek.com/#pro" target="_blank">http://xzh.i3geek.com/#pro</a></p>';
    return;
  }
  $nonced = ( isset( $_POST['_i3geek_xzh_post_nonce'] ) && wp_verify_nonce( $_POST['_i3geek_xzh_post_nonce'], 'i3geek-xzh-post' ) );
  if($nonced && !empty($_POST['action'])){
  switch ($_POST['action']) {
    case 'i3geek_xzh_setting':
        $appid = sanitize_text_field($_POST['appid']);
        $token = sanitize_text_field($_POST['token']);
        $auto_submit = sanitize_text_field($_POST['auto_submit']);
        $auto_original = sanitize_text_field($_POST['auto_original']);
        i3geek_baiduXZH_function::saveSetting($appid ,$token ,$_POST['Types'] ,$auto_submit ,$auto_original );
        break;
    case 'i3geek_xzh_submit_manual':
        $postid = sanitize_text_field($_POST['postid']);
        i3geek_xzh_publish($postid,TRUE);
        break;
    case 'i3geek_xzh_history_list':
        echo i3geek_baiduXZH_function::getHistorylist();
        break;
    case 'i3geek_xzh_history':
        i3geek_xzh_history($_POST['history_urls']);
        break;
    case 'i3geek_xzh_pagereform':
        i3geek_baiduXZH_function::savePagereform($_POST['page_type'],$_POST['CTypes'], $_POST['fans']);
        break;
    case 'i3geek_xzh_log':
        i3geek_baiduXZH_function::loadLog();
        break;
    }
  }
  require_once('i3geek_baiduXZH_html.php');
} 
?>
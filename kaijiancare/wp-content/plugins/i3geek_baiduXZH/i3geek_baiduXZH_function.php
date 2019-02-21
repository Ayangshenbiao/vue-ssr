<?php
class i3geek_baiduXZH_function{
	const ORIGINAL = 3600;
	public static $success_log;
	public static $fail_log;

	public static function submit_left(){
		$nustr = get_option( 'I3GEEK_XZH_SUBMITNUMBER');
		if(!$nustr){
			return '';
		}else{
			$arr = explode("|",$nustr);
			$times = '';
			if (date('Y-m-d') == date('Y-m-d',$arr[0])) $times = $arr[1];
			return $times;
		}
	}
	public static function submit($real,$orig){
		$nustr = get_option( 'I3GEEK_XZH_SUBMITNUMBER');
		if($nustr){
			$arr = explode("|",$nustr);
			if (date('Y-m-d') == date('Y-m-d',$arr[0])){
				$times = explode("&",$arr[1]);
				if(''==$real) $real = $times[0];
				if(''==$orig) $orig = $times[1];
			} 
		}
		update_option( 'I3GEEK_XZH_SUBMITNUMBER', strtotime('today')."|".$real."&".$orig );
		
	}
	public static function saveSetting($appid,$token,$types,$auto,$original){
		if(empty($appid) || empty($token)) return;
		$appid = trim($appid);
		$token = trim($token);
		$xzh		= self::save_verify($appid, $token);
		if( $xzh && @$xzh['success_batch']!=1 ){
			set_transient('I3GEEK_XZH_MSG_STATUS', 1, 86400);
			set_transient('I3GEEK_XZH_MSG_CONTENT', 'appid或token错误', 86400);
			return;
		}
		$Settings = array( 
			'Appid'		=> $appid,
			'Token'	=> $token,
			'Types'		=> $types,
			'auto'	=> trim($auto),
			'original'	=> trim($original),
		);
		@update_option('I3GEEK_XZH_SETTING', $Settings);
		set_transient('I3GEEK_XZH_MSG_STATUS', -1, 86400);
		set_transient('I3GEEK_XZH_MSG_CONTENT', '保存成功', 86400);
	}
	public static function submit2baidu($post_ID, $original, $Settings){
		$status = get_post_meta( $post_ID, 'i3geek_xzh_submit', TRUE);
		$post = get_post( $post_ID );
		$type='';
		if($status == 2){
			return;
		}else if($status == 1){
			if( ($original=='1') && (time()-get_post_time('G', true, $post)<self::ORIGINAL) ) $type = 'original';
			else return;
		}else{
			if( date('Y-m-d') == date('Y-m-d',get_post_time('G', true, $post)) ){
	          if( ($original=='1') && (time()-get_post_time('G', true, $post)<self::ORIGINAL) ) $type = 'original';
	          else $type='realtime';
	        }else{
	          $type='batch';
	        }
		}
		self::post2baidu($post_ID,$type,$Settings);
	}
	public static function post2baidu($post_ID, $type, $Settings){
		if( $type=='' ) return;
		$api_url = 'http://data.zz.baidu.com/urls?appid='.$Settings['Appid'].'&token='.$Settings['Token'].'&type='.$type;
      	$response = wp_remote_post($api_url, array(
	        'headers' => array('Accept-Encoding'=>'','Content-Type'=>'text/plain'),
	        'timeout' => 10,
	        'sslverify' => false,
	        'blocking'  => true,
	        'body'    => get_permalink($post_ID)
	     ));
	     if ( is_wp_error( $response ) ) {
	        self::write_log('ERROR','01 POST ERROR: '.$response->get_error_message());
	     } else {
	        $res = json_decode($response['body'], true);
	        if($res['success_'.$type]>=1){
	          if($type == 'batch'){
	          	update_post_meta($post_ID, 'i3geek_xzh_submit', '-1');
	          }else if($type == 'realtime'){
	            update_post_meta($post_ID, 'i3geek_xzh_submit', '1');
	            self::submit($res['remain_'.$type],'');
	          }else {
	          	update_post_meta($post_ID, 'i3geek_xzh_submit', '2'); 
	          	self::submit('',$res['remain_'.$type]);
	          }
	          self::write_log('SUCCESS',get_permalink($post_ID).'|'.$type.'|');
	        }elseif($res['remain_'.$type]==0){
	          if($type == 'realtime') self::submit($res['remain_'.$type],'');
	          else self::submit('',$res['remain_'.$type]);
	          self::write_log('FAIL',get_permalink($post_ID).'|'.$type.'|'.'已达上限');
	        }else{
	          self::write_log('FAIL',get_permalink($post_ID).'|'.$type.'|'.'提交失败');
	        }
	      }
	}
	public static function getHistorylist(){
		$results='';
		$args = array(        
       		'numberposts' => -1,  
       		'post_parent' => 'publish'
       	); 
		$lastposts = get_posts($args); 
		foreach($lastposts as $post) :
			if(!get_post_meta( $post->ID, 'i3geek_xzh_submit', TRUE)){
				$results.=get_permalink($post->ID);
				$results.='|';
			}
		endforeach;
		return 'i3geek_xzh_start'.$results.'i3geek_xzh';
	}
	public static function postHistory2baidu($urls, $Settings){
		$api_url = 'http://data.zz.baidu.com/urls?appid='.$Settings['Appid'].'&token='.$Settings['Token'].'&type=batch';
      	$response = wp_remote_post($api_url, array(
	        'headers' => array('Accept-Encoding'=>'','Content-Type'=>'text/plain'),
	        'timeout' => 10,
	        'sslverify' => false,
	        'blocking'  => true,
	        'body'    => $urls
	     ));
	     if ( is_wp_error( $response ) ) {
	        self::write_log('ERROR','01 POST ERROR: '.$response->get_error_message());
	     } else {
	        $res = json_decode($response['body'], true);
	        if($res['success_batch']>0){
	        	set_transient('I3GEEK_XZH_MSG_STATUS', -1, 86400);
				set_transient('I3GEEK_XZH_MSG_CONTENT', '批量提交历史内容'.$res['success_batch'].'条成功，还剩配额'.$res['remain_batch'], 86400);

	          	self::write_log('SUCCESS',$res['success_batch'].'条历史内容批量提交'.'|'.'batch'.'|');
	        }elseif($res['remain_batch']==0){
	        	set_transient('I3GEEK_XZH_MSG_STATUS', 1, 86400);
				set_transient('I3GEEK_XZH_MSG_CONTENT', '历史内容批量提交已达上限', 86400);
	        	self::write_log('FAIL','历史内容批量提交'.'|'.'batch'.'|'.'已达上限');
	        }else{
	        	set_transient('I3GEEK_XZH_MSG_STATUS', 1, 86400);
				set_transient('I3GEEK_XZH_MSG_CONTENT', '历史内容批量提交失败', 86400);
	          	self::write_log('FAIL','历史内容批量提交'.'|'.'batch'.'|'.'提交失败');
	        }
	      }
	}
	public static function savePagereform($pagetype,$ctypes,$fans){
		if(empty($pagetype) ) return;
		$Settings = array( 
			'Pagetype'		=> $pagetype,
			'CTypes'		=> $ctypes,
			'Fans'	=> $fans,

		);
		@update_option('I3GEEK_XZH_PAGEREFORM', $Settings);
		set_transient('I3GEEK_XZH_MSG_STATUS', -1, 86400);
		set_transient('I3GEEK_XZH_MSG_CONTENT', '保存成功', 86400);
	}
	function i3geek_xzh_excerpt($len=120){
		if ( is_single() || is_page() ){
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
				$excerpt = preg_replace('#^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,0}'.'((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$len.'}).*#s','$1',$post_content);
			}
			return str_replace(array("\r\n", "\r", "\n"), "", $excerpt);
		}
	}
	function i3geek_xzh_post_imgs(){
		global $post;
		$content = $post->post_content;  
		preg_match_all('/<img .*?src=[\"|\'](.+?)[\"|\'].*?>/', $content, $strResult, PREG_PATTERN_ORDER);  
		$n = count($strResult[1]);  
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
		return $src;
	}
	public static function fans_location($content, $fans){
		switch ($fans) {
			case 'head':
				return '<script>cambrian.render(\'head\')</script>'.$content;
				break;
			case 'body':
				return self::insert_after_p('<script>cambrian.render(\'body\')</script>',2,$content);
				break;
			case 'foot':
				return $content.'<script>cambrian.render(\'tail\')</script>';
				break;
		}
	}
	public static function insert_after_p( $insertion, $paragraph_id, $content ) {
		$closing_p = '</p>';
		$paragraphs = explode( $closing_p, $content );
		foreach ($paragraphs as $index => $paragraph) {
			if ( trim( $paragraph ) ) {
				$paragraphs[$index] .= $closing_p;
			}
			if ( $paragraph_id == $index + 1 ) {
				$paragraphs[$index] .= $insertion;
			}
		}
		return implode( '', $paragraphs );
	}
	public static function log_file($type){
		$filename= 'submit_log.txt';
		switch ($type) {
			case 'ERROR':
				$filename= 'i3geek_baiduXZH.error';
				break;
			case 'SUCCESS':
				$filename= 'i3geek_baiduXZH.success';
				break;
			case 'FAIL':
				$filename= 'i3geek_baiduXZH.fail';
				break;
		}
		return dirname(__FILE__).'/log/'.$filename;
	}
	public static function write_log($type,$content){
		$file = self::log_file($type);
		if(is_writable($file)){
	        $handle = @fopen($file,"a");
	        $time = current_time('Y-m-d H:i:s');
	        fwrite($handle,$time.'|'.$content."\n");
	        fclose($handle);
	        set_transient('I3GEEK_XZH_LOG_WRITABLE', 0, 3600);
	    }else{
	    	set_transient('I3GEEK_XZH_LOG_WRITABLE', 1, 3600);
	    }
	}
	public static function read_log($type, $n){
		return self::read_file_last(self::log_file($type),$n);
	}
	public static function read_file_last($filename,$n){
	  if(!$fp=@fopen($filename,'r')){
	    return false;
	  }
	  $pos=-2;
	  $eof="";
	  $arr = array();
	  while($n>0){
	    while($eof!="\n"){
	      if(!fseek($fp,$pos,SEEK_END)){
	        $eof=fgetc($fp);
	        $pos--;
	      }else{
	      	$n = 0;
	      	fseek($fp, $pos+1, SEEK_END); 
	        break;
	      }
	    }
	    $arr[] = explode("|",fgets($fp));
	    $eof="";
	    $n--;
	  }
	  return $arr;
	}
	public static function loadLog(){
		self::$success_log = self::read_log('SUCCESS',10);
		self::$fail_log = self::read_log('FAIL',10);
	}
	public static function save_verify($Appid, $Token){
		$baidu_api_url = 'http://data.zz.baidu.com/urls?appid='.$Appid.'&token='.$Token.'&type=batch';
		$response = wp_remote_post($baidu_api_url, array(
			'headers'	=> array('Accept-Encoding'=>'','Content-Type'=>'text/plain'),
			'timeout'	=> 10,
			'sslverify'	=> false,
			'blocking'	=> true,
			'body'		=> home_url()
		));
		if(is_array($response) && array_key_exists('body', $response)){
			$data = json_decode( $response['body'], true );
			return $data;
		}else{return FALSE;}
	}
	public static function getNoticeMsg($force = false){
		if( !$force && get_transient('I3GEEK_XZH_UPDATE_FLAG')==1 )return get_option( 'I3GEEK_XZH_NOTICE');
		$response = wp_remote_get( 'http://xzh.i3geek.com/baiduXZH_VIP.php?url='.home_url(), array('timeout' => 10) );
		if (!is_wp_error($response) && $response['response']['code'] == '200' ){
			$res = json_decode( $response['body'] ,true );
			@update_option('I3GEEK_XZH_NOTICE', $res);
			set_transient('I3GEEK_XZH_UPDATE_FLAG', 1, 10000);
			set_transient('I3GEEK_XZH_VIP_FLAG', $res['vip'], 10800);
			return $res;
		}else{
			@update_option('I3GEEK_XZH_NOTICE', '');
			return '';
		}
	}
	public static function active($key){
		$response = wp_remote_get( 'http://xzh.i3geek.com/jihuo.php?action=active&key='.$key.'&url='.home_url(), array('timeout' => 10) );
		if (!is_wp_error($response) && $response['response']['code'] == '200' ){
			$res = json_decode( $response['body'] ,true );
			return $res['result'];
		}else{
			return -1;
		}
	}
}
?>
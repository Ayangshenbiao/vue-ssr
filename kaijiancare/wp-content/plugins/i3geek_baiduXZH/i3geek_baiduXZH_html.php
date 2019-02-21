<?php
$current_tab = 'base';
if ( isset( $_GET[ 'tab' ] ) ) $current_tab = $_GET[ 'tab' ];
?>
<div class="wrap">  
    <h2>百度熊掌号（专业版）设置</h2>  
    <?php if( !is_writable(dirname(__FILE__).'/log/') || get_transient('I3GEEK_XZH_LOG_WRITABLE')==1 ){ set_transient('I3GEEK_XZH_LOG_WRITABLE', 0, 3600);?>
          <div id="message" class="updated" style="border-left-color: #d54e21;background: #fef7f1;">
            <p>log目录没有写权限！请设置/wp-content/plugins/i3geek_baiduXZH/log/目录及其中所有文件777权限 <a href="http://xzh.i3geek.com" target="_blank">查看帮助</a></p>
          </div>
    <?php } ?>
    <?php if( is_array($i3geek_xzh_notice) && $i3geek_xzh_notice['version'] > $plugin_data['Version'] ){?>
          <div id="message" class="updated" style="border-left-color: #f0ad4e;background: #fcf8e4;">
            <p>百度熊掌号 插件已有新版本啦！请更新插件到最新版，以避免百度处罚 <a href=<?php echo '"'.$i3geek_xzh_notice['download'].'"'; ?> target="_blank">查看详情</a></p>
          </div>
    <?php } ?>
    <?php if( is_array($i3geek_xzh_notice) && $i3geek_xzh_notice['msg_switch']==0 ){}else{ ?>
          <div id="notice_msg" class="updated" style="border-left-color: #00a0d2;background: #f7fcfe;">
            <p><strong>公告</strong>： <?php echo is_array($i3geek_xzh_notice)?$i3geek_xzh_notice['content']:'请更新插件到最新版，以避免百度处罚，详情查看插件主页：<a href="http://xzh.i3geek.com" target="_blank">百度熊掌号</a>'; ?></p>
          </div>
    <?php } ?>
    <?php if( get_transient('I3GEEK_XZH_MSG_STATUS') > 0){ ?>
        <div id="message" class="updated" style="border-left-color: #d54e21;background: #fef7f1;">
            <p><?php echo get_transient('I3GEEK_XZH_MSG_CONTENT'); ?></p>
        </div>
        <?php }elseif( get_transient('I3GEEK_XZH_MSG_STATUS') < 0){ ?>
        <div id="message" class="updated">
            <p><?php echo get_transient('I3GEEK_XZH_MSG_CONTENT'); ?></p>
        </div>
    <?php } ?>
        <h2 class="nav-tab-wrapper" style="border-bottom: 1px solid #ccc;">
          <a class="nav-tab <?php if($current_tab == 'base') echo "nav-tab-active" ;?>" href="?page=i3geek_xzh&tab=base" id="tab-title-setting">基本配置</a>
          <a class="nav-tab <?php if($current_tab == 'history') echo "nav-tab-active" ;?>" href="?page=i3geek_xzh&tab=history" id="tab-title-history">历史内容批量</a>
          <a class="nav-tab <?php if($current_tab == 'reform') echo "nav-tab-active" ;?>" href="?page=i3geek_xzh&tab=reform" id="tab-title-change">页面改造</a>
          <a class="nav-tab <?php if($current_tab == 'log') echo "nav-tab-active" ;?>" href="?page=i3geek_xzh&tab=log" id="tab-title-log">提交记录</a>
          <a class="nav-tab" href="http://xzh.i3geek.com" target="_blank" id="tab-title-about">帮助/关于</a>
        </h2>
        <?php $Settings = get_option('I3GEEK_XZH_SETTING');?>
        <?php
          switch ($current_tab) {
            default:
            case 'base':
        ?>
        <div id="tab-setting" class="div-tab" >
          <h3>熊掌号设置</h3>
            <p><strong>* 获取相关参数：注册百度熊掌号并绑定站点，在“提交方式”中查看所需参数填写在下方。<a href="http://ziyuan.baidu.com/xzh/commit/method" target="_blank">百度熊掌号</a></strong></p>
            <table class="form-table">
              <form method="post" action >
              <tbody>
                <tr>
                  <th scope="row">
                    <label for="host">appid</label>
                  </th>
                  <td>
                    <input type="text" name="appid" class="type-text regular-text" value="<?php echo $Settings['Appid']?>">
                    <p><i>您的熊掌号唯一识别ID</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <label for="bucket">token</label>
                  </th>
                  <td>
                    <input type="text" name="token" class="type-text regular-text" value="<?php echo $Settings['Token']?>">
                    <p><i>在搜索资源平台申请的推送用的准入密钥</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><label>文章类型支持</label></th>
                  <td><?php
                     $args = array('public' => true,);
                     $post_types = get_post_types($args);
                     foreach ( $post_types  as $post_type ) {
                        if($post_type != 'attachment'){
                          $postType = get_post_type_object($post_type);
                          echo '<label><input type="checkbox" name="Types[]" value="'.$post_type.'" ';
                          if(is_array($Settings['Types'])) {if(in_array($post_type,$Settings['Types'])) echo 'checked';}
                          echo '>'.$postType->labels->singular_name.' &nbsp; &nbsp; </label>';
                        }
                     }?>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <label for="access">自动提交</label>
                  </th>
                  <td>
                    <input type="radio" name="auto_submit" value="y" checked/>是 <input type="radio" name="auto_submit" value="n" />否
                    <p><i>当发布新文章时自动提交链接到百度官方熊掌号（若关闭则必须在本插件中手动提交）</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <label for="access">默认原创</label>
                  </th>
                  <td>
                    <input type="radio" name="auto_original" value="y" checked/>是 <input type="radio" name="auto_original" value="n" />否
                    <p><i>当发布新文章时默认原创保护提交至百度，可以在页面中修改（确认拥有“原创内容”权限，否则勿选）</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <input type="hidden" name="action" value="i3geek_xzh_setting" /> 
                    <input type="hidden" name="current_tab" value="setting"/>
                    <?php wp_nonce_field( 'i3geek-xzh-post', '_i3geek_xzh_post_nonce', false, true ); ?>
                    <input type="submit" value="保存" class="button-primary" />
                  </th>
                </tr>
              </tbody>
              </form>
            </table>
            <p>
              <strong>温馨提示</strong>：<br>
              1. 若关闭自动提交，可通过文章列表后面按钮进行手动提交；<br>
              2. 请正常操作，以免被百度封号；<br>
              3. 其它问题或建议请联系 <a target="_blank" href="http://www.i3geek.com">I3geek.com</a> 进行反馈。<br>
            </p>
        </div>
        <?php
              break;
            case 'history':
        ?>
    <div id="tab-history" class="div-tab">
        <h3>历史内容批量提交</h3>
          <p><strong>* 请先点击“获取文字链接”按钮自动获取链接后再提交</strong></p>
            <table class="form-table">
              <form method="post" action >
              <tbody>
                <tr>
                  <th scope="row">
                    <label for="host">历史内容url</label>
                  </th>
                  <td>
                    <textarea name="history_urls" id="i3geek_xzh_history_urls" style="width:40%;height:300px;" > </textarea>
                    <p><i>处于已发布状态且未有提交记录的历史文章，可以手动添加，保证一行一个链接即可</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <input type="hidden" name="action" value="i3geek_xzh_history" /> 
                    <input type="hidden" name="current_tab" value="history"/>
                    <?php wp_nonce_field( 'i3geek-xzh-post', '_i3geek_xzh_post_nonce', false, true ); ?>
                    <input type="button" value="获取文章链接" class="button-primary" onclick=<?php echo '"i3geek_xzh_history_list(\''.wp_create_nonce( 'i3geek-xzh-post' ).'\')"'; ?> id="i3geek_button_history"/>
                    <input type="submit" value="提交" class="button-primary" />
                  </th>
                </tr>
              </tbody>
              </form>
            </table>
            <p>
              <strong>温馨提示</strong>：<br>
              1. 请勿多次重复提交；<br>
              2. 可以收到添加链接，但是必须为绑定域名下的链接；<br>
              3. 其它问题或建议请联系 <a target="_blank" href="http://www.i3geek.com">I3geek.com</a> 进行反馈。<br>
            </p>
    </div>
    <?php
              break;
            case 'reform':
    ?>
        <?php $Settings = get_option('I3GEEK_XZH_SETTING');$PageSettings = get_option('I3GEEK_XZH_PAGEREFORM');?>
        <div id="tab-change" class="div-tab">
          <h3>熊掌号页面改造</h3>
            
            <p><strong>* 页面改造是指：粉丝关注功能与搜索结果出图功能</strong></p>
            <table class="form-table">
              <form method="post" action >
              <tbody>
                <tr>
                  <th scope="row">
                    <label for="access">页面类型</label>
                  </th>
                  <td>
                    <input type="radio" name="page_type" value="h5" checked/>H5页面 <input type="radio" name="page_type" value="mip" />MIP页面
                    <p><i>根据使用的主题页面类型来选择</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <label for="access">粉丝关注按钮位置</label>
                  </th>
                  <td>
                    <input type="checkbox" name="fans[]" value="head"/>顶部 <input type="checkbox" name="fans[]" value="body" />段落间 <input type="checkbox" name="fans[]" value="foot" />底部
                    <p><i>文章页面添加熊掌号粉丝关注功能，最多选择2个位置（该设置仅H5页面有效）</i></p>
                  </td>
                </tr>
                <tr>
                  <th scope="row"><label>改造类型支持</label></th>
                  <td><?php
                     $args = array('public' => true,);
                     $post_types = get_post_types($args);
                     foreach ( $post_types  as $post_type ) {
                        if($post_type != 'attachment'){
                          $postType = get_post_type_object($post_type);
                          echo '<label><input type="checkbox" name="CTypes[]" value="'.$post_type.'" ';
                          if(is_array($PageSettings['CTypes'])) {if(in_array($post_type,$PageSettings['CTypes'])) echo 'checked';}
                          echo '>'.$postType->labels->singular_name.' &nbsp; &nbsp; </label>';
                        }
                     }?>
                  </td>
                </tr>
                <tr>
                  <th scope="row">
                    <input type="hidden" name="action" value="i3geek_xzh_pagereform" /> 
                    <input type="hidden" name="current_tab" value="change"/>
                    <?php wp_nonce_field( 'i3geek-xzh-post', '_i3geek_xzh_post_nonce', false, true ); ?>
                    <input type="submit" value="保存" class="button-primary" />
                  </th>
                </tr>
              </tbody>
              </form>
            </table>
            <p>
              <strong>温馨提示</strong>：<br>
              1. 页面类型选择时按照主题选择，若主题是MIP规范则选择“MIP页面”，若是H5或不清楚的选择“H5页面”即可；<br>
              2. 添加粉丝关注功能段落间将随机段落添加；<br>
              3. 其它问题或建议请联系 <a target="_blank" href="http://www.i3geek.com">I3geek.com</a> 进行反馈。<br>
            </p>
        </div>
    <?php
              break;
            case 'log':
    ?>
    <div id="tab-log" class="div-tab">
        <h3>提交记录</h3>
        <form method="post" action>
          <input type="hidden" name="action" value="i3geek_xzh_log" /> 
          <input type="hidden" name="current_tab" value="log"/>
          <?php wp_nonce_field( 'i3geek-xzh-post', '_i3geek_xzh_post_nonce', false, true ); ?>
          <input type="submit" value="获取" class="button-primary" />
        </form>
        <p><strong>* 点击“获取”按钮，加载操作记录（只能显示最近10条记录）</strong></p>
            <?php

              if(is_array(i3geek_baiduXZH_function::$success_log) && !empty(i3geek_baiduXZH_function::$success_log[0][0])){
                echo '<div style="border-left: solid #5ab961;background: #dff0d9;padding: 10px;"><p>成功记录</p><table border="1">';
                echo '<tr><td>ID</td><td>日期</td><td>链接</td><td>类型</td></tr>';
                foreach (i3geek_baiduXZH_function::$success_log as $key => $value) {
                  echo '<tr><td>'.($key+1).'</td><td>'.$value[0].'</td><td>'.$value[1].'</td><td>'.($value[2]=='batch'?'历史内容':($value[2]=='realtime'?'实时内容':'原创内容')).'</td></tr>';
                }
                echo '</table></div>';
              }
            ?>
            <?php
              if( is_array(i3geek_baiduXZH_function::$fail_log) && !empty(i3geek_baiduXZH_function::$fail_log[0][0])){
                echo '<div id="message" style="border-left: solid #d54e21;background: #fef7f1;padding: 10px;"><p>失败记录</p><table border="1">';
                echo '<tr><td>ID</td><td>日期</td><td>链接</td><td>类型</td><td>原因</td></tr>';
                foreach (i3geek_baiduXZH_function::$fail_log as $key => $value) {
                  echo '<tr><td>'.($key+1).'</td><td>'.$value[0].'</td><td>'.$value[1].'</td><td>'.($value[2]=='batch'?'历史内容':($value[2]=='realtime'?'实时内容':'原创内容')).'</td><td>'.$value[3].'</td></tr>';
                }
                echo '</table></div>';
              }
            ?>
    </div>
    <?php
    break;}
    ?>
    <div id="tab-about" class="div-tab hidden" style="display: none;">
      <div class="welcome_inner">
        <div class="welcometxt">
          <img class="backwpup-banner-img" src=<?php echo '"'.plugin_dir_url(__FILE__).'logo.png"'; ?>>
          <h1>感谢使用</h1>
          <p>本插件主要是为了使百度熊掌号（原百家号）以及百度搜索的实时收录，进行自动的URL提交，站点的SEO优化等</p>
          <p>在使用中遇到问题或建议请及时和我联系：yan#i3geek.com(请把#替换成@)</p>
          <p>同时为了维护插件，欢迎使用者进行捐赠并提供了专业版进行购买</p>
        </div>
      </div>
      <div class="backwpup_comp">
            <h3>免费版和专业版</h3>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody><tr class="even ub">
                <td>功能</td>
                <td class="free">FREE</td>
                <td class="pro">PRO</td>
              </tr>
              <tr class="odd">
                <td>自动推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>手动推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>实时内容推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>原创内容推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>历史内容推送</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>推送结果展示</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>可选内容类型</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>提交记录查看</td>
                <td class="tick">YES</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>页面结构化改造</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>MIP页面改造</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>H5页面改造</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>粉丝关注按钮改造</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>未提交文章检索</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td>历史内容批量提交</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td>手动批量提交</td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="even">
                <td><strong>高级支持</strong></td>
                <td class="error">NO</td>
                <td class="tick">YES</td>
              </tr>
              <tr class="odd">
                <td><strong>自动更新</strong></td>
                <td class="error" style="border-bottom:none;">NO</td>
                <td class="tick" style="border-bottom:none;">YES</td>
              </tr>
              <tr class="odd ubdown">
                <td></td>
                <td></td>
                <td class="pro buylink"><a href="http://xzh.i3geek.com/#pro">GET PRO</a></td>
              </tr>
            </tbody></table>
          </div>
    </div>
    <hr>
    <div style='text-align:center;'>
      <a href="http://xzh.i3geek.com/" target="_blank">插件主页</a> | <a href="http://www.i3geek.com/archives/1681" target="_blank">插件讨论</a> | <a href="mailto:yan@i3geek.com" target="_blank">联系作者</a> | <a href="http://www.i3geek.com" target="_blank">作者主页</a> | <a href="mailto:yan@i3geek.com" target="_blank">意见反馈</a> | <a href="http://www.i3geek.com" target="_blank">i3geek.com</a> | QQ群：194895016
    </div>
</div>  
<script type='text/javascript'>
  <?php
    if(is_array($Settings)){
      echo 'jQuery("input[type=\'radio\'][name=\'auto_submit\'][value=\''.$Settings['auto'].'\']").attr("checked",true);';
      echo 'jQuery("input[type=\'radio\'][name=\'auto_original\'][value=\''.$Settings['original'].'\']").attr("checked",true);';
    }
    echo "var current_tab='".$_POST['current_tab']."';";
    if(is_array($PageSettings)){
      echo 'jQuery("input[type=\'radio\'][name=\'page_type\'][value=\''.$PageSettings['Pagetype'].'\']").attr("checked",true);';
      if($PageSettings['Fans']){
        foreach ($PageSettings['Fans'] as $fan){ 
          echo 'jQuery("input:checkbox[value=\''.$fan.'\']").attr(\'checked\',\'true\');';
        }
        if(sizeof($PageSettings['Fans'])== 2){
          echo 'jQuery("input[name=\'fans[]\']").attr(\'disabled\', true);';
          echo 'jQuery("input[name=\'fans[]\']:checked").attr(\'disabled\', false);';
        }
      }
    }
  ?>
  jQuery(function(jQuery){
    jQuery('input[type=checkbox]').click(function() {
      jQuery("input[name='fans[]']").attr('disabled', true);
      if (jQuery("input[name='fans[]']:checked").length >= 2) {
          jQuery("input[name='fans[]']:checked").attr('disabled', false);
      } else {
          jQuery("input[name='fans[]']").attr('disabled', false);
      }
    });
  return false;
});

</script>
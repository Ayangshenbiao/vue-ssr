function i3geek_xzh_submit(id, nonce){
	document.getElementById("i3geek_content"+id).innerHTML = '已提交';
	jQuery.post("admin.php?page=i3geek_xzh", { action: "i3geek_xzh_submit_manual", postid: id, _i3geek_xzh_post_nonce: nonce, original:1 } );
}
function i3geek_xzh_history_list( nonce ){
	var oldvalue = document.getElementById('i3geek_button_history').value;
	document.getElementById('i3geek_button_history').value='获取中';
	document.getElementById('i3geek_button_history').disabled=true;
	jQuery.post("admin.php?page=i3geek_xzh", { action: "i3geek_xzh_history_list", _i3geek_xzh_post_nonce: nonce},function(data){
		var index = data.indexOf('|i3geek_xzh');
		var start = data.indexOf('i3geek_xzh_start')+16;
		if(index > -1){
			var str = data.substring(start,index);
			var arr = str.split('|');
			var value = '';
			for (var i=0;i<arr.length ;i++ ) {
				value +=arr[i] + "\r\n";
			}
			console.log(value);
			document.getElementById('i3geek_xzh_history_urls').value =value;
   			document.getElementById("i3geek_xzh_history_urls").innerHTML = value;
   			document.getElementById('i3geek_button_history').value=oldvalue;
			document.getElementById('i3geek_button_history').disabled=false;
		}
	} );
} 
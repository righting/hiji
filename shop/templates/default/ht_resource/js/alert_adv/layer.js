$(document).ready(function(){
	var $alert_adv_layer_cont = $(".alert_adv_layer_cont");
	var $alert_adv_layer_close = $(".alert_adv_layer_close");
	var $alert_adv_layer_btn = $(".alert_adv_layer_btn > ul > li");
	var $alert_adv_layer_content = $(".alert_adv_layer_content > ul > li");
	var alert_adv_layer_btn_hover = "hover";
	var alert_adv_layer_show_num = 0;
	var alert_adv_layer_btn_Len = $alert_adv_layer_btn.length;
	$alert_adv_layer_btn.hover(function(){
		var alert_adv_layer_show_num = $alert_adv_layer_btn.index(this);
		$(this).addClass(alert_adv_layer_btn_hover).siblings().removeClass(alert_adv_layer_btn_hover);
		$alert_adv_layer_content.eq(alert_adv_layer_show_num).show().siblings().hide();
		});
	var alert_adv_layer_play = function(){
		alert_adv_layer_show_num++;
		if(alert_adv_layer_show_num>=alert_adv_layer_btn_Len) alert_adv_layer_show_num=0;
		$alert_adv_layer_btn.eq(alert_adv_layer_show_num).addClass(alert_adv_layer_btn_hover).siblings().removeClass(alert_adv_layer_btn_hover);
		$alert_adv_layer_content.eq(alert_adv_layer_show_num).show().siblings().hide();
		};
	
	$alert_adv_layer_close.click(function(){clearInterval(alert_adv_layer_play_time);$alert_adv_layer_cont.slideUp();});
	alert_adv_layer_pop = function(){
		$alert_adv_layer_cont.slideDown();
		$alert_adv_layer_btn.eq(alert_adv_layer_show_num).addClass(alert_adv_layer_btn_hover);
		$alert_adv_layer_content.eq(alert_adv_layer_show_num).show();
		alert_adv_layer_play_time = setInterval(function(){alert_adv_layer_play();},2000);
		};
	});
var scripts=document.getElementsByTagName("script"),script=scripts[scripts.length-1];
strJsPath=document.querySelector?script.src:script.getAttribute("src",4);
strJsPath = strJsPath.substring(0,strJsPath.lastIndexOf("/"))+"/";
function alert_adv_layer_probability(alert_adv_layer_array){
	var alert_adv_layer_array_Num=0,alert_adv_layer_array_rnd,alert_adv_layer_array_new_rnd=0;
	for(i=0;i<alert_adv_layer_array.length;i++){alert_adv_layer_array_Num += alert_adv_layer_array[i];};
	var alert_adv_layer_array_rnd=Math.round((alert_adv_layer_array_Num - 1) * Math.random()) + 1;
	if(alert_adv_layer_array_rnd<=0) return false;
	for(i=0;i<alert_adv_layer_array.length;i++){
		alert_adv_layer_array_new_rnd += alert_adv_layer_array[i];
		if(alert_adv_layer_array_rnd<=alert_adv_layer_array_new_rnd){
			if(window.addEventListener){window.addEventListener("load",alert_adv_layer_pop,false);}
			else{window.attachEvent("onload",alert_adv_layer_pop);};
			break;
			};
		};
	};
//批量延迟加载
//for(var i=0 ; i < imgs.length; i++){
//	var _top = getTop(imgs[i]),_left = getLeft(imgs[i]);
//	//判断图片是否在显示区域内
//	if( _top >= top &&
//		_left >= left &&
//		_top <= top+height &&
//		_left <= left+width){
//		var _src = imgs[i].getAttribute('_src');
//		//如果图片已经显示，则取消赋值
//		if(imgs[i].src !== _src){
//			imgs[i].src = _src;
//		}
//	}
//}
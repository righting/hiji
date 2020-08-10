//首页焦点广告图切换
(function($) {
	$.fn.jfocus = function(settings) {
		var defaults = {
			time: 5000
		};
		var settings = $.extend(defaults, settings);
		return this.each(function(){
			var $this = $(this);
			var sWidth = $this.width();
			var len = $this.find("ul li").length;
			var index = 0;
			var picTimer;
			var btn = "<div class='pagination'>";
			for (var i = 0; i < len; i++) {
				btn += "<span></span>";
			}
			btn += "</div><div class='arrow pre'></div><div class='arrow next'></div>";
			$this.append(btn);
			$this.find(".pagination span").css("opacity", 0.4).mouseenter(function() {
				index = $this.find(".pagination span").index(this);
				showPics(index);
			}).eq(0).trigger("mouseenter");
			$this.find(".arrow").css("opacity", 0.0).hover(function() {
				$(this).stop(true, false).animate({
					"opacity": "0.5"
				},
				300);
			},
			function() {
				$(this).stop(true, false).animate({
					"opacity": "0"
				},
				300);
			});
			$this.find(".pre").click(function() {
				index -= 1;
				if (index == -1) {
					index = len - 1;
				}
				showPics(index);
			});
			$this.find(".next").click(function() {
				index += 1;
				if (index == len) {
					index = 0;
				}
				showPics(index);
			});
			$this.find("ul").css("width", sWidth * (len));
			$this.hover(function() {
				clearInterval(picTimer);
			},
			function() {
				picTimer = setInterval(function() {
					showPics(index);
					index++;
					if (index == len) {
						index = 0;
					}
				},
				settings.time);
			}).trigger("mouseleave");
			function showPics(index) {
				var nowLeft = -index * sWidth;
				$this.find("ul").stop(true, false).animate({
					"left": nowLeft
				},
				300);
				$this.find(".pagination span").stop(true, false).animate({
					"opacity": "0.4"
				},
				300).eq(index).stop(true, false).animate({
					"opacity": "1"
				},
				300);
			}
		});
	}
//首页标准模块中间多图广告鼠标触及凸显
	$.fn.jfade = function(settings) {
		var defaults = {
			start_opacity: "1",
			high_opacity: "1",
			low_opacity: ".1",
			timing: "500"
		};
		var settings = $.extend(defaults, settings);
		settings.element = $(this);
		//set opacity to start
		$(settings.element).css("opacity", settings.start_opacity);
		//mouse over
		$(settings.element).hover(
		//mouse in
		function() {
			$(this).stop().animate({
				opacity: settings.high_opacity
			},
			settings.timing); //100% opacity for hovered object
			$(this).siblings().stop().animate({
				opacity: settings.low_opacity
			},
			settings.timing); //dimmed opacity for other objects
		},
		//mouse out
		function() {
			$(this).stop().animate({
				opacity: settings.start_opacity
			},
			settings.timing); //return hovered object to start opacity
			$(this).siblings().stop().animate({
				opacity: settings.start_opacity
			},
			settings.timing); // return other objects to start opacity
		});
		return this;
	}
})(jQuery);
	function takeCount() {
	    setTimeout("takeCount()", 1000);
	    $(".time-remain").each(function(){
	        var obj = $(this);
	        var tms = obj.attr("count_down");
	        if (tms>0) {
	            tms = parseInt(tms)-1;
                var days = Math.floor(tms / (1 * 60 * 60 * 24));
                var hours = Math.floor(tms / (1 * 60 * 60)) % 24;
                var minutes = Math.floor(tms / (1 * 60)) % 60;
                var seconds = Math.floor(tms / 1) % 60;
                
                if (days < 0) days = 0;
                if (hours < 0) hours = 0;
                if (minutes < 0) minutes = 0;
                if (seconds < 0) seconds = 0;
                obj.find("[time_id='d']").html(days);
                obj.find("[time_id='h']").html(hours);
                obj.find("[time_id='m']").html(minutes);
                obj.find("[time_id='s']").html(seconds);
                obj.attr("count_down",tms);
	        }
	    });
	}
	function DOTCHANGE() {
		var changenow = $(this).index();
		$('#fullScreenSlides li').eq(nownow).css('z-index', '900');
		$('#fullScreenSlides li').eq(changenow).css({
			'z-index': '800'
		}).show();
		pagination.eq(changenow).addClass('current').siblings('li').removeClass('current');
		$('#fullScreenSlides li').eq(nownow).fadeOut(400,
		function() {
			$('#fullScreenSlides li').eq(changenow).fadeIn(500);
		});
		nownow = changenow;
	}
	function ADDLI() {
		for (var i = 0; i <= numpic; i++) {
			ulcontent += '<li>' + '<a href="#">' + (i + 1) + '</a>' + '</li>';
		}
		$('#fullScreenSlides').after(ulstart + ulcontent + ulend);
	}
	function GOGO() {
		var NN = nownow + 1;
		if (inout == 1) {} else {
			if (nownow < numpic) {
				$('#fullScreenSlides li').eq(nownow).css('z-index', '900');
				$('#fullScreenSlides li').eq(NN).css({
					'z-index': '800'
				}).show();
				pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
				$('#fullScreenSlides li').eq(nownow).fadeOut(400,
				function() {
					$('#fullScreenSlides li').eq(NN).fadeIn(500);
				});
				nownow += 1;
			} else {
				NN = 0;
				$('#fullScreenSlides li').eq(nownow).css('z-index', '900');
				$('#fullScreenSlides li').eq(NN).stop(true, true).css({
					'z-index': '800'
				}).show();
				$('#fullScreenSlides li').eq(nownow).fadeOut(400,
				function() {
					$('#fullScreenSlides li').eq(0).fadeIn(500);
				});
				pagination.eq(NN).addClass('current').siblings('li').removeClass('current');
				nownow = 0;
			}
		}
		TT = setTimeout(GOGO, SPEED);
	}
    //首页焦点区满屏背景广告切换
	var numpic = $('#fullScreenSlides li').size() - 1;
	var nownow = 0;
	var inout = 0;
	var TT = 0;
	var SPEED = 5000;
	$('#fullScreenSlides li').eq(0).siblings('li').css({
		'display': 'none'
	});
	var ulstart = '<ul id="SlidesPagination" class="full-screen-slides-pagination">',
	ulcontent = '',
	ulend = '</ul>';
	ADDLI();
	var pagination = $('#SlidesPagination li');
	var paginationwidth = $('#SlidesPagination').width();
	$('#SlidesPagination').css('margin-left', (372 - paginationwidth))

	pagination.eq(0).addClass('current')
	pagination.on('click', DOTCHANGE)
	pagination.mouseenter(function() {
		inout = 1;
	})
	pagination.mouseleave(function() {
		inout = 0;
	})
	TT = setTimeout(GOGO, SPEED);
$(function(){
	setTimeout("takeCount()", 1000);
    //首页Tab标签卡滑门切换
    $(".tabs-nav > li > h3").bind('mouseover', (function(e) {
    	if (e.target == this) {
    		var tabs = $(this).parent().parent().children("li");
    		var panels = $(this).parent().parent().parent().children(".tabs-panel");
    		var index = $.inArray(this, $(this).parent().parent().find("h3"));
    		if (panels.eq(index)[0]) {
    			tabs.removeClass("tabs-selected").eq(index).addClass("tabs-selected");
    			panels.addClass("tabs-hide").eq(index).removeClass("tabs-hide");
    		}
    	}
    }));

	$('.jfocus-trigeminy > ul > li > a').jfade({
		start_opacity: "1",
		high_opacity: "1",
		low_opacity: ".5",
		timing: "200"
	});

	$('.jfocus-trigeminy2 > ul > li > a').jfade({
		start_opacity: "1",
		high_opacity: "1",
		low_opacity: ".5",
		timing: "200"
	});
	$('.jfocus-trigeminy3 > ul > li > a').jfade({
		start_opacity: "1",
		high_opacity: "1",
		low_opacity: ".5",
		timing: "200"
	});
	$('.fade-img > a').jfade({
		start_opacity: "1",
		high_opacity: "1",
		low_opacity: ".9",//原来的是0.5,更改0.9保持淡淡的关灯效果
		timing: "500"
	});
	$('.middle-goods-list > ul > li').jfade({
		start_opacity: "1",
		high_opacity: "1",
		low_opacity: "1",
		timing: "500"
	});	
	$('.recommend-brand > ul > li').jfade({
		start_opacity: "1",
		high_opacity: "1",
		low_opacity: "1",
		timing: "500"
	});
	$(".jfocus-trigeminy").jfocus();
	$(".jfocus-trigeminy2").jfocus();
	//$(".jfocus-trigeminy3").jfocus();
	$(".right-side-focus").jfocus();
	$(".groupbuy").jfocus({time:8000});
	$(".right_adv").jfocus({time:8000});
	$("#saleDiscount").jfocus({time:8000});
})


//电梯及置顶.begin

$(function(){ 
$(".nav_1f").click(function(){ 
$.scrollTo('#1F',800); 
}); 
$(".nav_2f").click(function(){ 
$.scrollTo('#2F',800); 
}); 
$(".nav_3f").click(function(){ 
$.scrollTo('#3F',800); 
}); 
$(".nav_4f").click(function(){ 
$.scrollTo('#4F',800); 
}); 
$(".nav_5f").click(function(){ 
$.scrollTo('#5F',800); 
}); 
$(".nav_6f").click(function(){ 
$.scrollTo('#6F',800); 
});
$(".nav_7f").click(function(){ 
$.scrollTo('#7F',800); 
});  

$(".nav_0f").click(function(){ 
$.scrollTo('#footer',800); 
});  

$(".nav_8f").click(function(){if(scroll=="off") return;$("html,body").animate({scrollTop: 0}, 600);});
$(".backtop").click(function(){if(scroll=="off") return;$("html,body").animate({scrollTop: 0}, 600);});


	//鼠标移上去显示中文.begin	
	$(".sidenav a").hover(function(){
			$(this).children("em.hides").show();
			$(this).children("em.shows").hide();
	},function(){ 
			$(this).children("em.hides").hide();
			$(this).children("em.shows").show();
	});
	//鼠标移上去显示中文.end
	
	

	//鼠标移上去显示中文.begin	
	$(".backtopbox a").hover(function(){
			$(this).children("em.hides").show();
			$(this).children("em.shows").hide();
	},function(){ 
			$(this).children("em.hides").hide();
			$(this).children("em.shows").show();
	});
	//鼠标移上去显示中文.end
	
}); 


 $(function () {            
            //绑定滚动条事件
              //绑定滚动条事件

			$(window).scroll(function(){ 
				if ($(window).scrollTop()>100){ 
					$(".sidenav").fadeIn(500);
					$(".backtopbox").fadeIn(500);
				} 
				else 
				{ 
					$(".sidenav").fadeOut(500); 
					$(".backtopbox").fadeOut(500);
				} 
			});
			//滚动底部
			
            $(window).bind("scroll", function(){
			　　var scrollTop = $(this).scrollTop();
			　　var scrollHeight = $(document).height();
			　　var windowHeight = $(this).height();
			　　if(scrollTop + windowHeight == scrollHeight){
			　　		//alert("已经到最底部了！");
					//
                    if ($(".sidenav").is(":visible")) {
                        try {							
                            $(".sidenav").fadeOut(500);
                            //$(".sidenav").slideUp();
                        } catch (e) {
                            $(".sidenav").hide();
                        }                       
                    }//
			　　}else{
					//
                    if (!$(".sidenav").is(":visible")) {
                        try {
                            $(".sidenav").fadeIn(500);
                            //$(".sidenav").slideDown();
                        } catch (e) {
                            $(".sidenav").show();
                        }                      
                    }
					//
				}
			});

			//.end
			
}) 
//电梯.end

//hotConAd.begin

		$(document).ready(function(){ 
		var speed=30; 
		var $tab=$("#hotConAd"); 
		var $tab1=$("#conlist"); 
		var $tab2=$("#conscroll"); 
		$tab2.html($tab1.html()); 
		function Marquee(){ 
		 if($tab2[0].offsetWidth-$tab[0].scrollLeft<=0) 
		 $tab[0].scrollLeft-=$tab1[0].offsetWidth; 
		 else{ 
		 $tab[0].scrollLeft++; 
		 } 
		 } 
		var MyMar=setInterval(Marquee,speed);  
		$tab.hover(function(){ 
            clearInterval(MyMar); 
            },function(){ 
            MyMar=setInterval(Marquee,speed) 
                }) 
         }) 
//hotConAd.end

//首页下拉广告.begin

    var time = 500;
    var h = 0;
    function addCount()
    {
        if(time>0)
        {
            time--;
            h = h+50;
        }
        else
        {
            return;
        }
        if(h>300)  //高度
        {
            return;
        }
        document.getElementById("ads").style.display = "";
        document.getElementById("ads").style.height = h+"px";
        setTimeout("addCount()",30); 
    }
    
    window.onload = function showAds()
    {
        
		/*
        document.getElementById("ads").style.display = "";//手动关闭广告
		*/
		addCount();
        setTimeout("noneAds()",7000); //停留时间自己适当调整
    }
	
	//设置
    var T = 260;
    var N = 300; //高度
    function noneAds()
    {
        if(T>0)
        {
            T--;
            N = N-50;
        }
        else
        {
            return;
        }
        if(N<0)
        {
            document.getElementById("ads").style.display = "none";
            return;
        }
        
        document.getElementById("ads").style.height = N+"px";
        setTimeout("noneAds()",30); 
    }
//首页下拉广告.end

//首页幕广告.begin

$(function() {
	ShowBigImg();
   
		if($("#Small_TopBanner").is(":hidden")){
   			$("#ConFold").css("display","block");//block
   			$("#ConClose").css("display","none");//block //控制关闭按钮显示
		}else{
   			$("#ConFold").css("display","none");//block
   			$("#ConClose").css("display","none");//block
		}
	
	$("#ConClose").click(function() {
		$("#Big_TopBanner").hide();
		$("#Small_TopBanner").hide();
		$("#ConFold").hide();
		$("#ConClose").hide();
	});
	
	$("#ConFold").click(function() {
		$(this).text($("#Big_TopBanner").is(":hidden") ? "收起" : "展开");
		$("#Big_TopBanner").slideToggle("fast");
		
		if($("#Big_TopBanner").is(":hidden")){
			$("#Small_TopBanner").slideDown(1000);
		}else{
			$("#Small_TopBanner").slideToggle("fast");
		}
		
	});
});

function ShowBigImg(){
  $("#Big_TopBanner").slideDown(500);
  $("#ConFold").text($("#Big_TopBanner").is(":hidden") ? "收起" : "展开"); 
}


//大图切换成小图
function changeImg(){
  $("#Big_TopBanner").slideUp(300,function(){
     $("#Small_TopBanner").slideDown(500);
  }); 
}
setTimeout(changeImg,3000);

//首页幕广告.end

//控制友情链接显示

$(function() {
		   
	if($(".rz").is(":hidden")){
		$("#flink").css("display","none");//block
		
	}else{
		$("#flink").css("display","block");//none
	}

});
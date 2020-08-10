(function ($) {
    // 首页满屏背景广告切换
    $.fn.fullScreen = function(settings) {//首页焦点区满屏背景广告切换
		var defaults = {
			time: 3000,
			css: 'full-screen-slides-pagination'
		};
		var settings = $.extend(defaults, settings);
		return this.each(function(){

			var $this = $(this);
		    var size = $this.find("li").size();
		    var now = 0;
		    var enter = 0;
		    var speed = settings.time;
		    $this.find("li:gt(0)").hide();
			var btn = '<ul class="' + settings.css + '">';
			for (var i = 0; i < size; i++) {
				btn += '<li>' + '<a href="javascript:void(0)">' + (i + 1) + '</a>' + '</li>';
			}
			btn += "</ul>";
			$this.parent().append(btn);
			var $pagination = $this.next();

			$pagination.find("li").first().addClass('current');
			$pagination.find("li").click(function() {
        		var change = $(this).index();
        		$(this).addClass('current').siblings('li').removeClass('current');
        		$this.find("li").eq(change).css('z-index', '800').show();
        		$this.find("li").eq(now).css('z-index', '900').fadeOut(400,
        		function() {
        			$this.find("li").eq(change).fadeIn(500);
        		});
        		now = change;
			}).mouseenter(function() {
        		enter = 1;
        	}).mouseleave(function() {
        		enter = 0;
        	});
        	function slide() {
        		var change = now + 1;
        		if (enter == 0){
        			if (change == size) {
        				change = 0;
        			}
        			$pagination.find("li").eq(change).trigger("click");
        		}
        		setTimeout(slide, speed);
        	}
        	setTimeout(slide, speed);
		});
	}

})(jQuery);
$(function(){
    picLoop();
})
  function picLoop() {
      var num = $('.banner-pic>li').length;
      var timer = null;
      var index = 0;
      $('.banner-pic>li').first().clone().appendTo('.banner-pic');
      $('.banner-pic').width($('.banner-pic>li').width()*(num+1));
      function next(){
        index++;
        if (index==num+1) {
          index=1;
          $('.banner-pic').css({left:'0'});
        }
        $('.banner-pic').stop().animate({left:-290*index+'px'},500);
        $('.img-thumb li').removeClass().eq(index).addClass('cur');
        if(index==num) {
          $('.img-thumb li').removeClass().eq(0).addClass('cur');
        }
    }
    timer=setInterval(next,2000);
    $(".img-thumb li").mouseover(function(){
      clearInterval(timer);
      var now=$(this).index();//获取鼠标移入的是第几个li标记

      $(".img-thumb li").removeClass();//删除a标记中的class=cur
      $(this).addClass("cur");//为此a标记添加cur样式
      // $('.banner-pic').stop().animate({left:-360*now+'px'},500);
      $('.banner-pic').css('left',-290*now+'px');

      index=now;//为变量index重新赋值，以便于再次启用定时器的时候，从当前显示的图片开始播放
    });
    $(".banner-pic").mouseover(function () {
      clearInterval(timer);
    });
    $(".img-thumb li").mouseout(function(){
    timer=setInterval(next,2000)
    });
    $(".banner-pic").mouseout(function(){
    timer=setInterval(next,2000)
    });
  }


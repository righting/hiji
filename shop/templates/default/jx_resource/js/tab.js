$(document).ready(function(){
    $('.list-tab li:first').addClass('current');
    $('.list-tab-content:first').css('display','block');
    autoRoll();
    hookThumb();
})
var i=-1; //第i+1个tab开始
var offset = 3000; //轮换时间
var timer = null;
function autoRoll(){
    var n = $('.list-tab li').length-1;
    i++;
    if(i > n){
        i = 0;
    }
    slide(i);
    timer = window.setTimeout(autoRoll, offset);
}
function slide(i){
    $('.list-tab li').eq(i).addClass('current').siblings().removeClass('current');
    $('.list-tab-content').eq(i).css('display','block').siblings('.list-tab-content').css('display','none');
}

function hookThumb(){
    $('.list-tab li').hover(
        function(){
            if(timer){
                clearTimeout(timer);
                i = $(this).prevAll().length;
                slide(i);
            }
        },function(){
            timer = window.setTimeout(autoRoll, offset);
            this.blur();
            return false;
        });
}
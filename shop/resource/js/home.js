$(function(){
	//代金券兑换功能
    $("[nc_type='exchangebtn']").live('click',function(){
    	var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    ajaxget('index.php?controller=pointvoucher&action=voucherexchange&dialog=1&vid='+data_str.vid);
	    return false;
    });
    //红包兑换功能
    $("[nc_type='rptexchangebtn']").live('click',function(){
    	var data_str = $(this).attr('data-param');
	    eval( "data_str = "+data_str);
	    ajaxget('index.php?controller=pointredpacket&action=rptexchange&dialog=1&tid='+data_str.tid);
	    return false;
    });
});
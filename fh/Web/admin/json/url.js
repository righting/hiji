
var base_url = 'http://www.hiji100.com/fh/Api/public/index.php';


//API接口
var issUrl = {
    // 登录接口
    admin_user: base_url + '/admin/login/index',

    //验证码生成
    pub: base_url + '/admin/pub/verify',

    //分红
    profit: base_url + '/admin/member_bonus_pool_log/index',

    //设置
    set: base_url + '/admin/config/info',

    //修改设置
    set_edit: base_url + '/admin/config/edit',

    //分红池明细
    bonus_pool_log: base_url + '/admin/bonus_pool_log/index',


    //分红池明细
    applicable: base_url + '/admin/period/index',



};
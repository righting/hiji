<?php

$tbconfig =array();
$tbconfig['web_root'] = '../../../data/upload/shop/store/goods/';//上传图片的存放位置。ccynet默认存放在/data/upload/shop/store/goods/ 目录下，如果你未更改，则此处无需修改。默认存放位置在 /global.php文件中定义，由define('DIR_UPLOAD','data/upload'); define('ATTACH_GOODS','shop/store/goods');共同决定。
	//如果你修改了ccynet的默认存放位置，此处需要相应作出修改。
$tbconfig['datahost']     = 'localhost:3306';//数据库服务器地址和端口
$tbconfig['datausername'] = '';//数据库用户名
$tbconfig['datauserpass'] = '';//数据库用户密码
$tbconfig['databasename'] = 'ccynet';//使用的数据库名
$tbconfig['datatablepre'] = 'ccynet_'; //数据表前缀
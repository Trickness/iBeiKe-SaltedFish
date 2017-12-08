<?php

$db_host = "localhost";
$db_user = "ibeike_test";
$db_pass = "ibeike_test";
$db_name = "ibeike_test";
$db_users_table = "salted_fish_users";
$db_goods_table = "salted_fish_goods";
$db_order_table = "orders";
$db_session_table = "sessions";

$debug_mod = false;

$addons = array(
    "ueditor" => "../addons/ueditor/php",

    "sms" => array(
        "sms_apikey" => 'c3e8dce36597707f9716d8fa2aeae034',
        "sms_tpl_id" => array(
            'create_order'              =>  '1996512',  //发给卖家
            'accept_order'              =>  '1996516',  //发给买家
            'complete_order'            =>  '1996518',  //发给买家
            'finish_order'              =>  '1996522',  //发给卖家
            'cancel_order_by_buyer'     =>  '2000018',  //买家撤回订单
            'cancel_order_by_seller'    =>  '2000020',  //卖家撤回订单
            'signup_captcha'            =>  '2000048',  //注册验证码
            'reset_captcha'             =>  '2000014',  //重置密码验证码
        ),
        "is_enabled"        =>  true
    )
);

date_default_timezone_set('Asia/Chongqing');
?>

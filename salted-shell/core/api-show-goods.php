<?php
session_start();
require_once "./goods.php";
require_once "./utils.php";
require_once "./authorization.php";
require_once "../config.php";
if (isset($_GET['goods_id'],$_GET['type'])) {
    if ($_GET['type']=="show") {
        $goods_info = fetch_goods_info($_GET['goods_id'],session_id());
        echo $goods_info;
        // var_dump($goods_info);
    }elseif ($_GET['type']=="comment") {
        if (isset($_GET['comment'])) {
            echo comment_goods($_GET['goods_id'],$_GET['comment'],session_id());
        }else echo json_encode(array(
		    "status" => "no comment"
	    ));
    }
}
?>
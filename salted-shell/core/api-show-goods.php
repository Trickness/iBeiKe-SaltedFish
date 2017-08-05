<?php
session_start();
require_once "./goods.php";
require_once "./orders.php";
require_once "./utils.php";
require_once "./authorization.php";
require_once "../config.php";
if (isset($_GET['goods_id'],$_GET['action'])) {
    if ($_GET['action']=="show") {
        $goods_info = fetch_goods_info($_GET['goods_id'],session_id());
        echo $goods_info;
        // var_dump($goods_info);
    }elseif ($_GET['action']=="comment") {
        if (isset($_GET['comment'])) {
            echo comment_goods($_GET['goods_id'],$_GET['comment'],session_id());
        }else echo json_encode(array(
		    "status" => "no comment"
	    ));
    }elseif ($_GET['action']=="new_order") {
        // echo $_GET['order_info'];
        if (isset($_GET['order_info'])) {
            $order_info = json_decode($_GET['order_info'],true);
            // create_order($session_key,$goods_id,$deliver_fee,$goods_count,$price_per_goods)
            if ($result = create_order(session_id(),
                                        $order_info['goods_id'],
                                        $order_info['deliver_fee'],
                                        $order_info['goods_count'],
                                        $order_info['price_per_goods']
                                        )) {
                echo json_encode(array(
		            "status" => "success",
                    "order_id" => $result
	            ));
            }else echo json_encode(array(
		        "status" => "failed to create order"
	        ));
        }
    }
}
?>
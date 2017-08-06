<?php
session_start();
require_once "./users.php";
require_once "./goods.php";
require_once "./orders.php";
require_once "./utils.php";
require_once "./authorization.php";
require_once "../config.php";
if (isset($_GET['goods_id'],$_GET['action'])) {
    if ($_GET['action']=="show") {
        $goods_info = json_decode(fetch_goods_info($_GET['goods_id'],session_id()),true);
        $buyer = json_decode(fetch_self_info(session_id()),true);
        $submitter = json_decode(fetch_info_from_user($goods_info['submitter']),true);
        $buyer_info = array(
            'student_id' => $buyer['student_id']['value'],
            'name' => $buyer['name']['value'],
            'phone_number' => $buyer['phone_number']['value']
        );
        $submitter_info = array(
            'student_id' => $submitter['student_id']['value'],
            'name' => $submitter['name']['value'],
            'phone_number' => $submitter['phone_number']['value']
        );
        $goods_info['buyer_info'] = $buyer_info;    $goods_info['submitter_info'] = $submitter_info;
        echo json_encode($goods_info);
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
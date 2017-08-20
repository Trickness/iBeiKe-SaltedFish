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
        $buyer = fetch_self_info(session_id());
        $goods_owner = fetch_user_info(session_id(),$goods_info['goods_owner']);
        $buyer_info = array();
        if($buyer){
            $buyer_info = array(
                'student_id' => $buyer['student_id']['value'],
                'name' => $buyer['name']['value'],
                'phone_number' => $buyer['phone_number']['value']
            );
        }
        $goods_owner_info = array(
            'student_id' => $goods_owner['student_id']['value'],
            'name' => $goods_owner['name']['value'],
            'phone_number' => $goods_owner['phone_number']['value']
        );
        $goods_info['buyer_info'] = $buyer_info;    $goods_info['goods_owner_info'] = $goods_owner_info;
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
            // create_order($session_key,$goods_id,$deliver_fee,$goods_count,$single_cost)
            if ($result = create_order(session_id(),
                                        $order_info['goods_id'],
                                        $order_info['delivery_fee'],
                                        $order_info['remain'],
                                        $order_info['singal_cost']
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
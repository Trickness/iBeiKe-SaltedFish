<?php
session_start();
require_once "./goods.php";
require_once "./utils.php";
require_once "./authorization.php";
require_once "../config.php";
if (isset($_GET['goods_id'])) {
    $goods_info = fetch_goods_info($_GET['goods_id'],session_id());
    echo $goods_info;
}
?>
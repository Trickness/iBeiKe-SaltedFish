<?php
// require_once '../config.php';

class Sms{
    protected $ch = null;
    protected $phone = null;
    protected $apikey = null;
    protected $sms_api_url = 'https://sms.yunpian.com/v2/sms/tpl_single_send.json';

    function __construct(){
        global $db_host;
        global $db_pass;
        global $db_name;
        global $db_user;
        global $db_order_table;
        global $db_goods_table;
        global $db_users_table;
        global $sms_apikey;
        global $sms_tpl_id;

        $this->sms_apikey       =   $sms_apikey;
        $this->sms_tpl_id       =   $sms_tpl_id;
        $this->db_host          =   $db_host;
        $this->db_pass          =   $db_pass;
        $this->db_name          =   $db_name;
        $this->db_user          =   $db_user;
        $this->db_order_table   =   $db_order_table;
        $this->db_goods_table   =   $db_goods_table;
        $this->db_users_table   =   $db_users_table;        
    }

    protected function tpl_send($data){
        $this->ch = curl_init();
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('Accept:text/plain;charset=utf-8','Content-Type:application/x-www-form-urlencoded', 'charset=utf-8'));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt ($this->ch, CURLOPT_URL,$this->sms_api_url);
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $result = curl_exec($this->ch);
        $error = curl_error($this->ch);
        curl_close($this->ch);
        return $result;
    }

    protected function query($sql){
        $link = mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
        $query = mysqli_query($link,$sql);
        mysqli_close($link);
        return $query;
    }

    protected function fetch_phone_number($user_id){
        $db_users_table = $this->db_users_table;
        $sql = "SELECT student_info FROM $db_users_table WHERE student_id = '$user_id'";
        $result = $this->query($sql);
        $result = mysqli_fetch_assoc($result);
        $student_info = json_decode(urldecode($result['student_info']),true);
        $phone_number = $student_info['phone_number']['value'];
        return $phone_number;
    }
}

class OrderSms extends Sms{

    function __construct(){
        parent::__construct();
    }

    // %E6%B5%8B%E8%AF%95%E5%93%812
    // %25E6%25B5%258B%25E8%25AF%2595%25E5%2593%25812

    public function create_order($order_id  = ''){
        if ($order_id != '') {
            $db_goods_table = $this->db_goods_table;
            $db_order_table = $this->db_order_table;
            $sql = "SELECT order_submitter,purchase_amount,offer,$db_goods_table.goods_title,$db_goods_table.goods_owner FROM $db_order_table
                INNER JOIN $db_goods_table ON $db_order_table.goods_id = $db_goods_table.goods_id WHERE order_id = '$order_id';";
            $result = mysqli_fetch_assoc($this->query($sql));
            $mobile = $this->fetch_phone_number($result['goods_owner']);
            $data = array(
                'tpl_id' => $this->sms_tpl_id['create_order'],
                'tpl_value' =>
                    ('#studentid#').       '=' .($result['order_submitter']).       '&'.
                    ('#goodstitle#').      '=' .($result['goods_title']).           '&'.
                    ('#purchaseamount#').  '=' .($result['purchase_amount']).       '&'.
                    ('#offer#').           '=' .($result['offer']).                 '&'.
                    ('#URL#').             '=' .('商城'),
                'apikey' => $this->sms_apikey,
                'mobile' => $mobile,
            );
            $result = json_decode($this->tpl_send($data),true);
            // if ($result['code'] == '0') return array('status'=>'success','phone_number'=>$mobile);
            //     else return array('status'=>'failed','error'=>$result['code'],'phone_number'=>$mobile);
            return $result;
        }else {
            return array('status'=>'failed','error'=>'-1');
        }
    }

    public function accept_order($order_id = ''){
        if ($order_id != '') {
            $db_goods_table = $this->db_goods_table;
            $db_order_table = $this->db_order_table;

            $sql = "SELECT order_submitter,$db_goods_table.goods_owner,$db_goods_table.goods_title FROM $db_order_table
                INNER JOIN $db_goods_table ON $db_order_table.goods_id = $db_goods_table.goods_id WHERE order_id = '$order_id'";
            $result = mysqli_fetch_assoc($this->query($sql));

            $mobile = $this->fetch_phone_number($result['order_submitter']);

            $data = array(
                'tpl_id' => $this->sms_tpl_id['accept_order'],
                'tpl_value' =>
                    ('#phonenumber#').  '=' .($this->fetch_phone_number($result['goods_owner'])).       '&'.
                    ('#goodsname#').    '=' .($result['goods_title']).        '&',
                'apikey' => $this->sms_apikey,
                'mobile' => $mobile,
            );
            $result = $this->tpl_send($data);
            // if ($result['code'] == '0') return array('status'=>'success','phone_number'=>$mobile);
            //     else return array('status'=>'failed','error'=>$result['code'],'phone_number'=>$mobile);
            return $result;
        }else {
            return array('status'=>'failed','error'=>'-1');
        }
    }

    public function complete_order($order_id = ''){
        if ($order_id != '') {
            $db_goods_table = $this->db_goods_table;
            $db_order_table = $this->db_order_table;

            $sql = "SELECT order_submitter FROM $db_order_table WHERE order_id = '$order_id'";
            $result = mysqli_fetch_assoc($this->query($sql));

            $data = array(
                'tpl_id' => $this->sms_tpl_id['complete_order'],
                'tpl_value' =>
                    ('#orderid#').  '=' .($order_id).       '&'.
                    ('#URL#').      '=' .('www.ibeike.com'),
                'apikey' => $this->sms_apikey,
                'mobile' => $this->fetch_phone_number($result['order_submitter']),
            );
            $result = $this->tpl_send($data);
            // if ($result['code'] == '0') return array('status'=>'success','phone_number'=>$mobile);
            //     else return array('status'=>'failed','error'=>$result['code'],'phone_number'=>$mobile);
            return $result;
        }else {
            return array('status'=>'failed','error'=>'-1');
        }
    }

    public function finish_order($order_id = ''){
        if ($order_id != '') {
            $db_goods_table = $this->db_goods_table;
            $db_order_table = $this->db_order_table;

            $sql = "SELECT order_submitter,purchase_amount,$db_goods_table.single_cost,$db_goods_table.goods_title,$db_goods_table.goods_owner FROM $db_order_table
                INNER JOIN $db_goods_table ON $db_order_table.goods_id = $db_goods_table.goods_id WHERE order_id = '$order_id'";
            $result = mysqli_fetch_assoc($this->query($sql));

            $data = array(
                'tpl_id' => $this->sms_tpl_id['finish_order'],
                'tpl_value' =>
                    ('#studentid#').       '=' .($result['order_submitter']).           '&'.
                    ('#singlecost#').      '=' .($result['single_cost']).       '&'.
                    ('#goodstitle#').      '=' .($result['goods_title']).       '&'.
                    ('#purchaseamount#').  '=' .($result['purchase_amount']).   '&',
                'apikey' => $this->sms_apikey,
                'mobile' => $this->fetch_phone_number($result['goods_owner']),
            );
            $result = $this->tpl_send($data);
            // if ($result['code'] == '0') return array('status'=>'success','phone_number'=>$mobile);
            //     else return array('status'=>'failed','error'=>$result['code'],'phone_number'=>$mobile);
            return $result;
        }else {
            return array('status'=>'failed','error'=>'-1');
        }
    }
}

// $order_sms = new OrderSms;

// var_dump($order_sms->accept_order());
// echo($order_sms->accept_order('11111111','11111111','实验商'));
// echo($order_sms->complete_order('11111111','20','www.ibeike.com'));
// var_dump($order_sms->finish_order('11111111','11111111',30,'实验品',10));
?>
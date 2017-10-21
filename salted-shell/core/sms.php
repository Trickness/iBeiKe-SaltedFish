<?php
// require_once '../config.php';

class Sms{
    protected $ch = null;
    protected $phone = null;
    protected $apikey = null;
    protected $sms_api_url = 'https://sms.yunpian.com/v2/sms/tpl_single_send.json';

    function __construct($phone,$apikey){
        $this->phone    =   $phone;
        $this->apikey  =   $apikey;
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
}

class OrderSms extends Sms{
    private $sms_tpl_id = null;

    function __construct($phone,$apikey,$sms_tpl_id){
        parent::__construct($phone,$apikey);
        $this->sms_tpl_id = $sms_tpl_id;
    }

    // %E6%B5%8B%E8%AF%95%E5%93%812
    // %25E6%25B5%258B%25E8%25AF%2595%25E5%2593%25812

    public function create_order($user_id,$goods_title,$purchase_amount,$offer,$url){
        $data = array(
            'tpl_id' => $this->sms_tpl_id['create_order'],
            'tpl_value' =>
                ('#studentid#').       '=' .($user_id).               '&'.
                ('#goodstitle#').      '=' .($goods_title).           '&'.
                ('#purchaseamount#').  '=' .($purchase_amount).       '&'.
                ('#offer#').           '=' .($offer).                 '&'.
                ('#URL#').             '=' .($url),
            'apikey' => $this->apikey,
            'mobile' => $this->phone,
        );
        $result = $this->tpl_send($data);
        return $result;
    }

    public function accept_order($goods_title,$phone_number){
        $data = array(
            'tpl_id' => $this->sms_tpl_id['accept_order'],
            'tpl_value' =>
                ('#phonenumber#').  '=' .($phone_number).       '&'.
                ('#goodsname#').    '=' .($goods_title).        '&',
            'apikey' => $this->apikey,
            'mobile' => $this->phone,
        );
        $result = $this->tpl_send($data);
        return $result;
    }

    public function complete_order($order_id,$url){
        $data = array(
            'tpl_id' => $this->sms_tpl_id['complete_order'],
            'tpl_value' =>
                ('#orderid#').  '=' .($order_id).       '&'.
                ('#URL#').      '=' .($url).        '&',
            'apikey' => $this->apikey,
            'mobile' => $this->phone,
        );
        $result = $this->tpl_send($data);
        return $result;
    }

    public function finish_order($user_id,$single_cost,$goods_title,$purchase_amount){
        $data = array(
            'tpl_id' => $this->sms_tpl_id['finish_order'],
            'tpl_value' =>
                ('#studentid#').       '=' .($user_id).           '&'.
                ('#singlecost#').      '=' .($single_cost).       '&'.
                ('#goodstitle#').      '=' .($goods_title).       '&'.
                ('#purchaseamount#').  '=' .($purchase_amount).   '&',
            'apikey' => $this->apikey,
            'mobile' => $this->phone,
        );
        $result = $this->tpl_send($data);
        return $result;
    }
}

// $order_sms = new OrderSms('18899873062','c3e8dce36597707f9716d8fa2aeae034',$sms_tpl_id);
// var_dump(
//     $order_sms->finish_order('41607405',666,'意大利炮2','233')
//     // $order_sms->complete_order('20','www.ibeike.com/salte-shell/')
//     // $order_sms->accept_order('意大利炮','15901230631')
//     // $order_sms->create('41607405','意大利炮','666','236','www.ibeike.com')
// );

// echo((new OrderSms('15901230631',$sms_apikey,$sms_tpl_id))->create_order('11111111','测试',20,6,'www.ibeike.com'));
?>
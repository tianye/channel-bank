<?php
require '../../vendor/autoload.php';

use ChannelBank\Foundation\Application;
use ChannelBank\JianShe\Order;

class Request
{

    static $app;

    public function __construct()
    {
        $options = [
            'debug' => true,
            'log'   => [
                'level' => 'debug',
                'file'  => '/tmp/ChannelBank_PuDong.log',
            ],

            'ccb_payment' => [
                'mer_id'   => '20065', // 此处为模拟联调商户号，正式投产时需使用清算平台分配的商户号
                'sign_key' => 'Y127BGP49APC1B9G8SMTF6PUI1XFITPGFLGU5E4B3MJKX76U3A6U7XHMKMUL', // 此处为模拟联调密钥，正式投产时需使用清算平台分配的密钥
            ],
        ];

        self::$app = new Application($options);
    }

    //微信H5支付
    public function wxPay($order_num, $order_amount = '1')
    {
        $attributes = [
            'back_end_url'   => 'http://test.itse.cc/Bank/notify.php',
            'front_end_url'  => 'http://test.itse.cc/Bank/notify.php',
            'order_number'   => $order_num,
            'order_amount'   => $order_amount,
            'customer_ip'    => '127.0.0.1',
            'mer_reserved_1' => '',
            'mer_reserved_2' => '',
            'mer_reserved_3' => '',
            'order_desc'     => 'orderDesc',
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->JsPay()->wxPay($order);

        var_export($return);
    }

    //微信二维码支付
    public function wxQrPay($order_num, $order_amount = '1')
    {
        $attributes = [
            'back_end_url'   => 'http://test.itse.cc',
            'order_number'   => $order_num,
            'order_amount'   => $order_amount,
            'customer_ip'    => '127.0.0.1',
            'mer_reserved_1' => '',
            'mer_reserved_2' => '',
            'mer_reserved_3' => '',
            'order_desc'     => 'orderDesc',
            'agent_amount'   => '',
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->JsPay()->wxQrPay($order);

        var_export($return);
    }

    //支付宝H5支付
    public function aliPay($order_num, $order_amount = '1')
    {
        $attributes = [
            'back_end_url'   => 'http://test.itse.cc/Bank/notify.php',
            'front_end_url'  => 'http://test.itse.cc/Bank/notify.php',
            'order_number'   => $order_num,
            'order_amount'   => $order_amount,
            'customer_ip'    => '127.0.0.1',
            'mer_reserved_1' => '',
            'mer_reserved_2' => '',
            'mer_reserved_3' => '',
            'order_desc'     => 'orderDesc',
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->JsPay()->aliPay($order);

        var_export($return);
    }

    //支付宝二维码支付
    public function aliQrPay($order_num, $order_amount = '1')
    {
        $attributes = [
            'back_end_url'   => 'http://test.itse.cc/Bank/notify.php',
            'front_end_url'  => 'http://test.itse.cc/Bank/notify.php',
            'order_number'   => $order_num,
            'order_amount'   => $order_amount,
            'customer_ip'    => '127.0.0.1',
            'mer_reserved_1' => '',
            'mer_reserved_2' => '',
            'mer_reserved_3' => '',
            'order_desc'     => 'orderDesc',
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->JsPay()->aliQrPay($order);

        var_export($return);
    }

    //查询
    public function query($order_num)
    {
        $attributes = [
            'order_number' => $order_num,
            //'qid'         => '',
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->Query()->query($order);

        var_export($return);
    }

    //退款
    public function refund($order_num, $qid, $ref_amount)
    {
        $attributes = [
            'order_number'   => $order_num,
            'qid'            => $qid,
            'ref_amount'     => $ref_amount,
            'mer_reserved_1' => '商户退款示例',
            'back_end_url'   => 'http://test.itse.cc/Bank/notify.php',
            #'refSplitAmount' => ',
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->Cancel()->refund($order);

        var_export($return);
    }

    //退款查询
    public function refundQuery($ref_id)
    {
        $attributes = [
            'ref_id' => $ref_id,
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->Query()->refundQuery($order);

        var_export($return);
    }

    //关闭订单接口
    public function repeal($order_number, $mer_order_id, $qid, $bank_number = '991', $mer_reserved_1 = '', $mer_reserved_2 = '', $mer_reserved_3 = '')
    {
        $attributes = [
            'order_number'   => $order_number,
            'mer_order_id'   => $mer_order_id,
            'qid'            => $qid,
            'bank_number'    => $bank_number,
            'mer_reserved_1' => $mer_reserved_1,
            'mer_reserved_2' => $mer_reserved_2,
            'mer_reserved_3' => $mer_reserved_3,
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->Cancel()->repeal($order);

        var_export($return);
    }
}

$Application = new Request();

$orig_order_num = '1493109659157606005536';
$order_num      = build_order_num();
$scan_code_id   = '收款码号';
$order_amount   = '2';

var_dump($order_num);

#$Application->wxPay($order_num, $order_amount);

#$Application->wxQrPay($order_num, $order_amount);

$Application->aliPay($order_num, $order_amount);

#$Application->aliQrPay($order_num, $order_amount);

#$order_num = '1508224926887838004091';
#$Application->query($order_num);

#$orderNumber  = '1508225732980122006341';
#$qid          = 'J014862017101715353358242911';
#$order_amount = '2';
#$Application->refund($order_num, $qid, $order_amount);

#$ref_id      = 'T002442017101715535694578618';
#$Application->refundQuery($ref_id);

//$order_number   = $order_num;
//$mer_order_id   = '1508141492285596002438';
//$qid            = 'J014312017101616113291237602';
//$bank_number    = '991';
//$mer_reserved_1 = '电子类消费产品';
//$Application->repeal($order_number, $mer_order_id, $qid, $bank_number, $mer_reserved_1);
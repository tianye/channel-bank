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
                'mer_id'   => '10001', // 此处为模拟联调商户号，正式投产时需使用清算平台分配的商户号
                'sign_key' => '8888888888888', // 此处为模拟联调密钥，正式投产时需使用清算平台分配的密钥
            ],
        ];

        self::$app = new Application($options);
    }

    /**
     * @param        $order_num
     * @param string $order_amount
     */
    public function fastPayment($order_num, $order_amount = '1')
    {
        $attributes = [
            'back_end_url'   => 'http://test.itse.cc',
            'front_end_url'  => 'http://test.itse.cc',
            'order_number'   => $order_num,
            'order_amount'   => $order_amount,
            'customer_ip'    => '127.0.0.1',
            'mer_reserved_1' => '',
            'mer_reserved_2' => '',
            'mer_reserved_3' => '',
            'order_desc'     => 'orderDesc',
        ];
        $order      = new Order($attributes);

        $return = self::$app->ccb_payment->JsPay()->pay($order);

        var_export($return);
    }

    public function qrPay($order_num, $order_amount = '1')
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

        $return = self::$app->ccb_payment->JsPay()->qrPay($order);

        var_export($return);
    }

}

$Application = new Request();

$orig_order_num = '1493109659157606005536';
$order_num      = build_order_num();
$scan_code_id   = '收款码号';
$order_amount   = '1';

var_dump($order_num);

$Application->fastPayment($order_num, $order_amount);

#$Application->qrPay($order_num, $order_amount);


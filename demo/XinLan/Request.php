<?php
require '../../vendor/autoload.php';

use ChannelBank\Foundation\Application;
use ChannelBank\XinLan\Order;

class Request
{

    static $app;

    public function __construct()
    {
        $options = [
            'debug' => true,
            'log'   => [
                'level' => 'debug',
                'file'  => '/tmp/ChannelBank_XinLan.log',
            ],

            'xinlan_payment' => [
                'merchant_id' => '8168001221',
                //'secret'      => '111111',
                'sign_key'    => '6547c991e1747b3d793007d8e6debbae',
            ],
        ];

        self::$app = new Application($options);
    }

    /**
     *
     */
    public function createOrder()
    {
        $attributes = [
            'goods_name'    => 'Test',
            'order_amount'  => '1',
            'mer_order_id'  => build_order_num(),
            'notify_url'    => 'http://242.itse.cc/XinLan/Notice.php?callback=backUrl',
            'terminal_code' => '101tywq0001',
            'channel_flag'  => '01', //渠道标志 01：支付宝，02：微信，03：易付宝
            'client_ip'     => '127.0.0.1',
        ];
        $order      = new Order($attributes);

        $return = self::$app->xinlan_payment->createOrder()->pay($order);

        var_dump($return);
        exit;
    }

    public function consumerShowCode($auth_code = '')
    {
        $attributes = [
            'goods_name'    => 'Test',
            'order_amount'  => '1',
            'mer_order_id'  => build_order_num(),
            'notify_url'    => 'http://242.itse.cc/XinLan/Notice.php?callback=backUrl',
            'terminal_code' => '101tywq0001',
            'channel_flag'  => '01', //渠道标志 01：支付宝，02：微信，03：易付宝
            'client_ip'     => '127.0.0.1',
            'auth_code'     => $auth_code,
        ];
        $order      = new Order($attributes);

        $return = self::$app->xinlan_payment->consumerShowCode()->pay($order);

        var_dump($return);
        exit;
    }

}

$Application = new Request();

//不明觉厉的 - 订单提交
#$Application->createOrder();

//刷卡支付
$Application->consumerShowCode('130329997040954776');
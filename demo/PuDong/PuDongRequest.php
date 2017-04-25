<?php
require '../../vendor/autoload.php';

use ChannelBank\Foundation\Application;
use ChannelBank\PuDong\Order;

class ApplicationDemo
{

    static $app;

    public function __construct()
    {
        $options = [
            'debug' => true,
            'log'   => [
                'level' => 'debug',
                'file'  => '/tmp/ChannelBank.log',
            ],

            'spdb_payment' => [
                'in_scd'      => '10134001',
                'mch_nt_id'   => '100000000000203',
                'terminal_id' => 'tywx0001',
                'sign_key'    => 'zsdfyreuoyamdphhaweyrjbvzkgfdycs',
            ],
        ];

        self::$app = new Application($options);
    }

    /**
     * @param        $order_num
     * @param        $scan_code_id
     * @param string $tx_amt
     */
    public function fastPayment($order_num, $scan_code_id, $tx_amt = '000000000011')
    {
        $attributes = [
            'order_num'    => $order_num,
            'tx_amt'       => $tx_amt,
            'scan_code_id' => $scan_code_id,
        ];
        $order      = new Order($attributes);

        $return = self::$app->spdb_payment->fastPayment()->pay($order);

        var_dump($return);
        exit;
    }

    /**
     * @param null   $order_num
     * @param string $tx_amt
     */
    public function payOrder($order_num = null, $tx_amt = '000000000011')
    {
        $attributes = [
            'chcd'      => 'WXP', //需要请求的渠道代码，例如需要请求支付宝则填写ALP，填写列表:ALP:支付宝，WXP: 微信，YZF:翼支付，QQP:qq钱包，京东钱包:JDP，百度钱包:BDP，YDP:移动和 包，YLP:银联钱包
            'order_num' => $order_num,
            'tx_amt'    => $tx_amt,
        ];
        $order      = new Order($attributes);

        var_dump($order->toArray());

        $return = self::$app->spdb_payment->qrCode()->pay($order);

        var_dump($return);
        exit;
    }

    public function jsPay($ch_cd = 'WXP', $order_num = null, $tx_amt)
    {
        $attributes = [
            'chcd'      => $ch_cd, // 付渠道， 前 仅 持微信 付 和 付宝， WXP:微信  付，ALP: 付 宝
            'order_num' => $order_num,
            'tx_amt'    => $tx_amt,
            'backUrl'   => 'http://242.itse.cc/PuDong/PuDongNotice.php?calback=backUrl',
            'frontUrl'  => 'http://242.itse.cc/PuDong/PuDongNotice.php?calback=frontUrl',
        ];

        if (null === $attributes['order_num']) {
            $attributes['order_num'] = build_order_num();
        }

        var_dump($attributes);
        $order = new Order($attributes);

        $return = self::$app->spdb_payment->jsPay()->pay($order);

        var_dump($return);
        exit;
    }

    public function query($orig_order_num = null)
    {
        $return = self::$app->spdb_payment->Query()->get($orig_order_num);

        var_dump($return);
        exit;
    }

    public function repeal($orig_order_num, $order_num = null)
    {

        $return = self::$app->spdb_payment->Cancel()->repeal($orig_order_num, $order_num);

        var_dump($return);
        exit;
    }

    public function abolish($orig_order_num = '', $order_num = '')
    {
        $return = self::$app->spdb_payment->Cancel()->abolish($orig_order_num, $order_num);

        var_dump($return);
        exit;
    }

    public function refund($tx_amt, $orig_order_num, $order_num)
    {
        $return = self::$app->spdb_payment->Cancel()->refund($tx_amt, $orig_order_num, $order_num);

        var_dump($return);
        exit;
    }
}

$Application = new ApplicationDemo();

$orig_order_num = '订单号';
$order_num      = build_order_num();
$scan_code_id   = '收款码号';

//金额
$tx_amt = '000000000010';

var_dump($order_num);
//扫码收款
#$Application->fastPayment($order_num, $scan_code_id ,$tx_amt);
//预订单
#$Application->payOrder($order_num, $tx_amt);
//H5支付
#$Application->jsPay('WXP', $order_num ,$tx_amt);
//查询
#$Application->query($orig_order_num);
//撤销
#$Application->repeal($orig_order_num, $order_num);
//取消订单
#$Application->abolish($orig_order_num, $order_num);
//退款
#$Application->refund($tx_amt, $orig_order_num, $order_num);
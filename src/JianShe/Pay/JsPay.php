<?php

namespace ChannelBank\JianShe\Pay;

use ChannelBank\JianShe\API;
use ChannelBank\JianShe\Order;

class JsPay extends API
{

    public function pay(Order $order)
    {
        $attributes = [
            'version'           => Order::PAY_VERSION,
            'charset'           => Order::CHARSET,
            'signMethod'        => Order::SIGNMETHOD,
            'payType'           => 'B2C',
            'transType'         => Order::PAY_TRANSTYPE,
            'merId'             => '10001',
            'orderTime'         => date('YmdHis', time()),
            'orderCurrency'     => Order::ORDERCURRENCY,
            'defaultBankNumber' => '991',
        ];

        foreach ($attributes as $key => $value) {
            $order->set($key, $value);
        }

        $subject = parent::request(parent::JSPT_PAY_URL, $order->all());
        //-----微信支付 - 下单处理方式-------------------------------------------------------------------------------------------------------------------
        //未知
        $response_array = ['error_msg' => '未知', 'error_code' => '-1', 'body' => $subject];

        if ($matche_number = preg_match_all('/window.location.href = "(.*)"/is', $subject, $matches)) {
            //成功
            parse_str($matches[1][0], $arr);
            parse_str(parse_url($arr['state'])['query'], $arr2);
            $pay_order_id = $arr2['payorderid'];

            $response_array = ['error_msg' => 'SUCCESS', 'error_code' => '0', 'pay_url' => $matches[1][0], 'pay_order_id' => $pay_order_id];
        } else {
            //失败
            $pattern = '/.*?<p class="main_word end_error">(.*)<\/p>.*?<p class="sub_word">(.*)<\/p>/is';
            if ($matche_number = preg_match_all($pattern, $subject, $matches)) {
                $response_array = ['error_msg' => $matches[1][0], 'error_code' => $matches[2][0]];
            }
        }

        //--------------------------------------------------------------------------------------------------------------------------------------------
        return $response_array;
    }

    public function qrPay(Order $order)
    {
        $attributes = [
            'version'           => Order::PAY_VERSION,
            'charset'           => Order::CHARSET,
            'signMethod'        => Order::SIGNMETHOD,
            'payType'           => 'B2C',
            'transType'         => Order::PAY_TRANSTYPE,
            'merId'             => $this->merchant->mer_id,
            'orderTime'         => date('YmdHis', time()),
            'orderCurrency'     => Order::ORDERCURRENCY,
            'defaultBankNumber' => '991',
            'scence'            => 'WECHAT_QR',
        ];

        foreach ($attributes as $key => $value) {
            $order->set($key, $value);
        }

        $subject = parent::request(parent::JSPT_PAY_URL, $order->all());

        parse_str($subject, $arr);

        return $arr;
    }
}

<?php

namespace ChannelBank\JianShe\Pay;

use ChannelBank\JianShe\API;
use ChannelBank\JianShe\Order;
use ChannelBank\Support\FromMatching;

class JsPay extends API
{

    /**
     * 微信H5支付
     *
     * @param \ChannelBank\JianShe\Order $order
     *
     * @return \ChannelBank\JianShe\Order
     */
    public function wxPay(Order $order)
    {
        $attributes = [
            'version'           => Order::PAY_VERSION,
            'charset'           => Order::CHARSET,
            'signMethod'        => Order::SIGNMETHOD,
            'payType'           => Order::PAY_TYPE_B2C,
            'transType'         => Order::PAY_TRANSTYPE,
            'merId'             => $this->merchant->mer_id,
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
        return new Order($response_array);
    }

    /**
     * 微信二维码支付
     *
     * @param \ChannelBank\JianShe\Order $order
     *
     * @return \ChannelBank\JianShe\Order
     */
    public function wxQrPay(Order $order)
    {
        $attributes = [
            'version'           => Order::PAY_VERSION,
            'charset'           => Order::CHARSET,
            'signMethod'        => Order::SIGNMETHOD,
            'payType'           => Order::PAY_TYPE_B2C,
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

        return new Order($arr);
    }

    /**
     * 支付宝H5支付
     *
     * @param \ChannelBank\JianShe\Order $order
     *
     * @return \ChannelBank\JianShe\Order
     */
    public function aliPay(Order $order)
    {
        $attributes = [
            'version'           => Order::PAY_VERSION,
            'charset'           => Order::CHARSET,
            'signMethod'        => Order::SIGNMETHOD,
            'payType'           => Order::PAY_TYPE_B2C,
            'transType'         => Order::PAY_TRANSTYPE,
            'merId'             => '10001',
            'orderTime'         => date('YmdHis', time()),
            'orderCurrency'     => Order::ORDERCURRENCY,
            'defaultBankNumber' => '992',
        ];

        foreach ($attributes as $key => $value) {
            $order->set($key, $value);
        }

        $subject = parent::request(parent::JSPT_PAY_URL, $order->all());

        $from_array = FromMatching::get_page_form_data($subject);

        $params = parent::params($order->all());

        $pay_url = parent::JSPT_PAY_URL;

        $html = '';
        foreach ($params as $key => $value) {
            $html .= '<input type="hidden" name="' . $key . '" value="' . $value . '"/>';
        }

        $editorSrc = <<<HTML
<form id="alipaysubmit"  name="alipaysubmit" action="$pay_url" method="post">$html<input type="submit" value="确认" style="display:none;"></form><script>document.forms['alipaysubmit'].submit();</script>
HTML;

        $data = ['pay_info' => $from_array, 'pay_html' => $editorSrc];

        return new Order($data);
    }

    /**
     * 支付宝二维码支付
     *
     * @param \ChannelBank\JianShe\Order $order
     *
     * @return \ChannelBank\JianShe\Order
     */
    public function aliQrPay(Order $order)
    {
        $attributes = [
            'version'           => Order::PAY_VERSION,
            'charset'           => Order::CHARSET,
            'signMethod'        => Order::SIGNMETHOD,
            'payType'           => Order::PAY_TYPE_B2C,
            'transType'         => Order::PAY_TRANSTYPE,
            'merId'             => $this->merchant->mer_id,
            'orderTime'         => date('YmdHis', time()),
            'orderCurrency'     => Order::ORDERCURRENCY,
            'defaultBankNumber' => '992',
            'scence'            => 'ALIPAY_QR',
        ];

        foreach ($attributes as $key => $value) {
            $order->set($key, $value);
        }

        $subject = parent::request(parent::JSPT_PAY_URL, $order->all());

        parse_str($subject, $arr);

        return new Order($arr);
    }
}

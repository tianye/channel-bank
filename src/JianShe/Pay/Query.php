<?php

namespace ChannelBank\JianShe\Pay;

use ChannelBank\JianShe\API;
use ChannelBank\JianShe\Order;
use ChannelBank\Support\XML;

class Query extends API
{
    /**
     * @param \ChannelBank\JianShe\Order $order
     *
     * @return \ChannelBank\JianShe\Order
     * @throws \Exception
     */
    public function query(Order $order)
    {
        $attributes = [
            'version'    => Order::PAY_VERSION,
            'charset'    => Order::CHARSET,
            'signMethod' => Order::SIGNMETHOD,
            'payType'    => Order::PAY_TYPE_B2C,
            'transType'  => Order::PAY_TRANSTYPE,
            'merId'      => $this->merchant->mer_id,
            'queryTime'  => date('YmdHis', time()),
        ];

        foreach ($attributes as $key => $value) {
            $order->set($key, $value);
        }

        $subject = parent::request(parent::JSPT_QUERY_URL, $order->all());

        parse_str($subject, $arr);

        $content = str_replace(' ', '+', $arr['content']);

        $xml = base64_decode($content, true);

        if (!parent::isXmlValid($xml, $arr['sign'])) {
            throw new \Exception(' 签名验证失败');
        }

        return new Order(XML::parse($xml));
    }

    /**
     * @param \ChannelBank\JianShe\Order $order
     *
     * @return \ChannelBank\JianShe\Order
     * @throws \Exception
     */
    public function refundQuery(Order $order)
    {
        $attributes = [
            'version'    => Order::PAY_VERSION,
            'charset'    => Order::CHARSET,
            'signMethod' => Order::SIGNMETHOD,
            'transType'  => Order::REF_TRANSTYPE,
            'merId'      => $this->merchant->mer_id,
            'orderTime'  => date('YmdHis', time()),
        ];

        foreach ($attributes as $key => $value) {
            $order->set($key, $value);
        }

        $subject = parent::request(parent::REFUND_QUERY_URL, $order->all());

        parse_str($subject, $arr);

        $content = str_replace(' ', '+', $arr['content']);

        $xml = base64_decode($content, true);

        if (!parent::isXmlValid($xml, $arr['sign'])) {
            throw new \Exception(' 签名验证失败');
        }

        return new Order(XML::parse($xml));
    }
}

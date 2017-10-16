<?php

namespace ChannelBank\JianShe\Pay;

use ChannelBank\JianShe\API;
use ChannelBank\JianShe\Order;
use ChannelBank\Support\Collection;

class Cancel extends API
{

    /**
     * 关闭
     *
     * @param \ChannelBank\JianShe\Order $order
     *
     * @return \ChannelBank\JianShe\Order
     * @throws \Exception
     */
    public function repeal(Order $order)
    {
        $attributes = [
            'version'    => Order::PAY_VERSION,
            'charset'    => Order::CHARSET,
            'signMethod' => Order::SIGNMETHOD,
            'payType'    => Order::PAY_TYPE_B2C,
            'transType'  => Order::FRONT_CLOSE_REQ_TRANSTYPE,
            'merId'      => $this->merchant->mer_id,
            'orderTime'  => date('YmdHis', time()),
        ];

        foreach ($attributes as $key => $value) {
            $order->set($key, $value);
        }

        $subject = parent::request(parent::FRONT_CLOSE_REQ, $order->all());

        parse_str($subject, $arr);

        if (!parent::isValid(new Collection($arr))) {
            throw new \Exception(' 签名验证失败');
        }

        return new Order($arr);
    }

    /**
     * 退款
     *
     * @param \ChannelBank\JianShe\Order $order
     *
     * @return \ChannelBank\JianShe\Order
     * @throws \Exception
     */
    public function refund(Order $order)
    {
        $attributes = [
            'version'       => Order::PAY_VERSION,
            'charset'       => Order::CHARSET,
            'signMethod'    => Order::SIGNMETHOD,
            'transType'     => Order::REF_TRANSTYPE,
            'merId'         => $this->merchant->mer_id,
            'orderTime'     => date('YmdHis', time()),
            'orderCurrency' => Order::ORDERCURRENCY,
            'serviceId'     => Order::REF_SERVICE_ID,
        ];

        foreach ($attributes as $key => $value) {
            $order->set($key, $value);
        }

        $subject = parent::request(parent::REFUND_PAY_URL, $order->all());

        parse_str($subject, $arr);

        if (!parent::isValid(new Collection($arr))) {
            throw new \Exception(' 签名验证失败');
        }

        return new Order($arr);
    }
}

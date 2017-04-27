<?php
namespace ChannelBank\XinLan\Pay;

use ChannelBank\XinLan\API;
use ChannelBank\XinLan\Order;

class ConsumerShowCode extends API
{
    /**
     * @param \ChannelBank\XinLan\Order $order
     *
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\ResponseInterface
     */
    public function pay(Order $order)
    {
        return $this->request(parent::API_CONSUMER_SHOW_CODE, $order->all());
    }
}

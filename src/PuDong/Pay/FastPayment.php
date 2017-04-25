<?php
namespace ChannelBank\PuDong\Pay;

use ChannelBank\PuDong\API;
use ChannelBank\PuDong\Order;

class FastPayment extends API
{

    public function pay(Order $order)
    {
        $order->with('busicd', parent::BUSICD_FAST);

        return parent::pay($order);
    }
}

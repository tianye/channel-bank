<?php
namespace ChannelBank\PuDong\Pay;

use ChannelBank\PuDong\API;
use ChannelBank\PuDong\Order;

class QrCode extends API
{

    public function pay(Order $order)
    {
        $order->with('busicd', parent::BUSICD_QR_CODE);

        return parent::pay($order);
    }
}

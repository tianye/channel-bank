<?php
namespace ChannelBank\PuDong\Pay;

use ChannelBank\PuDong\API;
use ChannelBank\PuDong\Order;

class Query extends API
{

    public function get($orig_order_num = null, $order_num = null, $out_order_num = null)
    {
        $order = new Order(['orig_order_num' => $orig_order_num, 'order_num' => $order_num, 'out_order_num' => $out_order_num]);

        $order->with('busicd', parent::BUSICE_INQY);

        return parent::request(parent::API_PAY_ORDER, $order->all());
    }
}

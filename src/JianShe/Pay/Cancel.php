<?php

namespace ChannelBank\JianShe\Pay;

use ChannelBank\JianShe\API;
use ChannelBank\JianShe\Order;

class Cancel extends API
{

    /**
     * 关闭
     *
     */
    public function repeal($orig_order_num = null, $order_num = null, $out_order_num = null)
    {
    }

    /**
     * 退款
     *
     */
    public function refund($tx_amt = 0, $orig_order_num = null, $order_num = null, $out_order_num = null)
    {
    }
}

<?php

namespace ChannelBank\MinSheng\Pay;

use ChannelBank\MinSheng\API;
use ChannelBank\MinSheng\Order;

class Query extends API
{
    const QUERY_TRANS_ID = '04';

    public function get($request_no = null, $order_date = null, $order_no = null)
    {
        $order = new Order(['request_no' => $request_no, 'order_date' => $order_date, 'order_no' => $order_no]);

        $order->with('mch_no', $this->merchant->mch_no);
        $order->with('version', parent::VERSION);
        $order->with('trans_id', self::QUERY_TRANS_ID);



        return parent::request(parent::API_PAY_ORDER, $order->all());
    }
}

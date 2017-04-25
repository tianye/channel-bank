<?php
namespace ChannelBank\PuDong\Pay;

use ChannelBank\PuDong\API;
use ChannelBank\PuDong\Order;

class JsPay extends API
{

    public function pay(Order $order)
    {
        $order->with('busicd', parent::BUSICD_JSPAY);

        $params = $this->params($order->all());

        $json_params = \GuzzleHttp\json_encode($params, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        $base64_params = base64_encode($json_params);

        return parent::PAY_URL . $base64_params;
    }
}

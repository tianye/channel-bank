<?php

namespace ChannelBank\MinSheng\Pay;

use ChannelBank\MinSheng\API;
use ChannelBank\MinSheng\Order;

class JsPay extends API
{
    const JSPAY_TRANS_ID = '10';

    const PRODUCT_ID_WECHAT_JS_PAY = '0105';
    const PRODUCT_ID_ALIPAY_JS_PAY = '0115';

    public function WeChatJsPay(Order $order)
    {
        $order->with('version', parent::VERSION);
        $order->with('product_id', self::PRODUCT_ID_WECHAT_JS_PAY);
        $order->with('trans_id', self::JSPAY_TRANS_ID);
        $order->with('mch_no', $this->merchant->mch_no);

        return $this->fieldChange(parent::pay($order));
    }

    public function AliJsPay(Order $order)
    {
        $order->with('version', parent::VERSION);
        $order->with('product_id', self::PRODUCT_ID_ALIPAY_JS_PAY);
        $order->with('trans_id', self::JSPAY_TRANS_ID);
        $order->with('mch_no', $this->merchant->mch_no);

        return $this->fieldChange(parent::pay($order));
    }

    public function fieldChange($order)
    {
        if (!$order) {
            return false;
        }

        return $order;
    }
}

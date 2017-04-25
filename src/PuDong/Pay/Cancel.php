<?php
namespace ChannelBank\PuDong\Pay;

use ChannelBank\PuDong\API;
use ChannelBank\PuDong\Order;

class Cancel extends API
{

    /**
     * 撤销
     *
     * @param null $orig_order_num
     * @param null $order_num
     * @param null $out_order_num
     *
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\ResponseInterface
     */
    public function repeal($orig_order_num = null, $order_num = null, $out_order_num = null)
    {
        $order = new Order(['orig_order_num' => $orig_order_num, 'order_num' => $order_num, 'out_order_num' => $out_order_num]);

        $order->with('busicd', parent::BUSICE_VOID);

        return parent::request(parent::API_PAY_ORDER, $order->all());
    }

    /**
     * 退款
     *
     * @param int  $tx_amt
     * @param null $orig_order_num
     * @param null $order_num
     * @param null $out_order_num
     *
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\ResponseInterface
     */
    public function refund($tx_amt = 0, $orig_order_num = null, $order_num = null, $out_order_num = null)
    {
        $order = new Order(['tx_amt' => $tx_amt, 'orig_order_num' => $orig_order_num, 'order_num' => $order_num, 'out_order_num' => $out_order_num]);

        $order->with('busicd', parent::BUSICE_REFD);

        return parent::request(parent::API_PAY_ORDER, $order->all());
    }

    /**
     * 取消
     *
     * @param null $orig_order_num
     * @param null $order_num
     * @param null $out_order_num
     *
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\ResponseInterface
     */
    public function abolish($orig_order_num = null, $order_num = null, $out_order_num = null)
    {
        $order = new Order(['orig_order_num' => $orig_order_num, 'order_num' => $order_num, 'out_order_num' => $out_order_num]);

        $order->with('busicd', parent::BUSICE_CANC);

        return parent::request(parent::API_PAY_ORDER, $order->all());
    }
}

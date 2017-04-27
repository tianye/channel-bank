<?php

namespace ChannelBank\XinLan;

use ChannelBank\Support\Attribute;

/**
 * Class Order.
 *
 * @property string $body
 * @property string $out_trade_no
 * @property string $fee_type
 * @property string $total_fee
 */
class Order extends Attribute
{
    protected $attributes = [
        'goodsName',
        'orderAmount',
        'merOrderId',
        'notifyURL',
        'terminalCode',
        'authCode',
        'clientIP',
        'orderCode',
        'transactionID',
        'channelFlag',
        'codeUrl',
        'status',
        'refundCode',
        'refundStatus',
        'createDate',
        'payDate',
        'refundDate',
        'merchOrderId',
        'amount',
        'merchName',
        'successUrl',
    ];

    /**
     * Aliases of attributes.
     *
     * @var array
     */
    protected $aliases = [
        'goodsName'     => 'goods_name',
        'orderAmount'   => 'order_amount',
        'merOrderId'    => 'mer_order_id',
        'notifyURL'     => 'notify_url',
        'terminalCode'  => 'terminal_code',
        'authCode'      => 'auth_code',
        'clientIP'      => 'client_iP',
        'orderCode'     => 'order_code',
        'transactionID' => 'transaction_id',
        'channelFlag'   => 'channel_flag',
        'codeUrl'       => 'code_url',
        'refundCode'    => 'refund_code',
        'refundStatus'  => 'refund_status',
        'createDate'    => 'create_date',
        'payDate'       => 'pay_date',
        'refundDate'    => 'refund_date',
        'merchOrderId'  => 'merch_order_id',
        'merchName'     => 'merch_name',
        'successUrl'    => 'success_url',
        'clientIP'      => 'client_ip',
    ];

    /**
     * Constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);
    }
}

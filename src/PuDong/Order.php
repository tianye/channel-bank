<?php

namespace ChannelBank\PuDong;

use ChannelBank\Support\Attribute;

/**
 * Class Order.
 *
 * @property string $body
 * @property string $detail
 * @property string $attach
 * @property string $out_trade_no
 * @property string $fee_type
 * @property string $total_fee
 * @property string $spbill_create_ip
 * @property string $time_start
 * @property string $time_expire
 * @property string $goods_tag
 * @property string $notify_url
 * @property string $trade_type
 * @property string $product_id
 * @property string $limit_pay
 * @property string $openid
 * @property string $sub_openid
 * @property string $auth_code
 */
class Order extends Attribute
{
    const JSAPI    = 'JSAPI';
    const NATIVE   = 'NATIVE';
    const APP      = 'APP';
    const MICROPAY = 'MICROPAY';

    protected $attributes = [
        'orderNum',
        'txamt',
        'goodsList',
        'scanCodeId',
        'outOrderNum',
        'origOrderNum',
        'outOrderNum',
    ];

    /**
     * Aliases of attributes.
     *
     * @var array
     */
    protected $aliases = [
        'orderNum'     => 'order_num',
        'txamt'        => 'tx_amt',
        'goodsList'    => 'goods_list',
        'scanCodeId'   => 'scan_code_id',
        'outOrderNum'  => 'out_order_num',
        'origOrderNum' => 'orig_order_num',
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

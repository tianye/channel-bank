<?php

namespace ChannelBank\MinSheng;

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
        'requestNo',
        'orderDate',
        'orderNo',
        'notifyUrl',
        'transAmt',
        'commodityName',
        'subChnlMerNo',
        'subMerName',
        'limitPay',
        'userId',
        'orderDate',
        'orderNo',
        'merNo',
        'openid',
        'storeId',
        'subMerNo',
        'productId',
        'transId',
    ];

    /**
     * Aliases of attributes.
     *
     * @var array
     */
    protected $aliases = [
        'requestNo'     => 'request_no',
        'orderDate'     => 'order_date',
        'orderNo'       => 'order_no',
        'notifyUrl'     => 'notify_url',
        'transAmt'      => 'trans_amt',
        'commodityName' => 'commodity_name',
        'subChnlMerNo'  => 'sub_channel_mch_no',
        'subMerName'    => 'sub_mch_name',
        'subMerNo'      => 'sub_mch_no',
        'limitPay'      => 'limit_pay',
        'userId'        => 'user_id',
        'merNo'         => 'mch_no',
        'storeId'       => 'store_id',
        'productId'     => 'product_id',
        'transId'       => 'trans_id',
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

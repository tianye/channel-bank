<?php

namespace ChannelBank\JianShe;

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
    const PAY_VERSION   = "2.0";    // 支付版本
    const QUE_VERSION   = "2.0";    // 查询版本
    const PAY_TRANSTYPE = "01";     // 01-消费交易

    const PAY_TYPE_B2C = 'B2C';

    const REF_PAY_VERSION = "2.0";   // 退款版本
    const REF_QUE_VERSION = "2.0";   // 退款查询版本
    const REF_TRANSTYPE   = "02";    // 02-退款交易
    const REF_SERVICE_ID  = '0';     // 退款SERVICE ID

    const FRONT_CLOSE_REQ_TRANSTYPE = "03";    // 03-关闭交易

    const BILL_DOWNLOAD_VERSION     = "2.0";     // 下载版本
    const BILL_DOWNLOAD_TRANSCODE01 = "F001";    // F001-对账单生成
    const BILL_DOWNLOAD_TRANSCODE02 = "F002";    // F002-对账单下载

    // 公用数据
    const CHARSET       = "UTF-8";  // 字符集UTF-8或者GBK
    const SIGNMETHOD    = "MD5";    // 加密方式
    const ORDERCURRENCY = "156";    // 交易币种

    protected $attributes = [
        'backEndUrl',
        'frontEndUrl',
        'orderNumber',
        'orderAmount',
        'customerIp',
        'merReserved1',
        'merReserved2',
        'merReserved3',
        'orderDesc',
        'agentAmount',
        'version',
        'charset',
        'signMethod',
        'payType',
        'transType',
        'merId',
        'orderTime',
        'orderCurrency',
        'defaultBankNumber',
        'scence',
        'refAmount',
        'refSplitAmount',
        'refId',
        'serviceId',
        'merOrderid',
        'bankNumber',
    ];

    /**
     * Aliases of attributes.
     *
     * @var array
     */
    protected $aliases = [
        'backEndUrl'        => 'back_end_url',
        'frontEndUrl'       => 'front_end_url',
        'orderNumber'       => 'order_number',
        'orderAmount'       => 'order_amount',
        'customerIp'        => 'customer_ip',
        'merReserved1'      => 'mer_reserved_1',
        'merReserved2'      => 'mer_reserved_2',
        'merReserved3'      => 'mer_reserved_3',
        'orderDesc'         => 'order_desc',
        'agentAmount'       => 'agent_amount',
        'version'           => 'version',
        'charset'           => 'charset',
        'signMethod'        => 'sign_method',
        'payType'           => 'pay_type',
        'transType'         => 'trans_type',
        'merId'             => 'mer_id',
        'orderTime'         => 'order_time',
        'orderCurrency'     => 'order_currency',
        'defaultBankNumber' => 'default_bank_number',
        'scence'            => 'scence',
        'refAmount'         => 'ref_amount',
        'refSplitAmount'    => 'ref_split_amount',
        'refId'             => 'ref_id',
        'serviceId'         => 'service_id',
        'merOrderid'        => 'mer_order_id',
        'bankNumber'        => 'bank_number',
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

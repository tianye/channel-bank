<?php

namespace ChannelBank\PuDong;

use ChannelBank\Support\Attribute;

/**
 * Class Merchant.
 *
 * @property string $version
 * @property string $sign_type
 * @property string $charset
 * @property string $txn_dir
 * @property string $bus_icd
 * @property string $in_scd
 * @property string $mch_nt_id
 * @property string $terminal_id
 * @property string $fee_type
 * @property string $sign_key
 */
class Merchant extends Attribute
{
    /**
     * @var array
     */
    protected $attributes = [
        'version',
        'signType',
        'charset',
        'txndir',
        'busicd',
        'inscd',
        'mchntid',
        'terminalid',
        'currency',
        'stringSignTemp',
    ];

    /**
     * Aliases of attributes.
     *
     * @var array
     */
    protected $aliases = [
        'version'        => 'version',
        'signType'       => 'sign_type',
        'charset'        => 'charset',
        'txndir'         => 'txn_dir',
        'busicd'         => 'bus_icd',
        'inscd'          => 'in_scd',
        'mchntid'        => 'mch_nt_id',
        'terminalid'     => 'terminal_id',
        'currency'       => 'fee_type',
        'stringSignTemp' => 'sign_key',
    ];

    /**
     * Constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        parent::__construct($attributes);

        $this->with('fee_type', 'CNY');
    }
}

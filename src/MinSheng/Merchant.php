<?php

namespace ChannelBank\MinSheng;

use ChannelBank\Support\Attribute;

/**
 * Class Merchant.
 *
 * @property string $version
 * @property string $mch_no
 * @property string $pri_key
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

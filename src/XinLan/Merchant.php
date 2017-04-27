<?php

namespace ChannelBank\XinLan;

use ChannelBank\Support\Attribute;

/**
 * Class Merchant.
 *
 * @property string $merchant_id
 * @property string $sign_type
 * @property string $sign_key
 */
class Merchant extends Attribute
{
    /**
     * @var array
     */
    protected $attributes = [
        'merchId',
        'sign_key',
        'secret',
    ];

    /**
     * Aliases of attributes.
     *
     * @var array
     */
    protected $aliases = [
        'merchId'  => 'merchant_id',
        'sign_key' => 'app_key',
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

<?php

namespace ChannelBank\JianShe;

use ChannelBank\Support\Attribute;

/**
 * Class Merchant.
 *
 * @property string $mer_id
 * @property string $sign_key
 * @property string $sign_method
 */
class Merchant extends Attribute
{
    /**
     * @var array
     */
    protected $attributes = [
        'customerIp',
        'version',
        'charset',
        'signMethod',
        'merId',
    ];

    /**
     * Aliases of attributes.
     *
     * @var array
     */
    protected $aliases = [
        'customerIp' => 'customer_ip',
        'version'    => 'version',
        'charset'    => 'charset',
        'signMethod' => 'sign_method',
        'merId'      => 'mer_id',
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

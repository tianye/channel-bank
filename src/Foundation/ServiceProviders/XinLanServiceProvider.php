<?php

namespace ChannelBank\Foundation\ServiceProviders;

use ChannelBank\XinLan\Merchant;
use ChannelBank\XinLan\Payment;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class XinLanServiceProvider
 *
 * @package ChannelBank\Foundation\ServiceProviders
 */
class XinLanServiceProvider implements ServiceProviderInterface
{
    const SIGN_TYPE = 'md5';

    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['xinlan_merchant'] = function ($pimple) {
            $config = array_merge(
                [
                    'sign_type' => self::SIGN_TYPE,
                ],
                $pimple['config']->get('xinlan_payment', [])
            );

            return new Merchant($config);
        };

        //Payment
        $pimple['xinlan_payment'] = function ($pimple) {
            return new Payment($pimple['xinlan_merchant']);
        };
    }
}
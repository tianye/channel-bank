<?php

namespace ChannelBank\Foundation\ServiceProviders;

use ChannelBank\MinSheng\Payment;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use ChannelBank\MinSheng\Merchant;

/**
 * Class MinShengServiceProvider
 *
 * @package ChannelBank\Foundation\ServiceProviders
 */
class MinShengServiceProvider implements ServiceProviderInterface
{
    const VERSION = '1.0';

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
        $pimple['minsheng_merchant'] = function ($pimple) {
            $config = array_merge(
                [
                    'version' => self::VERSION,
                ],
                $pimple['config']->get('minsheng_payment', [])
            );

            return new Merchant($config);
        };

        //Payment
        $pimple['minsheng_payment'] = function ($pimple) {
            return new Payment($pimple['minsheng_merchant']);
        };
    }
}
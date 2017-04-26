<?php

namespace ChannelBank\Foundation\ServiceProviders;

use ChannelBank\PuDong\JsPay;
use ChannelBank\PuDong\Notice;
use ChannelBank\PuDong\Payment;
use ChannelBank\PuDong\QrCode;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use ChannelBank\PuDong\FastPayment;
use ChannelBank\PuDong\Merchant;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PuDongServiceProvider
 *
 * @package ChannelBank\Foundation\ServiceProviders
 */
class PuDongServiceProvider implements ServiceProviderInterface
{
    const VERSION   = '2.1';
    const SIGN_TYPE = 'SHA256';
    const CHARSET   = 'utf-8';

    const REQUEST = 'Q';
    const ANSWER  = 'A';

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
        $pimple['spdb_merchant'] = function ($pimple) {
            $config = array_merge(
                [
                    'version'   => self::VERSION,
                    'sign_type' => self::SIGN_TYPE,
                    'charset'   => self::CHARSET,
                    'txn_dir'   => self::REQUEST,
                ],
                $pimple['config']->get('spdb_payment', [])
            );

            return new Merchant($config);
        };

        //Payment
        $pimple['spdb_payment'] = function ($pimple) {
            return new Payment($pimple['spdb_merchant']);
        };
    }
}
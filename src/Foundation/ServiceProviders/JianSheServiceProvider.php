<?php

namespace ChannelBank\Foundation\ServiceProviders;

use ChannelBank\JianShe\Payment;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use ChannelBank\JianShe\Merchant;

/**
 * Class MinShengServiceProvider
 *
 * @package ChannelBank\Foundation\ServiceProviders
 */
class JianSheServiceProvider implements ServiceProviderInterface
{

    const VERSION       = "2.0"; // 版本号2.0
    const CHARSET       = "UTF-8"; // 字符集UTF-8或者GBK
    const SIGNMETHOD    = "MD5"; // 签名方法
    const ORDERCURRENCY = "156";   // 币种
    const TRANSTYPE     = "01";    // 交易类型 01：消费

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
        $pimple['ccb_merchant'] = function ($pimple) {
            $config = array_merge(
                [
                    'version'        => self::VERSION,
                    'charset'        => self::CHARSET,
                    'sign_method'    => self::SIGNMETHOD,
                    'order_currency' => self::ORDERCURRENCY,
                    'trans_type'     => self::TRANSTYPE,
                ],
                $pimple['config']->get('ccb_payment', [])
            );

            return new Merchant($config);
        };

        //Payment
        $pimple['ccb_payment'] = function ($pimple) {
            return new Payment($pimple['ccb_merchant']);
        };
    }
}
<?php

namespace ChannelBank\JianShe;

use ChannelBank\Core\Exceptions\FaultException;
use ChannelBank\JianShe\API;
use ChannelBank\JianShe\Pay\Cancel;
use ChannelBank\JianShe\Pay\JsPay;
use ChannelBank\JianShe\Pay\Query;
use Symfony\Component\HttpFoundation\Response;

class Payment
{
    /**
     * @var API
     */
    protected $api;

    /**
     * Merchant instance.
     *
     * @var \ChannelBank\JianShe\Merchant
     */
    protected $merchant;

    /**
     * Constructor.
     *
     * @param Merchant $merchant
     */
    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * @param callable $callback
     *
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \ChannelBank\Core\Exceptions\FaultException
     */
    public function handleNotify(callable $callback)
    {
    }

    public function JsPay()
    {
        return new JsPay($this->merchant);
    }

    public function Query()
    {
        return new Query($this->merchant);
    }

    public function Cancel()
    {
        return new Cancel($this->merchant);
    }
}

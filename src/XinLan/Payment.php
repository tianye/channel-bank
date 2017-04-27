<?php
namespace ChannelBank\XinLan;

use ChannelBank\Core\Exceptions\FaultException;

use ChannelBank\XinLan\Pay\ConsumerShowCode;
use ChannelBank\XinLan\Pay\CreateOrder;
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
     * @var \ChannelBank\PuDong\Merchant
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
        $notify = $this->getNotify();

        if (!$notify->isValid()) {
            throw new FaultException('Invalid request payloads.', 400);
        }

        $notify     = $notify->getNotify();
        $successful = $notify->get('errorDetail') === 'SUCCESS';

        $handleResult = call_user_func_array($callback, [$notify, $successful]);

        if (is_bool($handleResult) && $handleResult) {
            $response = [
                'return_code' => 'SUCCESS',
                'return_msg'  => 'OK',
            ];
        } else {
            $response = [
                'return_code' => 'FAIL',
                'return_msg'  => $handleResult,
            ];
        }

        return new Response(\GuzzleHttp\json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Return Notify instance.
     *
     * @return \ChannelBank\XinLan\Notify
     */
    public function getNotify()
    {
        return new Notify($this->merchant);
    }

    public function createOrder()
    {
        return new CreateOrder($this->merchant);
    }

    public function consumerShowCode()
    {
        return new ConsumerShowCode($this->merchant);
    }
}

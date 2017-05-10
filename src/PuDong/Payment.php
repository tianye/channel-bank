<?php
namespace ChannelBank\PuDong;

use ChannelBank\Core\Exceptions\FaultException;
use ChannelBank\PuDong\Pay\Cancel;
use ChannelBank\PuDong\Pay\FastPayment;
use ChannelBank\PuDong\Pay\JsPay;
use ChannelBank\PuDong\Pay\QrCode;
use ChannelBank\PuDong\Pay\Query;

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

        $notify = $notify->getNotify();

        if ($notify->get('errorDetail') === 'SUCCESS' && $notify->get('respcd') === '00') {
            $successful = 'SUCCESS';
        } else {
            $successful = "FAIL";
        }

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
     * @return \ChannelBank\PuDong\Notify
     */
    public function getNotify()
    {
        return new Notify($this->merchant);
    }

    /**
     * @return \ChannelBank\PuDong\Pay\FastPayment
     */
    public function fastPayment()
    {
        return new FastPayment($this->merchant);
    }

    /**
     * @return \ChannelBank\PuDong\Pay\JsPay
     */
    public function jsPay()
    {
        return new JsPay($this->merchant);
    }

    /**
     * @return \ChannelBank\PuDong\Pay\QrCode
     */
    public function qrCode()
    {
        return new QrCode($this->merchant);
    }

    /**
     * @return \ChannelBank\PuDong\Pay\Query
     */
    public function query()
    {
        return new Query($this->merchant);
    }

    /**
     * @return \ChannelBank\PuDong\Pay\Cancel
     */
    public function cancel()
    {
        return new Cancel($this->merchant);
    }
}

<?php
namespace ChannelBank\PuDong;

use ChannelBank\Core\Exceptions\FaultException;
use ChannelBank\Support\Collection;
use ChannelBank\Support\XML;
use Symfony\Component\HttpFoundation\Request;

class Notify
{
    /**
     * Merchant instance.
     *
     * @var \ChannelBank\PuDong\Merchant
     */
    protected $merchant;

    /**
     * Request instance.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $request;

    /**
     * Payment notify (extract from XML).
     *
     * @var Collection
     */
    protected $notify;

    /**
     * Constructor.
     *
     * @param Merchant $merchant
     * @param Request  $request
     */
    public function __construct(Merchant $merchant, Request $request = null)
    {

        $this->merchant = $merchant;
        $this->request  = $request ?: Request::createFromGlobals();
    }

    /**
     * Validate the request params.
     *
     * @return bool
     */
    public function isValid()
    {
        //浦发回调 calback sign 字段不参与签名
        $localSign = generate_sign($this->getNotify()->except(['calback', 'sign'])->all(), $this->merchant->sign_key, 'SHA256');

        return $localSign === $this->getNotify()->get('sign');
    }

    /**
     * Return the notify body from request.
     *
     * @return \ChannelBank\Support\Collection
     *
     * @throws \ChannelBank\Core\Exceptions\FaultException
     */
    public function getNotify()
    {
        if (!empty($this->notify)) {
            return $this->notify;
        }

        $notify = $this->request->query->all();

        //浦发回调以GET 方式 所以 空格 要换成 +
        $notify = \GuzzleHttp\json_decode(str_replace(' ', '+', \GuzzleHttp\json_encode($notify, SON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)), true);

        if (!is_array($notify) || empty($notify)) {
            throw new FaultException('Invalid request query.', 400);
        }

        return $this->notify = new Collection($notify);
    }
}

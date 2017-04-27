<?php
namespace ChannelBank\XinLan;

use ChannelBank\Core\Exceptions\FaultException;
use ChannelBank\Support\Collection;
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
        return true;
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

        if (!is_array($notify) || empty($notify)) {
            throw new FaultException('Invalid request query.', 400);
        }

        return $this->notify = new Collection($notify);
    }
}

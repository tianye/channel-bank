<?php
namespace ChannelBank\PuDong;

use ChannelBank\Core\Exceptions\FaultException;
use Psr\Http\Message\ResponseInterface;
use ChannelBank\Core\AbstractAPI;
use ChannelBank\Support\Collection;

class API extends AbstractAPI
{
    /**
     * Merchant instance.
     *
     * @var Merchant
     */
    protected $merchant;

    //api
    const API_PAY_ORDER = 'http://test.quick.ipay.so/scanpay/unified';
    const PAY_URL       = 'http://test.quick.ipay.so/scanpay/unified?data=';

    const BUSICD_FAST    = 'PURC';
    const BUSICD_QR_CODE = 'PAUT';
    const BUSICD_JSPAY   = 'WPAY';
    const BUSICE_INQY    = 'INQY';
    const BUSICE_VOID    = 'VOID';
    const BUSICE_REFD    = 'REFD';
    const BUSICE_CANC    = 'CANC';

    /**
     * API constructor.
     *
     * @param \ChannelBank\PuDong\Merchant $merchant
     */
    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
    }

    /**
     * Pay the order.
     *
     * @param Order $order
     *
     * @return \ChannelBank\Support\Collection
     */
    public function pay(Order $order)
    {
        return $this->request(self::API_PAY_ORDER, $order->all());
    }

    /**
     * Make a API request.
     *
     * @param string $api
     * @param array  $params
     * @param string $method
     * @param array  $options
     * @param bool   $returnResponse
     *
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\ResponseInterface
     */
    protected function request($api, array $params, $method = 'post', array $options = [], $returnResponse = false)
    {
        $params = $this->params($params);

        $options = array_merge([
            'body' => \GuzzleHttp\json_encode($params, JSON_ERROR_UTF8),
        ], $options);

        $response = $this->getHttp()->request($api, $method, $options);

        return $returnResponse ? $response : $this->parseResponse($response);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    protected function params(array $params)
    {
        if (!in_array($params['busicd'], [self::BUSICD_JSPAY], true)) {
            $params['txndir']   = $this->merchant->txn_dir;
            $params['inscd']    = $this->merchant->in_scd;
            $params['currency'] = $this->merchant->fee_type;
        }

        $params['version']  = $this->merchant->version;
        $params['signType'] = $this->merchant->sign_type;
        $params['charset']  = $this->merchant->charset;

        $params['mchntid']    = $this->merchant->mch_nt_id;
        $params['terminalid'] = $this->merchant->terminal_id;

        $params = array_filter($params);

        $params['sign'] = generate_sign($params, $this->merchant->sign_key, $this->merchant->sign_type);

        return $params;
    }

    /**
     * @param $response
     *
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\StreamInterface
     * @throws \ChannelBank\Core\Exceptions\FaultException
     */
    protected function parseResponse($response)
    {

        if ($response instanceof ResponseInterface) {
            $response = $response->getBody();
        }

        $response = new Collection((array) \GuzzleHttp\json_decode($response->__toString(), true));

        $valid = $this->isValid($response);

        if ($valid) {
            return $response;
        } else {
            throw new FaultException('签名验证失败', 400);
        }
    }

    /**
     * @param \ChannelBank\Support\Collection $response
     *
     * @return bool
     */
    protected function isValid(Collection $response)
    {
        $localSign = generate_sign($response->except('sign')->all(), $this->merchant->sign_key, 'SHA256');

        return $localSign === $response->get('sign');
    }

}
<?php

namespace ChannelBank\XinLan;

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

    const API_CREATE_ORDER        = 'http://smartpay-server.91link.com/smartpay-api/openApi/scanpay/createOrder';       //订单提交
    const API_CONSUMER_SHOW_CODE  = 'http://smartpay-server.91link.com/smartpay-api/openApi/scanpay/consumerShowCode';  //刷卡支付
    const API_MERCH_SHOW_CODE     = 'http://smartpay-server.91link.com/smartpay-api/openApi/scanpay/merchShowCode';     //扫码支付
    const API_TRANS_STATUS_QUERY  = 'http://smartpay-server.91link.com/smartpay-api/openApi/scanpay/transStatusQuery';  //单笔订单查询
    const API_REFUND              = 'http://smartpay-server.91link.com/smartpay-api/openApi/scanpay/refund';            //退款申请
    const API_REFUND_STATUS_QUERY = 'http://smartpay-server.91link.com/smartpay-api/openApi/scanpay/refundStatusQuery'; //查询退款订单
    const API_AUTH_REQUEST        = 'http://www.91link.com/smartpay-api/api/scanpay/authRequest';                       //公众号支付

    /**
     * API constructor.
     *
     * @param \ChannelBank\XinLan\Merchant $merchant
     */
    public function __construct(Merchant $merchant)
    {
        $this->merchant = $merchant;
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
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\ResponseInterface|bool
     */
    protected function request($api, array $params, $method = 'post', array $options = [], $returnResponse = false)
    {
        $params = $this->params($params);

        $options = array_merge([
            'form_params' => $params,
        ], $options);

        var_dump($options['form_params']);

        $response = $this->getHttp()->request($api, $method, $options);

        return $returnResponse || !$response ? $response : $this->parseResponse($response);
    }

    /**
     * @param array $params
     *
     * @return array
     */
    protected function params(array $params)
    {
        $params['merchId'] = $this->merchant->merchant_id;

        $params = array_filter($params);

        $params['sign'] = self::generate_sign($params, $this->merchant->sign_key, $this->merchant->sign_type);

        return $params;
    }

    /**
     * @param ResponseInterface $response
     *
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\StreamInterface
     * @throws \ChannelBank\Core\Exceptions\FaultException
     */
    protected function parseResponse($response)
    {

        if ($response instanceof ResponseInterface) {
            $response = $response->getBody();
        }

        return new Collection((array) \GuzzleHttp\json_decode($response->__toString(), true));
    }

    public static function generate_sign(array $attributes, $key, $encryptMethod = 'MD5')
    {
        ksort($attributes);
        $attributes['key'] = $key;

        $str = urldecode(http_build_query($attributes));

        return strtolower(call_user_func_array($encryptMethod, [$str]));
    }
}
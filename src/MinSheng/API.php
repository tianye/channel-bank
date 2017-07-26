<?php

namespace ChannelBank\MinSheng;

use ChannelBank\Core\Exceptions\FaultException;
use Psr\Http\Message\ResponseInterface;
use ChannelBank\Core\AbstractAPI;
use ChannelBank\Support\Collection;

/**
 * https://www.zhongmaopay.com/merchantWeb/login
 *
 * Class API
 *
 * @package ChannelBank\PuDong
 */
class API extends AbstractAPI
{
    /**
     * Merchant instance.
     *
     * @var Merchant
     */
    protected $merchant;

    //api https://www.zhongmaopay.com/payment-gate-web/gateway/api/backTransReq
    #const API_PAY_ORDER = 'https://test.zhongmaopay.com/payment-gate-web/gateway/api/backTransReq';
    const API_PAY_ORDER = 'https://www.zhongmaopay.com/payment-gate-web/gateway/api/backTransReq';

    const VERSION = 'V1.0';

    /**
     * API constructor.
     *
     * @param \ChannelBank\MinSheng\Merchant $merchant
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

        var_dump($params);
        $options = array_merge([
            'form_params' => $params,
        ], $options);

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
        $params['signature'] = $this->generateSignature($params);

        ksort($params);

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

        parse_str($response, $parr);

        if (isset($parr['signature'])) {
            $parr['signature'] = str_replace(' ', '+', $parr['signature']);
            $response          = new Collection($parr);
            $valid             = $this->isValid($response);
        } else {
            $response = new Collection($parr);
            $valid    = true;
        }

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

        $localSign = $this->generateSignature($response->except('signature')->all());

        return $localSign === $response->get('signature');
    }

    public function generateSignature(array $attributes)
    {

        $data = $this->sinParamsToString($attributes);

        //读取私钥文件
        //注意所放文件路径
        $priKey = $this->merchant->pri_key;

        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);

        //调用openssl内置签名方法，生成签名$signature
        openssl_sign($data, $signature, $res);

        //释放资源
        openssl_free_key($res);

        return base64_encode($signature);
    }

    //public static function

    /**
     * @param $params
     *
     * @return bool|string
     */
    public function sinParamsToString($params)
    {
        $signature_str = '';
        // 排序
        ksort($params);
        foreach ($params as $key => $val) {
            if ($key == 'signature') {
                continue;
            }
            $signature_str .= sprintf("%s=%s&", $key, $val);
        }

        return substr($signature_str, 0, strlen($signature_str) - 1);
    }

}
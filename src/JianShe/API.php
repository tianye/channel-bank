<?php

namespace ChannelBank\JianShe;

use Psr\Http\Message\ResponseInterface;
use ChannelBank\Core\AbstractAPI;
use ChannelBank\Support\Collection;

class API extends AbstractAPI
{
    /**
     * Merchant instance.
     *
     * @var Merchant $merchant
     */
    protected $merchant;

    // 支付相关
    const JSPT_PAY_URL   = "http://test.ezf123.com/jspt/payment/frontTransReq.action";  // 测试环境地址，正式投产时需使用清算平台统一分配的地址
    const JSPT_QUERY_URL = "http://test.ezf123.com/jspt_query/payment/back-order-query.action"; // 测试环境地址，正式投产时需使用清算平台统一分配的地址

    const BACK_MOBIL_EPAY = "http://test.ezf123.com/jspt/payment/back-mobilepay.action";

    // 退款相关
    const REFUND_PAY_URL   = "http://test.ezf123.com/jspt/payment/order-refund.action"; // 测试环境地址，正式投产时需使用清算平台统一分配的地址
    const REFUND_QUERY_URL = "http://test.ezf123.com/jspt_query/payment/back-refund-query.action";  // 测试环境地址，正式投产时需使用清算平台统一分配的地址

    //后台类交易地址
    const BACKTRANS_URL = "http://test.ezf123.com/jspt/payment/backTransReq.action";

    //对账单下载相关
    const BILL_DOWNLOAD_URL = "http://test.ezf123.com/jspt/download/fileDownloadReq.action";    // 测试环境地址，正式投产时需使用清算平台统一分配的地址

    /**
     * API constructor.
     *
     * @param \ChannelBank\JianShe\Merchant $merchant
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
        return $this->request(self::JSPT_PAY_URL, $order->all());
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
     * @return \ChannelBank\Support\Collection|\Psr\Http\Message\ResponseInterface|array
     */
    protected function request($api, array $params, $method = 'post', array $options = [], $returnResponse = false)
    {
        $params = $this->params($params);

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
        $params['sign'] = self::generate_sign($params, $this->merchant->sign_key, $this->merchant->sign_method);

        return $params;
    }

    /**
     * @param  ResponseInterface|bool $response
     *
     * @return array|ResponseInterface|string
     */
    protected function parseResponse($response)
    {
        $subject = $response->getBody()->__toString();

        return $subject;
    }

    /**
     * @param \ChannelBank\Support\Collection $response
     *
     * @return bool
     */
    protected function isValid(Collection $response)
    {
        $localSign = self::generate_sign($response->except('sign')->all(), $this->merchant->sign_key, 'MD5');

        return $localSign === $response->get('sign');
    }

    /**
     * @param $xml
     * @param $sign
     *
     * @return bool
     */
    protected function isXmlValid($xml, $sign)
    {
        $localSign = self::generate_xml_sign($xml, $this->merchant->sign_key, 'MD5');

        return $localSign === $sign;
    }

    public static function generate_sign(array $attributes, $key, $encryptMethod = 'MD5')
    {
        ksort($attributes);

        $str = urldecode(http_build_query($attributes)) . '&' . $encryptMethod($key);

        return strtolower(call_user_func_array($encryptMethod, [$str]));
    }

    public static function generate_xml_sign($xml, $key, $encryptMethod = 'MD5')
    {
        $str = $xml . '&' . $encryptMethod($key);

        return strtolower(call_user_func_array($encryptMethod, [$str]));
    }

}
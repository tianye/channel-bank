<?php
require '../../vendor/autoload.php';

use ChannelBank\Core\Exceptions\FaultException;
use ChannelBank\Foundation\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class Notice
{

    static $app;

    public function __construct()
    {
        $options = [
            'debug' => true,
            'log'   => [
                'level' => 'debug',
                'file'  => '/tmp/ChannelBank.log',
            ],

            'spdb_payment' => [
                'in_scd'      => '10134001',
                'mch_nt_id'   => '100000000000203',
                'terminal_id' => 'tywx0001',
                'sign_key'    => 'zsdfyreuoyamdphhaweyrjbvzkgfdycs',
            ],
        ];

        self::$app = new Application($options);

        $request = Request::createFromGlobals();

        \ChannelBank\Support\Log::info('notice', [
                'request'    => $request->request->all(),
                'query'      => $request->query->all(),
                'getContent' => $request->getContent(),
            ]
        );

        try {
            $response = self::$app->spdb_payment->handleNotify(function (\ChannelBank\Support\Collection $notify, $successful) {

                //返回值信息  var_dump($notify->all());
                if ($successful) {
                    //TODO 支付成功

                } else {
                    //TODO 非支付成功消息

                    return '操作失败';
                }

                return true; // 处理成功
            });
        } catch (FaultException $e) {
            $response = [
                'return_code' => 'FAIL',
                'return_msg'  => '签名验证失败',
            ];
            $response = new Response(\GuzzleHttp\json_encode($response, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));

            $response->send();
        }
        $response->send(); // Laravel 里请使用：return $response;
    }

}

$Application = new Notice();


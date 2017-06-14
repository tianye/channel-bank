<?php

namespace ChannelBank\Core;

use ChannelBank\Core\Exceptions\HttpException;
use ChannelBank\Support\Collection;
use ChannelBank\Support\Log;
use GuzzleHttp\Middleware;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractAPI.
 */
abstract class AbstractAPI
{
    /**
     * Http instance.
     *
     * @var \ChannelBank\Core\Http
     */
    protected $http;

    const GET  = 'get';
    const POST = 'post';
    const JSON = 'json';

    static $guzzle_log = [];

    /**
     * AbstractAPI constructor.
     */
    public function __construct()
    {
    }

    /**
     * Return the http instance.
     *
     * @return \ChannelBank\Core\Http
     */
    public function getHttp()
    {
        if (is_null($this->http)) {
            $this->http = new Http();
        }

        if (count($this->http->getMiddlewares()) === 0) {
            $this->registerHttpMiddlewares();
        }

        return $this->http;
    }

    /**
     * Set the http instance.
     *
     * @param \ChannelBank\Core\Http $http
     *
     * @return $this
     */
    public function setHttp(Http $http)
    {
        $this->http = $http;

        return $this;
    }

    /**
     * Parse JSON from response and check error.
     *
     * @param string $method
     * @param array  $args
     *
     * @return \ChannelBank\Support\Collection
     */
    public function parseJSON($method, array $args)
    {
        $http = $this->getHttp();

        $contents = $http->parseJSON(call_user_func_array([$http, $method], $args));

        $this->checkAndThrow($contents);

        return new Collection($contents);
    }

    /**
     * Register Guzzle middlewares.
     */
    protected function registerHttpMiddlewares()
    {
        $uniqid = uniqid();
        // log
        $this->http->addMiddleware($this->logMiddleware($uniqid));
        $this->http->addMiddleware($this->logMiddlewareResponse($uniqid));
    }

    /**
     * Log the request.
     *
     * @return \Closure
     */
    protected function logMiddleware($uniqid)
    {
        return Middleware::tap(function (RequestInterface $request, $options) use ($uniqid) {
            self::$guzzle_log['request'] = ['method' => $request->getMethod(), 'url' => $request->getUri()->__toString(), 'options' => json_encode($options), 'body' => strval($request->getBody()), 'headers' => json_encode($request->getHeaders())];

            return $request;
        });
    }

    protected function logMiddlewareResponse($uniqid)
    {
        return Middleware::mapResponse(function (ResponseInterface $response) use ($uniqid) {
            self::$guzzle_log['response'] = ['code' => $response->getStatusCode(), 'body' => $response->getBody()->__toString(), 'headers' => json_encode($response->getHeaders())];

            Log::debug('Channel-Bank', self::$guzzle_log);

            return $response;
        });
    }

    /**
     * Check the array data errors, and Throw exception when the contents contains error.
     *
     * @param array $contents
     *
     * @throws \ChannelBank\Core\Exceptions\HttpException
     */
    protected function checkAndThrow(array $contents)
    {
        if (isset($contents['errcode']) && 0 !== $contents['errcode']) {
            if (empty($contents['errmsg'])) {
                $contents['errmsg'] = 'Unknown';
            }

            throw new HttpException($contents['errmsg'], $contents['errcode']);
        }
    }
}

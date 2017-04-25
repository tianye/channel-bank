<?php

/**
 * Generate a signature.
 *
 * @param array  $attributes
 * @param string $key
 * @param string $encryptMethod
 *
 * @return string
 */
if (!function_exists('generate_sign')) {
    function generate_sign(array $attributes, $key, $encryptMethod = 'SHA256')
    {

        ksort($attributes);

        $str = urldecode(http_build_query($attributes)) . $key;

        return strtolower(call_user_func_array($encryptMethod, [$str]));
    }
}

if (!function_exists('SHA256')) {
    function SHA256($str)
    {
        $re = hash('sha256', $str, true);

        return bin2hex($re);
    }
}

/**
 * Get client ip.
 *
 * @return string
 */
if (!function_exists('get_client_ip')) {
    function get_client_ip()
    {
        if (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            // for php-cli(phpunit etc.)
            $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }
}

/**
 * Get current server ip.
 *
 * @return string
 */
if (!function_exists('get_server_ip')) {
    function get_server_ip()
    {
        if (!empty($_SERVER['SERVER_ADDR'])) {
            $ip = $_SERVER['SERVER_ADDR'];
        } elseif (!empty($_SERVER['SERVER_NAME'])) {
            $ip = gethostbyname($_SERVER['SERVER_NAME']);
        } else {
            // for php-cli(phpunit etc.)
            $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }
}

if (!function_exists('build_order_num')) {
    /**
     * 生成订单号.
     *
     * @return int
     */
    function build_order_num()
    {
        list($time1, $time2) = explode('.', microtime());
        unset($time1);
        list($millisecond, $second) = explode(' ', $time2);
        $orderNum = $second . $millisecond . (function_exists('random_int') ? random_int(1000, 9999) : rand(1000, 9999));

        return $orderNum;
    }
}

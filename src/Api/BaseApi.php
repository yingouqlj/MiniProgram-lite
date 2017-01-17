<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午5:13
 */

namespace King\Core\MiniProgram\Api;


use Common\Utility\CurlRequest;
use Exception;
use King\Core\MiniProgram\Config;

class BaseApi
{
    const NEED_ACCESS_TOKEN = false;
    protected $appId = 'wx54a602a6b305f559';
    protected $secret = '3b6f96fb471a5883d8a9c4c0e040130d';
    protected $access_token;
    const CURL_RAW = false;

    public function __construct(Config $config)
    {
        $this->appId = $config->appId;
        $this->secret = $config->secret;
        return $this;
    }

    public function setAccessToken($token)
    {
        $this->access_token = $token;
    }

    protected function query($url, $params, $method = 'get')
    {
        $curl=false;
        // $startTime = self::microTimeFloat();
        switch ($method) {
            case 'get':
                $curl = CurlRequest::instance($url . '?' . http_build_query($params))
                    ->exec();
                break;
            case 'post':

                $curl = CurlRequest::instance($url)
                    ->setOption(CURLOPT_POST, 1)
                    ->setHeader('Content-Type', 'application/json; charset=utf-8')
                    ->setPostField(
                      json_encode($params)
                    )->setHeader('Content-Length', strlen(json_encode($params)))
                    ->ignoreSSL()
                    ->exec();
                break;

        }
        if (!$curl[0]) {
            throw new Exception('none');
        }
        if(static::CURL_RAW==true){
            return $curl[0];
        }
        try {
            $obj = json_decode($curl[0]);
            return $obj;
        } catch (\Exception $e) {
           throw $e;
        }
    }

    private static function microTimeFloat()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }


}
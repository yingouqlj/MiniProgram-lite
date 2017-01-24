<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午5:13
 */

namespace Yingou\MiniProgram\Api;

use Exception;
use Yingou\MiniProgram\Config;
use Yingou\MiniProgram\CurlRequest;

class BaseApi
{
    const NEED_ACCESS_TOKEN = false;
    protected $appId;
    protected $secret ;
    protected $accessToken;
    const CURL_RAW = false;

    public function __construct(Config $config)
    {
        $this->appId = $config->appId;
        $this->secret = $config->secret;
        return $this;
    }

    public function setAccessToken($token)
    {
        $this->accessToken = $token;
    }

    protected function query($url, $params, $method = 'get')
    {
        $curl=false;
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

    public function jsonToSelf(){

    }


}
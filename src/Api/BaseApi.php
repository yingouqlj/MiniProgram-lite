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
    const API = '';
    /**
     * NEED_ACCESS_TOKEN 是否需要 accessToken，如果为true，会掉接口获取
     */
    const NEED_ACCESS_TOKEN = false;
    protected $appId;
    protected $secret;
    protected $accessToken;
    /**
     * 如果为true 直接返回curl结果
     */
    const CURL_RAW = false;
    /**
     * 返回结果映射，如果返回的字段看着别扭，定义下mapping
     */
    const RESULT_MAPPING = [
    ];

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
        $curl = false;
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
        if (static::CURL_RAW == true) {
            return $curl[0];
        }
        try {
            $obj = json_decode($curl[0]);
            return $obj;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * @param $params
     * @return static
     */
    protected function get($params)
    {
        $url = static::API . '?' . http_build_query($params);
        $curl = CurlRequest::instance($url)
            ->exec();
        return $this->buildResponse($curl);
    }

    protected function buildResponse($curl)
    {
        if (static::CURL_RAW == true) {
            return $curl[0];
        }
        try {
            return $this->jsonToSelf($curl[0]);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    protected function jsonToSelf($json)
    {
        $obj = json_decode($json);
        $mapping = static::RESULT_MAPPING;
        foreach ($obj as $k => $v) {
            if (isset($mapping[$k])) {
                $name = $mapping[$k];
            } else {
                $name = $this->toCamel($k);
            }
            $this->$name = $v;
        }
        return $this;
    }

    protected function toCamel($string)
    {
        return preg_replace_callback(
            "/(_([a-z]))/",
            function ($match) {
                return strtoupper($match[2]);
            },
            $string
        );
    }


}
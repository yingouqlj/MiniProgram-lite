<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午5:15
 */

namespace Yingou\MiniProgram\Api;

class JsCodeToSession extends BaseApi
{
    const API = 'https://api.weixin.qq.com/sns/jscode2session';
    protected $grant_type = 'authorization_code';
    protected $js_code;
    public $openid;
    public $session_key;


    /**
     * @param $code
     * @return $this
     */
    public function getToken($code)
    {
        $this->js_code = $code;
        $params = [
            'appid' => $this->appId,
            'secret' => $this->secret,
            'js_code' => $this->js_code,
            'grant_type' => $this->grant_type,
        ];
        return $this->post($params);
    }


}
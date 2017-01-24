<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午5:15
 */

namespace Yingou\MiniProgram\Api;


class AccessToken extends BaseApi
{
    const API = 'https://api.weixin.qq.com/cgi-bin/token';
    protected $grant_type = 'client_credential';

    public $accessToken;
    public $expiresIn;

    public function getToken()
    {
        $params = [
            'grant_type' => $this->grant_type,
            'appid' => $this->appId,
            'secret' => $this->secret,
        ];
        $result = $this->query(self::API, $params);
        foreach ($result as $k => $v) {
            $this->$k = $v;
        }
        return $this;
    }

}
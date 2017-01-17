<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午5:15
 */

namespace King\Core\MiniProgram\Api;


class CreateQrCode extends BaseApi
{
    const API = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode';
    const NEED_ACCESS_TOKEN = true;
    protected $grant_type = 'client_credential';
    const CURL_RAW = true;

    public $expires_in;

    /**
     * @param $path
     * @param $width
     * @return resource
     */
    public function create($path, $width=480)
    {
        $params = [
            'path' => $path,
            'width' => $width,
        ];
        return $this->query(self::API.'?access_token='.$this->access_token, $params,'post');

    }


}
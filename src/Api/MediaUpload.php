<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午5:15
 */

namespace Yingou\MiniProgram\Api;


class MediaUpload extends BaseApi
{
    const API = 'https://api.weixin.qq.com/cgi-bin/media/upload';
    const NEED_ACCESS_TOKEN = true;


    public function uploadByForm($form)
    {
        $params = [
            'access_token' => $this->access_token,
            'type' => '',
        ];
// todo:Form
    }


}
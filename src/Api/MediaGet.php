<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午5:15
 */

namespace Yingou\MiniProgram\Api;


class MediaGet extends BaseApi
{
    const API = 'https://api.weixin.qq.com/cgi-bin/media/get';
    const NEED_ACCESS_TOKEN = true;


    public function getMedia($mediaId)
    {
        $params = [
            'access_token' => $this->access_token,
            'media_id' => $mediaId,
        ];
        $result = $this->query(self::API, $params);

        return $result;
    }


}
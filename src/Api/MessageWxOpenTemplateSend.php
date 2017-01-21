<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午5:15
 */

namespace Yingou\MiniProgram\Api;


class MessageWxOpenTemplateSend extends BaseApi
{
    const API = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send';
    const NEED_ACCESS_TOKEN = true;
    protected $toUser;
    protected $templateId;
    protected $page;
    protected $formId;
    protected $postData;
    protected $emphasisKeyword;


    public function sendTo($openId)
    {
        $this->toUser = $openId;
        return $this;
    }


}
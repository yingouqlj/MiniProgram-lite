<?php
namespace Yingou\MiniProgram;

use Yingou\MiniProgram\Api\AccessToken;
use Yingou\MiniProgram\Api\BaseApi;
use Yingou\MiniProgram\Api\CreateQrCode;
use Yingou\MiniProgram\Api\JsCodeToSession;
use Yingou\MiniProgram\Api\MessageCustomSend;
use Yingou\MiniProgram\Api\MessageWxOpenTemplateSend;

/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/13
 * Time: 下午4:08
 * @property AccessToken $access_token
 * @property CreateQrCode $create_qr_code
 * @property JsCodeToSession $js_code_to_session
 * @property MessageCustomSend $message_custom_send
 * @property MessageWxOpenTemplateSend message_wx_open_template_send
 */
class MiniProgram
{

    protected $apiClass = [
        AccessToken::class,
        JsCodeToSession::class,
        CreateQrCode::class,
    ];
    protected $className;
    protected $class;
    protected $config;

    public function __construct($config = null)
    {
        if ($config == null) {
            $config = new Config();
        }
        if (is_array($config)) {
            $this->config = new Config($config);

        }
        if ($config instanceof Config) {
            $this->config = $config;
        }

        if (empty($this->config)) {
            //thow
            return false;
        }
        $this->initApi();
        return $this;
    }


    protected function initApi()
    {

        $class = [];
        foreach ($this->apiClass as $api) {
            $name = explode('\\', $api);
            $className = strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', "_$1", array_pop($name)));
            $class[$className] = $api;
        }
        $this->className = $class;

    }

    public function __get($name)
    {
        if (isset($this->className[$name])) {
            if (!isset($this->class[$name])) {

                $new = new $this->className[$name]($this->config);
                /* @var $new BaseApi */
                if ($new::NEED_ACCESS_TOKEN == true) {
                    $new->setAccessToken($this->getToken());
                }
                $this->class[$name] = $new;
            }
            return $this->class[$name];
        } else {
            //exception
            return false;
        }
    }

    protected function getToken()
    {
        if (empty($this->config->getAccessToken())) {
            $token = $this->access_token->getToken();
            $this->config->setAccessToken($token->access_token, $token->expires_in);
        }
        return $this->config->getAccessToken();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 17/1/17
 * Time: 下午1:49
 */

namespace King\Core\MiniProgram;


use King\Core\CoreFactory;

class Config
{
    public $appId;
    public $secret;
    public $access_token;
    const ACCESS_TOKEN_REDIS_KEY = 'wx_access_token';

    public function __construct($config = null)
    {

        if ($config == null) {
            $config = CoreFactory::instance()->packageConfig('miniProgram');
        }
        if (isset($config['appId'])) {
            $this->appId = $config['appId'];
        }
        if (isset($config['secret'])) {
            $this->secret = $config['secret'];
        }
    }

    public function getAccessToken()
    {
        if (!$this->redis()->exists(self::ACCESS_TOKEN_REDIS_KEY)) {
            return null;
        }
        return $this->redis()->get(self::ACCESS_TOKEN_REDIS_KEY);
    }

    public function setAccessToken($token, $expires = 0)
    {
        $this->redis()->setex(self::ACCESS_TOKEN_REDIS_KEY, $expires, $token);
        return true;
    }

    protected function redis()
    {
        return CoreFactory::instance()->redis();
    }

}
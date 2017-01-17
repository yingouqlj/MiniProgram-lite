<?php namespace Yingou\MiniProgram;


/**
 * 本想换成Guzzle，线用curl吧（少个依赖包
 * 原作者mc，king项目移出来的
 * Created by JetBrains PhpStorm.
 * @author mcfog wang
 * Date: 12-11-13
 */
class CurlRequest
{
    protected $url = '';
    protected $headers = [];
    protected $options = [
        CURLOPT_TIMEOUT => 30,
    ];

    protected function __construct()
    {
    }

    public static function instance($url = null)
    {
        $instance = new self;
        if (null !== $url) {
            $instance->setUrl($url);
        }
        return $instance;
    }

    public function setPostField($data)
    {
        return $this->setOption(CURLOPT_POSTFIELDS, $data);
    }

    public function setOption($name, $value)
    {
        if (in_array($name, array(CURLOPT_RETURNTRANSFER, CURLOPT_HTTPHEADER, CURLOPT_URL))) {
            throw new \Exception('cannot set these option');
        }
        $this->options[$name] = $value;
        return $this;
    }

    public function setOptionArray(array $arr)
    {
        foreach ($arr as $name => $value) {
            $this->setOption($name, $value);
        }
        return $this;
    }

    public function setHeader($name, $value)
    {
        //防注入
        $name = str_replace(array("\r", "\n"), '', $name);
        $value = str_replace(array("\r", "\n"), '', $value);

        $this->headers[$name] = $value;
        return $this;
    }

    public function setHeaderArray(array $arr)
    {
        foreach ($arr as $name => $value) {
            $this->setHeader($name, $value);
        }
        return $this;
    }

    public function getOptionArray()
    {
        $options = $this->options;
        $headers = array();
        foreach ($this->headers as $name => $value) {
            $headers[] = "$name: $value";
        }
        $options[CURLOPT_HTTPHEADER] = $headers;
        $options[CURLOPT_RETURNTRANSFER] = true;
        $options[CURLOPT_URL] = $this->url;
        return $options;
    }

    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    public function ignoreSSL()
    {
        return $this->setOption(CURLOPT_SSL_VERIFYPEER, false)
            ->setOption(CURLOPT_SSL_VERIFYHOST, false);
    }

    public function setMethod($method)
    {
        return $this->setOption(CURLOPT_CUSTOMREQUEST, strtoupper($method));
    }

    public function exec()//直接访问
    {
        $ch = curl_init();
        curl_setopt_array($ch, $this->getOptionArray());
        $result = curl_exec($ch);
        $info = curl_getinfo($ch);
        return [$result, $info];
    }
}

# miniProgram-lite
微信小程序php后端接口轻量版


####初衷：
好用的微信SDK一大堆，已经没有自己写了。  
但是好用的SDK大而全，依赖也大。对于业务很小的应用着实有点浪费。  
当时业务需求，顺势做小程序，但是实际后端的接口用量很小，所以打算用到的接口自己包一下。  
再然后，就打算拆出来分享出来。  


####基本使用:

```php
<?php

use Yingou\MiniProgram\MiniProgram;
$config=[
    'appId' => 'wx54a602a6b305f559',
    'secret' => '3b6f96fb471a5883d8a9c4c0e040130d'
    ];
$program=new MiniProgram($config);
//创建Qrcode
$program->create_qr_code->create('/page?id=1',120);

```


####建议用法:
增加个配置继承Config  
在里面实现 token 的读写覆盖原有方法  

```php
<?php

class ProgramConfig extends \Yingou\MiniProgram\Config{
    public function getAccessToken()
    {
        //覆盖掉原来的方法在这里 读取token
    }
     public function setAccessToken($token, $expires = 0)
     {
          //覆盖写入 如 redis      
     }   
}

use Yingou\MiniProgram\MiniProgram;
$program=new MiniProgram(new ProgramConfig());
$program->create_qr_code->create('/page?id=1',120);

```


####进度
先立项，慢慢完善。后面也会考虑引入其他依赖包。第一版是轻巧。
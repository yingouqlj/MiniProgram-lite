<?php
/**
 * Created by PhpStorm.
 * User: yingouqlj
 * Date: 2019/7/2
 * Time: 2:01 AM
 */

namespace Yingou\MiniProgram;

class EncryptedData
{

    public static function decryptData($encryptedData, $iv, $sessionKey)
    {
        if (strlen($sessionKey) != 24) {
            throw new MiniProgramException('wrong session key', -41001);
        }
        if (strlen($iv) != 24) {
            throw new MiniProgramException('wrong iv', -41002);
        }
        $aesKey = base64_decode($sessionKey);
        $aesIV = base64_decode($iv);
        $aesCipher = base64_decode($encryptedData);
        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        return json_decode($result, true);
    }
}

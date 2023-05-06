<?php
class Rsa{

    /**
     * 签名算法，SHA256WithRSA
     */

    const SIGNATURE_ALGORITHM = OPENSSL_ALGO_SHA256;

    /**
     * RSA最大加密明文大小
     */
    const MAX_ENCRYPT_BLOCK = 117;

    /**
     * RSA最大解密密文大小
     */
    const MAX_DECRYPT_BLOCK = 256;

    /**
     * 使用公钥将数据加密
     * @param $data string 需要加密的数据
     * @param $publicKey string 公钥
     * @return string 返回加密串(base64编码)
     */
    public static function publicEncrypt($data,$publicKey){
        $data = str_split($data, self::MAX_ENCRYPT_BLOCK);

        $encrypted = '';
        foreach($data as & $chunk){
            if(!openssl_public_encrypt($chunk, $encryptData, $publicKey)){
                return '';
            }else{
                $encrypted .= $encryptData;
            }
        }
        return self::urlSafeBase64encode($encrypted);
    }

    /**
     * 使用私钥解密
     * @param $data string 需要解密的数据
     * @param $privateKey string 私钥
     * @return string 返回解密串
     */
    public static function privateDecrypt($data,$privateKey){
        $data = str_split(self::urlSafeBase64decode($data), self::MAX_DECRYPT_BLOCK);

        $decrypted = '';
        foreach($data as & $chunk){
            if(!openssl_private_decrypt($chunk, $decryptData, $privateKey)){
                return '';
            }else{
                $decrypted .= $decryptData;
            }
        }
        return $decrypted;
    }

    /**
     * 使用私钥将数据加密
     * @param $data string 需要加密的数据
     * @param $privateKey string 私钥
     * @return string 返回加密串(base64编码)
     */
    public static function privateEncrypt($data,$privateKey){
        $data = str_split($data, self::MAX_ENCRYPT_BLOCK);

        $encrypted = '';
        foreach($data as & $chunk){
            if(!openssl_private_encrypt($chunk, $encryptData, $privateKey)){
                return '';
            }else{
                $encrypted .= $encryptData;
            }
        }
        return self::urlSafeBase64encode($encrypted);
    }


    /**
     * 使用公钥解密
     * @param $data string 需要解密的数据
     * @param $publicKey string 公钥
     * @return string 返回解密串
     */
    public static function publicDecrypt($data,$publicKey){
        $data = str_split(self::urlSafeBase64decode($data), self::MAX_DECRYPT_BLOCK);

        $decrypted = '';
        foreach($data as & $chunk){
            if(!openssl_public_decrypt($chunk, $decryptData, $publicKey)){
                return '';
            }else{
                $decrypted .= $decryptData;
            }
        }
        return $decrypted;
    }


    /**
     * 私钥加签名
     * @param $data 被加签数据
     * @param $privateKey 私钥
     * @return mixed|string
     */
    public static function rsaSign($data, $privateKey){
        if(openssl_sign($data, $sign, $privateKey, self::SIGNATURE_ALGORITHM)){
            return self::urlSafeBase64encode($sign);
        }
        return '';
    }

    /**
     * 公钥验签
     * @param $data 被加签数据
     * @param $sign 签名
     * @param $publicKey 公钥
     * @return bool
     */
    public static function verifySign($data, $sign, $publicKey){
        return (1 == openssl_verify($data, self::urlSafeBase64decode($sign), $publicKey, self::SIGNATURE_ALGORITHM));
    }

    /**
     * url base64编码
     * @param $string
     * @return mixed|string
     */
    public static function urlSafeBase64encode($string,$replace = false){
        if($replace){
            $data = str_replace(array('+','/','='), array( '-','_',''), base64_encode($string));
        }else{
            $data = base64_encode($string);
        }
        return $data;
    }

    /**
     * url base64解码
     * @param $string
     * @return bool|string
     */
    public static function urlSafeBase64decode($string,$replace = false){
        if($replace){
            $data = str_replace(array('-','_'), array('+','/'), $string);
            $mod4 = strlen($data) % 4;
            if($mod4){
                $data .= substr('====', $mod4);
            }
        }else{
            $data = $string;
        }
        return base64_decode($data);
    }
}


?>
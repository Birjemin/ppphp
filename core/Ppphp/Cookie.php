<?php

namespace Ppphp;

/**
 * Class Cookie
 * @package Ppphp
 */
class Cookie
{
    const SECRETKEY = 'jonson';//混淆字符串

    /**
     * 获取cookie
     * @param $name
     *
     * @return string
     */
    public static function get($name)
    {
        return ($name == '' || empty($_COOKIE[$name])) ? '' : self::decrypt($_COOKIE[$name]);
    }

    /**
     * 删除cookie
     * @param $name
     *
     * @return bool
     */
    public static function drop($name)
    {
        return ($name == '' || empty($_COOKIE[$name])) ? true : self::set($name, '', '-10');
    }

    /**
     * 设置cookie
     * @param string $name    必需。规定 cookie 的名称。
     * @param string $value    必需。规定 cookie 的值。
     * @param int $expire    可选。规定 cookie 的有效期。
     * @param string $path    可选。规定 cookie 的服务器路径。
     * @param string $domain    可选。规定 cookie 的域名。
     * @param bool $secure    可选。规定是否通过安全的 HTTPS 连接来传输 cookie。
     * @return mixed
     */
    public static function set($name, $value = null, $expire = 3600, $path = '/', $domain = '', $secure = false)
    {
        if ($name == '' || $value == '') return false;
        return setcookie($name, self::encrypt($value), time() + $expire, $path, $domain, $secure);
    }

    /**
     * 字符串加密
     */
    private static function encrypt($string)
    {
        return self::calCrypt(base64_encode($string));
    }


    /**
     * 字符串解密
     */
    private static function decrypt($string)
    {
        return base64_decode(self::calCrypt($string));
    }

    /**
     * @param $string
     *
     * @return string
     */
    private static function calCrypt($string)
    {
        $code   = '';
        $key    = substr(md5(self::SECRETKEY), 8, 18);
        $strLen = strlen($string);
        $keyLen = strlen($key);
        for ($i = 0; $i < $strLen; $i++) {
            $k    = $i % $keyLen;
            $code .= $string[$i] ^ $key[$k];
        }
        return $code;
    }
}
<?php
/**
 * session 操作类
 * @author 张森  2013-08-27
 */

namespace Ppphp;

/**
 * Class Session
 * @package Ppphp
 */
class Session
{

    /**
     * @param $sessionName
     * @param $value
     *
     * @return mixed
     */
    function set($sessionName, $value)
    {
        return $_SESSION[$sessionName] = $value;
    }

    /**
     * 根据sessionName获取session值
     *
     * @param string $sessionName
     *
     * @return string session的值如果没有此session，返回空。
     */
    function get($sessionName)
    {
        return isset($_SESSION[$sessionName]) ? $_SESSION[$sessionName] : '';
    }

    /**
     * 删除一个session
     *
     * @param string $sessionName
     * @return bool
     */
    function del($sessionName)
    {
        if (!isset($sessionName)) {
            return false;
        }
        unset($_SESSION[$sessionName]);
        return true;
    }

    /**
     *
     */
    function clear()
    {
        isset($_SESSION) && session_unset();
    }
}
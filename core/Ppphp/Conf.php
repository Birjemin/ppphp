<?php
/* ========================================================================
 * 加载系统配置类,可以防止重复引入文件
 * ======================================================================== */
namespace Ppphp;

class Conf
{
    /**
     * 用来存储已经加载的配置
     *
     * @var array
     */
    public static $conf = [];
    
    /**
     * 加载系统配置,如果之前已经加载过,那么就直接返回
     * @param string $name 配置名
     * @param string $file 文件名
     * @return mixed
     */
    public static function get($name, $file = 'conf')
    {
        if (isset(self::$conf[$file][$name])) return self::$conf[$file][$name];
        self::$conf[$file] = self::includeFile($file);
        return isset(self::$conf[$file][$name]) ? self::$conf[$file][$name] : false;
    }

    /**
     * 加载系统配置文件(直接加载整个配置文件),如果之前已经加载过,那么就直接返回
     * @param string $file 文件名
     * @return mixed
     */
    public static function all($file)
    {
        if (isset(self::$conf[$file])) return self::$conf[$file];
        return self::includeFile($file);
    }

    /**
     * @param $file
     *
     * @return bool|mixed
     */
    private static function includeFile($file)
    {
        $conf = self::getConfigFile($file);
        // file is not exist
        if (!is_file($conf)) return false;
        // 这个用法有趣，加载该文件的变量
        return include $conf;
    }

    /**
     * @param $file
     *
     * @return string
     */
    private static function getConfigFile($file)
    {
        return PPPHP . '/config/' . $file . '.php';
    }
}
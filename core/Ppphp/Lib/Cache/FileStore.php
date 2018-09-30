<?php

namespace Ppphp\Lib\Cache;

/**
 * Class FileStore
 * @package Ppphp\Lib\Cache
 */
class FileStore implements CacheInterface
{
    /** @var string $path 存储路径 */
    private $path;

    /**
     * file constructor.
     *
     * @param $option
     */
    public function __construct($option)
    {
        array_walk($option, function($value, $key) {
            $this->$key = $value;
        });
    }

    /**
     * @return null
     */
    public function getInstance()
    {
        return null;
    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function get($name)
    {
        $pathName = $this->getPathName($name);
        if (!is_file($pathName)) return false;
        $ret      = json_decode(file_get_contents($pathName), true);
        return ($ret['time'] == 0 || $ret['time'] >= TIME) ? $ret['data'] : false;
    }

    /**
     * @param $name
     * @param $value
     * @param bool $time
     *
     * @return bool|int|mixed
     */
    public function set($name, $value, $time = false)
    {
        if (!is_dir($this->path)) mkdir($this->path, 0755, true);
        // put content
        return file_put_contents($this->getPathName($name), json_encode([
            'data' => $value,
            'time' => $this->calTime($time),
        ]));
    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function del($name)
    {
        $file = $this->getPathName($name);
        return is_file($file) ? unlink($file) :false;
    }

    /**
     * @return mixed|void
     */
    public function clear()
    {
        $dh = opendir($this->path);
        while ($file = readdir($dh)) {
            if ($file != "." && $file != "..") {
                $fullPath = $this->path . "/" . $file;
                (!is_dir($fullPath)) ? unlink($fullPath) : rmdir($fullPath);
            }
        }
    }

    /**
     * get path's name
     * @param $name
     *
     * @return string
     */
    private function getPathName($name)
    {
        return $this->path . '/' . $name . self::CACHE_SUFFIX;
    }


    /**
     * calculate time
     * @param $time
     *
     * @return int|mixed
     */
    private function calTime($time)
    {
        if ($time === 0) return 0;
        return TIME + ($time === false ? self::DEFAULT_TIME : $time);
    }
}
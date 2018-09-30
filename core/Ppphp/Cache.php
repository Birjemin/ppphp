<?php
/* ========================================================================
 * 缓存类
 * ======================================================================== */
namespace Ppphp;


use Ppphp\Lib\Cache\CacheInterface;

/**
 * Class Cache
 * @package Ppphp
 */
class Cache
{
    /** @var CacheInterface $class */
    private $class;

    /**
     * cache constructor.
     */
    public function __construct()
    {
        $option      = Conf::get('OPTION', 'cache');
        $class       = '\\Ppphp\\Lib\\Cache\\' . Conf::get('CACHE_TYPE', 'cache');
        $this->class = new $class($option);
    }

    /**
     * @return CacheInterface
     */
    public function getInstance()
    {
        return $this->class;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this->class->get($name);
    }

    /**
     * @param $name
     * @param $value
     * @param bool $time
     *
     * @return mixed
     */
    public function set($name, $value, $time = false)
    {
        return $this->class->set($name,$value,$time);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function del($name)
    {
        return $this->class->del($name);
    }

    /**
     * @return mixed
     */
    public function clear()
    {
        return $this->class->clear();
    }
}
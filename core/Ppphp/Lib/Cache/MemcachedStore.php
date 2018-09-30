<?php
namespace Ppphp\Lib\Cache;

/**
 * Class MemcachedStore
 * @package Ppphp\Lib\Cache
 */
class MemcachedStore implements CacheInterface
{
    /** @var \Memcached $mem */
    private $mem;

    /**
     * MemcachedStore constructor.
     *
     * @param $option
     */
    public function __construct($option)
    {
        $this->mem = new \Memcached();
        $this->mem->setOption(\Memcached::OPT_COMPRESSION, false); //关闭压缩功能
        $this->mem->setOption(\Memcached::OPT_BINARY_PROTOCOL, true);//使用binary二进制协议
        $ret = $this->mem->addServers($option['servers']);
        (!$ret)  && \ppphp\log::alert($this->mem->getResultMessage());
    }

    /**
     * @return \Memcached
     */
    public function getInstance()
    {
        return $this->mem;
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this->mem->get($name);
    }

    /**
     * @param $name
     * @param $value
     * @param null $time
     *
     * @return bool|mixed
     */
    public function set($name, $value, $time = null)
    {
        return $this->mem->set($name, $value, $time ? $time : self::DEFAULT_TIME);
    }

    /**
     * @param $name
     *
     * @return bool|mixed
     */
    public function del($name)
    {
        return $this->mem->delete($name);
    }

    /**
     * @return bool|mixed
     */
    public function clear()
    {
        return $this->mem->flush();
    }
}

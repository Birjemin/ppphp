<?php
/**
 * Created by PhpStorm.
 * User: birjemin
 * Date: 29/09/2018
 * Time: 23:58
 */

namespace Ppphp\Lib\Cache;


/**
 * Interface CacheInterface
 * @package ppphp\lib\cache
 */
interface CacheInterface
{
    /** @var string cache后缀 */
    const CACHE_SUFFIX = '.ppcache';

    /** @var int $time 默认存活时间s */
    const DEFAULT_TIME = 3600;

    /**
     * @return mixed
     */
    public function getInstance();

    /**
     * @param $name
     *
     * @return mixed
     */
    public function get($name);

    /**
     * @param $name
     * @param $value
     * @param bool $time
     *
     * @return mixed
     */
    public function set($name, $value, $time = false);

    /**
     * @param $name
     *
     * @return mixed
     */
    public function del($name);

    /**
     * @return mixed
     */
    public function clear();
}
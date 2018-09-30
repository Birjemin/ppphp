<?php
/* ========================================================================
 * 路由类
 * 主要功能,解析URL
 * ======================================================================== */

namespace Ppphp;

class Route
{
    /**
     * @var string $ctrl
     */
    public $ctrl;
    /**
     * @var string $action
     */
    public $action;

    public $path;

    public $route;

    /**
     * route constructor.
     */
    public function __construct()
    {
        $this->route = conf::all('route');
        $this->setCtrl();
        $this->setUrlVar();
    }

    /**
     * @return bool
     */
    private function setCtrl()
    {
        $this->ctrl   = $this->route['DEFAULT_CTRL'];
        $this->action = $this->route['DEFAULT_ACTION'];

        if (!isset($_SERVER['REQUEST_URI'])) return true;

        $path = explode('/', trim(parse_url($_SERVER['REQUEST_URI'])['path'], '/'));
        if (empty($path[0])) return true;

        $this->ctrl = $path[0];
        unset($path[0]);
        //检测是否包含路由缩写
        if (isset($this->route['ROUTE'][$this->ctrl])) {
            list($this->ctrl, $this->action) = $this->route['ROUTE'][$this->ctrl];
        } elseif (isset($path[1]) && $path[1]) {
            $this->action = $path[1];
            unset($path[1]);
        }
        $this->path = array_values($path);
        return true;
    }

    /**
     * 把url上面的参数追加到$_GET中
     * set url params
     */
    private function setUrlVar()
    {
        $i      = 0;
        $length = count($this->path);
        while ($i < $length) {
            isset($this->path[$i + 1]) && $_GET[$this->path[$i]] = $this->path[$i + 1];
            $i += 2;
        }
    }
}
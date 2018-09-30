<?php

/* ========================================================================
 * ppphp核心类
 * 实现以下几个功能
 * 类自动加载
 * 启动框架
 * 引入模型
 * 引入视图
 * ======================================================================== */

class Ppphp
{
    /**
     * model用于存放已经加载的model模型,下次加载时直接返回
     */
    public $model;
    /**
     * 视图赋值
     */
    public $assign;


    /**
     * 自动加载类
     *
     * @param string $class 需要加载的类,需要带上命名空间
     */
    public static function load($class)
    {
        $class = str_replace('\\', '/', trim(ucfirst($class), '\\'));
        if (is_file(CORE . $class . '.php')) {
            include_once CORE . $class . '.php';
        } else {
            if (is_file(PPPHP . '/' . $class . '.php')) {
                include_once PPPHP . '/' . $class . '.php';
            }
        }
    }

    /**
     * 框架启动方法,完成了两件事情
     * 1.加载route解析当前URL
     * 2.找到对应的控制以及方法,并运行
     */
    public static function run()
    {
        self::init();
        $request = new \Ppphp\Route();

        $ctrlClass = '\\' . MODULE . '\ctrl\\' . $request->ctrl . 'Ctrl';
        $action    = $request->action;
        $ctrlFile  = APP . 'ctrl/' . $request->ctrl . 'Ctrl.php';

        if (is_file($ctrlFile)) {
            include $ctrlFile;
        } else {
            if (DEBUG) {
                throw new Exception($ctrlClass . '是一个不存在的控制器');
            } else {
                show404();
            }
        }
        // 走路由
        $ctrl = new $ctrlClass();

        if (method_exists($ctrl, $action)) {
            $ctrl->$action();
        } else {
            if (DEBUG) {
                throw new Exception($ctrlClass . '是一个不存在的方法');
            } else {
                show404();
            }
        }

    }

    protected static function init()
    {
        //环境配置
        \Ppphp\Env::init();
        //日志
        \Ppphp\Log::init();
        // model
        \Ppphp\Model::init();
    }

}
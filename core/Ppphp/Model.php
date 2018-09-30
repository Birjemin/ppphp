<?php
/* ========================================================================
 * 模型基类,当前继承于medoo
 * 主要用于连接数据库,并封装了四个常用操作
 * ======================================================================== */

namespace Ppphp;

use think\Db;

/**
 * Class Model
 * @package Ppphp
 */
class Model extends Db
{
    protected $db;

    /**
     *
     */
    public static function init()
    {
        Db::setConfig(Conf::all("database"));
    }
}
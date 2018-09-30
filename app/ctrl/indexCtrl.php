<?php
/**
 * 示例控制器
 */

namespace App\Ctrl;


use Ppphp\Conf;
use Ppphp\Log;
use Ppphp\View;
use think\Db;

class indexCtrl extends \Ppphp
{
    use View;

    public function index()
    {
        $this->display('index/index.html');
    }

    public function log()
    {
        $log = conf::all('route');
        log::error("error", $log);
    }

    public function getDb()
    {
        $ret = Db::query("show databases");

        dump([$_GET]);
    }
}

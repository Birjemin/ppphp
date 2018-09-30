<?php
/* ========================================================================
 * env 系统环境类
 * ======================================================================== */

namespace Ppphp;


use Dotenv\Dotenv;

/**
 * Class Env
 * @package Ppphp
 */
class Env
{
    public static function init()
    {
        $dotenv = new Dotenv(PPPHP);
        $dotenv->load();
    }
}
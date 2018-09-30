<?php
/* ========================================================================
 * 全局函数
 * ======================================================================== */
/**
 * 更漂亮的数组或变量的展现方式
 */
function p($var)
{
    if (is_cli()) {
        if (is_array($var) || is_object($var)) {
            dump($var);
        } else {
            echo PHP_EOL;
            echo "\e[31m" . $var . "\e[37m" . PHP_EOL;
            echo PHP_EOL;
        }
    } else {
        if (is_bool($var)) {
            var_dump($var);
        } else if (is_null($var)) {
            var_dump(null);
        } else {
            echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>" . print_r($var, true) . "</pre>";
        }
    }
}

function debug(...$var)
{
    if (function_exists('dump')) {
        array_walk($var, function($v) {
            dump($v);
        });
    } else {
        array_walk($var, function($v) {
            print_r($v);
        });
    }
    exit();
}

function is_cli()
{
    return PHP_SAPI == 'cli';
}

/**
 * 获取get数据
 *
 * @param string $key    变量名
 * @param string $filter 过滤方式 int为只支持int类型
 * @param mixed $default 默认值 当获取不到值时,所返回的默认值
 *
 * @return mixed
 */
function get($key = '', $filter = '', $default = null)
{
    return getRequstParams($_GET, $key, $filter, $default);
}

/**
 * 获取post数据
 *
 * @param string $key    变量名
 * @param string $filter 过滤方式 int为只支持int类型
 * @param mixed $default 默认值 当获取不到值时,所返回的默认值
 *
 * @return mixed
 */
function post($key = '', $filter = '', $default = null)
{
    return getRequstParams($_POST, $key, $filter, $default);
}

/**
 * @param $params
 * @param $key
 * @param $filter
 * @param $default
 *
 * @return null|string
 */
function getRequstParams($params, $key, $filter, $default)
{
    if (empty($key)) {
        return $params;
    }
    $return = isset($params[$key]) ? $params[$key] : null;
    if (!$return) {
        return $default;
    }
    switch ($filter) {
        case 'int':
            if (!is_numeric($return)) {
                return $default;
            }
            break;
        default:
            $return = htmlspecialchars($return);
    }
    return $return;
}

function redirect($str)
{
    header('Location:' . $str);
}

function http_method()
{
    if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
        return 'POST';
    } else {
        return 'GET';
    }
}

function json($array)
{
    header('Content-Type:application/json; charset=utf-8');
    echo json_encode($array);
}

function show404()
{
    header('HTTP/1.1 404 Not Found');
    header("status: 404 Not Found");
    exit();
}
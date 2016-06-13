<?php

// 自动加载
function getFilePath($data)
{
    $data = (array) $data;
    $data = array_map(function($d) {
        return strtolower($d);
    }, $data);
    $file = implode(DIRECTORY_SEPARATOR, $data) . EXT;
    return $file;
}

function autoload($className)
{
    if (false===strpos($className, NS_SEPARATOR)) {
        $file = getFilePath([CORE_DIR, $className]);
    }
    else {
        $list = explode(NS_SEPARATOR, $className);
        if (count($list)==1) {
            array_unshift($list, CORE_DIR);
        }
        $file = getFilePath($list);
    }

    if (file_exists($file)) {
        require_once($file);
    }
}

spl_autoload_register('autoload');

// 环境初始化
define('ROOT', __DIR__);
define('NS_SEPARATOR', '\\');
define('CORE_DIR', 'core');
define('MODEL_DIR', 'model');
define('CONTROLLER_DIR', 'controller');
define('VIEW_DIR', 'view');
define('RESPONSE_DIR', 'response');
define('EXT', '.php');
define('DEFAULT_RESPONSE_TYPE', 'html');

// 路由
\Request::exec($_SERVER['REQUEST_URI'])->response();


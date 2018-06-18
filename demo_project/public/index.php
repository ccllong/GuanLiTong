<?php
// [ 应用入口文件 ]

// 定义应用目录
define('APP_PATH', __DIR__ . '/../application/');

//自定义用于辨别测试环境的常量
if(is_file('test_environment.md')){
    define('FLYME_ENV','test');
}else{
    define('FLYME_ENV','');
}

// 加载框架引导文件
require __DIR__ . '/../thinkphp/start.php';
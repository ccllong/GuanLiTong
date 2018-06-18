<?php
namespace app\index\controller;

use think\Controller;

class Base extends Controller
{
    public function _initialize()
    {
    }

    public function _result($code, $msg = '', $data = '', $url = '')
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'data' => $data,
            'url'  => $url,
        ];
        die(json_encode($result));
    }
}
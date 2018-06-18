<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 过滤xss攻击
 */
if (!function_exists('remove_xss')) {
    function remove_xss($val)
    {
        // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
        // this prevents some character re-spacing such as <java\0script>
        // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
        $val = preg_replace('/([\x00-\x08\x0b-\x0c\x0e-\x19])/', '', $val);

        // straight replacements, the user should never need these since they're normal characters
        // this prevents like <IMG SRC=@avascript:alert('XSS')>
        $search = 'abcdefghijklmnopqrstuvwxyz';
        $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $search .= '1234567890!@#$%^&*()';
        $search .= '~`";:?+/={}[]-_|\'\\';
        for ($i = 0; $i < strlen($search); $i++) {
            // ;? matches the ;, which is optional
            // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars

            // @ @ search for the hex values
            $val = preg_replace('/(&#[xX]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
            // @ @ 0{0,7} matches '0' zero to seven times
            $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
        }

        // now the only remaining whitespace attacks are \t, \n, and \r
        //$ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
        $ra1 = array(
            'javascript',
            'vbscript',
            'expression',
            'applet',
            'xml',
            'blink',
            'link',
            //'style',
            'script',
            //'embed',
            'object',
            'iframe',
            'frame',
            'frameset',
            'ilayer',
            'layer',
            'bgsound',
            //'title',
            'base',
            'marquee',
            'prompt',
            'alert',
        );//去掉了meta标签防止跟公司的metal系列相同而误处理
        $ra2 = array(
            'onabort',
            'onactivate',
            'onafterprint',
            'onafterupdate',
            'onbeforeactivate',
            'onbeforecopy',
            'onbeforecut',
            'onbeforedeactivate',
            'onbeforeeditfocus',
            'onbeforepaste',
            'onbeforeprint',
            'onbeforeunload',
            'onbeforeupdate',
            'onblur',
            'onbounce',
            'oncellchange',
            'onchange',
            'onclick',
            'oncontextmenu',
            'oncontrolselect',
            'oncopy',
            'oncut',
            'ondataavailable',
            'ondatasetchanged',
            'ondatasetcomplete',
            'ondblclick',
            'ondeactivate',
            'ondrag',
            'ondragend',
            'ondragenter',
            'ondragleave',
            'ondragover',
            'ondragstart',
            'ondrop',
            'onerror',
            'onerrorupdate',
            'onfilterchange',
            'onfinish',
            'onfocus',
            'onfocusin',
            'onfocusout',
            'onhelp',
            'onkeydown',
            'onkeypress',
            'onkeyup',
            'onlayoutcomplete',
            'onload',
            'onlosecapture',
            'onmousedown',
            'onmouseenter',
            'onmouseleave',
            'onmousemove',
            'onmouseout',
            'onmouseover',
            'onmouseup',
            'onmousewheel',
            'onmove',
            'onmoveend',
            'onmovestart',
            'onpaste',
            'onpropertychange',
            'onreadystatechange',
            'onreset',
            'onresize',
            'onresizeend',
            'onresizestart',
            'onrowenter',
            'onrowexit',
            'onrowsdelete',
            'onrowsinserted',
            'onscroll',
            'onselect',
            'onselectionchange',
            'onselectstart',
            'onstart',
            'onstop',
            'onsubmit',
            'onunload',
        );
        $ra  = array_merge($ra1, $ra2);

        $found = true; // keep replacing as long as the previous round replaced something
        while ($found == true) {
            $val_before = $val;
            for ($i = 0; $i < sizeof($ra); $i++) {
                $pattern = '/';
                for ($j = 0; $j < strlen($ra[$i]); $j++) {
                    if ($j > 0) {
                        $pattern .= '(';
                        $pattern .= '(&#[xX]0{0,8}([9ab]);)';
                        $pattern .= '|';
                        $pattern .= '|(&#0{0,8}([9|10|13]);)';
                        $pattern .= ')*';
                    }
                    $pattern .= $ra[$i][$j];
                }
                $pattern .= '/i';
                $replacement = substr($ra[$i], 0, 2).'<x>'.substr($ra[$i], 2); // add in <> to nerf the tag
                $val         = preg_replace($pattern, $replacement, $val); // filter out the hex tags
                if ($val_before == $val) {
                    // no replacements were made, so exit the loop
                    $found = false;
                }
            }
        }

        return $val;
    }
}

/**
 * 用指定元素指定字段作为（替换或新增）key
 */
if (!function_exists('arrayChangeKey')) {
    function arrayLevel($arr)
    {
        $al = array(0);
        if (!function_exists('aL')) {
            function aL($arr, &$al, $level = 0)
            {
                if (is_array($arr)) {
                    $level++;
                    $al[] = $level;
                    foreach ($arr as $v) {
                        aL($v, $al, $level);
                    }
                }
            }
        }
        aL($arr, $al);

        return max($al);
    }

    /**
     * 用指定元素指定字段作为（替换或新增）key
     * 例：
     * $old_ary = [['a'=>1,'b'=>2],['a'=>3,'b'=>4]];
     * 1.只换key
     * $new_ary = arrayChangeKey($old_ary,'a');  Rs: [1=>['a'=>1,'b'=>2],3=>['a'=>3,'b'=>4]]
     * 2.换key同时只留一个字段,即第三参数用字符串传
     * $new_ary = arrayChangeKey($old_ary,'a','b');  Rs: [1=>2,3=>4]
     * 3.换key同时保留多个字段,即第三参数要用数组传
     * $new_ary = arrayChangeKey($old_ary,'a',['a','b']);  Rs: [1=>['a'=>1,'b'=>2],3=>['a'=>3,'b'=>4]]
     *
     * @param $arr
     * @param $key
     * @param mixed $fields 要保留在返回里的单字段或多字段数组
     * @return array
     */
    function arrayChangeKey($arr, $key, $fields = '')
    {
        $processedArr = array();
        if (is_array($arr) && !empty($arr)) {
            if (!empty($fields)) {
                foreach ($arr as $item) {
                    if (isset($processedArr[$item[$key]])) {
                        if (arrayLevel($processedArr[$item[$key]]) == 1) {
                            if (!is_array($fields)) {
                                $processedArr[$item[$key]] = array($processedArr[$item[$key]], $item[$fields]);
                            } else {
                                $tmp = array();
                                foreach ($fields as $v) {
                                    $tmp[$v] = $item[$v];
                                }
                                $processedArr[$item[$key]] = array($processedArr[$item[$key]], $tmp);
                            }
                        } else {
                            if (!is_array($fields)) {
                                $processedArr[$item[$key]] = $item[$fields];
                            } else {
                                $tmp = array();
                                foreach ($fields as $v) {
                                    $tmp[$v] = $item[$v];
                                }
                                $processedArr[$item[$key]][] = $tmp;
                            }
                        }

                    } else {
                        if (!is_array($fields)) {
                            $processedArr[$item[$key]] = $item[$fields];
                        } else {
                            foreach ($fields as $v) {
                                $processedArr[$item[$key]][$v] = $item[$v];
                            }
                        }
                    }

                }
            } else {
                foreach ($arr as $item) {
                    if (isset($processedArr[$item[$key]])) {
                        if (arrayLevel($processedArr[$item[$key]]) == 1) {
                            $processedArr[$item[$key]] = array($processedArr[$item[$key]], $item);
                        } else {
                            $processedArr[$item[$key]][] = $item;
                        }
                    } else {
                        $processedArr[$item[$key]] = $item;
                    }
                }
            }
        }

        return $processedArr;
    }
}

/**
 * 返回一定位数的时间戳，多少位由参数决定
 * @param bool $digits 多少位的时间戳
 * @return 时间戳
 */
if (!function_exists('getTimestamp')) {
    function getTimestamp($digits = false)
    {
        $digits = $digits > 10 ? $digits : 10;
        $digits = $digits - 10;
        if ((!$digits) || ($digits == 10)) {
            return time();
        } else {
            return number_format(microtime(true), $digits, '', '');
        }
    }
}

/**
 * @param $timestamp  时间戳，10位长度则直接转，13位长度则先截取前10位再转
 * @param string $format 要转成的时间格式
 * @return bool|string  时间日期
 */
if (!function_exists('getDateFromTimestamp')) {
    function getDateFromTimestamp($timestamp,$format='Y-m-d H:i:s')
    {
        if(strlen($timestamp)<10){
            return false;
        }
        if(strlen($timestamp)==10){
            return date($format,$timestamp);
        }
        if(strlen($timestamp)==13){
            $timestamp = substr($timestamp,0,10);
            return date($format,$timestamp);
        }
        return false;
    }
}

/**
 * @param $url 请求链接
 * @param null $data 数据 array() string
 * @param string $type 请求类型 POST GET PUT DELETE,默认GET
 * @param string $headers 头部信息,为数组
 * @param string $data_type 返回数据类型 可选为encode,decode,空
 * @return mixed
 */
if (!function_exists('curlContents')) {
    function curlContents($url, $data = null, $headers = [], $type = 'GET', $data_type = '')
    {
        $ch = curl_init();

        //本地开发环境方便用Fiddler抓取
        if (defined('FLYME_ENV') && FLYME_ENV=='dev') {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');//设置代理服务器
        }

        //判断ssl连接方式
        if (stripos($url, 'https://') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        }

        $connttime = 1100; //连接等待时间500毫秒,改成1100是为了饶过centos下的libcurl的一个小于1000毫秒就返回time out的坑
        $timeout   = 10000;//超时时间10秒

        $querystring = "";
        if (is_array($data)) {
            // Change data in to postable data
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    foreach ($val as $val2) {
                        $querystring .= urlencode($key).'='.urlencode($val2).'&';
                    }
                } else {
                    $querystring .= urlencode($key).'='.urlencode($val).'&';
                }
            }
            $querystring = substr($querystring, 0, -1);
        } else {
            $querystring = $data;
        }

        curl_setopt($ch, CURLOPT_URL, $url); //发贴地址

        //设置HEADER头部信息
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/json'));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//反馈信息
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); //http 1.1版本

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $connttime);//连接等待时间
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);//超时时间

        switch ($type) {
            case "GET" :
                curl_setopt($ch, CURLOPT_HTTPGET, true);
                break;
            case "POST":
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $querystring);
                break;
            case "PUT" :
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $querystring);
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $querystring);
                break;
        }
        $file_contents = curl_exec($ch);//获得返回值

        $status = curl_getinfo($ch);

        //查找调试时可以打出curl_errno($ch)，对应的码和错误信息在http://php.net/manual/zh/function.curl-errno.php

        curl_close($ch);

        if ($data_type == "encode") {
            return json_encode($file_contents);
        } elseif ($data_type == "decode") {
            return json_decode($file_contents,true);
        } else {
            return $file_contents;
        }
    }

    function curlUpload($url, $data = null, $headers = [], $data_type = '')
    {
        //当php大于等于5.5的用新的方式
        if(version_compare(phpversion(),'5.5.0') >= 0 && class_exists('CURLFile')){
            $files_data['file'] = new CURLFile(realpath($data['tmp_name']),$data['type'],$data['name']);
        }else{
            $files_data['file'] = '@'.realpath($data['tmp_name']).";type=".$data['type'].";filename=".$data['name'];//加@符号curl就会把它当成是文件上传处理
        }

        $ch = curl_init();

        //本地开发环境方便用Fiddler抓取
        if (defined('FLYME_ENV') && FLYME_ENV=='dev') {
            curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');//设置代理服务器
        }

        //判断ssl连接方式
        if (stripos($url, 'https://') !== false) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1);
        }

        $connttime = 1100; //连接等待时间500毫秒
        $timeout   = 10000;//超时时间10秒

        curl_setopt($ch, CURLOPT_URL, $url); //发贴地址

        //设置HEADER头部信息
        if (!empty($headers)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/json'));
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//反馈信息
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1); //http 1.1版本

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT_MS, $connttime);//连接等待时间
        curl_setopt($ch, CURLOPT_TIMEOUT_MS, $timeout);//超时时间

        //POST方式传
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $files_data);

        $file_contents = curl_exec($ch);//获得返回值

        $status = curl_getinfo($ch);

        curl_close($ch);

        if ($data_type == "encode") {
            return json_encode($file_contents);
        } elseif ($data_type == "decode") {
            return json_decode($file_contents,true);
        } else {
            return $file_contents;
        }
    }
}
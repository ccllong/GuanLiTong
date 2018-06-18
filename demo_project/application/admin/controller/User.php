<?php
namespace app\admin\controller;
use app\admin\model\User as userModel;
use think\Controller;

class User extends Controller
{
    public function login()
    {
        $useruri   = url('admin/User/loginFlyme', '', true, true);
        $login_url = config('LOGIN_URL').'?appuri=&sid=unionlogin&service='.config('LOGIN_SERVICE').'&useruri='.$useruri;
        return redirect($login_url);
    }

    public function loginFlyme()
    {
        $_islogin = cookie('_islogin','');
        $_uticket = cookie('_uticket','');
        $token    = '';
        $m        = new userModel();
        if ($_islogin && $_uticket) {
            $get_token_url = config('MEMBER_TOKEN_GET_URL').$_uticket;
            $result        = curlContents($get_token_url);
            $result_array  = json_decode($result, true);
            if (empty($result_array) || !is_array($result_array) || $result_array['code'] != 200 || empty($result_array['value'])) {
                $this->login();
            } else {
                $token = $result_array['value'];
            }
            if (empty($token)) {
                return response('token错误');
            }

            //解析token字段获得用户的信息,获取uid,username,email
            /* 例：
 array (size=21)
  'uid' => int 7679880
  'name' => string 'ffff30719520' (length=14)
  'name_sync' => string 'UID-7679880' (length=11)
  'nickname' => string 'ffff30719520' (length=14)
  'iconExsit' => boolean false
  'icon' => string 'http://image.res.meizu.com/image/uc/423ab7a3c1724a0aafaef7ff8a18f492z?t=946656000000' (length=84)
  'email' => string '1431325984@qq.com' (length=17)
  'flyme' => string 'l1431325984' (length=11)
  'phone' => string '' (length=0)
  'regdate' => int 1428996009
  'score' => int -1
  'user-agent' => string 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/57.0.2987.133 Safari/537.36' (length=109)
  'salt' => string '034325' (length=6)
  'last_login_ip' => int -1408135984
  'last_login_time' => int 1502266792
  'new_session' => boolean true
  'date' => float 1502347670504
  'isActiveEmail' => boolean true
  'areaCode' => string '0086' (length=4)
  'current_login_ip' => string '172.17.140.96' (length=13)
  'service' => string 'meizu_ie' (length=8)
             */
            $json_data = $m->praseToken($token);
            if (!$json_data || !isset($json_data['uid'])) {
                return response('token解析错误');
            }
            if (!isset($json_data['service']) || ($json_data['service'] != config('LOGIN_SERVICE'))) {
                //如果验证的service跟其他不一样，那么进行一次用户登录
                $this->login();
            }

            //判断用户是否有权限
            if (!$m->checkAllow($json_data['uid'])) {
                return response('你的账号无权限登陆！');
            }

            session('admin_auth',['uid'=>$json_data['uid'],'username'=>$json_data['name']]);

            return redirect('Index/index');

        } else {
            $this->login();
        }
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        session('admin_auth', null);
        session_regenerate_id(true);
        $_islogin = cookie('_islogin');
        $_uticket = cookie('_uticket');
        if ($_islogin && $_uticket) {
            $logoout_token_url = config('MEMBER_TOKEN_DESTRORY_URL').$_uticket;
            curlContents($logoout_token_url);
        }
        $app_url = url('/', '', true, true);
        $this->redirect(config('LOGOUT_URL').rawurlencode($app_url));
        exit();
    }
}
<?php
namespace app\admin\model;
use think\Model;
use Meizu\MzTokenLogin;
use app\admin\model\Admin as adminModel;

class User extends Model{

    protected function initialize()
    {
        parent::initialize();
    }

    //只在第一次初始化时执行
    protected static function init(){

    }

    /**
     * 反解Flyme登陆的token
     * @param $token
     * @return bool|mixed
     */
    public function praseToken($token)
    {
        $token = trim($token);
        if (empty($token)) {
            return false;
        }

        $token_login = new MzTokenLogin();
        //通过token解密 获取uid,username,email
        if (defined('FLYME_ENV')  && (FLYME_ENV=='test' || FLYME_ENV=='dev')) {
            $PUBLICKEY = str_replace('{n}', "\n", config('TEST_PUBLIC_KEY'));//有定义常量的时候表示是测试环境用不同的key
        }else{
            $PUBLICKEY = str_replace('{n}', "\n", config('PUBLIC_KEY'));
        }

        $loginjson = $token_login->decrypt_with_rsa_aes($token, $PUBLICKEY);

        return json_decode($loginjson, true);
    }

    /**
     * 根据flyme_uid检查是否有登录使用的权限
     * @param $flyme_uid
     * @return bool
     */
    public function checkAllow($flyme_uid){
        if(empty($flyme_uid)){
            return false;
        }
        $allow_flyme_uids = config('USER_ALLOW_FLYME');//超管

        //加入后台加入的管理员
        $admin_model = new adminModel();
        $allow_list_uid = $admin_model->getAllowUid();

        $allow_flyme_uids = !empty($allow_list_uid) ? array_merge($allow_flyme_uids,$allow_list_uid) : $allow_flyme_uids;

        if(!empty($allow_flyme_uids)){
            if(in_array($flyme_uid,$allow_flyme_uids)){
                return true;
            }else{
                return false;
            }
        }
        return true;
    }
}
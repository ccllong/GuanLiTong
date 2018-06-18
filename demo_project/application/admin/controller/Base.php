<?php
namespace app\admin\controller;

use app\admin\model\Common;
use think\Controller;

class Base extends Controller
{
    public $admin;

    public function _initialize()
    {
        //判断是否有登录
        $this->admin = $this->is_login();
        if (empty($this->admin)) {
            $this->redirect('user/login');
        }

        //define('MODULE_NAME',$this->request->module());
        $this->assign('user', $this->admin);
        $this->assign('controller_name', $this->request->controller());
        $this->assign('action_name', $this->request->action());
        $this->assign('current_url','');
    }

    private function is_login()
    {
        $user = session('admin_auth');
        if (empty($user)) {
            return false;
        } else {
            return $user;
        }
    }

    public function upload(){
        $file = input('file.');
        if(isset($file['images']) || isset($file['big_images']) || isset($file['mob_images'])){//图片
            $tmp = isset($file['images']) ? $file['images'] : (isset($file['big_images']) ? $file['big_images'] : $file['mob_images']);
            $info = $tmp->getInfo();
            if(!empty($info)){
                //检查大小,不超过2M
                if($info['size']>2097152){
                    die(json_encode(['msg'=>'上传的图片超出2M限制']));
                }

                $commonModel = new Common();
                $rs = $commonModel->upload_image_baas($info);
                if(!empty($rs)){
                    $this->success('上传成功','',$rs['url']);
                }else{
                    $this->error('上传失败');
                }
            }
        }elseif(isset($file['file'])){//文件
            $tmp = $file['file'];
            $info = $tmp->getInfo();
            if(!empty($info)){
                //检查大小,不超过2M
                if($info['size']>2097152){
                    die(json_encode(['msg'=>'上传的文件超出2M限制']));
                }

                $commonModel = new Common();
                $rs = $commonModel->upload_file_baas($info);
                if(!empty($rs)){
                    $this->success('上传成功','',$rs['url']);
                }else{
                    $this->error('上传失败');
                }
            }
        }
    }
}
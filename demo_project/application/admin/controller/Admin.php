<?php
namespace app\admin\controller;
use app\admin\model\Admin as adminModel;

class Admin extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign(
            'menu_ary',
            [
                '管理' => [
                    '管理员'  => url('Admin/index'),
                ],
            ]
        );
    }

    public function index()
    {
        $adminModel = new adminModel();
        $list = $adminModel->getList();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add(){
        if($this->request->isPost()){
            $data = $this->request->except('_id','post');
            if(empty($data['name'])){
                $this->error('名字不能为空！');
            }
            if(empty($data['flyme_uid'])){
                $this->error('Flyme UID 不能为空！');
            }
            $adminModel = new adminModel();
            $rs = $adminModel->add_post_baas('admin_user',$data);
            if(!empty($rs)){
                $this->success('添加成功！','Admin/index');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $this->assign('current_url',url('Admin/index'));
            return $this->fetch();
        }
    }

    public function edit(){
        if($this->request->isPost()){
            $data = input('post.');
            if(empty($data['_id'])){
                $this->error('非法请求！');
            }
            if(empty($data['name'])){
                $this->error('名字不能为空！');
            }
            if(empty($data['flyme_uid'])){
                $this->error('Flyme UID 不能为空！');
            }
            $adminModel = new adminModel();
            $rs = $adminModel->update_put_baas('admin_user/'.$data['_id'],$data);
            if(!empty($rs)){
                $this->success('编辑成功！','Admin/index');
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $id = input('param.id');
            if(empty($id)){
                $this->error('非法请求');
            }
            $adminModel = new adminModel();
            $item = $adminModel->get_baas('admin_user/'.$id);
            if(empty($item)){
                $this->error('不存在此数据');
            }
            $this->assign('item',$item);
            $this->assign('current_url',url('Admin/index'));
            return $this->fetch('add');
        }
    }

    public function del(){
        $id = input('param.id');
        if(empty($id)){
            $this->error('非法请求');
        }
        $adminModel = new adminModel();
        $item = $adminModel->get_baas('admin_user/'.$id);
        if(empty($item)){
            $this->error('不存在此数据');
        }
        $rs = $adminModel->delete_baas('admin_user/'.$id);
        if(!empty($rs)){
            $this->success('删除成功！','Admin/index');
        }else{
            $this->error('删除失败！');
        }
    }

}
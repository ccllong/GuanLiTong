<?php
namespace app\admin\controller;
use app\admin\model\Page as PageModel;
class Page extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign(
            'menu_ary',
            [
                '单页管理' => [
                    '单页列表' => url('Page/index'),
                ],
            ]
        );
    }

    public function index()
    {
        $page_model = new PageModel();
        $list = $page_model->getList();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add()
    {
        if ($this->request->isPost()) {
            $data = $this->request->except('_id','post');
            if(empty($data['title'])){
                $this->error('中文名称不能为空！');
            }
            if(empty($data['tag'])){
                $this->error('英文标识符不能为空！');
            }
            if(empty($data['content'])){
                $this->error('内容不能为空！');
            }
            $data['content'] = $_POST['content'];//重置为没有过滤前的富文本

            $page_model = new PageModel();

            //检查是否已经存在此相同tag
            $is_exist_item = $page_model->check_tag($data['tag']);
            if($is_exist_item){
                $this->error('已存在此英文标识符，请更改！');
            }

            $rs = $page_model->add_post_baas('page',$data);
            if(!empty($rs)){
                $this->success('添加成功！','Page/index');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $this->assign('current_url',url('Page/index'));
            return $this->fetch();
        }
    }

    public function edit()
    {
        if ($this->request->isPost()) {
            $data = input('post.');
            if(empty($data['title'])){
                $this->error('中文名称不能为空！');
            }
            if(empty($data['tag'])){
                $this->error('英文标识符不能为空！');
            }
            if(empty($data['content'])){
                $this->error('内容不能为空！');
            }
            $data['content'] = $_POST['content'];//重置为没有过滤前的富文本
            $page_model = new PageModel();
            $rs = $page_model->update_put_baas('page/'.$data['_id'],$data);
            if(!empty($rs)){
                $this->success('编辑成功！','Page/index');
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $id = input('param.id');
            if(empty($id)){
                $this->error('非法请求');
            }

            $page_model = new PageModel();
            $item = $page_model->get_baas('page/'.$id);
            if(empty($item)){
                $this->error('不存在此数据');
            }
            $this->assign('item',$item);
            $this->assign('current_url',url('Page/index'));
            return $this->fetch('add');
        }
    }

    public function del()
    {
        $id = input('param.id');
        if(empty($id)){
            $this->error('非法请求');
        }
        $page_model = new PageModel();
        $item = $page_model->get_baas('page/'.$id);
        if(empty($item)){
            $this->error('不存在此数据');
        }
        $rs = $page_model->delete_baas('page/'.$id);
        if(!empty($rs)){
            $this->success('删除成功！','page/index');
        }else{
            $this->error('删除失败！');
        }
    }
}
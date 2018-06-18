<?php
namespace app\admin\controller;

use app\admin\model\Admin;
use app\admin\model\Carousel;
use app\admin\model\Feature;
use app\admin\model\Nav;

class Index extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign(
            'menu_ary',
            [
                '首页管理' => [
                    '顶部导航栏'  => url('index/index'),
                    '底部导航栏'  => url('index/footerNav'),
                    '轮播管理'    => url('index/carousel'),
                    '推荐位'      => url('index/feature'),
                ],
            ]
        );
    }

    /**
     * 顶部导航管理
     */
    public function index()
    {
        //$admin = new Admin();
        //查
        //$rs = $admin->get_baas('admin_user?fileds=allows,_id',['MZ-Query-Count:true']);

        //删除
        //$rs = $admin->delete_baas('admin_user/598d253708af564b3651636d');
        //批量删除
        //$rs = $admin->delete_batch_baas('admin_user?objectIds=598d253708af564b3651636d,5991122908af564b36516381');

        //增
        //$rs = $admin->add_post_baas('admin_user',['allows'=>[1,5,3,6],'age'=>21]);

        //改
        //$rs = $admin->update_put_baas('admin_user/599105f408af564b36516380',['allows'=>[8888,3,6]]);
        //批量更新
        //$rs = $admin->update_batch_put_baas('admin_user',["where"=>'{"age":{$gte:20}}', "update"=>'{$set:{"allows":[7,8,9]}}']);

        //上传图片
        //$rs = $admin->upload_image_baas($_FILES['img']);

        //$rs = $admin->upload_files_baas($_FILES['img']);

        //print_rs($rs);

        //$this->assign('current_url',url('index/feature'));
        $nav_model = new Nav();
        $nav_list = $nav_model->getTopNavs();
        $this->assign('nav_list',$nav_list);
        return $this->fetch();
    }

    public function addNav(){
        if($this->request->isPost()){
            $data = $this->request->except('_id','post');
            if(empty($data['title'])){
                $this->error('名称不能为空！');
            }
            if(empty($data['url'])){
                $this->error('链接不能为空！');
            }
            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            $navModel = new Nav();
            $rs = $navModel->add_post_baas('nav',$data);
            if(!empty($rs)){
                $this->success('添加成功！','index/index');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $this->assign('current_url',url('index/index'));
            return $this->fetch();
        }
    }

    public function editNav(){
        if($this->request->isPost()){
            $data = input('post.');
            if(empty($data['_id'])){
                $this->error('非法请求！');
            }
            if(empty($data['title'])){
                $this->error('名称不能为空！');
            }
            if(empty($data['url'])){
                $this->error('链接不能为空！');
            }
            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            $navModel = new Nav();
            $rs = $navModel->update_put_baas('nav/'.$data['_id'],$data);
            if(!empty($rs)){
                $this->success('编辑成功！','index/index');
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $id = input('param.id');
            if(empty($id)){
                $this->error('非法请求');
            }
            $navModel = new Nav();
            $nav = $navModel->get_baas('nav/'.$id);
            if(empty($nav)){
                $this->error('不存在此数据');
            }
            $this->assign('nav',$nav);
            $this->assign('current_url',url('index/index'));
            return $this->fetch('addnav');
        }
    }

    public function delNav(){
        $id = input('param.id');
        if(empty($id)){
            $this->error('非法请求');
        }
        $navModel = new Nav();
        $nav = $navModel->get_baas('nav/'.$id);
        if(empty($nav)){
            $this->error('不存在此数据');
        }
        $rs = $navModel->delete_baas('nav/'.$id);
        if(!empty($rs)){
            $this->success('删除成功！','index/index');
        }else{
            $this->error('删除失败！');
        }
    }

    /**
     * 底部导航管理
     */
    public function footerNav(){
        $nav_model = new Nav();
        $nav_list = $nav_model->getBottomNavs();
        $this->assign('nav_list',$nav_list);
        $this->assign('nav_type','底部');
        return $this->fetch('index');
    }

    public function addFooterNav(){
        if($this->request->isPost()){
            $data = $this->request->except('_id','post');
            if(empty($data['title'])){
                $this->error('名称不能为空！');
            }
            if(empty($data['url'])){
                $this->error('链接不能为空！');
            }
            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            $navModel = new Nav();
            $rs = $navModel->add_post_baas('nav',$data);
            if(!empty($rs)){
                $this->success('添加成功！','index/footerNav');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $this->assign('current_url',url('index/footerNav'));
            return $this->fetch();
        }
    }

    public function editFooterNav(){
        if($this->request->isPost()){
            $data = input('post.');
            if(empty($data['_id'])){
                $this->error('非法请求！');
            }
            if(empty($data['title'])){
                $this->error('名称不能为空！');
            }
            if(empty($data['url'])){
                $this->error('链接不能为空！');
            }
            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            $navModel = new Nav();
            $rs = $navModel->update_put_baas('nav/'.$data['_id'],$data);
            if(!empty($rs)){
                $this->success('编辑成功！','index/footerNav');
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $id = input('param.id');
            if(empty($id)){
                $this->error('非法请求');
            }
            $navModel = new Nav();
            $nav = $navModel->get_baas('nav/'.$id);
            if(empty($nav)){
                $this->error('不存在此数据');
            }
            $this->assign('nav',$nav);
            $this->assign('current_url',url('index/footerNav'));
            return $this->fetch('addfooternav');
        }
    }

    public function delFooterNav(){
        $id = input('param.id');
        if(empty($id)){
            $this->error('非法请求');
        }
        $navModel = new Nav();
        $nav = $navModel->get_baas('nav/'.$id);
        if(empty($nav)){
            $this->error('不存在此数据');
        }
        $rs = $navModel->delete_baas('nav/'.$id);
        if(!empty($rs)){
            $this->success('删除成功！','index/footerNav');
        }else{
            $this->error('删除失败！');
        }
    }

    /**
     * 轮播管理
     */
    public function carousel(){
        $carousel_model = new Carousel();
        $list = $carousel_model->getList();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function addCarousel(){
        if($this->request->isPost()){
            $data = $this->request->except('_id','post');
            if(empty($data['title'])){
                $this->error('名称不能为空！');
            }
            if(empty($data['url'])){
                $this->error('链接不能为空！');
            }
            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            $carouselModel = new Carousel();
            $rs = $carouselModel->add_post_baas('feature',$data);
            if(!empty($rs)){
                $this->success('添加成功！','index/carousel');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $this->assign('current_url',url('index/carousel'));
            return $this->fetch();
        }
    }

    public function editCarousel(){
        if($this->request->isPost()){
            $data = input('post.');
            if(empty($data['_id'])){
                $this->error('非法请求！');
            }
            if(empty($data['title'])){
                $this->error('名称不能为空！');
            }
            if(empty($data['url'])){
                $this->error('链接不能为空！');
            }
            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            $carouselModel = new Carousel();
            $rs = $carouselModel->update_put_baas('feature/'.$data['_id'],$data);
            if(!empty($rs)){
                $this->success('编辑成功！','index/carousel');
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $id = input('param.id');
            if(empty($id)){
                $this->error('非法请求');
            }
            $carouselModel = new Carousel();
            $item = $carouselModel->get_baas('feature/'.$id);
            if(empty($item)){
                $this->error('不存在此数据');
            }
            $this->assign('item',$item);
            $this->assign('current_url',url('index/carousel'));
            return $this->fetch('addcarousel');
        }
    }

    public function delCarousel(){
        $id = input('param.id');
        if(empty($id)){
            $this->error('非法请求');
        }
        $carouselModel = new Carousel();
        $item = $carouselModel->get_baas('feature/'.$id);
        if(empty($item)){
            $this->error('不存在此数据');
        }
        $rs = $carouselModel->delete_baas('feature/'.$id);
        if(!empty($rs)){
            $this->success('删除成功！','index/carousel');
        }else{
            $this->error('删除失败！');
        }
    }

    /**
     * 推荐位管理
     */
    public function feature(){
        $feature_model = new Feature();
        $list = $feature_model->getList();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function addFeature(){
        if($this->request->isPost()){
            $data = $this->request->except('_id','post');
            if(empty($data['title'])){
                $this->error('名称不能为空！');
            }
            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            if(empty($data['url'])){
                $this->error('链接不能为空！');
            }
            $featureModel = new Feature();
            $rs = $featureModel->add_post_baas('feature',$data);
            if(!empty($rs)){
                $this->success('添加成功！','index/feature');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $this->assign('current_url',url('index/feature'));
            return $this->fetch();
        }
    }

    public function editFeature(){
        if($this->request->isPost()){
            $data = input('post.');
            if(empty($data['_id'])){
                $this->error('非法请求！');
            }
            if(empty($data['title'])){
                $this->error('名称不能为空！');
            }
            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            if(empty($data['url'])){
                $this->error('链接不能为空！');
            }
            $featureModel = new Feature();
            $rs = $featureModel->update_put_baas('feature/'.$data['_id'],$data);
            if(!empty($rs)){
                $this->success('编辑成功！','index/feature');
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $id = input('param.id');
            if(empty($id)){
                $this->error('非法请求');
            }
            $featureModel = new Feature();
            $item = $featureModel->get_baas('feature/'.$id);
            if(empty($item)){
                $this->error('不存在此数据');
            }
            $this->assign('item',$item);
            $this->assign('current_url',url('index/feature'));
            return $this->fetch('addfeature');
        }
    }

    public function delFeature(){
        $id = input('param.id');
        if(empty($id)){
            $this->error('非法请求');
        }
        $featureModel = new Feature();
        $item = $featureModel->get_baas('feature/'.$id);
        if(empty($item)){
            $this->error('不存在此数据');
        }
        $rs = $featureModel->delete_baas('feature/'.$id);
        if(!empty($rs)){
            $this->success('删除成功！','index/feature');
        }else{
            $this->error('删除失败！');
        }
    }


}
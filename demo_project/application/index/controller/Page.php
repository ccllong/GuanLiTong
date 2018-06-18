<?php
namespace app\index\controller;
use app\index\model\Page as PageModel;
class Page extends Base
{
    public function _initialize()
    {
    }

    public function index()
    {
        exit;
    }

    public function getPage(){
        $tag = input('tag','');

        if(empty($tag)){
            $this->_result(12000,'不存在数据!');
        }

        $model = new PageModel();

        $item = $model->getPageByTag($tag);

        empty($item) ? $this->_result(12000,'不存在此数据！','') : $this->_result(200,'',$item);
    }
}
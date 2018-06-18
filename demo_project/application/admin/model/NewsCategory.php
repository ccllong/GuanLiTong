<?php
namespace app\admin\model;

class NewsCategory extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList($field=''){
        $list = $this->get_baas('news_category?where={}&fields='.$field,['MZ-Query-Count:true','MZ-Query-MaxNum:100','MZ-Query-Order:sort:-1,createAt:-1']);
        return !empty($list) ? $list : false;
    }
}
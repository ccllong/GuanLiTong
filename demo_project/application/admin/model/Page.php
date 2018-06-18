<?php
namespace app\admin\model;

class Page extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList(){
        $list = $this->get_baas('page?where={}&fields=',['MZ-Query-Count:true','MZ-Query-Order:createAt:-1']);
        return !empty($list) ? $list : false;
    }

    public function check_tag($tag){
        $item = $this->get_baas('page?where={"tag":"'.$tag.'"}');
        return !empty($item) ? true : false;
    }
}
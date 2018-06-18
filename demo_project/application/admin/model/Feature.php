<?php
namespace app\admin\model;

class Feature extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList(){
        $list = $this->get_baas('feature?where={"type":"feature"}&fields=',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
        return !empty($list) ? $list : false;
    }
}
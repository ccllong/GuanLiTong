<?php
namespace app\admin\model;

class Carousel extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList(){
        $list = $this->get_baas('feature?where={"type":"carousel"}&fields=',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
        return !empty($list) ? $list : false;
    }
}
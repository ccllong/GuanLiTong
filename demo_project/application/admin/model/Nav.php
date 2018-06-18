<?php
namespace app\admin\model;

class Nav extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getTopNavs(){
        $list = $this->get_baas('nav?where={"type":"top"}&fields=',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
        return !empty($list) ? $list : false;
    }

    public function getBottomNavs(){
        $list = $this->get_baas('nav?where={"type":"bottom"}&fields=',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
        return !empty($list) ? $list : false;
    }
}
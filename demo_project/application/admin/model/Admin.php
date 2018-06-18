<?php
namespace app\admin\model;

class Admin extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList(){
        $list = $this->get_baas('admin_user?where={}&fields=',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
        return !empty($list) ? $list : false;
    }

    public function getAllowUid($status=0){
        $list = $this->get_baas('admin_user?where={"status":'.$status.'}&fields=flyme_uid',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
        if(!empty($list)){
            $list = array_values(arrayChangeKey($list,'flyme_uid','flyme_uid'));
            return $list;
        }
        return false;
    }
}
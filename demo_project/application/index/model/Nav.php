<?php
namespace app\index\model;

class Nav extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getTopNavs(){
        $list = $this->get_baas('nav?where={"status":0,"type":"top"}&fields=&ignoreFields=_id,accPer,status,type,sort',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
        if(!empty($list)){
            foreach($list as $k=>&$v){
                $v['createAt'] = getDateFromTimestamp($v['createAt']);
                $v['updateAt'] = getDateFromTimestamp($v['updateAt']);
            }
            return $list;
        }
        return false;
    }

    public function getBottomNavs(){
        $list = $this->get_baas('nav?where={"status":0,"type":"bottom"}&fields=&ignoreFields=_id,accPer,status,type,sort',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
        if(!empty($list)){
            foreach($list as $k=>&$v){
                $v['createAt'] = getDateFromTimestamp($v['createAt']);
                $v['updateAt'] = getDateFromTimestamp($v['updateAt']);
            }
            return $list;
        }
        return false;
    }
}
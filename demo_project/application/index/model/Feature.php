<?php
namespace app\index\model;

class Feature extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList(){
        $list = $this->get_baas('feature?where={"status":0,"type":"feature"}&fields=&ignoreFields=_id,accPer,status,type,sort',['MZ-Query-Count:true','MZ-Query-Order:sort:-1']);
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
<?php
namespace app\index\model;

class Page extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getPageByTag($tag){
        $item = $this->get_baas('page?where={"status":0,"tag":"'.$tag.'"}&fields=&ignoreFields=_id,accPer,status,tag',['MZ-Query-Count:true','MZ-Query-Order:createAt:-1']);
        if(!empty($item) && isset($item[0])){
            $item = $item[0];
            $item['createAt'] = getDateFromTimestamp($item['createAt']);
            $item['updateAt'] = getDateFromTimestamp($item['updateAt']);
            return $item;
        }
        return false;
    }
}
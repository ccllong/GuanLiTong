<?php
namespace app\index\model;

class NewsCategory extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList($field=''){
        $list = $this->get_baas('news_category?where={}&fields=&ignoreFields=accPer,status,type,sort,updateAt,createAt'.$field,['MZ-Query-Count:true','MZ-Query-MaxNum:100','MZ-Query-Order:sort:-1,createAt:-1']);
        if(!empty($list)){
            foreach($list as $k=>&$v){
                $v['cid'] = $v['_id'];
                unset($v['_id']);
                //$v['createAt'] = getDateFromTimestamp($v['createAt']);
                //$v['updateAt'] = getDateFromTimestamp($v['updateAt']);
            }
            return $list;
        }
        return false;
    }
}
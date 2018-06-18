<?php
namespace app\index\model;

class News extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList($cate_id = '')
    {
        $cate_str = '';
        if (!empty($cate_id)) {
            $cate_str = '"cate_id":"'.$cate_id.'"';
        }
        $list = $this->get_baas(
            'news?where={"status":0,'.$cate_str.'}&fields=&ignoreFields=accPer,status,type,sort,updateAt',
            ['MZ-Query-Count:true', 'MZ-Query-Order:sort:-1,createAt:-1'],
            true
        );

        if(!empty($list['data'])){
            foreach($list['data'] as $k=>&$v){
                $v['id'] = $v['_id'];
                $v['cid'] = $v['cate_id'];
                unset($v['_id'],$v['cate_id']);
                $v['createAt'] = getDateFromTimestamp($v['createAt']);
                //$v['updateAt'] = getDateFromTimestamp($v['updateAt']);
            }
            return ['data' => $list['data'], 'count'=>$list['count']];
        }
        return false;
    }
}
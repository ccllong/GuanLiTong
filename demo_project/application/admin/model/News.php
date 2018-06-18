<?php
namespace app\admin\model;

class News extends Common
{
    protected function initialize()
    {
        parent::initialize();
    }

    public function getList($page = 1, $cate_id = '', $page_size = 50)
    {
        $cate_str = $page_str = '';
        if (!empty($cate_id)) {
            $cate_str = '"cate_id":"'.$cate_id.'"';
        }
        $list = $this->get_baas(
            'news?where={'.$cate_str.'}&fields=',
            ['MZ-Query-Count:true', 'MZ-Query-MaxNum:'.$page_size, 'MZ-Query-NowPageNum:'.($page-1), 'MZ-Query-Order:sort:-1,createAt:-1'],
            true
        );

        if($list){
            $page_str = $this->getPage($page,$page_size,$list['count'],['cid'=>$cate_id],'News/index');
        }

        return ['data' => empty($list['data']) ? '' : $list['data'], 'page'=>$page_str];
    }
}
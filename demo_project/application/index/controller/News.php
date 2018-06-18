<?php
namespace app\index\controller;
use app\index\model\Common;
use app\index\model\News as NewsModel;
use app\index\model\NewsCategory;
class News extends Base
{
    public function _initialize()
    {
    }

    public function index()
    {
        exit;
    }

    /**
     * 获取分类列表
     */
    public function getCategorys(){
        $model = new NewsCategory();
        $list = $model->getList();
        $this->_result(200, '', $list);
    }

    /**
     * 获取新闻列表,按分类取，按排序倒序和时间倒序
     */
    public function getNewsList(){
        $cid = input('cid','');
        $model = new NewsModel();
        $list = $model->getList($cid);
        if(empty($list)){
            $this->_result(12000, '暂无数据', '');
        }
        $this->_result(200, $list['count'], $list['data']);
    }

    /**
     * 根据文章id获取文章内容
     */
    public function getContent(){
        $id = input('id','');
        if(empty($id)){
            $this->_result(12000,'非法请求！' , '');
        }
        $news_model = new NewsModel();
        $item = $news_model->get_baas('news?ignoreFields=accPer,status,type,sort&where={"status":0,"_id":"'.$id.'"}');
        if(empty($item)){
            $this->_result(12000,'不存在此文章数据！' , '');
        }else{
            $item = $item[0];
            $item['id'] = $item['_id'];
            $item['cid'] = $item['cate_id'];
            unset($item['_id'],$item['cate_id']);
            $item['createAt'] = getDateFromTimestamp($item['createAt']);
            $item['updateAt'] = getDateFromTimestamp($item['updateAt']);
            $this->_result(200, '', $item);
        }

    }

}
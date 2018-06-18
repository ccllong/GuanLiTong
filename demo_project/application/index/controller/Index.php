<?php
namespace app\index\controller;

use app\index\model\Carousel;
use app\index\model\Feature;
use app\index\model\Nav;

class Index extends Base
{
    public function index()
    {
        exit;
    }

    /**
     * 获取顶部和底部导航
     */
    public function getNavs()
    {
        $model = new Nav();

        $top_nav    = $model->getTopNavs();
        $bottom_nav = $model->getBottomNavs();

        $item = [
            'top'    => $top_nav,
            'bottom' => $bottom_nav,
        ];

        $this->_result(200, '', $item);
    }

    /**
     * 获取轮播和推荐位
     */
    public function getFeatures()
    {
        $feature_model  = new Feature();
        $carousel_model = new Carousel();

        $features  = $feature_model->getList();
        $carousels = $carousel_model->getList();

        $item = [
            'feature'  => $features,
            'carousel' => $carousels,
        ];

        $this->_result(200, '', $item);
    }
}

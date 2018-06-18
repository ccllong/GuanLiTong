<?php
namespace app\admin\controller;
use app\admin\model\Common;
use app\admin\model\News as NewsModel;
use app\admin\model\NewsCategory;
class News extends Base
{
    public function _initialize()
    {
        parent::_initialize();
        $this->assign(
            'menu_ary',
            [
                '资讯管理' => [
                    '新闻列表' => url('news/index'),
                    '分类列表' => url('news/category'),
                ],
            ]
        );
    }

    /**
     * 资讯管理
     */
    public function index()
    {
        $p = input('p',1);
        $page_size = 50;

        $category_model = new NewsCategory();
        $cate_list = $category_model->getList('_id,cate_name');
        $cate_list = !empty($cate_list) ? arrayChangeKey($cate_list,'_id','cate_name') : [];

        $news_model = new NewsModel();
        $news_list = $news_model->getList($p,'',$page_size);
        $this->assign('list',$news_list['data']);
        $this->assign('page',$news_list['page']);
        $this->assign('cate_list',$cate_list);
        return $this->fetch();
    }

    public function addNews()
    {
        if($this->request->isPost()){
            $data = $this->request->except('_id','post');
            if(empty($data['title'])){
                $this->error('新闻名称不能为空！');
            }
            if(empty($data['cate_id'])){
                $this->error('请选择新闻分类！');
            }
            if(empty($data['content'])){
                $this->error('新闻内容不能为空！');
            }

            $data['content'] = $_POST['content'];//重置为没有过滤前的富文本

            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }

            $newsModel = new NewsModel();
            $rs = $newsModel->add_post_baas('news',$data);
            if(!empty($rs)){
                $this->success('添加成功！','News/index');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $category_model = new NewsCategory();
            $cate_list = $category_model->getList('_id,cate_name');
            $cate_list = !empty($cate_list) ? arrayChangeKey($cate_list,'_id','cate_name') : [];
            $this->assign('cate_list',$cate_list);
            $this->assign('current_url',url('News/index'));
            return $this->fetch();
        }
    }

    public function editNews()
    {
        if($this->request->isPost()){
            $data = input('post.');
            if(empty($data['title'])){
                $this->error('新闻名称不能为空！');
            }
            if(empty($data['cate_id'])){
                $this->error('请选择新闻分类！');
            }
            if(empty($data['content'])){
                $this->error('新闻内容不能为空！');
            }

            $data['content'] = $_POST['content'];//重置为没有过滤前的富文本

            if(!is_numeric($data['sort']) || intval($data['sort'])<0){
                $this->error('排序数必需为数字！');
            }
            $newsModel = new NewsModel();
            $rs = $newsModel->update_put_baas('news/'.$data['_id'],$data);
            if(!empty($rs)){
                $this->success('编辑成功！','News/index');
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $id = input('param.id');
            if(empty($id)){
                $this->error('非法请求');
            }

            $newsModel = new NewsModel();
            $item = $newsModel->get_baas('news/'.$id);
            if(empty($item)){
                $this->error('不存在此数据');
            }
            $this->assign('item',$item);

            $category_model = new NewsCategory();
            $cate_list = $category_model->getList('_id,cate_name');
            $cate_list = !empty($cate_list) ? arrayChangeKey($cate_list,'_id','cate_name') : [];
            $this->assign('cate_list',$cate_list);
            $this->assign('current_url',url('News/index'));
            return $this->fetch('addnews');
        }
    }

    public function delNews()
    {
        $id = input('param.id');
        if(empty($id)){
            $this->error('非法请求');
        }
        $news_model = new NewsModel();
        $item = $news_model->get_baas('news/'.$id);
        if(empty($item)){
            $this->error('不存在此数据');
        }
        $rs = $news_model->delete_baas('news/'.$id);
        if(!empty($rs)){
            $this->success('删除成功！','News/index');
        }else{
            $this->error('删除失败！');
        }
    }

    /**
     * 分类管理
     */
    public function category()
    {
        $categoryModel = new NewsCategory();
        $list = $categoryModel->getList();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function addCategory()
    {
        if($this->request->isPost()){
            $data = $this->request->except('_id','post');
            if(empty($data['cate_name'])){
                $this->error('分类名称不能为空！');
            }
            $categoryModel = new NewsCategory();
            $rs = $categoryModel->add_post_baas('news_category',$data);
            if(!empty($rs)){
                $this->success('添加成功！','News/category');
            }else{
                $this->error('添加失败！');
            }
        }else{
            $this->assign('current_url',url('News/category'));
            return $this->fetch();
        }
    }

    public function editCategory()
    {
        if($this->request->isPost()){
            $data = input('post.');
            if(empty($data['_id'])){
                $this->error('非法请求！');
            }
            if(empty($data['cate_name'])){
                $this->error('分类名称不能为空！');
            }
            $categoryModel = new NewsCategory();
            $rs = $categoryModel->update_put_baas('news_category/'.$data['_id'],$data);
            if(!empty($rs)){
                $this->success('编辑成功！','News/category');
            }else{
                $this->error('编辑失败！');
            }
        }else{
            $id = input('param.id');
            if(empty($id)){
                $this->error('非法请求');
            }
            $categoryModel = new NewsCategory();
            $item = $categoryModel->get_baas('news_category/'.$id);
            if(empty($item)){
                $this->error('不存在此数据');
            }
            $this->assign('item',$item);
            $this->assign('current_url',url('News/category'));
            return $this->fetch('addcategory');
        }
    }

    public function delCategory()
    {
        $id = input('param.id');
        if(empty($id)){
            $this->error('非法请求');
        }
        $categoryModel = new NewsCategory();
        $item = $categoryModel->get_baas('news_category/'.$id);
        if(empty($item)){
            $this->error('不存在此分类');
        }

        $news_model = new NewsModel();
        $is_exist_data = $news_model->getList(1,$id);
        if(!empty($is_exist_data['data'])){
            $this->error('该分类下存有文章数据，请先处理掉对应的文章再删除该分类 ！');
        }

        $rs = $categoryModel->delete_baas('news_category/'.$id);
        if(!empty($rs)){
            $this->success('删除成功！','News/category');
        }else{
            $this->error('删除失败！');
        }
    }


    /**
     * 用于编辑器上传
     */
    public function editor(){
        $config = [
            /* 上传图片配置项 */
            "imageActionName"=>"uploadimage", /* 执行上传图片的action名称 */
            "imageFieldName"=> "upfile", /* 提交的图片表单名称 */
            "imageMaxSize"=> 10485760, /* 上传大小限制，单位B,1M=1024KB,1KB=1024B,此处10M */
            "imageAllowFiles"=> [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 上传图片格式显示 */
            "imageCompressEnable"=> true, /* 是否压缩图片,默认是true */
            "imageCompressBorder"=> 3000, /* 图片压缩最长边限制 */
            "imageInsertAlign"=>"none", /* 插入的图片浮动方式 */
            "imageUrlPrefix"=> "", /* 图片访问路径前缀 */
            "imagePathFormat"=> "/ueditor/fuwuduan_php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                                /* {filename} 会替换成原文件名,配置这项需要注意中文乱码问题 */
                                /* {rand:6} 会替换成随机数,后面的数字是随机数的位数 */
                                /* {time} 会替换成时间戳 */
                                /* {yyyy} 会替换成四位年份 */
                                /* {yy} 会替换成两位年份 */
                                /* {mm} 会替换成两位月份 */
                                /* {dd} 会替换成两位日期 */
                                /* {hh} 会替换成两位小时 */
                                /* {ii} 会替换成两位分钟 */
                                /* {ss} 会替换成两位秒 */
                                /* 非法字符 \ : * ? " < > | */
                                /* 具请体看线上文档: fex.baidu.com/ueditor/#use-format_upload_filename */

            /* 涂鸦图片上传配置项 */
            "scrawlActionName"=> "uploadscrawl", /* 执行上传涂鸦的action名称 */
            "scrawlFieldName"=> "upfile", /* 提交的图片表单名称 */
            "scrawlPathFormat"=> "/ueditor/fuwuduan_php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "scrawlMaxSize"=> 10485760, /* 上传大小限制，单位B */
            "scrawlUrlPrefix"=> "", /* 图片访问路径前缀 */
            "scrawlInsertAlign"=> "none",

            /* 截图工具上传 */
            "snapscreenActionName"=>"uploadimage", /* 执行上传截图的action名称 */
            "snapscreenPathFormat"=> "/ueditor/fuwuduan_php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "snapscreenUrlPrefix"=>"", /* 图片访问路径前缀 */
            "snapscreenInsertAlign"=> "none", /* 插入的图片浮动方式 */

            /* 抓取远程图片配置 */
            "catcherLocalDomain"=>["127.0.0.1", "localhost", "img.baidu.com"],
            "catcherActionName"=> "catchimage", /* 执行抓取远程图片的action名称 */
            "catcherFieldName"=>"source", /* 提交的图片列表表单名称 */
            "catcherPathFormat"=> "/ueditor/fuwuduan_php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "catcherUrlPrefix"=> "", /* 图片访问路径前缀 */
            "catcherMaxSize"=> 10485760, /* 上传大小限制，单位B */
            "catcherAllowFiles"=> [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 抓取图片格式显示 */

            /* 上传视频配置 */
            "videoActionName"=> "uploadvideo", /* 执行上传视频的action名称 */
            "videoFieldName"=> "upvideo", /* 提交的视频表单名称 */
            "videoPathFormat"=> "/ueditor/fuwuduan_php/upload/video/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "videoUrlPrefix"=> "", /* 视频访问路径前缀 */
            "videoMaxSize"=> 10485760, /* 上传大小限制，单位B，默认10MB */
            "videoAllowFiles"=> [
                    ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
                    ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid"
            ], /* 上传视频格式显示 */

            /* 上传文件配置 */
            "fileActionName"=>"uploadfile", /* controller里,执行上传视频的action名称 */
            "fileFieldName"=>"upfile", /* 提交的文件表单名称 */
            "filePathFormat"=> "/ueditor/fuwuduan_php/upload/file/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
            "fileUrlPrefix"=>"", /* 文件访问路径前缀 */
            "fileMaxSize"=> 10485760, /* 上传大小限制，单位B，默认10MB */
            "fileAllowFiles"=> [
                    ".png", ".jpg", ".jpeg", ".gif", ".bmp",
                    ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
                    ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
                    ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
                    ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
            ], /* 上传文件格式显示 */

            /* 列出指定目录下的图片 */
            "imageManagerActionName"=> "listimage", /* 执行图片管理的action名称 */
            "imageManagerListPath"=> "/ueditor/fuwuduan_php/upload/image/", /* 指定要列出图片的目录 */
            "imageManagerListSize"=>20, /* 每次列出文件数量 */
            "imageManagerUrlPrefix"=> "", /* 图片访问路径前缀 */
            "imageManagerInsertAlign"=> "none", /* 插入的图片浮动方式 */
            "imageManagerAllowFiles"=> [".png", ".jpg", ".jpeg", ".gif", ".bmp"], /* 列出的文件类型 */

            /* 列出指定目录下的文件 */
            "fileManagerActionName"=>"listfile", /* 执行文件管理的action名称 */
            "fileManagerListPath"=>"/ueditor/fuwuduan_php/upload/file/", /* 指定要列出文件的目录 */
            "fileManagerUrlPrefix"=> "", /* 文件访问路径前缀 */
            "fileManagerListSize"=>20, /* 每次列出文件数量 */
            "fileManagerAllowFiles"=> [
                    ".png", ".jpg", ".jpeg", ".gif", ".bmp",
                    ".flv", ".swf", ".mkv", ".avi", ".rm", ".rmvb", ".mpeg", ".mpg",
                    ".ogg", ".ogv", ".mov", ".wmv", ".mp4", ".webm", ".mp3", ".wav", ".mid",
                    ".rar", ".zip", ".tar", ".gz", ".7z", ".bz2", ".cab", ".iso",
                    ".doc", ".docx", ".xls", ".xlsx", ".ppt", ".pptx", ".pdf", ".txt", ".md", ".xml"
            ],/* 列出的文件类型 */
        ];

        $action = input('get.action','');
        switch ($action) {
            case 'config':
                $result =  $config;
                break;
                /* 上传涂鸦
            case 'uploadscrawl':*/
                /* 上传视频 */
            case 'uploadvideo':
                $video = input('file.upvideo');
                $video_info = $video->getInfo();
                if(!empty($video_info)){

                    //检查大小
                    if($video_info['size']>$config['videoMaxSize']){
                        die(json_encode(['state'=>'上传的视频超出大小限制']));
                    }

                    $commonModel = new Common();
                    $rs = $commonModel->upload_file_baas($video_info);
                    if(!empty($rs)){
                        $result =  [
                            "state" => 'SUCCESS',
                            "url"   => $rs['url'],
                            "original" =>$video_info['name'],
                            "type" => $video_info['type'],
                            "size" => $video_info['size'],
                        ];
                    }else{
                        $result =  [
                            "state" => '上传失败',
                        ];
                    }
                }
                break;
            /* 上传图片 */
            case 'uploadimage':
                $file = input('file.upfile');
                $info = $file->getInfo();
                if(!empty($info)){
                    //检查大小
                    if($info['size']>$config['imageMaxSize']){
                        die(json_encode(['state'=>'上传的图片超出大小限制']));
                    }

                    $commonModel = new Common();
                    $rs = $commonModel->upload_image_baas($info);
                    if(!empty($rs)){
                        $result =  [
                            "state" => 'SUCCESS',
                            "url"   => $rs['url'],
                            "original" =>$info['name'],
                            "type" => $info['type'],
                            "size" => $info['size'],
                        ];
                    }else{
                        $result =  [
                            "state" => '上传失败',
                        ];
                    }
                }
                break;
            /* 上传文件 */
            case 'uploadfile':
                $file = input('file.upfile');
                $info = $file->getInfo();
                if(!empty($info)){
                    //检查大小
                    if($info['size']>$config['imageMaxSize']){
                        die(json_encode(['state'=>'上传的文件超出大小限制']));
                    }

                    $commonModel = new Common();
                    $rs = $commonModel->upload_file_baas($info);
                    if(!empty($rs)){
                        $result =  [
                            "state" => 'SUCCESS',
                            "url"   => $rs['url'],
                            "original" =>$info['name'],
                            "type" => $info['type'],
                            "size" => $info['size'],
                        ];
                    }else{
                        $result =  [
                            "state" => '上传失败',
                        ];
                    }
                }
                break;

            /* 列出图片
            case 'listimage':
                $result = include("action_list.php");
                break; */
            /* 列出文件
            case 'listfile':
                $result = include("action_list.php");
                break;*/

            /* 抓取远程文件
            case 'catchimage':
                $result = include("action_crawler.php");
                break;*/

            default:
                $result = array(
                    'state'=> '请求地址出错'
                );
                break;
        }
        /* 全结构
       $result =  array(
           "state" => 'SUCCESS',
           "url" => $this->fullName,
           "title" => $this->fileName,//文件名
           "original" => $this->oriName,//原始文件名
           "type" => $this->fileType,
           "size" => $this->fileSize
        );
         */
        die(json_encode($result));
    }
}
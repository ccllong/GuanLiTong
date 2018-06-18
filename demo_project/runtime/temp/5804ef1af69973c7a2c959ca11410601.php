<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:88:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\admin\index.html";i:1504669438;s:88:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\common\base.html";i:1504514948;s:88:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\common\head.html";i:1504514948;s:90:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\common\header.html";i:1504666644;s:90:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\common\footer.html";i:1502954855;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <title>管理平台</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="UTF-8">
<link href="/admin/img/favicon.ico" type="image/x-icon" rel="shortcut icon">
<link rel="stylesheet" type="text/css" href="/admin/css/base.css" media="all">
<link rel="stylesheet" type="text/css" href="/admin/css/common.css" media="all">
<link rel="stylesheet" type="text/css" href="/admin/css/module.css">
<link rel="stylesheet" type="text/css" href="/admin/css/style.css" media="all">
<link rel="stylesheet" type="text/css" href="/admin/css/default_color.css" media="all">
<script type="text/javascript" src="/admin/js/jquery-2.js"></script>
<script type="text/javascript" src="/admin/js/jquery-mouse-wheel.js"></script>
    
</head>
<body>
<!-- 头部 -->
<div class="header">
    <!-- Logo -->
    <a href="http://ie.meizu.com" target="_blank"><span class="logo"></span></a>
    <!-- /Logo -->

    <!-- 主导航 -->
    <ul class="main-nav">
        <li <?php if($controller_name == 'Index'): ?>class="current"<?php endif; ?>><a href="<?php echo url('index/index'); ?>">首页</a></li>
        <li <?php if($controller_name == 'News'): ?>class="current"<?php endif; ?>><a href="<?php echo url('news/index'); ?>">新闻</a></li>
        <li <?php if($controller_name == 'Page'): ?>class="current"<?php endif; ?>><a href="<?php echo url('page/index'); ?>">单页</a></li>
        <li <?php if($controller_name == 'Admin'): ?>class="current"<?php endif; ?>><a href="<?php echo url('admin/index'); ?>">管理</a></li>
    </ul>
    <!-- /主导航 -->

    <!-- 用户栏 -->
    <div class="user-bar">
        <a href="javascript:;" class="user-entrance"><i class="icon-user"></i></a>
        <ul class="nav-list user-menu hidden">
            <li class="manager">你好，<em title="<?php echo $user['username']; ?>"><?php echo $user['username']; ?></em></li>
            <li><a href="<?php echo url('admin/user/logout'); ?>">退出</a></li>
        </ul>
    </div>
</div>
<!-- /头部 -->

<!-- 边栏 -->
<div class="sidebar">
    <!-- 子导航 -->
    <div id="subnav" class="subnav">
        <?php if(is_array($menu_ary) || $menu_ary instanceof \think\Collection || $menu_ary instanceof \think\Paginator): $i = 0; $__LIST__ = $menu_ary;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub_menu): $mod = ($i % 2 );++$i;if(!(empty($sub_menu) || (($sub_menu instanceof \think\Collection || $sub_menu instanceof \think\Paginator ) && $sub_menu->isEmpty()))): if(!(empty($key) || (($key instanceof \think\Collection || $key instanceof \think\Paginator ) && $key->isEmpty()))): ?><h3><i class="icon"></i><?php echo $key; ?></h3><?php endif; ?>
                <ul class="side-sub-menu">
                    <?php if(is_array($sub_menu) || $sub_menu instanceof \think\Collection || $sub_menu instanceof \think\Paginator): $i = 0; $__LIST__ = $sub_menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$url): $mod = ($i % 2 );++$i;?>
                        <li <?php if((url($controller_name.'/'.$action_name) == $url) || ($current_url == $url)): ?> class="current"<?php endif; ?>>
                            <a class="item" href="<?php echo $url; ?>"><?php echo $key; ?></a>
                        </li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            <?php endif; endforeach; endif; else: echo "" ;endif; ?>
        
    </div>
    <script>
        $(function () {
            $(".side-sub-menu li").hover(function () {
                $(this).addClass("hover");
            }, function () {
                $(this).removeClass("hover");
            });
        })
    </script>
    <!-- /子导航 -->
</div>
<!-- /边栏 -->

<!-- 内容区 -->
<div id="main-content">
    <div id="top-alert" class="fixed alert alert-error" style="display: none;">
        <button class="close fixed" style="margin-top: 4px;">×</button>
        <div class="alert-content">这是内容</div>
    </div>
    <div id="main" class="main">
        

<!-- 标题 -->
<div class="main-title">
    <h2>
        管理员列表
    </h2>
</div>

<!-- 按钮工具栏 -->
<div class="cf" >
    <div class="fl">
        <a class="btn" href="<?php echo url('Admin/add'); ?>">添 加</a>
    </div>
</div>


<!-- 数据表格 -->
<div class="data-table">
    <table class="">
        <thead>
        <tr>
            <th class="">编号</th>
            <th class="">姓名</th>
            <th class="">Flyme UID</th>
            <th class="">状态</th>
            <th class="">备注</th>
            <th class="">最后更新</th>
            <th class="">操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty()))): if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?>
        <tr>
            <td><?php echo $item['_id']; ?></td>
            <td><?php echo $item['name']; ?></td>
            <td><?php echo $item['flyme_uid']; ?></td>
            <td><?php echo !empty($item['status']) && $item['status']==1?'<font color="red">禁用</font>' : '<font color="green">启用</font>'; ?></td>
            <td><?php echo $item['remark']; ?></td>
            <td><?php echo getDateFromTimestamp($item['updateAt']); ?></td>
            <td>
                <a href="<?php echo url('Admin/edit',['id'=>$item['_id']]); ?>">编辑</a>
                <a href="<?php echo url('Admin/del',['id'=>$item['_id']]); ?>" class="confirm ajax-get">删除</a>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; endif; ?>
        </tbody>
    </table>


</div>

<!-- 分页 -->
<div class="page">
    <div></div>
</div>


    </div>
</div>
<!-- /内容区 -->

<!-- 尾部 -->

<script type="text/javascript" src="/admin/js/common.js"></script>
<script type="text/javascript">
    +function(){
        var $window = $(window), $subnav = $("#subnav"), url;
        $window.resize(function(){
            $("#main").css("min-height", $window.height());
        }).resize();

        /* 左边菜单高亮 */
        url = window.location.pathname + window.location.search;
        url = url.replace(/(\/(p)\/\d+)|(&p=\d+)|(\/(id)\/\d+)|(&id=\d+)|(\/(group)\/\d+)|(&group=\d+)/, "");
        $subnav.find("a[href='" + url + "']").parent().addClass("current");

        /* 左边菜单显示收起 */
        $("#subnav").on("click", "h3", function(){
            var $this = $(this);
            $this.find(".icon").toggleClass("icon-fold");
            $this.next().slideToggle("fast").siblings(".side-sub-menu:visible").
            prev("h3").find("i").addClass("icon-fold").end().end().hide();
        });

        $("#subnav h3 a").click(function(e){e.stopPropagation()});

        /* 头部管理员菜单 */
        $(".user-bar").mouseenter(function(){
            var userMenu = $(this).children(".user-menu ");
            userMenu.removeClass("hidden");
            clearTimeout(userMenu.data("timeout"));
        }).mouseleave(function(){
            var userMenu = $(this).children(".user-menu");
            userMenu.data("timeout") && clearTimeout(userMenu.data("timeout"));
            userMenu.data("timeout", setTimeout(function(){userMenu.addClass("hidden")}, 100));
        });

        /* 表单获取焦点变色 */
        $("form").on("focus", "input", function(){
            $(this).addClass('focus');
        }).on("blur","input",function(){
            $(this).removeClass('focus');
        });
        $("form").on("focus", "textarea", function(){
            $(this).closest('label').addClass('focus');
        }).on("blur","textarea",function(){
            $(this).closest('label').removeClass('focus');
        });

        // 导航栏超出窗口高度后的模拟滚动条
        var sHeight = $(".sidebar").height();
        var subHeight  = $(".subnav").height();
        var diff = subHeight - sHeight; //250
        var sub = $(".subnav");
        if(diff > 0){
            $(window).mousewheel(function(event, delta){
                if(delta>0){
                    if(parseInt(sub.css('marginTop'))>-10){
                        sub.css('marginTop','0px');
                    }else{
                        sub.css('marginTop','+='+10);
                    }
                }else{
                    if(parseInt(sub.css('marginTop'))<'-'+(diff-10)){
                        sub.css('marginTop','-'+(diff-10));
                    }else{
                        sub.css('marginTop','-='+10);
                    }
                }
            });
        }
    }();
</script>

<!-- /尾部 -->
</body>
</html>
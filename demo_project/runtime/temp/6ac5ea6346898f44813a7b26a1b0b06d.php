<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:94:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\index\addcarousel.html";i:1507705469;s:88:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\common\base.html";i:1504514948;s:88:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\common\head.html";i:1504514948;s:90:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\common\header.html";i:1504666644;s:90:"E:\web\meizu\ie.meizu.com\src\main\php\public/../application/admin\view\common\footer.html";i:1502954855;}*/ ?>
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
        
<div class="main-title">
    <h2>
        添加 / 编辑 轮播位
    </h2>
</div>

<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
    <div class="form-item">
        <label class="item-label">名称<span class="check-tips">（用于显示在导航上的文字）</span></label>
        <div class="controls">
            <input type="text" class="text input-large" name="title" value="<?php echo !empty($item['title'])?$item['title'] : ''; ?>">
        </div>
    </div>

    <div class="form-item">
        <label class="item-label">上传图片<span class="check-tips">(图片不允许超过2M，宽度1920 X 高度680)</span></label>
        <div class="controls">
            <div id="current_img" style="margin-bottom: 25px;<?php if(!isset($item) || empty($item['img'])): ?>display: none<?php endif; ?>"><img src="<?php echo !empty($item['img'])?$item['img'] : ''; ?>" width="200" border="0" id="upload_img"/></div>
            <input name="images" type="file" id="upload_file" value="上传图"/>
        </div>
    </div>

    <div class="form-item">
        <label class="item-label">上传2倍大图片<span class="check-tips">(图片不允许超过2M，宽度3840 X 高度1360)</span></label>
        <div class="controls">
            <div id="current_big_img" style="margin-bottom: 25px;<?php if(!isset($item) || empty($item['big_img'])): ?>display: none<?php endif; ?>"><img src="<?php echo !empty($item['big_img'])?$item['big_img'] : ''; ?>" width="200" border="0" id="upload_big_img"/></div>
            <input name="big_images" type="file" id="upload_big_file" value="上传图"/>
        </div>
    </div>

    <div class="form-item">
        <label class="item-label">移动端图片<span class="check-tips">(图片不允许超过2M，宽度1080 X 高度980)</span></label>
        <div class="controls">
            <div id="current_mob_img" style="margin-bottom: 25px;<?php if(!isset($item) || empty($item['mob_img'])): ?>display: none<?php endif; ?>"><img src="<?php echo !empty($item['mob_img'])?$item['mob_img'] : ''; ?>" width="200" border="0" id="upload_mob_img"/></div>
            <input name="mob_images" type="file" id="upload_mob_file" value="上传图"/>
        </div>
    </div>

    <div class="form-item">
        <label class="item-label">跳转URL<span class="check-tips">（用于导航点击的跳转链接，请带上http://前缀）</span></label>
        <div class="controls">
            <input type="text" class="text input-large" name="url" value="<?php echo !empty($item['url'])?$item['url'] : ''; ?>">
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">排序<span class="check-tips">（用于导航先后顺序，排序数越大越排前）</span></label>
        <div class="controls">
            <input type="text" class="text input-small" name="sort" value="<?php echo !empty($item['sort'])?$item['sort'] : '0'; ?>">
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">新窗口打开<span class="check-tips">（是否新窗口打开链接）</span></label>
        <div class="controls">
            <select name="target">
                <option value="0" <?php if(isset($item['target']) && ($item['target'] == 0)): ?>selected<?php endif; ?>>否</option>
                <option value="1" <?php if(isset($item['target']) && ($item['target'] == 1)): ?>selected<?php endif; ?>>是</option>
            </select>
        </div>
    </div>
    <div class="form-item">
        <label class="item-label">状态<span class="check-tips"></span></label>
        <div class="controls">
            <select name="status">
                <option value="0" <?php if(isset($item['status']) && ($item['status'] == 0)): ?>selected<?php endif; ?>>启用</option>
                <option value="1" <?php if(isset($item['status']) && ($item['status'] == 1)): ?>selected<?php endif; ?>>禁用</option>
            </select>
        </div>
    </div>
    <div class="form-item">
        <input type="hidden" name="_id" value="<?php echo !empty($item['_id'])?$item['_id'] : ''; ?>">
        <input type="hidden" name="type" value="carousel"/>
        <input type="hidden" name="img" id="img" value="<?php echo !empty($item['img'])?$item['img'] : ''; ?>"/>
        <input type="hidden" name="big_img" id="big_img" value="<?php echo !empty($item['big_img'])?$item['big_img'] : ''; ?>"/>
        <input type="hidden" name="mob_img" id="mob_img" value="<?php echo !empty($item['mob_img'])?$item['mob_img'] : ''; ?>"/>
        <button class="btn submit-btn ajax-post" id="submit" type="submit" target-form="form-horizontal">确 定</button>
        <button class="btn btn-return" onclick="javascript:history.back(-1);return false;">返 回</button>
    </div>
</form>
<script>
    var uploading = false;

    $("#upload_file").on("change", function(){
        if(uploading){
            alert("文件正在上传中，请稍候");
            return false;
        }
        $.ajax({
            url: "<?php echo url('index/upload'); ?>",
            type: 'POST',
            cache: false,
            data: new FormData($('.form-horizontal')[0]),
            processData: false,
            contentType: false,
            dataType:"json",
            beforeSend: function(){
                //uploading = true;
            },
            success : function(data) {
                if (data.code == 1) {
                    $("#upload_file").val('');
                    $("#upload_img").attr("src", data.data);
                    $("#img").val(data.data);
                    $("#current_img").show();
                } else {
                    alert(data.msg);
                }
                uploading = false;
            }
        });
    });

    $("#upload_big_file").on("change", function(){
        if(uploading){
            alert("文件正在上传中，请稍候");
            return false;
        }
        $.ajax({
            url: "<?php echo url('index/upload'); ?>",
            type: 'POST',
            cache: false,
            data: new FormData($('.form-horizontal')[0]),
            processData: false,
            contentType: false,
            dataType:"json",
            beforeSend: function(){
                //uploading = true;
            },
            success : function(data) {
                if (data.code == 1) {
                    $("#upload_big_file").val('');
                    $("#upload_big_img").attr("src", data.data);
                    $("#big_img").val(data.data);
                    $("#current_big_img").show();
                } else {
                    alert(data.msg);
                }
                uploading = false;
            }
        });
    });

    $("#upload_mob_file").on("change", function(){
        if(uploading){
            alert("文件正在上传中，请稍候");
            return false;
        }
        $.ajax({
            url: "<?php echo url('index/upload'); ?>",
            type: 'POST',
            cache: false,
            data: new FormData($('.form-horizontal')[0]),
            processData: false,
            contentType: false,
            dataType:"json",
            beforeSend: function(){
                //uploading = true;
            },
            success : function(data) {
                if (data.code == 1) {
                    $("#upload_mob_file").val('');
                    $("#upload_mob_img").attr("src", data.data);
                    $("#mob_img").val(data.data);
                    $("#current_mob_img").show();
                } else {
                    alert(data.msg);
                }
                uploading = false;
            }
        });
    });
</script>

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
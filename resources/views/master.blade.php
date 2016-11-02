<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <link rel="stylesheet" href="//cdn.bootcss.com/weui/0.2.2/style/weui.min.css">
    <link rel="stylesheet" href="/laravel/public/css/book.css">
    <title>@yield('title')</title>
</head>
<body>
<div class="bk_title_bar">
    <img src="/laravel/public/images/back.png" alt="" class="bk_back" onclick="history.go(-1)" />
    <p class="bk_title_content"></p>
    <img src="/laravel/public/images/menu.png" alt="" class="bk_menu" onclick="onMenuClick();" />
</div>

<div class="page">
@yield('content')
</div>

<div class="bk_toptips"><span></span></div>
{{--<div id="global_menu" onclick="onMenuClick();">--}}
    {{--<div></div>--}}
{{--</div>--}}
<div id="actionSheet_wrap">
    <div class="weui_mask_transition" id="mask"></div>
    <div class="weui_actionsheet" id="weui_actionsheet">
        <div class="weui_actionsheet_menu">
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(1)">主页</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(2)">书籍列表</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(3)">购物车</div>
            <div class="weui_actionsheet_cell" onclick="onMenuItemClick(4)">订单</div>
        </div>
        <div class="weui_actionsheet_action">
            <div class="weui_actionsheet_cell" id="actionsheet_cancel">取消</div>
        </div>
    </div>
</div>
</body>
<script src="//cdn.bootcss.com/jquery/3.1.1/jquery.min.js"></script>
<script>
    function init() {
        $('.bk_title_content').text(document.title);
    }
    init();
    
    var bkToptips = $('.bk_toptips');
    function hideActionSheet(weuiActionSheet, mask) {
        weuiActionSheet.removeClass('weui_actionsheet_toggle');
        mask.removeClass('weui_fade_toggle');
        weuiActionSheet.on('transitionend', function () {
            mask.hide();
        });
    }

    function onMenuClick() {
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        weuiActionsheet.addClass('weui_actionsheet_toggle');
        mask.show().addClass('weui_fade_toggle').click(function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        $('#actionsheet_cancel').click(function () {
            hideActionSheet(weuiActionsheet, mask);
        });
        weuiActionsheet.unbind('transitionend').unbind('webkitTransitionEnd');
    }

    function onMenuItemClick(index) {
        var mask = $('#mask');
        var weuiActionsheet = $('#weui_actionsheet');
        hideActionSheet(weuiActionsheet, mask);
        if (index == 1) {

        } else if (index == 2) {
            location.href = '/laravel/public/category';
        } else if (index == 3) {
            location.href = '/laravel/public/cart';
        } else {
            location.href = '/laravel/public/order_list';
        }
    }
</script>
@yield('custom-js')
</html>
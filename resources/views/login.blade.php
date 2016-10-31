@extends('master')

@section('title','Login')

@include('component.loading')

@section('content')
    <div class="weui_cells_title"></div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_bd">
                <label class="weui_label">账号</label>
            </div>
            <div class="weui_cell_bd weui_cell_primary">
                <input type="tel" name="account" placeholder="邮箱或手机号" class="weui_input">
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary"><input type="password" name="password" class="weui_input" placeholder="不少于6位"></div>
        </div>
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
            <div class="weui_cell weui_cell_primary"><input type="text" name="validate_code" class="weui_input" placeholder="请输入验证码"></div>
            <div class="weui_cell_ft">
                <img src="/laravel/public/service/validate_code/create" class="bk_validate_code" alt="">
            </div>
        </div>
        
    </div>
    <div class="weui_cells_tips"></div>
    <div class="weui_btn_area">
        <a href="javascript:;" onclick="onLoginClick();" class="weui_btn weui_btn_primary">登录</a>
    </div>
    <a href="/laravel/public/register" class="bk_bottom_tips bk_important">没有账号？去注册</a>
@endsection



@section('custom-js')
    <script>
        $(function () {
            $('.bk_validate_code').on('click',function () {
                $(this).attr('src','/laravel/public/service/validate_code/create?_'+Date.now());
            })
        });
        function validLogin(account,password,validate_code) {
            if(!account || !password || !validate_code){
                return false;
            }
            return true;
        }
        function onLoginClick(){
            var account = $('input[name=account]').val() || '';
            var password = $('input[name=password]').val() || '';
            var validate_code = $('input[name=validate_code]').val() || '';
            if(!validLogin(account,password,validate_code)){
                bkToptips.show().children('span').html('请填写必须项');
                setTimeout(function(){bkToptips.hide()},2000);
                return ;
            }
            $.ajax({
                url:'/laravel/public/service/login',
                type:'post',
                dataType:'json',
                data:{
                    account:account,
                    password:password,
                    validate_code:validate_code,
                    _token:'{{csrf_token()}}'
                },
                cache:false
            }).done(function (d) {
                if(d == null){
                    bkToptips.show().children('span').html(d.msg);
                    setTimeout(function(){bkToptips.hide()},1500);
                    return ;
                }
                bkToptips.show().children('span').html(d.msg);
                setTimeout(function(){
                    bkToptips.hide();
                    location.href = '/laravel/public/category';
                },2000);
            }).fail(function () {
                bkToptips.show().children('span').html('登录失败，稍后再试');
                setTimeout(function(){bkToptips.hide()},1500);
            })

        }
    </script>
@endsection
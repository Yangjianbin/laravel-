@extends('master')

@section('title','Register')


@section('content')

    <div class="weui_cells_title">注册方式</div>
    <div class="weui_cells weui_cells_radio">
        <label class="weui_cell weui_check_label" for="x11">
            <div class="weui_cell_bd weui_cell_primary">
                <p>手机号注册</p>
            </div>
            <div class="weui_cell_ft">
                <input type="radio" class="weui_check" name="register_type" id="x11" checked="checked">
                <span class="weui_icon_checked"></span>
            </div>
        </label>
        <label class="weui_cell weui_check_label" for="x12">
            <div class="weui_cell_bd weui_cell_primary">
                <p>邮箱注册</p>
            </div>
            <div class="weui_cell_ft">
                <input type="radio" class="weui_check" name="register_type" id="x12">
                <span class="weui_icon_checked"></span>
            </div>
        </label>
    </div>
    <div class="weui_cells weui_cells_form">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">手机号</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" placeholder="" name="phone"/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_phone'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_phone_cfm'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">手机验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" placeholder="" name='phone_code'/>
            </div>
            <p class="bk_important bk_phone_code_send">发送验证码</p>
            <div class="weui_cell_ft">
            </div>
        </div>
    </div>
    <div class="weui_cells weui_cells_form" style="display: none;">
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">邮箱</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" placeholder="" name='email'/>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_email'>
            </div>
        </div>
        <div class="weui_cell">
            <div class="weui_cell_hd"><label class="weui_label">确认密码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="password" placeholder="不少于6位" name='passwd_email_cfm'/>
            </div>
        </div>
        <div class="weui_cell weui_vcode">
            <div class="weui_cell_hd"><label class="weui_label">验证码</label></div>
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="text" placeholder="请输入验证码" name='validate_code'/>
            </div>
            <div class="weui_cell_ft">
                <img src="/laravel/public/service/validate_code/create" class="bk_validate_code"/>
            </div>
        </div>
    </div>
    <div class="weui_cells_tips"></div>
    <div class="weui_btn_area">
        <a class="weui_btn weui_btn_primary" href="javascript:" onclick="onRegisterClick();">注册</a>
    </div>
    <a href="/laravel/public/login" class="bk_bottom_tips bk_important">已有帐号? 去登录</a>


    @endsection




@section('custom-js')
    <script>
        function checkPhone(phone){
            if(!(/^1[34578]\d{9}$/.test(phone))){
                return false;
            }
            return true;
        }
        $(function () {
            $('input[name=register_type]').on('click',function () {
                var idx = $('input[name=register_type]').index($(this));
                $('.weui_cells_form').eq(idx).show().siblings('.weui_cells_form').hide();
            });
            var canSend = true;
            $('.bk_phone_code_send').on('click',function () {
                var _this = $(this);
                if(!canSend){
                    return ;
                }

                //验证手机号码
                var phone = $('input[name=phone]').val();
                if(!checkPhone(phone)){
                    bkToptips.show().children('span').html('手机格式不正确');
                    setTimeout(function(){bkToptips.hide()},1500);
                    return ;
                }
                _this.removeClass('bk_important').addClass('bk_summary');
                canSend = false;
                var num = 60;
                var interval = window.setInterval(function () {
                    _this.html(--num + 's 重新发送');
                    if(num<=0){
                        _this.addClass('bk_important').removeClass('bk_summary');
                        canSend = true;
                        window.clearInterval(interval);
                        _this.html('重新发送');
                    }
                },1000);


                $.ajax({
                    url:'/laravel/public/service/validate_phone/send',
                    data:{phone:phone},
                    dataType:'json',
                    cache:false
                }).done(function(d){
                    if(d == null){
                        bkToptips.show().children('span').html(d.msg);
                        setTimeout(function(){bkToptips.hide()},1500);
                        return ;
                    }
                    bkToptips.show().children('span').html(d.msg);
                    setTimeout(function(){bkToptips.hide()},1500);
                }).fail(function(d){
                    bkToptips.show().children('span').html('发送失败，稍后再试');
                    setTimeout(function(){bkToptips.hide()},1500);
                })


            });

        });
    </script>
    <script>
        function phoneRegisterValid(phone,passwd_phone,passwd_phone_cfm,phone_code){
            //valid phone
            var b = checkPhone(phone);
            if(!b) {
                return false;
            }
            //valid password
            if(!passwd_phone || !passwd_phone_cfm || !phone_code){
                return false;
            }

            return true;

        }
        function onRegisterClick(){
            var phone = $('input[name=phone]').val() || '';
            var passwd_phone = $('input[name=passwd_phone]').val() || '';
            var passwd_phone_cfm = $('input[name=passwd_phone_cfm]').val() || '';
            var phone_code = $('input[name=phone_code]').val() || '';
            if(!phoneRegisterValid(phone,passwd_phone,passwd_phone_cfm,phone_code)){
                bkToptips.show().children('span').html('请填写必填项');
                setTimeout(function(){bkToptips.hide()},1500);
                return;
            }
            if(passwd_phone!=passwd_phone_cfm){
                bkToptips.show().children('span').html('密码两次输入不一致');
                setTimeout(function(){bkToptips.hide()},1500);
                return;
            }
            $.ajax({
                url:'/laravel/public/service/register',
                dataType:'json',
                data:{
                    phone:phone,
                    password:passwd_phone,
                    phone_code:phone_code,
                    _token:'{{csrf_token()}}'
                },
                type:'post',
                cache:false
            }).done(function (d) {
                if(d == null){
                    bkToptips.show().children('span').html(d.msg);
                    setTimeout(function(){bkToptips.hide()},1500);
                    return ;
                }
                bkToptips.show().children('span').html(d.msg);
                setTimeout(function(){bkToptips.hide()},2000);
            }).fail(function () {
                bkToptips.show().children('span').html('注册失败，稍后再试');
                setTimeout(function(){bkToptips.hide()},1500);
            })



        }
    </script>
@endsection
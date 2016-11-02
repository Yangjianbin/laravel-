@extends('master')
@section('title',$product->name)

@section('content')
    <link rel="stylesheet" href="/laravel/public/css/swipe.css">
    <div class="page" style="top:0">
    <div class="addWrap">
        <div class="swipe" id="mySwipe">
            <div class="swipe-wrap">
                @foreach($pdt_images as $pdt_image)
                    <div><a href="">
                            <img src="{{$pdt_image->path}}" alt="" class="img-responsive">
                        </a></div>
                    @endforeach
            </div>
        </div>
        <div id="position">
            @foreach($pdt_images as $index => $pdt_image)
                <li class="{{$index == 0 ? 'cur' : ''}}"></li>
                @endforeach
        </div>
    </div>
    <div class="weui_cells_title">
        <span class="bk_title">{{$product->name}}</span>
        <span class="bk_price" style="float:right;">￥ {{$product->price}}</span>
    </div>
    <div class="weui_cells">
        <div class="weui_cell"><p class="bk_summary">{{$product->summary}}</p></div>
    </div>
    <div class="weui_cells_title">详细介绍</div>
    <div class="weui_cells">
        <div class="weui_cell" style="display:block;">
            {!! $pdt_content ? $pdt_content->content : '' !!}
        </div>
    </div>
    <div class="bk_fix_bottom">
        <div class="bk_half_area">
            <button onclick="addCart();" class="weui_btn weui_btn_primary">
                加入购物车
            </button>
        </div>
        <div class="bk_half_area">
            <button onclick="toCart();" class="weui_btn weui_btn_default">
                结算(<span id="cart_num" class="m3_price">{{$count}}</span>)
            </button>
        </div>
    </div>
    </div>
@endsection


@section('custom-js')
    <script src="/laravel/public/js/swipe.min.js"></script>
    <script>
        var bullets = document.getElementById('position').getElementsByTagName('li');
        Swipe(document.getElementById('mySwipe'),{
            auto:2000,
            disableScroll:false,
            callback:function (pos) {
                var i = bullets.length;
                while(i--){
                    bullets[i].className = '';
                }
                bullets[pos].className = 'cur';
            }
        });
        var cart_num = $('#cart_num');
        function addCart() {
            var product_id = '{{$product->id}}';
            $.ajax({
                url:'/laravel/public/service/cart/add/' + product_id,
                cache:false,
                dataType:'json'
            }).done(function (d) {
                if(d == null || d.code != 0){
                    bkToptips.show().children('span').html('操作失败，稍后再试');
                    setTimeout(function(){bkToptips.hide()},1500);
                    return ;
                }
                var num = cart_num.text();
                cart_num.text(!num ? 1 : parseInt(num) + 1);
            }).fail(function () {
                bkToptips.show().children('span').html('操作失败，稍后再试');
                setTimeout(function(){bkToptips.hide()},1500);
            })
        }
        
        function toCart() {
            location.href = '/laravel/public/cart';
        }
        

    </script>
@endsection
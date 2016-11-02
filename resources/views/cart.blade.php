@extends('master')
@section('title','购物车')

@section('content')
    <div class="page bk_content" style="top:0">
        <div class="weui_cells weui_cells_checkbox">
            @foreach($cart_items as $v)
                <label for="{{$v->product_id}}" class="weui_cell weui_check_label">
                <div class="weui_cell_hd" style="width:23px">
                    <input type="checkbox" class="weui_check" name="cart_item" id="{{$v->product->id}}">
                    <i class="weui_icon_checked"></i>
                </div>
                <div class="weui_cell_bd weui_cell_primary">
                    <div style="position:relative;">
                        <img class="bk_preview" onclick="" src="{{$v->product->preview}}" alt="" class="bk_preview">
                        <div style="position:absolute;left: 100px;right: 0px;top: 0px;">
                            <p>{{$v->product->name}}</p>
                            <p class="bk_time" style="margin-top:15px;">数量:<span class="bk_summary">x</span>{{$v->count}}</p>
                            <p class="bk_time">总计：<span class="bk_price">￥{{$v->product->price}}</span></p>
                        </div>
                    </div>
                </div>
                </label>
            @endforeach
        </div>

        <div class="bk_fix_bottom">
            <div class="bk_half_area">
                <button onclick="toCharge();" class="weui_btn weui_btn_primary">
                    结算
                </button>
            </div>
            <div class="bk_half_area">
                <button onclick="toDelete();" class="weui_btn weui_btn_default">
                    清除
                </button>
            </div>
        </div>


    </div>

@endsection
@section('custom-js')
    <script>

        function getSelectArr() {
            var selected = $(':checkbox:checked');
            if(!selected.length){
                return [];
            }
            var ids = [];
            selected.each(function () {
                ids.push($(this).attr('id'));
            });
            return ids;
        }
        
        function toCharge() {
            var product_ids_arr = getSelectArr();
            if(!product_ids_arr.length){
                return;
            }
            location.href= '/laravel/public/order_commit/'+product_ids_arr+'';
        }
        
        function toDelete() {
            var ids = getSelectArr();
            if(!ids.length){
                return;
            }
            $.ajax({
                url:'/laravel/public/service/cart/delete',
                cache:false,
                dataType:'json',
                data:{product_ids:ids+''}
            }).done(function (d) {
                if(d == null || d.code != 0){
                    bkToptips.show().children('span').html('操作失败，稍后再试');
                    setTimeout(function(){bkToptips.hide()},1500);
                    return ;
                }
                location.reload();
            }).fail(function () {
                bkToptips.show().children('span').html('操作失败，稍后再试');
                setTimeout(function(){bkToptips.hide()},1500);
            })
        }
    </script>
@endsection



















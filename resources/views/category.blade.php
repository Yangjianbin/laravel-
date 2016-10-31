@extends('master')

@section('title','书籍类别')

@section('content')

    <div class="weui_cells_title">选择书籍类别</div>
    <div class="weui_cells weui_cells_split">
        <div class="weui_cell weui_cell_sheet">
            <div class="weui_cell_bd weui_cell_primary">
                <select name="category"  class="weui_select">
                    @foreach($categorys as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="weui_cells weui_cells_access">

    </div>

@endsection


@section('custom-js')
    <script>
        var categorys = {};
        var weui_cells_access = $('.weui_cells_access');
        $('[name=category]').on('change',function () {
            loadSubCategory();
        });
        loadSubCategory();

        function loadSubCategory() {
            var parent_id = $('[name=category]').val();
            weui_cells_access.empty();
            if(categorys[parent_id]){
                drawHtml(categorys[parent_id]);
                return ;
            }
            $.ajax({
                url:'/laravel/public/service/category/parent_id/' + parent_id,
                dataType:'json',
                cache:false
            }).done(function (d) {
                if(d == null || d.code !=0){
                    return ;
                }
                categorys[parent_id] = d.categorys;
                drawHtml(d.categorys);
            }).fail(function () {
                bkToptips.show().children('span').html('请求失败，稍后再试');
                setTimeout(function(){bkToptips.hide()},1500);
            })
        }
        
        function drawHtml(categoryArr) {
            $.each(categoryArr,function (i,v) {
                var url = '/laravel/public/product/category_id/'+v.id;
                var html = '<a href="'+url+'" class="weui_cell">'+
                        '<div class="weui_cell_bd weui_cell_primary">'+
                        '<p>'+v.name+'</p>'+
                        '</div>'+
                        '<div class="weui_cell_ft"></div>'+
                        '</a>';
                weui_cells_access.append(html);
            })
        }

    </script>

@endsection











@extends('admin.master')

@section('content')

    <article class="page-container">
        <form action="" method="post" class="form form-horizontal" id="form-category-edit">
            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>名称：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$category->name}}" name="name">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>序号：</label>
                <div class="formControls col-xs-8 col-sm-9">
                    <input type="text" class="input-text" value="{{$category->no}}" name="no">
                </div>
            </div>

            <div class="row cl">
                <label class="form-label col-xs-4 col-sm-3">父类别：</label>
                <div class="formControls col-xs-8 col-sm-9"> <span class="select-box">
				<select class="select" size="1" name="parent_id">
					<option value="" selected>无</option>
                    @foreach($categories as $v)
					<option {{$v->id == $category->parent_id ? 'selected' : ''}} value="{{$v->id}}">{{$v->name}}</option>
                    @endforeach
				</select>
				</span> </div>
            </div>

            <div class="row cl">
                <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                    <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
                </div>
            </div>
        </form>
    </article>
@endsection
@section('custom-js')
    <script>
        $(function () {
            $("#form-category-edit").validate({
                rules:{
                    username:{
                        required:true,
                    },
                    no:{
                        required:true
                    }
                },
                onkeyup:false,
                focusCleanup:true,
                success:"valid",
                submitHandler:function(form){
                    $(form).ajaxSubmit({
                        type:'post',
                        url:'/laravel/public/admin/service/category/edit',
                        dataType:'json',
                        data:{
                            id:"{{$category->id}}",
                            name:$('input[name=name]').val(),
                            no:$('input[name=no]').val(),
                            parent_id:$('input[name=parent_id]').val(),
                            _token:"{{csrf_token()}}"
                        },
                        success:function(d){
                            if(d == null || d.code != 0){
                                layer.msg('操作失败请稍后再试',{icon:2,time:2000});
                                return ;
                            }
                            layer.msg(d.msg,{icon:1,time:2000});
                            parent.location.reload();
                        },
                        error:function () {
                            layer.msg('操作失败请稍后再试',{icon:2,time:2000});
                        },
                        beforeSend:function(){
                            layer.load(0,{shade:false});
                        }
                    });
                    return false;
                    //var index = parent.layer.getFrameIndex(window.name);
                    //parent.layer.close(index);
                }
            });
        })
    </script>

@endsection
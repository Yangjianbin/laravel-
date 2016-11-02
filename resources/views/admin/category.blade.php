@extends('admin.master')
@section('content')
    <nav class="breadcrumb">
        <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" >
            <i class="Hui-iconfont">&#xe68f;</i></a>
        </nav>
    <div class="page-container">
        <div class="cl pd-5 bg-1 bk-gray mt-20">
            <span class="l">
                <a href="javascript:;" onclick="category_add('添加用户','/laravel/public/admin/category_add','','510')" class="btn btn-primary radius">
                    <i class="Hui-iconfont">&#xe600;</i> 添加类别</a></span>
                    <span class="r">共有数据：<strong>{{count($categorys)}}</strong> 条</span>
        </div>
        <div class="mt-20">
            <table class="table table-border table-bordered table-hover table-bg table-sort">
                <thead>
                <tr class="text-c">
                    <th width="80">ID</th>
                    <th width="100">名称</th>
                    <th width="40">编号</th>
                    <th width="90">父类别</th>
                    <th width="100">操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($categorys as $k=>$v)
                <tr class="text-c">
                    <td>{{$v->id}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->no}}</td>
                    <td>{{$v->parent_id ? $v->parent->name : ''}}</td>
                    <td class="td-manage">
                        <a title="编辑" href="javascript:;" onclick="category_edit('编辑','/laravel/public/admin/category_edit?id={{$v->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a>
                        <a title="删除" href="javascript:;" onclick="category_del('{{$v->name}}','{{$v->id}}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('custom-js')
    <script>
        function category_add(title,url,w,h) {
            layer_show(title,url,w,h);
        }
        function category_edit(title, url, w, h) {
            layer_show(title,url,w,h);
        }
        function category_del(name,id){
            layer.confirm('确认要删除'+name+'分类吗？',function(){
                $.ajax({
                    url:'/laravel/public/admin/service/category/del',
                    type:'post',
                    dataType:'json',
                    data:{id:id,_token:"{{csrf_token()}}"}
                }).done(function (d) {
                    if(d == null || d.code != 0){
                        layer.msg('操作失败请稍后再试',{icon:2,time:2000});
                        return ;
                    }
                    layer.msg(d.msg,{icon:1,time:2000});
                    location.reload();
                }).fail(function () {
                    layer.msg('操作失败请稍后再试',{icon:2,time:2000});
                })
            });
        }
    </script>

@endsection

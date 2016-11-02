<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:05
 */

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function toCategory(){

        $categorys = Category::all();
        foreach ($categorys as $k=>&$v){
            if($v->parent_id != null && $v->parent_id != ''){
                $v->parent = Category::find($v->parent_id);
            }
        }
        $data = array(
            'categorys'=>$categorys
        );
        return view('admin/category',$data);
    }
    public function toCategoryAdd(){
        $categorys = Category::whereNull('parent_id')->get();
        $data = array(
            'categorys'=>$categorys
        );
        return view('admin/category_add',$data);
    }

    public function toCategoryEdit(Request $request){
        $id = $request->input('id');
        $category = Category::find($id);
        $categories = Category::whereNull('parent_id')->get();
        $data = array(
            'categories'=>$categories,
            'category'=>$category
        );
        return view('admin/category_edit',$data);
    }

//    Service
    public function categoryAdd(Request $request){
        $name = $request->input('name','');
        $no = $request->input('no','');
        $parent_id = $request->input('parent_id');
        $category = new Category;
        $category->name = $name;
        $category->no = $no;
        $category->parent_id = $parent_id;
        $category->save();
        $m3_result = new M3Result;
        $m3_result->code = 0;
        $m3_result->msg = '添加成功';
        return $m3_result->toJson();
    }
    public function categoryDel(Request $request){
        $id = $request->input('id','');
        Category::find($id)->delete();
        $m3_result = new M3Result;
        $m3_result->code = 0;
        $m3_result->msg = '删除成功';
        return $m3_result->toJson();
    }
    public function categoryEdit(Request $request){
        $id = $request->input('id','');
        $name = $request->input('name','');
        $no = $request->input('no','');
        $parent_id = $request->input('parent_id');

        $category = Category::find($id);
        $category->name = $name;
        $category->no = $no;
        $category->parent_id = $parent_id;
        $category->save();
        $m3_result = new M3Result;
        $m3_result->code = 0;
        $m3_result->msg = '修改成功';
        return $m3_result->toJson();
    }
}
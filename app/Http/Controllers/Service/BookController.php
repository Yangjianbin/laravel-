<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:05
 */

namespace App\Http\Controllers\Service;

use App\Entity\Category;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function getCategoryByParentId($parent_id){
        $categorys = Category::where('parent_id',$parent_id)->get();
        $m3_result = new M3Result;
        $m3_result->code = 0;
        $m3_result->msg = '返回成功';
        $m3_result->categorys = $categorys;
        return $m3_result->toJson();
    }
}
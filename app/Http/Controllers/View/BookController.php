<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:05
 */

namespace App\Http\Controllers\View;

use App\Entity\Category;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use App\Entity\Product;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function toCategory(){

        $categorys = Category::whereNull('parent_id')->get();
        $data = array(
            'categorys'=>$categorys
        );
        return view('category',$data);
    }
    public function toProduct($category_id){
        $products = Product::where('category_id',$category_id)->get();
        $data = array(
            'products'=>$products
        );
        return view('product',$data);
    }
    public function toPdtContent($product_id){
        $product = Product::find($product_id);
        $pdt_content = PdtContent::where('product_id',$product_id)->first();
        $pdt_images = PdtImages::where('product_id',$product_id)->get();
        $data = array(
            'product'=>$product,
            'pdt_content'=>$pdt_content,
            'pdt_images'=>$pdt_images
        );
        return view('pdt_content',$data);
    }
}
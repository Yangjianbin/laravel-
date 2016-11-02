<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:05
 */

namespace App\Http\Controllers\View;

use App\Entity\CartItem;
use App\Entity\Category;
use App\Entity\PdtContent;
use App\Entity\PdtImages;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
    public function toPdtContent(Request $request , $product_id){
        $product = Product::find($product_id);
        $pdt_content = PdtContent::where('product_id',$product_id)->first();
        $pdt_images = PdtImages::where('product_id',$product_id)->get();
        $count = 0;
        $member = $request->session()->get('member','');
        if($member!=''){
            $cart_items = CartItem::where('member_id',$member->id)->get();
            foreach ($cart_items as $cart_item){
                if($cart_item->product_id == $product_id){
                    $count = $cart_item->count;
                    break;
                }

            }
        }else{
            $bk_cart = $request->cookie('bk_cart');
            $bk_cart_arr = $bk_cart != null ? explode(',',$bk_cart) : array();
            foreach ($bk_cart_arr as $v) {
                $index = strpos($v,':');
                if(substr($v,0,$index) == $product_id){
                    $count = intval(substr($v,$index + 1));
                    break;
                }
            }
        }

        $data = array(
            'product'=>$product,
            'pdt_content'=>$pdt_content,
            'pdt_images'=>$pdt_images,
            'count'=>$count
        );
        return view('pdt_content',$data);
    }
}
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

class CartController extends Controller
{
    public function addCart(Request $request , $product_id){
        $m3_result = new M3Result();
        $m3_result -> code =0;
        $m3_result -> msg = '添加成功';
        //have login
        $member = $request->session()->get('member','');
        if($member != ''){
            $cart_items = CartItem::where('member_id', $member->id)->get();
            $exist = false;
            foreach ($cart_items as $cart_item) {
                if($cart_item->product_id == $product_id) {
                    $cart_item->count ++;
                    $cart_item->save();
                    $exist = true;
                    break;
                }
            }
            if($exist == false) {
                $cart_item = new CartItem;
                $cart_item->product_id = $product_id;
                $cart_item->count = 1;
                $cart_item->member_id = $member->id;
                $cart_item->save();
            }
            return $m3_result->toJson();
        }
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = $bk_cart != null ? explode(',',$bk_cart) : array();
        $count = 1;
        foreach ($bk_cart_arr as &$v){
            $index = strpos($v,':');
            if(substr($v,0,$index) == $product_id){
                $count = intval(substr($v,$index+1)) + 1;
                $v = $product_id . ':' . $count;
                break;
            }
        }
        if($count == 1){
            array_push($bk_cart_arr,$product_id . ':' . $count);
        }
        return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }
    public function deleteCart(Request $request){
        $product_ids = $request->input('product_ids','');
        $m3_result = new M3Result;
        $m3_result->code = 0;
        $m3_result->msg = '删除成功';


        if(!$product_ids){
            $m3_result->code = 1;
            $m3_result->msg = '书籍id不为空';
            return $m3_result->toJson();
        }
        $product_ids_arr = explode(',',$product_ids);
        //have login
        $member = $request->session()->get('member', '');
        if($member != '') {
            CartItem::whereIn('product_id', $product_ids_arr)->delete();
            return $m3_result->toJson();
        }


        //no login
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = $bk_cart != null ? explode(',',$bk_cart) : array();
        foreach ($bk_cart_arr as $key=>$value) {
            $index = strpos($value,':');
            $product_id = substr($value,0,$index);
            if(in_array($product_id,$product_ids_arr)){
                array_splice($bk_cart_arr,$key,1);
                continue;
            }
        }
        return response($m3_result->toJson())->withCookie('bk_cart',implode(',',$bk_cart_arr));
    }
}













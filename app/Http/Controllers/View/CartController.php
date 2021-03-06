<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:05
 */

namespace App\Http\Controllers\View;

use App\Entity\CartItem;
use App\Entity\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function toCart(Request $request){
        $bk_cart = $request->cookie('bk_cart');
        $bk_cart_arr = $bk_cart != null ? explode(',',$bk_cart) : array();
        $cart_items = array();

        $member = $request->session()->get('member','');
        if($member != ''){
            $cart_items = $this->syncCart($member->id,$bk_cart_arr);
            return response()->view('cart',['cart_items'=>$cart_items])->withCookie('bk_cart',null);
        }

        foreach ($bk_cart_arr as $key=>$value) {
            $index = strpos($value,':');
            $cart_item = new CartItem;
            $cart_item->id = $key;
            $cart_item->product_id = substr($value,0,$index);
            $cart_item->count =(int)substr($value,$index+1);
            $cart_item->product = Product::find($cart_item->product_id);
            if($cart_item->product != null){
                array_push($cart_items,$cart_item);
            }
        }
        $data = array(
            'cart_items'=>$cart_items
        );
        return view('cart',$data);
    }

    public function syncCart($member_id,$bk_cart_arr){
        $cart_items = CartItem::where('member_id',$member_id)->get();
        $cart_items_arr = array();
        foreach ($bk_cart_arr as $value){
            $index = strpos($value,':');
            $product_id = substr($value,0,$index);
            $count = (int)substr($value,$index + 1);
            $exists = false;
            foreach ($cart_items as $temp) {
                if($temp->product_id == $product_id){
                    if($temp->count < $count){
                        $temp->count = $count;
                        $temp->save();
                    }
                    $exists = true;
                    break;
                }
            }
            if($exists == false){
                $cart_item = new CartItem;
                $cart_item->member_id = $member_id;
                $cart_item->product_id = $product_id;
                $cart_item->count = $count;
                $cart_item->save();
                array_push($cart_items_arr,$cart_item);
            }
        }

        foreach ($cart_items as $cart_item) {
            $cart_item->product = Product::find($cart_item->product_id);
            array_push($cart_items_arr,$cart_item);
        }
        return $cart_items_arr;

    }


}
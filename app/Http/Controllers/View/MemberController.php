<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:05
 */

namespace App\Http\Controllers\View;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function toLogin(Request $request){
        $return_url = $request->input('return_url','');
        return view('login')->with('return_url',urldecode($return_url));
    }
    public function toRegister(){
        return view('register');
    }
}
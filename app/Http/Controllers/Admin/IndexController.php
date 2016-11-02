<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:05
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function login(){
        return redirect('admin/index');
    }
    public function toLogin(){
        return view('admin/login');
    }
    public function toIndex(){
        return view('admin/index');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/29
 * Time: 11:04
 */

namespace App\Http\Controllers;


use App\Http\Requests\Request;

class UserController extends Controller
{
    public function index(){
        echo 'index';

    }

    public function get(){
        return 'this is get user';
    }

}
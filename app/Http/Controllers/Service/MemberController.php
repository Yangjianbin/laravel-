<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:05
 */

namespace App\Http\Controllers\Service;

use App\Entity\Member;
use App\Entity\TempPhone;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    public function register(Request $req){
        $phone = $req->input('phone','');
        $password = $req->input('password','');
        $phone_code = $req->input('phone_code','');


        $m3_result = new M3Result();
        //验证 手机验证码
        $tempPhone = TempPhone::where('phone',$phone)->first();
        if($tempPhone->code == $phone_code){
            if(time() > strtotime($tempPhone->deadline)){
                $m3_result->code = 1;
                $m3_result->msg = '验证码错误';
                return $m3_result->toJson();
            }
            $member = new Member;
            $member->phone = $phone;
            $member->password = md5('bk' . $password);
            $member->save();
            $m3_result->code = 0;
            $m3_result->msg = '注册成功';
            return $m3_result->toJson();
        }else{
            $m3_result->code = 1;
            $m3_result->msg = '验证码错误';
            return $m3_result->toJson();
        }

    }

    public function login(Request $req){
        $phone = $req->input('account','');
        $password = $req->input('password','');
        $validate_code = $req->input('validate_code','');
        $m3_result = new M3Result;
        //验证验证码

        $validate_code_session = $req->session()->get('validate_code','');
        if($validate_code != $validate_code_session){
            $m3_result->code = 1;
            $m3_result->msg = '验证码错误';
            return $m3_result->toJson();
        }
        //默认手机登录
        $member = Member::where('phone',$phone)->first();
        if($member == null){
            $m3_result->code = 2;
            $m3_result->msg = '该用户不存在';
            return $m3_result->toJson();
        }else{
            if(md5('bk'.$password) != $member->password){
                $m3_result->code = 3;
                $m3_result->msg = '密码不正确';
                return $m3_result->toJson();
            }
        }

        $req->session()->put('member',$member);

        $m3_result->code = 0;
        $m3_result->msg = '登录成功';
        $req->session()->put('member','');
        return $m3_result->toJson();


    }
}
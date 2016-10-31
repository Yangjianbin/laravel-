<?php

namespace App\Http\Controllers\Service;

use App\Entity\TempPhone;
use App\Http\Controllers\Controller;
use App\Models\M3Result;
use App\Tool\SMS\SendSMS;
use App\Tool\ValidateCode\ValidateCode;
use Illuminate\Http\Request;


class ValidateController extends Controller
{

    public function create(Request $req){
        $validateCode = new ValidateCode();
        $req->session()->put('validate_code',$validateCode->getCode());
        return $validateCode->doimg();
    }

    public function sendSMS(Request $req){
        $m3_result = new M3Result;

        $phone = $req->input('phone','');
        if(!$phone){
            $m3_result->code = 1;
            $m3_result->msg='手机号不为空';
            return $m3_result->toJson();
        }

        $sendSMS = new SendSMS;
        $charset = '12344567890';
        $_len = strlen($charset)-1;
        $code = '';
        for($i=0;$i<6;++$i){
            $code .= $charset[mt_rand(0,$_len)];
        }
        $result = $sendSMS->sendSMS($phone,$code);
        if($result->code ==0){
            $tempPhone = TempPhone::where('phone',$phone)->first();
            if($tempPhone == null){
                $tempPhone = new TempPhone();
            }
            $tempPhone->phone = $phone;
            $tempPhone->code = $code;
            $tempPhone->deadline = date('Y-m-d H:i:s',time() + 24 * 60 * 60);
            $tempPhone->save();
        }
        return $result->toJson();
    }




}

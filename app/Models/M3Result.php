<?php
/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 14:41
 */

namespace App\Models;


class M3Result
{
    public $code;
    public $msg;
    public function toJson(){
        return json_encode($this,JSON_UNESCAPED_UNICODE);
    }
}
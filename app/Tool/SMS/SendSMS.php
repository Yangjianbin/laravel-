<?php

/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/30
 * Time: 11:47
 */

namespace App\Tool\SMS;

use App\Models\M3Result;

class SendSMS
{
    private $encode='UTF-8';

    private $username = 'kuaifa';

    private $password_md5 = '8520be65490ca389b46776db8bcfcb2f';

    private $api_key = '285f07d6d1ffe9ff80f535868762fc75';


    //发送接口
    function sendSMS($mobile='18814888873',$content = '您好，您的验证码是：12345【美联】')
    {
        $url = "http://m.5c.com.cn/api/send/index.php?";
        $data=array
        (
            'username'=>$this->username,
            'password_md5'=>$this->password_md5,
            'apikey'=>$this->api_key,
            'mobile'=>$mobile,
            'content'=>$content,
            'encode'=>$this->encode,
        );
        $result = $this->curlSMS($url,$data);
        $m3_result = new M3Result();

        if(strpos($result,"success")>-1) {
            $m3_result->code = 0;
            $m3_result->msg = '发送成功';
        } else {
            $m3_result->code = 2;
            $m3_result->msg = '发送失败，请稍后再试';
        }
        return $m3_result;
    }
    function curlSMS($url,$post_fields=array())
    {
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_TIMEOUT,30);
        curl_setopt($ch,CURLOPT_HEADER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$post_fields);
        $data = curl_exec($ch);
        curl_close($ch);//释放资源
        $res = explode("\r\n\r\n",$data);
        return $res[2];//"success:90682144766207"
    }

}
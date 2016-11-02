<?php
/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/31
 * Time: 13:43
 */

namespace App\Http\Middleware;
use Closure;

class CheckLogin
{

    public function handle($request,Closure $next){
        $http_referer = @$_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '/';
        $member = $request->session()->get('member','');
        if(!$member){
            return redirect('/login?return_url=' . urlencode($http_referer));
        }
        return $next($request);
    }

}
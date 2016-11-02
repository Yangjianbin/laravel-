<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'View\MemberController@toLogin');

Route::group(['prefix'=>'service'],function(){
    Route::get('validate_code/create', 'Service\ValidateController@create');
    Route::get('validate_phone/send','Service\ValidateController@sendSMS');
    Route::post('register','Service\MemberController@register');
    Route::post('login','Service\MemberController@login');
    Route::any('category/parent_id/{parent_id}','Service\BookController@getCategoryByParentId');
    Route::any('cart/add/{product_id}','Service\CartController@addCart');
    Route::any('cart/delete','Service\CartController@deleteCart');
});

Route::get('/login','View\MemberController@toLogin');
Route::get('/register','View\MemberController@toRegister');
Route::get('/category','view\BookController@toCategory');
Route::get('/product/category_id/{category_id}','view\BookController@toProduct');
Route::get('/product/{product_id}','view\BookController@toPdtContent');
Route::get('/cart','view\CartController@toCart');
Route::group(['middleware'=>['check.login']],function(){
    Route::get('/order_commit/{product_ids}','View\OrderController@toOrderCommit');
    Route::get('/order_list','View\OrderController@toOrderList');
});
Route::group(['prefix'=>'admin'],function (){
    Route::group(['prefix'=>'service'],function (){
        Route::post('login','Admin\IndexController@login');
        Route::post('category/add','Admin\CategoryController@categoryAdd');
        Route::post('category/del','Admin\CategoryController@categoryDel');
        Route::post('category/edit','Admin\CategoryController@categoryEdit');
    });

    Route::get('index', 'Admin\IndexController@toIndex');
    Route::get('category', 'Admin\CategoryController@toCategory');
    Route::get('category_add', 'Admin\CategoryController@toCategoryAdd');
    Route::get('category_edit', 'Admin\CategoryController@toCategoryEdit');
    Route::get('login','Admin\IndexController@toLogin');
});





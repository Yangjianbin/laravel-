<?php
/**
 * Created by PhpStorm.
 * User: youngsun
 * Date: 2016/10/31
 * Time: 12:16
 */

namespace App\Entity;


use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $table = 'cart_item';
    protected $primaryKey = 'id';


}
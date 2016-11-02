<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $timestamps = false;
    protected $table = 'order_item';
    protected $primaryKey = 'id';



}

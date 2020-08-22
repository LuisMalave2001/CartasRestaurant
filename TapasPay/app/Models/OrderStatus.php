<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderStatus extends Model{

//    use SoftDeletes;
    protected $table = 'order_status';

    public static $PENDING = 1;
    public static $IN_PROGRESS = 2;
    public static $READY = 3;
    public static $DELIVERED = 4;
    public static $PAID = 5;
    public static $CANCELLED = 6;

    /* One2many relations */
    public function order_lines()
    {
        return $this->hasMany(OrderLine::class, 'order_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'order_id');
    }


}

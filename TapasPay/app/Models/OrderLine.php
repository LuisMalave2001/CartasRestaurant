<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderLine extends Model{

    use SoftDeletes;
    protected $table = 'order_lines';

    public $PENDING = 1;
    public $IN_PROGRESS = 2;
    public $READY = 3;
    public $DELIVERED = 4;

    /* Many2one relations */
    public function order_lines()
    {
        return $this->belongsTo(OrderSession::class, 'order_id');
    }

}

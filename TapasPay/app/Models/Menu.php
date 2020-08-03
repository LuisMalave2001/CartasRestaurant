<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    protected $table = 'menus';

    /* ManyTomany relations */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'menu_product');
    }

}

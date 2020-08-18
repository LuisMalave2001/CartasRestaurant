<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarteMenu extends Model
{
    use SoftDeletes;
    protected $table = 'carte_menus';

    /* ManyTomany relations */
    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'carte_menu_product');
    }

    public function menus()
    {
        return $this->belongsToMany('App\Models\Menu', 'carte_menu_menu');
    }

}

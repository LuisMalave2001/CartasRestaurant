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

    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopeActive($query) {
        return $query->where('active', 1);
    }
}

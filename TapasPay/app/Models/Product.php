<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{

    use SoftDeletes;
    public function establishment()
    {
        return $this->hasMany('App\Models\Establishment');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    // Scopes
    public function scopeActive($query) {
        return $query->where('active', 1);
    }

    protected $table = 'products';
}

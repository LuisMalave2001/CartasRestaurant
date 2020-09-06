<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    public function establishment()
    {
        return $this->belongsTo('App\Models\Establishment');
    }

    protected $table = 'categories';
}

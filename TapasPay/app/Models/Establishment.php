<?php

namespace App\Models;

use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\CarteMenu;

class Establishment extends Model
{
    use SoftDeletes;

    function getTables() {

        $number_of_tables = $this->number_of_tables;

        $tables = [];
        for ($i = 1; $i <= $number_of_tables; $i++) {

            $url = Hashids::encode($this->id, $i);

//            $url = "foo" . intval($i, 10);
            $number = $i;
            $table = new Table($number, $url);
            $tables[$url] = $table;
        }

        return $tables;

    }

    public function carte_menus()
    {
        return $this->hasMany(CarteMenu::class, 'establishment_id');
    }

    protected $table = 'establishments';
}

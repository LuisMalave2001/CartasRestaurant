<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;
use App\Models\CarteMenu;

class TableShoppingController extends Controller
{

    public function showCarteMenuList(Request $request, string $tableHashId) {

        // The position 0 is the establishment and the position 1 is the table number
        $decodedTableHashId = Hashids::decode($tableHashId);

        $establishment = Establishment::find($decodedTableHashId[0]);
        $numberOfTable = $decodedTableHashId[1];
        $carte_menus = $establishment->carte_menus;

        return view("pages.shopping.establishment_items", ["carte_menus" => $carte_menus]);
    }

}

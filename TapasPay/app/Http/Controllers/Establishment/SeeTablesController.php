<?php

namespace App\Http\Controllers\Establishment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeeTablesController extends Controller
{

    function __invoke()
    {
        $user_current_establishment = auth()->user()->getSessionCurrentEstablishment();

        $tables = $user_current_establishment->getTables();

        return view("pages.establishment_edit.see_tables", ["tables" => $tables]);
    }
}


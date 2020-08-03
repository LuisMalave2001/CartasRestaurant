<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PhotoController extends Controller
{
   public function holaFormVerify(Request $request){
        if ($request->input("age", 0) > 18){
            return view("mayor");
        }
        $request->flashOnly(["username", "age"]);
        /* $request->flash(""); */
        /* $request->flash("password"); */
        return view("hola_form");
   }
}

<?php

namespace App\Http\Controllers\Establishment;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EstablishmentController extends Controller
{

    function editView(){
//        $request->post("");
        return view("pages.establishment_edit.establishment_edit");
    }

    function update(Request $request, int $id) {

        $establishment = Establishment::find($id);

        if ($request->has("name")) {
            $name = $request->post("name");
            $establishment->name = $name;
        }

        if ($request->has("number_of_tables")) {
            $number_of_tables = $request->post("number_of_tables");
            $establishment->number_of_tables = $number_of_tables;
        }

        if ($request->has("table_message")) {
            $table_message = $request->post("table_message");
            $establishment->table_message = $table_message;
        }

        $establishment->save();

        return redirect("/");
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function change(Request $request, $id)
    {
        $new_establishment = Establishment::find($id);

        $request->session()->put('user_current_establishment', $new_establishment);
        return "Success";
    }
}
?>

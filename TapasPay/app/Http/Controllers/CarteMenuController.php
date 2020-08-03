<?php

namespace App\Http\Controllers;

use App\Models\CarteMenu;
use Illuminate\Http\Request;

class CarteMenuController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(Request $request)
    {

        $user_current_establishment = session()->get("user_current_establishment");

        $carteMenu = new CarteMenu();
        $carteMenu->name = $request->input('name') ?: 'New carte menu';
        $carteMenu->establishment_id = $user_current_establishment->id;
        $carteMenu->save();

        return redirect('/');
    }

    public function remove(Request $request, int $id)
    {
        CarteMenu::find($id)->delete();
        return redirect('/');
    }

    public function update(Request $request, int $id)
    {

        $carteMenu = CarteMenu::find($id);

        $carteMenu->name = $request->input('name') ?: $carteMenu->name;
        $carteMenu->save();

        return redirect('/');
    }
}
?>

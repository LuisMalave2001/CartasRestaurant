<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Menu;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuController extends Controller
{
    use SoftDeletes;
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

        $menu = new Menu();
        $menu->name = $request->input('name') ?: 'Default menu';
        $menu->price = floatval($request->input('price') ?: 0.0);
        $menu->establishment_id = $user_current_establishment->id;
        $menu->save();

        return redirect('/');
    }

    public function remove(Request $request, int $id)
    {
        Menu::find($id)->delete();
        return redirect('/');
    }

    public function update(Request $request, int $id)
    {

        $menu = Menu::find($id);

        $menu->name = $request->input('name') ?: $menu->name;
        $menu->price = floatval($request->input('price')) ?: $menu->price;
        $menu->save();

        return redirect('/');
    }
}
?>

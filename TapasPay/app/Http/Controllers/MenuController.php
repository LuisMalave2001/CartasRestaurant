<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Menu;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;

// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $user_current_establishment = auth()->user()->getSessionCurrentEstablishment();

        $menu = new Menu();
        $menu->name = $request->input('name') ?: 'Default menu';
        $menu->description = $request->input('description') ?: '';
        $menu->price = floatval($request->input('price') ?: 0.0);
        $menu->establishment_id = $user_current_establishment->id;
        $menu->category_id = $request->input('category_id') ?: null;
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

        if ($request->has("menu_image")) {
            $path = $request->file("menu_image")->store("public/images/menu");
            $menu->image_path = Storage::url($path);;
        }

        $menu->name = $request->input('name') ?: $menu->name;
        $menu->price = floatval($request->input('price')) ?: $menu->price;
        $menu->description = $request->input('description') ?: $menu->description;
        $menu->category_id = $request->input('category_id') ?: null;

        $menu->save();

        return redirect('/');
    }

    public function updateProductRelations(Request $request)
    {

        $newProductRelations = $request->json();

        if ($newProductRelations) {
            foreach ($newProductRelations as $menuId => $productIds) {
                if (empty($productIds)) {
                    Menu::find($menuId)->products()->detach();
                } else {
                    Menu::find($menuId)->products()->sync($productIds);
                }
            }
        }

        return response("success", 200);
    }
}

?>

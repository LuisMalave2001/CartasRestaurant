<?php

namespace App\Http\Controllers;

use App\Models\CarteMenu;
use App\Models\Menu;
use App\Models\Product;
use Illuminate\Http\Request;

class MenuSetupController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $products = [];
        $menus = [];
        $carte_menus = [];

        if (session()->has('user_current_establishment')) {
            $current_establishment = session()->get('user_current_establishment');
            $products = Product::where('establishment_id', $current_establishment->id)
                                ->orderBy('name')
                                ->orderBy('price')
                                ->get();


            $menus = Menu::where('establishment_id', $current_establishment->id)
                           ->orderBy('name', 'asc')
                           ->orderBy('price', 'desc')
                           ->get();

            $carte_menus = CarteMenu::where('establishment_id', $current_establishment->id)
                            ->orderBy('name', 'asc')
                            ->get();

        }
        return view('settings.menu_setup', [
            'products' => $products,
            'menus' => $menus,
            'carte_menus' => $carte_menus,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\CarteMenu;
use Illuminate\Http\Request;

class ChooseMenuController extends Controller
{
    function showMenuList(Request $request) {

        $current_establishment = session()->get('user_current_establishment');
        $carte_menus = CarteMenu::where('establishment_id', $current_establishment->id)
            ->orderBy('name', 'asc')
            ->get();

        $default_empty_list = serialize([]);
        $product_amount = unserialize($request->cookie("product_items_count", $default_empty_list));
        $menu_amount = unserialize($request->cookie("menu_items_count", $default_empty_list));

        return view("pages.choose_menus.show_list", [
            "carte_menus" => $carte_menus,
            "product_amount" => $product_amount,
            "menu_amount" => $menu_amount,
        ]);
    }

    function updateShoppingItems(Request $request) {

//        $current_establishment = session()->get('user_current_establishment');

        $product_amounts = $request->product_amount;
        $product_ids = $request->product_id;
        $menu_amounts = $request->menu_amount;
        $menu_ids = $request->menu_id;

        $menu_items_count = [];
        $product_items_count = [];

        foreach($product_amounts as $pos=>$amount) {
            $product_id = $product_ids[$pos];
            $product_items_count[$product_id] = $amount;
        }

        foreach($menu_amounts as $pos=>$amount) {
            $menu_id = $menu_ids[$pos];
            $menu_items_count[$menu_id] = $amount;
        }

        $minutes = 60 * 4;

        $cookie_menu_items_count = cookie('menu_items_count', serialize(    $menu_items_count), $minutes);
        $cookie_product_items_count = cookie('product_items_count', serialize($product_items_count), $minutes);

        return redirect(route("choose_menu"))->withCookies([$cookie_menu_items_count, $cookie_product_items_count]);
    }
}

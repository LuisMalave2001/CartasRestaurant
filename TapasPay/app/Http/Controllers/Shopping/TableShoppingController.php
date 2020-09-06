<?php

namespace App\Http\Controllers\Shopping;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Order;
use Illuminate\Support\Facades\Cookie;
use Vinkla\Hashids\Facades\Hashids;
use Illuminate\Http\Request;
use App\Models\CarteMenu;

class TableShoppingController extends Controller
{

    public function addCookieOrderLine(Request $request, string $tableHashId)
    {

        // The position 0 is the establishment and the position 1 is the table number
        $oneDayInMinutes = 60 * 24;
//        $decodedTableHashId = Hashids::decode($tableHashId);
//
//        $establishment = Establishment::find($decodedTableHashId[0]);
//        $numberOfTable = $decodedTableHashId[1];
//        $carte_menus = $establishment->carte_menus;

        $default_empty_list = serialize([]);
        $order_line_list = unserialize($request->cookie("order_line_list-$tableHashId", $default_empty_list));

        $order_line_list[] = (object) [
            'name' => $request->input('name'),
            'res_id' => $request->input('res_id'),
            'res_table' => $request->input('res_table'),
            'total_price' => $request->input('total_price'),
            'unit_price' => $request->input('unit_price'),
            'note' => $request->input('note'),
            'item_units' => $request->input('item_units'),
        ];

        $cookie_menu_items_count = cookie("order_line_list-$tableHashId", serialize($order_line_list), $oneDayInMinutes);

        return redirect(route("table_shopping", ["tableHashId" => $tableHashId]))->withCookies([$cookie_menu_items_count]);

    }

    public function showCarteMenuList(Request $request, string $tableHashId) {

        // The position 0 is the establishment and the position 1 is the table number
        list($establishment, $numberOfTable) = $this->extractHashIdValues($tableHashId);
        $carte_menus = $establishment->carte_menus;

        $pendingOrders = Order::where([
            ['establishment_id', '=', $establishment->id],
            ['number_of_table', '=', $numberOfTable],
            ['order_status_id', '<>', Order::$PAID],
        ])->get();

        $default_empty_list = serialize([]);
        $order_line_list = unserialize($request->cookie("order_line_list-$tableHashId", $default_empty_list));

        return view('pages.shopping.establishment_items',
            [
                'tableHashId' => $tableHashId,
                'carte_menus' => $carte_menus,
                'pending_orders' => $pendingOrders,
                'number_of_table' => $numberOfTable,
                'order_line_list' => $order_line_list,
            ]);
    }

    public function showClientOrderList(Request $request, string $tableHashId) {

        // The position 0 is the establishment and the position 1 is the table number
        list($establishment, $numberOfTable) = $this->extractHashIdValues($tableHashId);
        $carte_menus = $establishment->carte_menus;


        $pendingOrders = Order::where([
            ['establishment_id', '=', $establishment->id],
            ['number_of_table', '=', $numberOfTable],
            ['order_status_id', '<>', Order::$PAID],
        ])->get();

        return view('pages.shopping.client_order_list',
            [
                'tableHashId' => $tableHashId,
                'carte_menus' => $carte_menus,
                'orders' => $pendingOrders,
                'number_of_table' => $numberOfTable,
            ]);

    }

    public function showClientCurrentShoppingCart(Request $request, string $tableHashId) {

        list($establishment, $numberOfTable) = $this->extractHashIdValues($tableHashId);


        $default_empty_list = serialize([]);
        $cartOrderList = unserialize($request->cookie("order_line_list-$tableHashId", $default_empty_list));

        return view('pages.shopping.shopping_cart',
            [
                'tableHashId' => $tableHashId,
                'number_of_table' => $numberOfTable,
                'cartOrderList' => $cartOrderList,
            ]);

    }

    public function updateOrderLine(Request $request, string $tableHashId, int $orderLineIndex) {

        $oneDayInMinutes = 60 * 24;

        $default_empty_list = serialize([]);
        $cartOrderList = unserialize($request->cookie("order_line_list-$tableHashId", $default_empty_list));
        if (isset($cartOrderList[$orderLineIndex])){

            $cartOrderList[$orderLineIndex]->note = (isset($request->note) && $request->note) ? $request->note : $cartOrderList[$orderLineIndex]->note;

            if (isset($request->item_units) && $request->item_units) {
                $cartOrderList[$orderLineIndex]->item_units = $request->item_units;
                $cartOrderList[$orderLineIndex]->total_price = floatval($cartOrderList[$orderLineIndex]->unit_price) * floatval($request->item_units);
            }

//            $cartOrderList[$orderLineIndex]->item_units = (isset($request->item_units) && $request->item_units) ?  : $cartOrderList[$orderLineIndex]->item_units;

        }

        return response("success", 200)->cookie("order_line_list-$tableHashId", serialize($cartOrderList), $oneDayInMinutes);

    }


    public function deleteOrderLine(Request $request, string $tableHashId, int $orderLineIndex) {

        $oneDayInMinutes = 60 * 24;

        $default_empty_list = serialize([]);
        $cartOrderList = unserialize($request->cookie("order_line_list-$tableHashId", $default_empty_list));

        if (isset($cartOrderList[$orderLineIndex])) {
            unset($cartOrderList[$orderLineIndex]);
        }

        return response("success", 200)->cookie("order_line_list-$tableHashId", serialize($cartOrderList), $oneDayInMinutes);
    }

    /**
     * @param string $tableHashId
     * @return array
     */
    public function extractHashIdValues(string $tableHashId): array
    {
// The position 0 is the establishment and the position 1 is the table number
        $decodedTableHashId = Hashids::decode($tableHashId);

        $establishment = Establishment::find($decodedTableHashId[0]);
        $numberOfTable = $decodedTableHashId[1];
        return array($establishment, $numberOfTable);
    }


}

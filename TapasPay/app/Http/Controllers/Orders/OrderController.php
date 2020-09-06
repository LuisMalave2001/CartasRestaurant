<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Order;
use App\Models\OrderLine;
use App\Models\OrderSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Vinkla\Hashids\Facades\Hashids;

class OrderController extends Controller
{
    //

    function submitOrder(Request $request, $tableHashId)
    {

        try {
            // The position 0 is the establishment and the position 1 is the table number
            $decodedTableHashId = Hashids::decode($tableHashId);

            $establishment = Establishment::find($decodedTableHashId[0]);
            $numberOfTable = $decodedTableHashId[1];

            $default_empty_list = serialize([]);
            $cartOrderList = unserialize($request->cookie("order_line_list-$tableHashId", $default_empty_list));

            if (count($cartOrderList) > 0) {

                // First, we check if the user has an opened session
                $user = Auth::user();
                $orderSession = $user->orderSessions()->where("opened", "=", true)->first();

                if (!$orderSession) {
                    $orderSession = new OrderSession();

                    $orderSession->opened = true;
                    $orderSession->user_id = $user->id;
                    $orderSession->open_date = now();
                    $orderSession->tableHashId = $tableHashId;

                    $orderSession->save();
                }

                $order = new Order();
                $order->establishment_id = $establishment->id;
                $order->number_of_table = $numberOfTable;
                $order->order_session_id = $orderSession->id;
                $order->order_status_id = Order::$PENDING;
                $order->save();

                foreach ($cartOrderList as $cartOrder) {

                    $order_line = new OrderLine();

                    $order_line->product_name = $cartOrder->name;
                    $order_line->note = $cartOrder->note;
                    $order_line->price_unit = $cartOrder->unit_price;
                    $order_line->quantity = $cartOrder->item_units;
                    $order_line->res_id = $cartOrder->res_id;
                    $order_line->res_table = $cartOrder->res_table;
                    $order_line->order_status_id = Order::$PENDING;

                    $order_line->order_id = $order->id;

                    $order_line->save();
                }

            }
            $cookie_menu_items_count = cookie("order_line_list-$tableHashId", serialize([]), 24 * 60);

            return redirect(route("table_shopping", ["tableHashId" => $tableHashId]))->withCookies([$cookie_menu_items_count]);

        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    function getAllPendingOrders()
    {
        $pendingOrders = OrderSession::where('order_status_id', '<>', OrderSession::$DELIVERED)->get();
        return $pendingOrders;
    }

    function getAllTableOrders(Request $request, $tableHashId)
    {
        // The position 0 is the establishment and the position 1 is the table number
        $decodedTableHashId = Hashids::decode($tableHashId);

        $establishment = Establishment::find($decodedTableHashId[0]);
        $numberOfTable = $decodedTableHashId[1];

        $pendingOrders = OrderSession::where([
            ['establishment_id', '=', $establishment->id],
            ['number_of_table', '=', $numberOfTable],
            ['order_status_id', '<>', OrderSession::$PAID],
        ])->get();

        return $pendingOrders;
    }

    function changeStatus(Request $request, int $order_id)
    {
//        $order_id = $request->input('order_id');
        $new_status_id = $request->input('status_id');

        $order = OrderSession::find($order_id);
        $order->order_status_id = $new_status_id;
        $order->save();
    }

}

<?php

namespace App\Http\Controllers\Orders;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Order;
use Illuminate\Http\Request;
use Vinkla\Hashids\Facades\Hashids;

class OrderController extends Controller
{
    //

    function sendOrder(Request $request, $tableHashId)
    {

        try {

            // The position 0 is the establishment and the position 1 is the table number
            $decodedTableHashId = Hashids::decode($tableHashId);

            $establishment = Establishment::find($decodedTableHashId[0]);
            $numberOfTable = $decodedTableHashId[1];

            $order = new Order();

            $order->establishment_id = $establishment->id;
            $order->number_of_table = $numberOfTable;
            $order->order_status_id = Order::$PENDING;

            // Insert order lines

            $order->save();

            return response("", 200);

        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    function getAllPendingOrders()
    {
        $pendingOrders = Order::where('order_status_id', '<>', Order::$DELIVERED)->get();
        return $pendingOrders;
    }

    function getAllTableOrders(Request $request, $tableHashId)
    {
        // The position 0 is the establishment and the position 1 is the table number
        $decodedTableHashId = Hashids::decode($tableHashId);

        $establishment = Establishment::find($decodedTableHashId[0]);
        $numberOfTable = $decodedTableHashId[1];

        $pendingOrders = Order::where([
            ['establishment_id', '=', $establishment->id],
            ['number_of_table', '=', $numberOfTable],
            ['order_status_id', '<>', Order::$PAID],
        ])->get();

        return $pendingOrders;
    }

    function changeStatus(Request $request, int $order_id)
    {
//        $order_id = $request->input('order_id');
        $new_status_id = $request->input('status_id');

        $order = Order::find($order_id);
        $order->order_status_id = $new_status_id;
        $order->save();
    }

}

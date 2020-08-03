<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Product;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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

        $product = new Product();
        $product->name = $request->input('name') ?: 'Default product';
        $product->price = floatval($request->input('price') ?: 0.0);
        $product->establishment_id = $user_current_establishment->id;
        $product->save();

        return redirect('/');
    }

    public function remove(Request $request, int $id)
    {
        Product::find($id)->delete();
        return response('success', 200);
    }

    public function update(Request $request, int $id)
    {

        $product = Product::find($id);

        $product->name = $request->input('name') ?: $product->name;
        $product->price = floatval($request->input('price')) ?: $product->price;
        $product->save();

        return redirect('/');
    }
}
?>

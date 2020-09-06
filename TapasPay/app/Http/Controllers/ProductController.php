<?php

namespace App\Http\Controllers;

use App\Models\Establishment;
use App\Models\Product;
use Illuminate\Http\Request;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $user_current_establishment = auth()->user()->getSessionCurrentEstablishment();

        $product = new Product();

        if ($request->has("product_image")) {
            $path = $request->file("product_image")->store("public/images/product");
            $product->image_path = Storage::url($path);;
        }

        $product->name = $request->input('name') ?: 'Default product';
        $product->price = floatval($request->input('price') ?: 0.0);
        $product->establishment_id = $user_current_establishment->id;
        $product->description = $request->input('description') ?: '';
        $product->category_id = $request->input('category_id') ?: null;
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

        if ($request->has("product_image")) {
            $path = $request->file("product_image")->store("public/images/product");
            $product->image_path = Storage::url($path);;
        }

        $product->name = $request->input('name') ?: $product->name;
        $product->price = floatval($request->input('price')) ?: $product->price;
        $product->description = $request->input('description') ?: $product->description;
            $product->category_id = $request->input('category_id') ?: null;

        $product->save();

        return redirect('/');
    }
}
?>

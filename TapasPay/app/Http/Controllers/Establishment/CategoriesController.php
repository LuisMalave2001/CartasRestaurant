<?php

namespace App\Http\Controllers\Establishment;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Establishment;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoriesController extends Controller
{
    //
    function deleteCategory(Request $request, Category $category) {
        try {
            $category->delete();
        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
        return response('ok', 200);
    }

    function setCategoryParams(Category $category, array $values) {
        $category->establishment_id = $values["establishment_id"];
        $category->name = $values["name"];
        $category->is_global = $values["is_global"];
    }

    function getCategoriesPage (Request $request, Establishment $establishment_id) {
        $establishment = Auth::user()->getSessionCurrentEstablishment();
        $categories = $establishment->getCategories();
        return view("pages.establishment_edit.see_categories", [
            "categories" => $categories
        ]);

    }

    function createCategory(Request $request) {

            $category = new Category();

        $values = [
            "establishment_id" => $request->post("establishment_id"),
            "name" => $request->post("name"),
            "is_global" => $request->has("is_global"),
        ];

        $this->setCategoryParams($category, $values);

        $category->save();

        return redirect(route("see_categories", ['establishment_id' => $request->post("establishment_id")]));
    }

    function updateCategory(Request $request) {
        $id = $request->post("category_id");
        $category = Category::find($id);

        $values = [
            "establishment_id" => $request->post("establishment_id"),
            "name" => $request->post("name"),
            "is_global" => $request->has("is_global"),
        ];

        $this->setCategoryParams($category, $values);
        $category->save();
        return redirect(route("see_categories", ['establishment_id' => $request->post("establishment_id")]));
    }

}

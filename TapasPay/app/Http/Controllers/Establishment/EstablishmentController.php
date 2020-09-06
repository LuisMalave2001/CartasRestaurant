<?php

namespace App\Http\Controllers\Establishment;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EstablishmentController extends Controller
{

    function editView(){
        return view('pages.establishment_edit.establishment_edit');
    }

    function update(Request $request, int $id) {

        $establishment = Establishment::find($id);
        $this->setEstablishmentFields($request, $establishment);
        $establishment->save();

        return redirect(route('edit_establishment_form'));
    }

    function create(Request $request) {

        $establishment = new Establishment();
        $this->setEstablishmentFields($request, $establishment);
        $establishment->save();
        auth()->user()->establishments()->attach($establishment->id);

        return redirect(route('edit_establishment_form'));
    }

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
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    public function change(Request $request, $id)
    {
        $new_establishment = Establishment::find($id);
        $request->session()->put('user_current_establishment', $new_establishment);
        return response('Success', 200);
    }

    /**
     * @param Request $request
     * @param Establishment $establishment
     */
    public function setEstablishmentFields(Request $request, Establishment $establishment): void
    {
        if ($request->has('name')) {
            $name = $request->post('name');
            $establishment->name = $name;
        }

        if ($request->has('number_of_tables')) {
            $number_of_tables = $request->post('number_of_tables');
            $establishment->number_of_tables = $number_of_tables;
        }

        if ($request->has('table_message')) {
            $table_message = $request->post('table_message');
            $establishment->table_message = $table_message;
        }

        if ($request->has('parent_id')) {
            $parent_id = intval($request->post('parent_id'));
            $establishment->parent_id = $parent_id == -1 ? null : $parent_id;
        }
    }
}

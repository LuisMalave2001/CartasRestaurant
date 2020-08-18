@extends('layouts.app');

@section("content")

    <?php $current_establishment = Session::get("user_current_establishment");  ?>

    <section class="container">
        <form method="post" action="{{ route("edit_establishment_update", ["establishment_id" => $current_establishment->id]) }}">
            @csrf
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">{{ __("establishment_edit.name") }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name"
                           value="{{ $current_establishment->name }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">{{ __("establishment_edit.number_of_tables") }}</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="number_of_tables"
                           value="{{ $current_establishment->number_of_tables }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label">{{ __("establishment_edit.table_message") }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="table_message" value="{{ $current_establishment->table_message }}">
                </div>
            </div>

            <div class="row align-items-center justify-content-center">
                <a href="{{ route("see_tables") }}" class="btn btn-info" role="button"> {{ __("establishment_edit.see_tables") }} </a>
            </div>

            <button class="btn" type="Submit">Submit</button>
        </form>
    </section>

@endsection

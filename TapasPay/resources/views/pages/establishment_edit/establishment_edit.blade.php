@extends('layouts.app')

@section("content")

    <?php $current_establishment = auth()->user()->getSessionCurrentEstablishment()  ?>
    <?php $current_establishment->refresh()  ?>

    <section class="container">
        <form method="post" action="{{ route("edit_establishment_update", ["establishment_id" => 1]) }}">
            @csrf
            <div class="form-group row">
                <label for="staticEmail" class="col-sm-2 col-form-label">{{ __("establishment_edit.name") }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name"
                           value="{{ $current_establishment->name }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword"
                       class="col-sm-2 col-form-label">{{ __("establishment_edit.number_of_tables") }}</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="number_of_tables"
                           value="{{ $current_establishment->number_of_tables }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputPassword"
                       class="col-sm-2 col-form-label">{{ __("establishment_edit.table_message") }}</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="table_message"
                           value="{{ $current_establishment->table_message }}">
                </div>
            </div>

            <div class="form-group row">
                <label for="category-modal-parent_establishment"
                       class="col-sm-2 col-form-label">{{ __("establishment_edit.parent_establishment") }}</label>
                <div class="col-sm-10">
                    <select type="text" class="form-control" name="parent_id" id="category-modal-parent_establishment"
                            aria-describedby="categoryHelp">
                        <option selected="selected" value="-1">- {{ __('establishment_edit.no_parent_establishment') }} -</option>
                        @foreach(auth()->user()->establishments->sortBy('name') as $auxEstablishment)
                            @if($current_establishment->parent
                                && $current_establishment->parent->id == $auxEstablishment->id)
                                <option value="{{ $auxEstablishment->id }}" selected="selected">{{ $auxEstablishment->name }}</option>
                            @else
                                <option value="{{ $auxEstablishment->id }}">{{ $auxEstablishment->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mt-4  align-items-center justify-content-around">
                <!-- See tables -->
                <a href="{{ route("see_tables") }}" class="btn btn-info"
                   role="button"> {{ __("establishment_edit.see_tables") }} </a>


                <!-- See tables -->
                <a href="{{ route("see_categories", ['establishment_id' => $current_establishment->id]) }}" class="btn btn-info"
                   role="button"> {{ __("establishment_edit.see_categories") }} </a>

                <!-- Create establishment -->
                <button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#js-create-establishment-modal">
                    {{ __("establishment_edit.create_establishment") }}
                </button>

                <!-- Create user -->
                <a href="#" class="btn btn-secondary" role="button">
                    {{ __("establishment_edit.create_user") }} <i style="color: #d39e00"
                                                                  class="fa fa-exclamation-triangle"></i>
                </a>

                <!-- Security groups -->
                <a href="#" class="btn btn-secondary" role="button">
                    {{ __("establishment_edit.security_groups") }} <i style="color: #d39e00"
                                                                      class="fa fa-exclamation-triangle"></i>
                </a>
            </div>

            <div class="row mt-4 align-items-center justify-content-center">
                <button class="btn btn-outline-primary" type="Submit">Submit</button>
            </div>
        </form>
    </section>

@endsection

<div id="js-create-establishment-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" id="js_category_form" action="{{ route('create_establishment') }}">
                @csrf
                <div class="modal-body">
                    <section class="container-fluid">
                        <div class="form-group">
                            <label
                                for="category-modal-category_name">{{ __('establishment_edit.establishment_name') }}</label>
                            <input type="text" class="form-control" name="name" id="modal-establishment-name"
                                   aria-describedby="categoryHelp">
                        </div>

                        <div class="form-group">
                            <label
                                for="modal-establishment-number_of_table">{{ __('establishment_edit.number_of_tables') }}</label>
                            <input type="text" class="form-control" name="number_of_tables"
                                   id="modal-establishment-number_of_table" aria-describedby="categoryHelp">
                        </div>

                        <div class="form-group">
                            <label
                                for="modal-establishment-table-message">{{ __('establishment_edit.table_message') }}</label>
                            <input type="text" min="0" class="form-control" name="table_message"
                                   id="modal-establishment-table-message" aria-describedby="categoryHelp">
                        </div>

                        <div class="form-group">
                            <label
                                for="category-modal-is_global">{{ __('establishment_edit.parent_establishment') }}</label>
                            <select type="text" class="form-control" name="parent_id" id="category-modal-category_name"
                                    aria-describedby="categoryHelp">
                                <option selected="selected" value="-1">
                                    - {{ __('establishment_edit.no_parent_establishment') }} -
                                </option>
                                @foreach(auth()->user()->establishments->sortBy('name') as $auxEstablishment)
                                    {{--                                    {{ $auxEstablishment }}--}}
                                    <option value="{{ $auxEstablishment->id }}">{{ $auxEstablishment->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </section>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"
                            class="btn btn-primary loading-on-click">{{ __('establishment_edit.create_establishment') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>

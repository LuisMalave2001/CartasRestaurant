
@extends('layouts.app')

@section("content")
    <?php $current_establishment = auth()->user()->getSessionCurrentEstablishment() ?>

    <section class="container js_category_page">
        <div class="row">
            <div class="col text-center">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#js-category-modal">
                    Añadir categoría
                </button>
            </div>
        </div>
        <div class="row">
            <table id="products" class="table table-hover">
                <thead>
                    <th>{{ __('menu_setup.name') }}</th>
                    <th class="text-center">{{ __('menu_setup.actions') }}</th>
                </thead>
                <tbody>
                @foreach ($categories->sortBy('name') as $category)
                    <tr id="category-{{ $category->id }}"
                        data-id="{{ $category->id }}"
                        data-name="{{ $category->name }}"
                        data-is-global="{{ $category->is_global }}"
                    >
                        <!-- Fields -->
                        <td class="product-name">{{ $category->name }}</td>

                        <!-- Actions -->
                        <td class="product-action">
                            <div class="">
                                <a class="nav-link dropdown-toggle text-right" href="#"
                                   id="product-action-dropdown-{{ $category->id }}" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">{{ __('menu_setup.actions') }}</a>
                                <ul class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="product-action-dropdown-{{ $category->id }}">
                                    <li>
                                        <button class="dropdown-item btn-edit-category" href="#" data-target="category-{{ $category->id }}">Edit</button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item btn-remove-category" href="#" data-id="{{ $category->id }}">Remove</button>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

<div id="js-category-modal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="POST" id="js_category_form" action="{{ route('submit_categories', ["establishment_id" => $current_establishment->id]) }}">
                @csrf
                @method('POST')
                <input type="hidden" name="establishment_id" value="{{ $current_establishment->id }}"/>
                <div class="modal-body">
                    <section class="container-fluid">

                        <div class="form-group">
                            <label for="category-modal-category_name">Nombre de la categoría</label>
                            <input type="text" class="form-control" name="name" id="category-modal-category_name" aria-describedby="categoryHelp">
                            <small id="categoryHelp" class="form-text text-muted">Categoría del producto</small>
                        </div>
                        <div class="form-group">
                            <label for="category-modal-is_global">Global</label>
                            <input type="checkbox" name="is_global" class="form-control" id="category-modal-is_global" >
                        </div>
                    </section>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit"
                            class="btn btn-primary loading-on-click">{{ __('shopping.add_to_cart') }}</button>
                </div>
            </form>

        </div>
    </div>
</div>

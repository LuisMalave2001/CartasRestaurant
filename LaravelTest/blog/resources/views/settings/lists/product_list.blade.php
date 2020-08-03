<div class="row justify-content-around mt-4">
    <div class="container-fluid">
        <div class="row">
            <b class="h2 col-4">{{ __('menu_setup.products') }}</b>
            <span class="col-8 text-center d-inline-block text-center">
                <button id="btn-add-product"
                    class="btn btn-add-element text-center mb-3">{{ __('menu_setup.add_product') }}</button>
            </span>
        </div>
        <table id="products" class="table table-hover">
            <thead>
                <th colspan="2">{{ __('menu_setup.name') }}</th>
                <th class="d-none d-sm-table-cell">{{ __('menu_setup.price') }}</th>
                <th class="text-center">{{ __('menu_setup.actions') }}</th>
            </thead>
            <tbody>
                @foreach ($products as $product)
                    <tr data-id="{{ $product->id }}">
                        <td class="handle text-center"><i class="fa fa-arrows"></i></td>

                        <!-- Fields -->
                        <td class="product-name col-5">{{ $product->name }}</td>
                        <td class="product-price d-none d-sm-table-cell col col-sm-4">{{ $product->price }}</td>

                        <!-- Actions -->
                        <td class="col-4">
                            <div class="">
                                <a class="nav-link dropdown-toggle text-right" href="#"
                                    id="product-action-dropdown-{{ $product->id }}" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Actions</a>
                                <ul class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="product-action-dropdown-{{ $product->id }}">
                                    <li><button class="dropdown-item btn-edit-product" href="#">Edit</button></li>
                                    <li><button class="dropdown-item btn-remove-product" href="#">Remove</button></li>
                                    <li><button class="dropdown-item btn-toggle-product" href="#">Hide</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

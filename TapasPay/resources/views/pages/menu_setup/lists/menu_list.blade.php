<div class="row justify-content-around mt-4">
    <div class="container-fluid">
        <div class="row">
            <b class="h2 col-12 col-md-4 text-center">{{ __('menu_setup.menus') }}</b>
            <div class="col-12 col-md-4 text-center d-inline-block text-center">
                <button id="btn-add-menu"
                    class="btn btn-add-element text-center mb-3 w-100">{{ __('menu_setup.add_menu') }}</button>
            </div>
            <div class="col-12 col-md-4 text-center d-inline-block text-center" >
                <button id="btn-save-menu-list"
                        class="btn btn-add-element text-center mb-3 w-100" disabled>{{ __('menu_setup.save') }}</button>
            </div>
        </div>
        <table id="menus" class="table table-hover">
            <thead>
                <th>{{ __('menu_setup.name') }}</th>
                <th class="d-none d-sm-table-cell">{{ __('menu_setup.price') }}</th>
                <th class="text-center">{{ __('menu_setup.actions') }}</th>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr data-id="{{ $menu->id }}" data-img-url="{{ $menu->image_path }}" class="js-menu-product-properties">

                        <!-- fields -->
                        <td class="menu-name">{{ $menu->name }}</td>
                        <td class="menu-price d-none d-sm-table-cell">{{ $menu->price }}</td>

                        <!-- Actions -->
                        <td class="menu-action">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle text-right" href="#"
                                    id="menu-action-dropdown-{{ $menu->id }}" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">{{ __('menu_setup.actions') }}</a>
                                <ul class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="menu-action-dropdown-{{ $menu->id }}">
                                    <li><button class="dropdown-item btn-edit-menu" href="#">Edit</button></li>
                                    <li><button class="dropdown-item btn-remove-menu" href="#">Remove</button></li>
                                    <li><button class="dropdown-item btn-hide-menu" href="#">Active</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr data-id="{{ $menu->id }}" class="menu-product-list">
                        <td colspan="3">
                            <table class="w-100 table">
                                <tbody>
                                    @foreach ($menu->products as $product)
                                        <tr data-id="{{ $product->id }}" >
                                            <td class="handle text-center"><i class="fa fa-arrows"></i></td>
                                            <td class="product-name">{{ $product->name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

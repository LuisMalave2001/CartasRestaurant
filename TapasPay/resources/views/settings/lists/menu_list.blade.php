<div class="row justify-content-around mt-4">
    <div class="container-fluid">
        <div class="row">
            <b class="h2 col-4">{{ __('menu_setup.menus') }}</b>
            <span class="col-8 text-center d-inline-block text-center">
                <button id="btn-add-menu"
                    class="btn btn-add-element text-center mb-3">{{ __('menu_setup.add_menu') }}</button>
            </span>
        </div>
        <table id="menus" class="table table-hover">
            <thead>
                <th>{{ __('menu_setup.name') }}</th>
                <th class="d-none d-sm-table-cell">{{ __('menu_setup.price') }}</th>
                <th class="text-center">{{ __('menu_setup.actions') }}</th>
            </thead>
            <tbody>
                @foreach ($menus as $menu)
                    <tr data-id="{{ $menu->id }}">

                        <!-- fields -->
                        <td class="menu-name col-6">{{ $menu->name }}</td>
                        <td class="menu-price d-none d-sm-table-cell col col-sm-4">{{ $menu->price }}</td>

                        <!-- Actions -->
                        <td class="col-4">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle text-right" href="#"
                                    id="menu-action-dropdown-{{ $menu->id }}" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    Actions</a>
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
                                        <tr data-id="{{ $product->id }}" class="d-flex">
                                            <td class="handle col-1 text-center"><i class="fa fa-arrows"></i></td>
                                            <td class="product-name col-11">{{ $product->name }}</td>
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

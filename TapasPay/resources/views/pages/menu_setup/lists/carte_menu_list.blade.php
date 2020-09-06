<div class="row justify-content-around mt-4">
    <div class="container-fluid">
        <div class="row">
            <b class="h2 col-12 col-md-4 text-center">{{ __('menu_setup.carte-menus') }}</b>
            <div class="col-12 col-md-4 text-center d-inline-block text-center">
                <button id="btn-add-carte-menu"
                    class="btn btn-add-element text-center mb-3 w-100">{{ __('menu_setup.add_carte-menu') }}</button>
            </div>
            <div class="col-12 col-md-4 text-center d-inline-block text-center">
                <button id="btn-save-carte-menu-list"
                        class="btn btn-secondary text-center mb-3 w-100" disabled>{{ __('menu_setup.save') }}</button>
            </div>
        </div>
        <table id="carte-menus" class="table table-hover">
            <thead>
                <th>{{ __('menu_setup.name') }}</th>
                <th class="text-center">{{ __('menu_setup.actions') }}</th>
            </thead>
            <tbody>
                @foreach ($carte_menus as $carte_menu)
                    <tr data-id="{{ $carte_menu->id }}">

                        <!-- fields -->
                        <td class="carte-menu-name col-6">{{ $carte_menu->name }}</td>

                        <!-- Actions -->
                        <td class="col-4">
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle text-right" href="#"
                                    id="carte-menu-action-dropdown-{{ $carte_menu->id }}" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">{{ __('menu_setup.actions') }}</a>
                                <ul class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="carte-menu-action-dropdown-{{ $carte_menu->id }}">
                                    <li><button class="dropdown-item btn-edit-carte-menu" href="#">Edit</button></li>
                                    <li><button class="dropdown-item btn-remove-carte-menu" href="#">Remove</button></li>
                                    <li><button class="dropdown-item btn-hide-carte-menu" href="#">Active</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                    <tr data-id="{{ $carte_menu->id }}" class="carte-menu-items-list">
                        <td colspan="3">
                            <table class="w-100 table">
                                <tbody data-id="{{ $carte_menu->id }}">


                                @foreach ($carte_menu->products as $product)
                                    <tr data-id="{{ $product->id }}" data-table="products">
                                        <td class="handle text-center"><i class="fa fa-arrows"></i></td>
                                        <td class="product-name">{{ $product->name }}</td>
                                        <td class="carte-delete-item text-center"><i class="fa fa-trash" aria-hidden="true"></i></td>
                                    </tr>
                                @endforeach

                                @foreach ($carte_menu->menus as $menu)
                                    <tr data-id="{{ $menu->id }}" data-table="menus">
                                        <td class="handle text-center"><i class="fa fa-arrows"></i></td>
                                        <td class="product-name">{{ $menu->name }}</td>
                                        <td class="carte-delete-item text-center"><i class="fa fa-trash" aria-hidden="true"></i></td>
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

<div class="row justify-content-around mt-4">
    <div class="container-fluid">
        <div class="row">
            <b class="h2 col-4">{{ __('menu_setup.carte-menus') }}</b>
            <span class="col-8 text-center d-inline-block text-center">
                <button id="btn-add-carte-menu"
                    class="btn btn-add-element text-center mb-3">{{ __('menu_setup.add_carte-menu') }}</button>
            </span>
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
                                    aria-haspopup="true" aria-expanded="false">
                                    Actions</a>
                                <ul class="dropdown-menu dropdown-menu-right"
                                    aria-labelledby="carte-menu-action-dropdown-{{ $carte_menu->id }}">
                                    <li><button class="dropdown-item btn-edit-carte-menu" href="#">Edit</button></li>
                                    <li><button class="dropdown-item btn-remove-carte-menu" href="#">Remove</button></li>
                                    <li><button class="dropdown-item btn-hide-carte-menu" href="#">Active</button></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

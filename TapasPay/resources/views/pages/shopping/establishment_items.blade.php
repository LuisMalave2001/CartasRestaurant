@extends('layouts.app')

@section('content')
    <div class="container js-shopping-list shopping-list">

        <article class="row">
            <input type="hidden" name="tableHashId" value="{{ $tableHashId }}"/>
        </article>

        @foreach($carte_menus as $carte_menu)
            <article class="row mt-4">
                <div class="col-12">
                    @foreach($carte_menu->menus as $menu)
                        <div class="row shopping-element"
                             id="menu-{{ $menu->id }}"
                             data-res-id="{{ $menu->id }}"
                             data-price="{{ $menu->price }}"
                             data-name="{{ $menu->name }}"
                             data-image-url="{{ $menu->image_path }}"
                             data-default-image-url="{{ asset('storage/images/food_default.png') }}"
                             data-res-model="menus"
                        >

                            <div class="card w-100">
                                <img class="card-img-top js-modal-image-trigger" src="{{ $menu->image_path }}"
                                     onerror="this.src='{{ asset('storage/images/food_default.png') }}'" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $menu->name }}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                                <ul class="list-group list-group-flush">

                                    @foreach($menu->products as $product)
                                        <li class="list-group-item">{{ $product->name }}</li>
                                    @endforeach
                                </ul>
                                <div class="card-body">

                                    <button class="btn btn-primary js-btn-modal-order w-100"
                                            data-html-id="menu-{{ $menu->id }}">
                                        {{ __('shopping.add_to_cart') }}
                                        <span class="badge badge-light badge-pill js-menu-price">{{ $menu->price }} €</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @foreach($carte_menu->products as $product)
                        <div class="row shopping-element"
                             id="product-{{ $product->id }}"
                             data-res-id="{{ $product->id }}"
                             data-price="{{ $product->price }}"
                             data-name="{{ $product->name }}"
                             data-image-url="{{ $product->image_path }}"
                             data-default-image-url="{{ asset('storage/images/food_default.png') }}"
                             data-res-model="products">

                            <div class="card w-100">
                                <img class="card-img-top js-modal-image-trigger" src="{{ $product->image_path }}"
                                     onerror="this.src='{{ asset('storage/images/food_default.png') }}'" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                </div>
                                <div class="card-body">
                                    <button class="btn btn-primary js-btn-modal-order w-100"
                                            data-html-id="product-{{ $product->id }}">
                                        {{ __('shopping.add_to_cart') }}
                                        <span class="badge badge-light badge-pill js-menu-price">{{ $product->price }} €</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </article>
        @endforeach
    </div>

    <div class="js-shopping-cart-bar shopping-cart-bar border-top container-fluid">
        <div class="row pt-2 pb-2">
            <div class="col text-center">
                <a href="{{ route("table_shopping_cart", ["tableHashId" => $tableHashId]) }}"
                   class="btn btn-primary loading-on-click" role="button">
                    {{ __('shopping.shopping_cart') }}
                    <span class="badge badge-light badge-pill">{{ count($order_line_list) }}</span>
                </a>
            </div>


            <div class="col text-center">
                <a class="btn btn-link" href="{{ route("table_shopping_order_list", ["tableHashId" => $tableHashId]) }}"
                   role="button">See orders</a>
            </div>
        </div>
    </div>


    <div id="js-image-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <img class="img-responsive js-modal-image-content w-100">
                </div>
            </div>
        </div>
    </div>

    <div id="js-order-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">

                <form method="POST" action="{{ route("add_cookie_order_line", ["tableHashId" => $tableHashId]) }}">
                    <div class="modal-body">
                        @csrf

                        <section class="container-fluid">
                            <input type="hidden" name="res_id" readonly="readonly" id="js_order_modal-res_id"/>
                            <input type="hidden" name="res_table" readonly="readonly" id="js_order_modal-res_modal"/>
                            <section class="row">
                                <img class="img-responsive js-order-modal-image-content w-100">
                            </section>

                            <section class="form-group form-row mt-4">
                                <div class="col-4">
                                    <label>{{__('shopping.name')}}</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" name="name" class="form-control" readonly="readonly"
                                           id="js_order_modal-name"/>
                                </div>
                            </section>

                            <section class="form-group form-row">
                                <div class="col-4">
                                    <label>{{__('shopping.price')}}</label>
                                </div>
                                <div class="col-8">


                                    <div class="input-group mb-3">
                                        <input type="text" name="price" class="form-control" readonly="readonly"
                                               id="js_order_modal-price"/>
                                        <div class="input-group-append">
                                            <span class="input-group-text" id="js_order_modal-price">€</span>
                                        </div>
                                    </div>

                                </div>
                            </section>

                            <section class="form-group form-row">
                                <div class="col-12 col-md-4">
                                    <label>{{__('shopping.units')}}</label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="row js_modal_order_item_units_group">
                                        <button type="button" class="col-2 btn js_btn_number_subtract"
                                                data-input-id="js_modal_order_item_units">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <div class="col">
                                            <input class="form-control w-100" type="number" readonly="readonly"
                                                   required="required" min="1"
                                                   id="js_modal_order_item_units" name="item_units"/>
                                        </div>
                                        <button type="button" class="col-2 btn js_btn_number_add"
                                                data-input-id="js_modal_order_item_units">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </section>


                            <section class="form-group form-row">
                                <div class="col-12 col-md-4">
                                    <label>{{__('shopping.note')}}</label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <textarea class="w-100 form-control" name="note"></textarea>
                                </div>
                            </section>
                        </section>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('shopping.add_to_cart') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection

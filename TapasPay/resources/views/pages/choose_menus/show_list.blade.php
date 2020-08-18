@extends("layouts.app")

@section("scripts")

    <script src="{{ asset("/js/shopping/show_list.js") }}"></script>

@endsection

@section("content")
    <form action="/update-shopping-items-count" method="post">
        @csrf
        <div class="container">
            @foreach ($carte_menus as $carte_menu)
                <section class="row">
                    <div class="col-12">
                        @foreach ($carte_menu->products as $product)
                            <div class="row">
                                <div class="col-12 col-md-2">
                                    <div class="row js_input_with_buttons">
                                        <button type="button" class="col-2 btn js_btn_number_subtract" data-input-id="product-{{$product->id}}">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <div class="col">
                                            <input class="form-control w-100" type="number" id="product-{{$product->id}}"
                                                   name="product_amount[]" value="{{ $product_amount[$product->id] ?? 0 }}"/>
                                            <input type="hidden" name="product_id[]" value="{{ $product->id }}"/>
                                        </div>
                                        <button type="button" class="col-2 btn js_btn_number_add" data-input-id="product-{{$product->id}}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">{{$product->name}}</div>
                                <div class="col-4">{{$product->price}}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="col-12">
                        @foreach ($carte_menu->menus as $menu)
                            <div class="row">
                                <div class="col-12 col-md-2">

                                    <div class="row js_input_with_buttons">
                                        <button type="button" class="col-2 btn js_btn_number_subtract" data-input-id="menu-{{$menu->id}}">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <div class="col">
                                            <input class="form-control w-100" type="number" id="menu-{{$menu->id}}"
                                                   name="menu_amount[]" value="{{ $menu_amount[$menu->id] ?? 0 }}"/>
                                            <input type="hidden" name="menu_id[]" value="{{ $menu->id }}"/>
                                        </div>
                                        <button type="button" class="col-2 btn js_btn_number_add" data-input-id="menu-{{$menu->id}}">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6">{{$menu->name}}</div>
                                <div class="col-4">{{$menu->price}}</div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endforeach
            <section class="row">
                <div class="col text-center">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </section>
        </div>

    </form>

@endsection

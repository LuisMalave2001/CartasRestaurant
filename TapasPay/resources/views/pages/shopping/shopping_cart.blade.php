@extends('layouts.shopping')

@section('content')

    <section class="container-fluid">
        <input type="hidden" name="tableHashId" value="{{ $tableHashId }}"/>
        <div class="row">
            <div class="col">
                <a class="btn btn-link" href="{{ route("table_shopping", ["tableHashId" => $tableHashId]) }}"
                   role="button">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                @foreach($cartOrderList as $orderId => $cartOrder)
                    <div class="row"
                         id="order-{{ $orderId }}"
                         data-id="{{ $orderId }}">
                        <div class="card w-100">
                            <div class="card-body">
                                <div class="row js_order_units_group">
                                    <button type="button" class="col-2 btn js_btn_number_subtract"
                                            data-input-id="js_order_units-{{ $orderId }}">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <div class="col">
                                        <input class="form-control w-100" type="number" readonly="readonly"
                                               required="required" min="1"
                                               value="{{ $cartOrder->item_units }}"
                                               data-target="order-{{ $orderId }}"
                                               data-toggle-unit-price="order_line-unit_price-{{ $orderId }}"
                                               data-toggle-item-units="order_line-items_units-{{ $orderId }}"
                                               data-toggle-total-price="order_line-total_price-{{ $orderId }}"
                                               id="js_order_units-{{ $orderId }}" name="item_units"/>
                                    </div>
                                    <button type="button" class="col-2 btn js_btn_number_add"
                                            data-input-id="js_order_units-{{ $orderId }}">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <h5 class="card-title">{{ $cartOrder->name }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">
                                            <span id="order_line-unit_price-{{ $orderId }}">{{ $cartOrder->unit_price }}</span>€
                                            x <span id="order_line-items_units-{{ $orderId }}">{{ $cartOrder->item_units }}</span>
                                            = <span id="order_line-total_price-{{ $orderId }}">{{ $cartOrder->total_price }}</span>€</h6>
                                    </div>
                                    <div class="col-4 d-flex justify-content-center align-content-center">
                                        <button data-target="order-{{ $orderId }}"
                                                class="btn btn-link js_button_remove_order_line loading-on-click"
                                                style="font-size: 2rem">
                                            <i class="fa fa-trash" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        @if ($cartOrder->note)
                                            <textarea data-target="order-{{ $orderId }}"
                                                      class="js_order_note w-100 form-control">{{ $cartOrder->note }}</textarea>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="js-shopping-cart-bar shopping-cart-bar border-top container-fluid">
        <div class="row pt-2 pb-2">
            <div class="col text-center">
                <form method="POST" action="{{ route("submit_order_lines", ["tableHashId" => $tableHashId]) }}">
                    @csrf
                    <button class="btn btn-primary loading-on-click" type="submit" role="button">
                        {{ __('shopping.order') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection

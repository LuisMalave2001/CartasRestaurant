@extends('layouts.app')

@section('content')

    <section class="container-fluid">

        <div class="row">
            <div class="col">
                <a class="btn btn-link" href="{{ route("table_shopping", ["tableHashId" => $tableHashId]) }}"
                   role="button">Back</a>
            </div>
        </div>
        <div class="row">
            <div class="col">
{{--                <form method="POST">--}}
{{--                    @csrf--}}
                    @foreach($cartOrderList as $cartOrder)
                        {{--                {{ $cartOrder = (object) $cartOrder }}--}}

                        <div class="row">

                            <div class="card w-100">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $cartOrder->name }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $cartOrder->price }}€ x {{ $cartOrder->item_units }} </h6>
                                    <p class="card-text">{{ $cartOrder->note }}</p>
                                </div>
                            </div>
                        </div>

                    @endforeach
{{--                </form>--}}
            </div>
        </div>

    </section>

    <div class="js-shopping-cart-bar shopping-cart-bar border-top container-fluid">
        <div class="row pt-2 pb-2">
            <div class="col text-center">
                <a href="#" class="btn btn-primary loading-on-click" role="button">
                    {{ __('shopping.order') }}
                    <span class="badge badge-light badge-pill"></span>
                </a>
            </div>
        </div>
    </div>

@endsection

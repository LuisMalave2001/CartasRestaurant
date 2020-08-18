@extends('layouts.app')

@section('content')
    <div class="container js-shopping-list">
        @foreach($carte_menus as $carte_menu)
            <article class="row">
                <div class="col-12">
                    @foreach($carte_menu->menus as $menu)
                        <div class="row">
                            <div class="col-12">
                                <div>{{$menu->name}}</div>
                            </div>
                        </div>
                    @endforeach


                    @foreach($carte_menu->products as $product)
                        <div class="row">
                            <div class="shopping-image-container col-12 position-relative d-flex justify-content-center align-items-center">
                                <img src="{{ $product->image_path }}"
                                     class="shopping-image-as img-fluid position-absolute js-modal-image-trigger"/>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <dl class="w-100">

                                        <dt><span>{{ $product->name }}</span></dt>
                                        <dd>{{ $product->price }}</dd>

                                    </dl>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </article>
        @endforeach
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

@endsection

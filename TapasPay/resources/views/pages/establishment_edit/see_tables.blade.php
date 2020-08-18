@extends('layouts.app');

@section("content")
    <section class="container">
        <div class="row">

            @foreach ($tables as $table)

                <div class="col-4 border border-dark js-qr-block">
                    <div class="row justify-content-center border border-dark">
                        {{ session()->get("user_current_establishment")->name }} - #{{ $table->number }}
                    </div>
                    <div class="row justify-content-center border border-dark"><a class="js-qr-url" href="{{ route("table_shopping", ["tableHashId" => $table->url]) }}">
{{--                            <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ urlencode(route("table_shopping", ["tableHashId" => $table->url])) }}"/>--}}
                            <canvas  class="js-qr-image"></canvas>
                        </a></div>
                    <div class="row justify-content-center border border-dark">{{ session()->get("user_current_establishment")->table_message }}</div>

                </div>

            @endforeach
        </div>
    </section>
@endsection

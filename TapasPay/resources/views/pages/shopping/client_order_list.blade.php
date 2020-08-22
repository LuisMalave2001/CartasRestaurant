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
                <ul class="list-group">

                    @foreach($orders as $order)

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $order->number_of_table }}
                            {{ $order->order_number }}
                            <span class="badge badge-primary badge-pill">{{ $order->order_status->name }}</span>
                        </li>

                    @endforeach
                </ul>
            </div>
        </div>
    </section>

@endsection

@extends('layouts.app')

@section('head')

    <link rel="stylesheet" href="{{ mix('/css/settings/kanban_style.css') }}" />

    <script defer src="{{ mix('/js/settings/kanban_behaviour.js') }}"></script>

@endsection

@section('content')
    <section class="container">

        <!-- Product list -->
        @include('settings.lists.product_list')

        <!-- Product list -->
        @include('settings.lists.menu_list')

        <!-- Product list -->
        @include('settings.lists.carte_menu_list')

        @include('settings.modals')
    @endsection

@extends('layouts.app')

@section('content')
    <section class="container js-menu-setup-page">

        <!-- Product list -->
        @include('pages.menu_setup.lists.product_list')

        <!-- Product list -->
        @include('pages.menu_setup.lists.menu_list')

        <!-- Product list -->
        @include('pages.menu_setup.lists.carte_menu_list')

        @include('pages.menu_setup.modals.modals')
    </section>
@endsection

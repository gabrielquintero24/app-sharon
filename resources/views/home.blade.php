@extends('layouts.app')

@section('content-page')
    <div class="dash">
        @include('dashboard.nav.nav_izq')
        <div class="dash-app">
            @include('dashboard.nav.nav_sup')
            <main class="dash-content">
                <div class="container-fluid">
                    <dash-principal-component></dash-principal-component>
                </div>
            </main>
        </div>
    </div>
@endsection

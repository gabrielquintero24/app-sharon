@extends('layouts.dash')

@section('title', 'Especificaciones')

@section('content-page')
    <div class="dash">
        @include('dashboard.nav.nav_izq')
        <div class="dash-app">
            @include('dashboard.nav.nav_sup')
            <main class="dash-content">
                <div class="container-fluid">
                    <dash-especificaciones-component></dash-especificaciones-component>
                </div>
            </main>
        </div>
    </div>
@endsection

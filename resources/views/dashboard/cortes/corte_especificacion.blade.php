@extends('layouts.dash')

@section('title', 'Corte - Especificación')

@section('content-page')
    <div class="dash">
        @include('dashboard.nav.nav_izq')
        <div class="dash-app">
            @include('dashboard.nav.nav_sup')
            <main class="dash-content">
                <div class="container-fluid">
                  <dash-corte-esp-component></dash-corte-esp-component>
                </div>
            </main>
        </div>
    </div>
@endsection

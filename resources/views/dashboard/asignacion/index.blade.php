@extends('layouts.dash')

@section('title', 'Asignaciones')

@section('content-page')
    <div class="dash">
        @include('dashboard.nav.nav_izq')
        <div class="dash-app">
            @include('dashboard.nav.nav_sup')
            <main class="dash-content">
                <div class="container-fluid">
                    <dash-asignacion-component></dash-asignacion-component>
                </div>
            </main>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content">
            <div class="title m-b-md">
                BDE Cesi Rouen
            </div>
            @if (Route::has('login'))
                <div class="links">
                    @auth
                        <a href="{{ url('/home') }}">Acceder au site</a>
                    @else
                        <a href="{{ route('login') }}">Connexion</a>
                        <a href="{{ route('register') }}">Inscription</a>
                    @endauth
                </div>
            @endif
        </div>
    </div>
@endsection


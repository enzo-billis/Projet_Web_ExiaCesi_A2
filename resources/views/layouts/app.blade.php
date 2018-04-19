<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>BDE - Exia Cesi</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel" style="background-color:#8a1002 ">
            <div class="container ">
                <a class="navbar-brand " href="{{ url('/') }} " style="color:#fff;">
                    {{ "Bureau des étudiants" }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link text-white" href="{{ route('manifs') }}">{{ __('Activités') }}</a></li>
                            <li><a class="nav-link text-white" href="{{ route('ideas') }}">{{ __('Idées') }}</a></li>
                            <li><a class="nav-link text-white" href="{{ route('shopList') }}">{{ __('Magasin') }}</a></li>
                        @else
                            <li><a class="nav-link text-white" href="{{ route('manifs') }}">{{ __('Activités') }}</a></li>
                            <li><a class="nav-link text-white" href="{{ route('ideas') }}">{{ __('Idées') }}</a></li>
                            <li><a class="nav-link text-white" href="{{ route('shopList') }}">{{ __('Magasin') }}</a></li>
                        @endguest

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link text-white" href="{{ route('login') }}">{{ __('Connexion') }}</a></li>
                            <li><a class="nav-link text-white" href="{{ route('register') }}">{{ __('Inscription') }}</a></li>
                        @else

                                <notification></notification>

                            @if(Auth::user()->isRang(1))
                                <li class="nav-item dropdown">
                                    <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        Administration BDE <span class="caret"></span>
                                    </a>

                                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                        <a class="dropdown-item " href="/administration">
                                            <i class="fa fa-user" aria-hidden="true"></i> {{ __('Panel') }}
                                        </a>
                                    </div>
                                </li>
                                @endif
                                @if(Auth::user()->isRang(2))
                                        <p id="navbarDropdown" class="nav-link text-white">
                                            Administration CESI
                                        </p>
                                @endif
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-white" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item " href="/profile">
                                        <i class="fa fa-user" aria-hidden="true"></i> {{ __('Profile') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-plug" aria-hidden="true"></i> {{ __('Deconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <header>
            <div class="flex-row">
                <img class="" href="{{asset('logoBDE.png')}}" alt="logo">
            </div>
        </header>

        <main class="py-4">
            @yield('content'):
        </main>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Coemp') }}</title>

    <!-- Styles -->
    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('style/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    
    <style>
        @yield('estilo')
    </style>
    

</head>
<body>
    <div id="wrapper" class="home-page">

        <!-- start header -->
        <header>
            <div class="navbar-content">
                <nav class="navbar navbar-default navbar-static-top">
                    <div class="container">

                        <div class="navbar-header">

                            <!-- Collapsed Hamburger -->
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>



                            <!-- Branding Image -->
                            <div class="navbar-logo">
                                <a class="navbar-brand" href="{{ url('/') }}" ><img src="{{ asset('template/img/logo.png') }}" alt="logo"/></a>
                            </div>
                        </div>

                        <div class="collapse navbar-collapse" id="app-navbar-collapse">
                            <!-- Left Side Of Navbar -->
                            <!-- <ul class="nav navbar-nav">
                                &nbsp;
                            </ul> -->

                            <!-- Right Side Of Navbar -->
                            <ul class="nav navbar-nav navbar-right">
                                <!-- Authentication Links -->
                                @if (Auth::guest())
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ url('/generador') }}">Registrar Generador</a></li>
                                    <li><a href="{{ url('/transportista') }}">Registrar Transportista</a></li>
                                @else
                                    <li class="li-menu"><a href="{{ url('/requerimiento/nuevo') }}">Nuevo Requerimiento</a></li>
                                    <li class="li-menu"><a href="{{ url('/home') }}">Listado Requerimiento</a></li>
                        
                                    <li class="dropdown li-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                            {{ Auth::user()->empresa->razonsocial }} <span class="caret"></span>
                                        </a>



                                        <ul class="dropdown-menu" role="menu">
                                            <li>
                                                <a href="{{ url('/empresa/editar') }}">Editar Usuario</a>
                                                <a href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                                             document.getElementById('logout-form').submit();">
                                                    Cerrar Sesion
                                                </a>

                                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                    {{ csrf_field() }}
                                                </form>
                                            </li>
                                        </ul>
                                    </li>
                                    @endif
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

        </header>
        <!-- end header -->

        @yield('content')


    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
</body>
</html>

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
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('style/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">


    <style>
        .dropdown-header{
            font-weight: bold;
            text-transform: uppercase;
        }

        .divider{
            margin: 3px;
        } 
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
                            <div>
                                <div class="navbar-logo" style="float: left">
                                        <a class="navbar-brand" href="{{ url('/') }}" ><img src="{{ asset('template/img/logo.png') }}" alt="logo"/></a>


                                </div>
                                <div style="float: left"> 
                                    <ul class="nav navbar-nav">
                                      <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" id="npublicacion-img">
                                            <i class="fa fa-bell fa-menu" aria-hidden="true"></i>
                                            <span class="badge" id="notf-nreq">0</span> 
                                        </a>
                                        <ul class="dropdown-menu" id="npublicacion-list">

                                        </ul>
                                      </li>
                                    </ul>
                                </div>
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
                                <li><a href="{{ url('/home') }}">Publicaciones</a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Registro <span class="caret"></span>
                                    </a>

                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="{{ url('/trabajador/nuevo') }}"> Nuevo Trabajador </a></li>
                                            <li><a href="{{ url('/unidad/nuevo') }}"> Nueva Unidad </a></li>
                                        </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        Listado <span class="caret"></span>
                                    </a>

                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="{{ url('/postulacion/listado') }}"> Postulacion </a></li>
                                        <li><a href="{{ url('/trabajador/listado') }}"> Trabajador </a></li>
                                        <li><a href="{{ url('/unidad/listado') }}"> Unidad </a></li>
                                    </ul>
                                </li>
                    
                                <li class="dropdown li-menu">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        {{ Auth::user()->empresa->razonsocial }} <span class="caret"></span>
                                    </a>



                                    <ul class="dropdown-menu" role="menu">
                                        <li>
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
    <script src="{{ asset('js/notificacion.js') }}"></script>

    <script>
        var timestamp = null;
        function cargar_push () {
            $.ajax({
                async: true,
                type: "POST",
                url: '/httpush/npublicacion',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "timestamp": "timestamp",
                },
                dataType: "html",
                success: function(data){
                    var json = eval("("+data+")");
                    timestamp = json.timestamp;
                    mensaje = json.mensaje;

                    console.log(timestamp);

                    if (timestamp == null) {}
                    else{
                        $.ajax({
                            async: true,
                            type: "POST",
                            url: '/mensaje/npublicacion',
                            data: {
                                "_token": "{{ csrf_token() }}", 
                            },
                            dataType: "html",
                            success: function(data)
                            {
                                $('#notf-nreq').html(data);
                            }
                        });
                    }
                    setTimeout('cargar_push()', 1000);
                }
            });
        }

        $(document).ready(function () {
            cargar_push();
        });
    </script>
    @yield('scripts')
</body>
</html>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Órdenes de Servicio</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ secure_asset('js/scripts.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/captura-domicilio.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/mistablas.js') }}" ></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{{asset('css/customize-navbar.css')}}}">
    <link rel="stylesheet" type="text/css" href="{{{asset('css/datatables.min.css')}}}">
</head>
<body>
    <div id="app">
        <div>
            <header>
                <!--
                <img src="{{asset('/images/LOGO_GESTIONTEC_extendido.png')}}" srcset="{{asset('/images/LOGO_GESTIONTEC_extendido.png')}}" width="100%" height="170" sizes="(min-width: 1920px)" alt="Ejemplo">
                -->
                <img src="{{asset('/images/header1920.jpg')}}" srcset="{{asset('/images/header1920.jpg')}} 1920w, {{asset('/images/header1600.jpg')}} 1600w,  {{asset('/images/header800.jpg')}} 800w, {{asset('/images/header650.jpg')}} 650w, {{asset('/images/header450.jpg')}} 450w" sizes="(min-width: 1920px)" alt="Ejemplo">
            </header>
        </div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    @auth
                        <div class="dropdown">
                            {{--@consultaServicio--}}
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <img src="{{ asset('bootstrap-icons-1.5.0/file-text.svg') }}" width="18" height="18">
                                    Servicios
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    <li><a class="dropdown-item" href="{{ url('servicios/index') }}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/search.svg') }}" width="18" height="18"> Lista de Servicios
                                        </a>
                                    </li>
                                </ul>
                            {{--@endconsultaServicio--}}
                        </div>
                        <div class="dropdown">
                          <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('bootstrap-icons-1.5.0/file-text-fill.svg') }}" width="18" height="18">
                            Catálogos
                          </a>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            {{--@consultaTaller--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18"> Talleres <span class="caret"></span></a>
                                    <ul class="dropdown-menu sub-menu">
                                        <li><a class="dropdown-item" href="{{ url('talleres/index') }}" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18"> Lista de Talleres
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ url('talleres/nuevo') }}" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                            <img src="{{ asset('bootstrap-icons-1.5.0/tools.svg') }}" width="18" height="18"> Nuevo Taller
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            {{--@endconsultaTaller
                            @consultaEmpleado--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/person-lines-fill.svg') }}" width="18" height="18"> Empleados <span class="caret"></span></a>
                                    <ul class="dropdown-menu sub-menu">
                                        <li><a class="dropdown-item" href="{{ url('empleados/index') }}">
                                            <img src="{{ asset('bootstrap-icons-1.5.0/person-lines-fill.svg') }}" width="18" height="18"> Lista de Empleados
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ url('empleados/nuevo') }}">
                                            <img src="{{ asset('bootstrap-icons-1.5.0/person-vcard-fill.svg') }}" width="18" height="18"> Nuevo Empleado
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            {{--@endconsultaEmpleado
                            @consultaCuadrilla--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/people-fill.svg') }}" width="18" height="18"> Cuadrillas <span class="caret"></span></a>
                                    <ul class="dropdown-menu sub-menu">
                                        <li><a class="dropdown-item" href="{{ url('cuadrillas/index') }}">
                                            <img src="{{ asset('bootstrap-icons-1.5.0/people-fill.svg') }}" width="18" height="18"> Lista de Cuadrillas
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ url('cuadrillas/nuevo') }}">
                                            <img src="{{ asset('bootstrap-icons-1.5.0/person-plus-fill.svg') }}" width="18" height="18"> Nueva Cuadrilla
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            {{--@endconsultaCuadrilla
                            @consultaAdministracion--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18"> Administraciones <span class="caret"></span></a>
                                    <ul class="dropdown-menu sub-menu">
                                        <li><a class="dropdown-item" href="{{ url('administraciones/index') }}">
                                            <img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18"> Lista de Administraciones
                                            </a>
                                        </li>
                                        <li><a class="dropdown-item" href="{{ url('administraciones/nueva') }}">
                                            <img src="{{ asset('bootstrap-icons-1.5.0/folder-plus.svg') }}" width="18" height="18"> Nueva Administración
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            {{--@enconsultaAdministracion
                            @consultaEdificio--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18"> Edificios <span class="caret"></span></a>
                                    <ul class="dropdown-menu sub-menu">
                                            <li><a class="dropdown-item" href="{{ url('edificios/index') }}">
                                                <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18"> Lista de Edificios
                                                </a>
                                            </li>
                                            <li><a class="dropdown-item" href="{{ url('edificios/nuevo') }}">
                                                <img src="{{ asset('bootstrap-icons-1.5.0/building-add.svg') }}" width="18" height="18"> Nuevo Edificio
                                                </a>
                                            </li>
                                        </ul>
                                </li>
                            {{--@endconsultaEdificio--}}
                          </ul>
                        </div>
                    @endauth

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <br>
        <div class="container col-md-10">
            <div class="container container-fluid h-100">
                <div class="card">
                    <div class="card-header">
                        <h4 class="text-primary-sin text-center">@yield('titulo')</h4>
                    </div>
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($message = Session::get('warning'))
                            <div class="alert alert-warning">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @if ($message = Session::get('danger'))
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                        @yield('panel')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <footer class="footer">
        <img src="{{URL::asset('/images/footer.png')}}"width="900" align="center" style="width: 100%; height: 60px;" />
        <!--
        <img src="{{asset('/images/footer1920.jpg')}}" srcset="{{asset('/images/footer1920.jpg')}} 1920w, {{asset('/images/footer1600.jpg')}} 1600w, {{asset('/images/footer800.jpg')}} 800w, {{asset('/images/footer650.jpg')}} 650w, {{asset('/images/footer450.jpg')}} 450w" sizes="(min-width: 1920px)" alt="Ejemplo">
        -->
    </footer>
</body>
</html>

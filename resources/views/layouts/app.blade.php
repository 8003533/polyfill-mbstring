 <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Órdenes de Servicio</title>

    <!-- Scripts -->
    <!--@vite(['resources/sass/app.scss', 'resources/js/app.js']) -->
    <script src="{{asset('js/app.js')}}" defer></script>
    <scriptrc="{{ secure_asset('js/scripts.js') }}"></script>
    <!--<script src="{{asset('js/scripts.js')}}"></script>-->
    <!--<script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/captura-domicilio.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/captura-puesto.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/captura-adscrip.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}" defer></script>
    <script type="text/javascript" src="{{ asset('js/mistablas.js') }}" ></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <!-- Luego cargamos Select2 -->
      <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/modales.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{{asset('css/customize-navbar.css')}}}">
    <link rel="stylesheet" type="text/css" href="{{{asset('css/datatables.min.css')}}}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Select2 CSS 
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />-->
     <!-- Luego tu script -->
        <script>
            $(document).ready(function() {
                // Inicializar Select2
                $('.select2').select2();
            });
        </script>

</head>
<body>
    <div id="app">
        <div>
            <header>
                <img src="{{asset('/images/LOGO_PJ.jpg')}}" srcset="{{asset('/images/LOGO_PJ.jpg')}} 1920w, {{asset('/images/LOGO_PJ.jpg')}} 1600w,  {{asset('/images/LOGO_PJ.jpg')}} 800w, {{asset('/images/LOGO_PJ.jpg')}} 650w, {{asset('/images/LOGO_PJ.jpg')}} 450w" sizes="(min-width: 1920px)" alt="Ejemplo" height="110px" align="left">
                <img src="{{asset('/images/LOGO_GESTIONTEC_extendido.png')}}" srcset="{{asset('/images/LOGO_GESTIONTEC_extendido.png')}} 1920w, {{asset('/images/LOGO_GESTIONTEC_extendido.png')}} 1600w,  {{asset('/images/LOGO_GESTIONTEC_extendido.png')}} 800w, {{asset('/images/LOGO_GESTIONTEC_extendido.png')}} 650w, {{asset('/images/LOGO_GESTIONTEC_extendido.png')}} 450w" sizes="(min-width: 1920px)" alt="Ejemplo" height="110px" align="right">
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
                                    <li><a class="dropdown-item" href="{{ url('registro/index') }}">
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
                                        <a class="dropdow-item" href="{{ url('taller/index')}}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18"> Talleres <span class="caret"></span></a>
                                    <ul class="dropdown-menu sub-menu">
                                            </a>
                                        </li>
                    
                                    </ul>
                                </li>
                            {{--@endconsultaTaller

                            @consultaEmpleado--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <a class="dropdow-item" href="{{ url('empleados/index')}}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/person-lines-fill.svg') }}" width="18" height="18"> Empleados <span class="caret"></span></a>
                            {{--@endconsultaEmpleado

                            
                            @consultaCuadrilla--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <a class="dropdow-item" href="{{ url('cuadrillas/index')}}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/people-fill.svg') }}" width="18" height="18"> Cuadrillas <span class="caret"></span></a>
                                </li>
                            {{--@endconsultaCuadrilla


                            @consultaAdministracion--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <a class="dropdow-item" href="{{ url('administraciones/index')}}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18"> Administraciones <span class="caret"></span></a>
                                </li>
                            {{--@enconsultaAdministracion



                            @consultaEdificio--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <a class="dropdow-item" href="{{ url('edificios/index')}}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/buildings-fill.svg') }}" width="18" height="18"> Edificios <span class="caret"></span></a>
                                </li>
                            {{--@endconsultaEdificio


                            @consultaPuesto--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <a class="dropdow-item" href="{{ url('puestos/index')}}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/diagram-3.svg') }}" width="18" height="18"> Puestos <span class="caret"></span></a>
                                </li>
                            {{--@endconsultaPuesto

                            
                            @consultaAdscripcion--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <a class="dropdow-item" href="{{ url('adscripciones/index')}}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18"> Adscripciones <span class="caret"></span></a>
                                </li>
                            {{--@endconsultaAdscripcion

                            @consultaPersonal--}}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-item" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <a class="dropdow-item" href="{{ url('personal/index')}}">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/people.svg') }}" width="18" height="18"> Personal <span class="caret"></span></a>
                                    <ul class="dropdown-menu sub-menu">
                                        
                                        {{--@endaltaPersonal--}}
                                    </ul>
                                </li>
                                {{--@consultaArea--}}

<li>
    <a class="dropdown-item" href="{{ url('areas/index') }}">
        <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18"> Áreas
    </a>
</li>
{{--@endconsultaArea--}}

{{--@consultaBien--}}
<li>
    <a class="dropdown-item" href="{{ url('bienes/index') }}">
        <img src="{{ asset('bootstrap-icons-1.5.0/box-seam.svg') }}" width="18" height="18"> Bienes
    </a>
</li>
{{--@endconsultaBien--}}

{{--@consultaProveedor--}}
<li>
    <a class="dropdown-item" href="{{ url('proveedores/index') }}">
        <img src="{{ asset('bootstrap-icons-1.5.0/truck.svg') }}" width="18" height="18"> Proveedores
    </a>
</li>
{{--@endconsultaProveedor--}}

{{--@consultaEntrada--}}
<li>
    <a class="dropdown-item" href="{{ url('entradas') }}">
        <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-in-down.svg') }}" width="18" height="18"> Entradas
    </a>
</li>
{{--@endconsultaEntrada--}}

{{--@consultaSalida--}}
<li>
    <a class="dropdown-item" href="{{ url('salidas/index') }}">
        <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-up.svg') }}" width="18" height="18"> Salidas
    </a>
</li>

{{--@consultaUnidad--}}
<li>
    <a class="dropdown-item" href="{{ url('unidades/index') }}">
        <img src="{{ asset('bootstrap-icons-1.5.0/bounding-box-circles.svg') }}" width="18" height="18"> Unidades
    </a>
</li>
{{--@endconsultaUnidad--}}


                            {{--@endconsultaPersonal--}}
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
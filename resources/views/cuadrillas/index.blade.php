@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center"><img src="{{ asset('bootstrap-icons-1.5.0/people-fill.svg') }}" width="18" height="18"> Listado de Cuadrillas</h4>
@endsection

@section('panel')
    <div class="table-responsive">
        <form method="GET" action="{{ url('/cuadrillas/index') }}" id="formIndexCuadrillas">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p>Corrige los errores para continuar</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

        <div class="row">
            <div class="col col-form-label text-md-right">
                {{--@altaCuadrilla--}}
                    <a href="{{ url('cuadrillas/nueva') }}" data-toggle="tooltip" data-html="true" title="Nuevo">
                        + Nueva Cuadrilla
                    </a>
                {{--@endaltaCuadrilla--}}
            </div>
        </div>
        <table class="table table-striped shadow-lg" id="MyTableCuadrillas">
          <thead>
            <tr>
                <th class="text-center">Número</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($cuadrillas as $indice=>$cuadrilla)
                <tr>
                    <td class="text-center">{{ $cuadrilla['iid_cuadrilla'] }}</td>
                    <td class="text-center">{{ $cuadrilla['cnombre_cuadrilla'] }}</td>
                    <td class="text-center col-actions">
                    @if ($cuadrilla->iestatus == 1)
                        {{--@editaCuadrilla--}}
                            <a href="{{ url('cuadrillas/editar/'.$cuadrilla->iid_cuadrilla) }}" data-toggle="tooltip" data-html="true" title="Actualizar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endeditaCuadrilla
                        @borraCuadrilla--}}
                            <a href="{{ url('cuadrillas/inhabilitar/'.$cuadrilla->iid_cuadrilla) }}" data-toggle="tooltip" data-html="true" title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraCuadrilla--}}
                    @else
                        {{--@borraCuadrilla--}}
                            <a href="{{ url('cuadrillas/inhabilitar/'.$cuadrilla->iid_cuadrilla) }}" data-toggle="tooltip" data-html="true" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraCuadrilla--}}
                    @endif
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection
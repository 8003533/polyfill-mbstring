@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center"><img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18"> Listado de Edifcios</h4>
@endsection

@section('panel')
    <div class="table-responsive">
        <form method="GET" action="{{ url('/edificios/index') }}" id="formIndexEdifcios">
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
                {{--@altaEdificio--}}
                    <a href="{{ url('edificios/nuevo') }}" data-toggle="tooltip" data-html="true" title="Nuevo">
                        + Nuevo Edificio
                    </a>
                {{--@endaltaEdificio--}}
            </div>
        </div>
        <table class="table table-striped shadow-lg" id="MyTableEdificios">
          <thead>
            <tr>
                <th class="text-center">Número</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Administración</th>
                <th class="text-center">Dirección</th>
                <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($edificios as $indice=>$edificio)
                <tr>
                    <td class="text-center">{{ $edificio['iid_edificio'] }}</td>
                    <td class="text-center">{{ $edificio['cnombre_edificio'] }}</td>
                    <td class="text-center">{{ $edificio['administracion']['cdescripcion_administracion'] }}</td>
                    <td class="text-center">{{ $edificio['ccalle'].' '.$edificio['cnumero_exterior'].' '.$edificio['cnumero_interior'].', '.$edificio['colonia']['cnombre_colonia'].', '.$edificio['alcaldia']['cnombre_alcaldia'].', '.$edificio['entidad']['cnombre_entidad'].', C.P. '.$edificio['cid_codigo_postal'] }}</td>
                    <td class="text-center col-actions">
                    @if ($edificio->iestatus == 1)
                        {{--@editaEdificio--}}
                            <a href="{{ url('edificios/editar/'.$edificio->iid_edificio) }}" data-toggle="tooltip" data-html="true" title="Actualizar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endeditaEdificio
                        @borraEdificio--}}
                            <a href="{{ url('edificios/inhabilitar/'.$edificio->iid_edificio) }}" data-toggle="tooltip" data-html="true" title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraEdificio--}}
                    @else
                        {{--@borraEdificio--}}
                            <a href="{{ url('edificios/inhabilitar/'.$edificio->iid_edificio) }}" data-toggle="tooltip" data-html="true" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraEdificio--}}
                    @endif
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection
@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center"><img src="{{ asset('bootstrap-icons-1.5.0/person-lines-fill.svg') }}" width="18" height="18"> Listado de Empleados de Talleres</h4>
@endsection

@section('panel')
    <div class="table-responsive">
        <form method="GET" action="{{ url('/empleados/index') }}" id="formIndexEmpleados">
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
                {{--@altaEmpleado--}}
                    <a href="{{ url('empleados/nuevo') }}" data-toggle="tooltip" data-html="true" title="Nuevo">
                        + Nuevo Empleado Taller
                    </a>
                {{--@endaltaEmpleado--}}
            </div>
        </div>
        <table class="table table-striped shadow-lg" id="MyTableEmpleados">
          <thead>
            <tr>
                <th class="text-center">Nombre</th>
                <th class="text-center">Paterno</th>
                <th class="text-center">Materno</th>
                <th class="text-center">Puesto</th>
                <th class="text-center">Adscripción</th>
                <th class="text-center">Taller</th>
                <th class="text-center">Cuadrilla</th>
                <th class="text-center">Correo Electrónico</th>
                <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($empleados as $indice=>$empleado)
                <tr>
                    <td class="text-center">{{ $empleado->cnombre_empleado_taller }}</td>
                    <td class="text-center">{{ $empleado->cpaterno_empleado_taller }}</td>
                    <td class="text-center">{{ $empleado->cmaterno_empleado_taller }}</td>
                    <td class="text-center">{{ $empleado->cdescripcion_puesto }}</td>
                    <td class="text-center">{{ $empleado->cdescripcion_adscripcion }}</td>
                    <td class="text-center">{{ $empleado->cdescripcion_taller }}</td>
                    <td class="text-center">{{ $empleado->cnombre_cuadrilla }}</td>
                    <td class="text-center">{{ $empleado->ccorreo_electronico }}</td>
                    <td class="text-center col-actions">
                    @if ($empleado->iestatus == 1)
                        {{--@editaEmpleado--}}
                            <a href="{{ url('empleados/editar/'.$empleado->iid_empleado_taller) }}" data-toggle="tooltip" data-html="true" title="Corrección de datos">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endeditaEmpleado
                        @borraEmpleado--}}
                            <a href="{{ url('empleados/inhabilitar/'.$empleado->iid_empleado_taller) }}" data-toggle="tooltip" data-html="true" title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraEmpleado--}}
                    @else
                        {{--@borraEmpleado--}}
                            <a href="{{ url('empleados/inhabilitar/'.$empleado->iid_empleado_taller) }}" data-toggle="tooltip" data-html="true" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraEmpleado--}}
                    @endif
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection
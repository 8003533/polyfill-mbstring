@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/person-lines-fill.svg') }}" width="18" height="18">
        Listado de Empleados de Talleres
    </h4>
@endsection

@section('panel')
<div class="table-responsive">

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- ERRORES --}}
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

    {{-- FORM GET (si lo usas para filtros/búsquedas). Si no lo usas, puedes quitarlo. --}}
    <form method="GET" action="{{ url('/empleados/index') }}" id="formIndexEmpleados">
        {{-- aquí irían filtros si tienes --}}
    </form>

    <div class="row mb-2">
        <div class="col col-form-label text-md-right">
            <a href="#" data-toggle="modal" data-target="#modalNuevoEmpleado" title="Nuevo">
                + Nuevo Empleado Taller
            </a>
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
                            <a href="{{ url('empleados/editar/'.$empleado->iid_empleado_taller) }}" title="Corrección de datos">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </a>
                            <a href="{{ url('empleados/inhabilitar/'.$empleado->iid_empleado_taller) }}" title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </a>
                        @else
                            <a href="{{ url('empleados/inhabilitar/'.$empleado->iid_empleado_taller) }}" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- ===================== MODAL NUEVO EMPLEADO ===================== -->
<div class="modal fade" id="modalNuevoEmpleado" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">
          <img src="{{ asset('bootstrap-icons-1.5.0/person-plus-fill.svg') }}" width="18" height="18">
          Nuevo Empleado de Taller
        </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <form method="POST" action="{{ url('empleados/guardar') }}">
        @csrf

        <div class="modal-body">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Nombre</label>
              <input type="text" name="cnombre_empleado_taller" class="form-control" required value="{{ old('cnombre_empleado_taller') }}">
            </div>
            <div class="form-group col-md-4">
              <label>Paterno</label>
              <input type="text" name="cpaterno_empleado_taller" class="form-control" required value="{{ old('cpaterno_empleado_taller') }}">
            </div>
            <div class="form-group col-md-4">
              <label>Materno</label>
              <input type="text" name="cmaterno_empleado_taller" class="form-control" value="{{ old('cmaterno_empleado_taller') }}">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Puesto (ID)</label>
              <input type="number" name="iid_puesto" class="form-control" value="{{ old('iid_puesto') }}">
            </div>
            <div class="form-group col-md-6">
              <label>Adscripción (ID)</label>
              <input type="number" name="iid_adscripcion" class="form-control" value="{{ old('iid_adscripcion') }}">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Taller (ID)</label>
              <input type="number" name="iid_taller" class="form-control" value="{{ old('iid_taller') }}">
            </div>
            <div class="form-group col-md-6">
              <label>Cuadrilla (ID)</label>
              <input type="number" name="iid_cuadrilla" class="form-control" value="{{ old('iid_cuadrilla') }}">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-12">
              <label>Correo Electrónico</label>
              <input type="email" name="ccorreo_electronico" class="form-control" value="{{ old('ccorreo_electronico') }}">
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>

{{-- Reabrir modal si hubo errores de validación --}}
@if($errors->any())
<script>
document.addEventListener("DOMContentLoaded", function () {
    $('#modalNuevoEmpleado').modal('show');
});
</script>
@endif

@endsection

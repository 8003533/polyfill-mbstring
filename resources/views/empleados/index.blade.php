@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/person-lines-fill.svg') }}" width="18" height="18">
        Listado de Empleados de Talleres
    </h4>
@endsection

@section('panel')
<div class="table-responsive">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif


    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <p>Corrige los errores para continuar</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

<!-- NUEVO -->
    <div class="row mb-2">
        <div class="col text-right">
            <a href="#" data-toggle="modal" data-target="#modalNuevoEmpleado">
                + Nuevo Empleado Taller
            </a>
        </div>
    </div>
<!-- tabla -->
    <table class="table table-striped shadow-lg" id="MyTableEmpleados">
        <thead>
            <tr>
                <th class="text-center">Nombre</th>
                <th class="text-center">Apellido Paterno</th>
                <th class="text-center">Apellido Materno</th>
                <th class="text-center">Puesto</th>
                <th class="text-center">Adscripción</th>
                <th class="text-center">Taller</th>
                <th class="text-center">Cuadrilla</th>
                <th class="text-center">Correo</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($empleados as $empleado)
            <tr>
                <td class="text-center">{{ $empleado->cnombre_empleado_taller }}</td>
                <td class="text-center">{{ $empleado->cpaterno_empleado_taller }}</td>
                <td class="text-center">{{ $empleado->cmaterno_empleado_taller }}</td>
                <td class="text-center">{{ $empleado->cdescripcion_puesto }}</td>
                <td class="text-center">{{ $empleado->cdescripcion_adscripcion }}</td>
                <td class="text-center">{{ $empleado->cdescripcion_taller }}</td>
                <td class="text-center">{{ $empleado->cnombre_cuadrilla }}</td>
                <td class="text-center">{{ $empleado->ccorreo_electronico }}</td>
                <td class="text-center">
                    <a href="{{ url('empleados/editar/'.$empleado->iid_empleado_taller) }}">
                        <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18">
                    </a>
                    <a href="{{ url('empleados/inhabilitar/'.$empleado->iid_empleado_taller) }}">
                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18">
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

 <!-- MODAL NUEVO  -->
<div class="modal fade" id="modalNuevoEmpleado" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title">Nuevo Empleado de Taller</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <form method="POST" action="{{ url('empleados/guardar') }}">
        @csrf
        <div class="modal-body">

          <div class="form-row">
            <div class="form-group col-md-4">
              <label>Nombre:</label>
              <input type="text" name="cnombre_empleado_taller" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
              <label>Apellido Paterno:</label>
              <input type="text" name="cpaterno_empleado_taller" class="form-control" required>
            </div>
            <div class="form-group col-md-4">
              <label>Apellido Materno:</label>
              <input type="text" name="cmaterno_empleado_taller" class="form-control">
            </div>
          </div>

          
          <div class="form-group">
            <label>Correo:</label>
            <input type="email" name="ccorreo_electronico" class="form-control">
          </div>


          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Puesto:</label>
              <select name="iid_puesto" id="iid_puesto" class="form-control select2-modal">
                <option value=""></option>
                @foreach($puestos as $p)
                  <option value="{{ $p->iid_puesto }}">{{ $p->cdescripcion_puesto }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-md-6">
              <label>Adscripción:</label>
              <select name="iid_adscripcion" id="iid_adscripcion" class="form-control select2-modal">
                <option value=""></option>
                @foreach($adscripciones as $a)
                  <option value="{{ $a->iid_adscripcion }}">{{ $a->cdescripcion_adscripcion }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label>Taller:</label>
              <select name="iid_taller" id="iid_taller" class="form-control select2-modal">
                <option value=""></option>
                @foreach($talleres as $t)
                  <option value="{{ $t->iid_taller }}">{{ $t->cdescripcion_taller }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group col-md-6">
              <label>Cuadrilla:</label>
              <select name="iid_cuadrilla" id="iid_cuadrilla" class="form-control select2-modal">
                <option value=""></option>
                @foreach($cuadrillas as $c)
                  <option value="{{ $c->iid_cuadrilla }}">{{ $c->cnombre_cuadrilla }}</option>
                @endforeach
              </select>
            </div>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
      </form>

    </div>
  </div>
</div>

<!-- Select -->
<script>
$(document).ready(function () {

  function initSelect2() {
    $('.select2-modal').select2({
      width: '100%',
      dropdownParent: $('#modalNuevoEmpleado'),
      placeholder: 'Buscar...',
      allowClear: true
    });
  }

  $('#modalNuevoEmpleado').on('shown.bs.modal', function () {
    initSelect2();
  });

  @if($errors->any())
    $('#modalNuevoEmpleado').modal('show');
    setTimeout(initSelect2, 200);
  @endif

});
</script>

<style>
.select2-container .select2-selection--single {
  height: calc(2.25rem + 2px);
  padding: .375rem .75rem;
}
.select2-selection__rendered {
  line-height: 1.5 !important;
}
.select2-selection__arrow {
  height: calc(2.25rem + 2px);
}
</style>

@endsection

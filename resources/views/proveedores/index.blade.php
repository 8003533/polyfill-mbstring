@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
    Listado de Proveedores
</h3>
@endsection

@section('panel')
<div class="table-responsive">

    {{-- Mensaje éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Mensaje danger --}}
    @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Errores --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>Corrige los errores para continuar</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- Nuevo Proveedor (MODAL) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevoProveedor"
               data-toggle="tooltip"
               data-html="true"
               title="Nuevo Proveedor">
                + Nuevo Proveedor
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTableProveedores">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Contacto</th>
                <th class="text-center">Dirección</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($proveedores as $prov)
                <tr>
                    <td class="text-center">{{ $prov->id_proveedor }}</td>
                    <td class="text-center">{{ $prov->nombre }}</td>
                    <td class="text-center">{{ $prov->contacto }}</td>
                    <td class="text-center">{{ $prov->direccion }}</td>
                    <td class="text-center">{{ $prov->telefono }}</td>

                    <td class="text-center">
                        @if($prov->estatus == 1)
                            <span>Activo</span>
                        @else
                            <span>Inactivo</span>
                        @endif
                    </td>

                    <td class="text-center col-actions">

                        {{-- EDITAR (MODAL) --}}
                        <button type="button" class="btn"
                            data-toggle="modal"
                            data-target="#modalEditarProveedor"
                            data-id="{{ $prov->id_proveedor }}"
                            data-nombre="{{ $prov->nombre }}"
                            data-contacto="{{ $prov->contacto }}"
                            data-direccion="{{ $prov->direccion }}"
                            data-telefono="{{ $prov->telefono }}"
                            title="Actualizar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </button>

                        {{-- ELIMINAR (DELETE) (MODAL) --}}
                        <button type="button" class="btn"
                            data-toggle="modal"
                            data-target="#modalEliminarProveedor"
                            data-id="{{ $prov->id_proveedor }}"
                            data-nombre="{{ $prov->nombre }}"
                            title="Borrar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>




{{-- =========================
    MODAL: NUEVO PROVEEDOR
========================= --}}
<div class="modal fade" id="modalNuevoProveedor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">
            <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
            Nuevo Proveedor
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('proveedores.guardar') }}" id="formNuevoProveedor">
          @csrf

          <div class="form-group">
            <label><b>Nombre:</b></label>
            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre') }}" maxlength="255" required>
            @error('nombre')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label><b>Contacto:</b></label>
            <input type="text" name="contacto" class="form-control" value="{{ old('contacto') }}" maxlength="255">
          </div>

          <div class="form-group">
            <label><b>Dirección:</b></label>
            <input type="text" name="direccion" class="form-control" value="{{ old('direccion') }}" maxlength="255">
          </div>

          <div class="form-group">
            <label><b>Teléfono:</b></label>
            <input type="text" name="telefono" class="form-control" value="{{ old('telefono') }}" maxlength="50">
          </div>

          <div class="row text-center mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    Guardar
                </button>

                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                    <span>&nbsp;Cancelar</span>
                </button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>


{{-- =========================
    MODAL: EDITAR PROVEEDOR
========================= --}}
<div class="modal fade" id="modalEditarProveedor" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('proveedores.actualizar') }}" id="formEditarProveedor">
          @csrf

          <input type="hidden" id="edit_id_proveedor" name="id_proveedor">

          <div class="form-group">
            <label><b>Nombre:</b></label>
            <input type="text" id="edit_nombre" name="nombre" class="form-control" maxlength="255" required>
          </div>

          <div class="form-group">
            <label><b>Contacto:</b></label>
            <input type="text" id="edit_contacto" name="contacto" class="form-control" maxlength="255">
          </div>

          <div class="form-group">
            <label><b>Dirección:</b></label>
            <input type="text" id="edit_direccion" name="direccion" class="form-control" maxlength="255">
          </div>

          <div class="form-group">
            <label><b>Teléfono:</b></label>
            <input type="text" id="edit_telefono" name="telefono" class="form-control" maxlength="50">
          </div>

          <div class="row text-center mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    Guardar
                </button>

                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                    <span>&nbsp;Cancelar</span>
                </button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>


{{-- =========================
    MODAL: ELIMINAR PROVEEDOR (DELETE)
========================= --}}
<div class="modal fade" id="modalEliminarProveedor" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar este proveedor?</p>
        <strong id="nombreEliminarProveedor"></strong>
      </div>

      <div class="modal-footer justify-content-center">

        <form id="formEliminarProveedor" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-primary">
            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
            Sí, eliminar
          </button>
        </form>

        <button type="button" class="btn btn-primary" data-dismiss="modal">
          <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
          <span>&nbsp;Cancelar</span>
        </button>

      </div>

    </div>
  </div>
</div>


{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    $('[data-toggle="tooltip"]').tooltip();

    // Modal Editar: llenar campos
    $('#modalEditarProveedor').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#edit_id_proveedor').val(button.data('id'));
        $('#edit_nombre').val(button.data('nombre'));
        $('#edit_contacto').val(button.data('contacto'));
        $('#edit_direccion').val(button.data('direccion'));
        $('#edit_telefono').val(button.data('telefono'));
    });

    // Modal Eliminar: set action DELETE
    $('#modalEliminarProveedor').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');

        $('#nombreEliminarProveedor').text(nombre);
        $('#formEliminarProveedor').attr('action', "{{ url('proveedores') }}/" + id);
    });

});
</script>

@endsection

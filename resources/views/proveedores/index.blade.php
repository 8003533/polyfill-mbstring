@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
    Listado de Proveedores
</h3>
@endsection

@section('panel')
<div class="table-responsive">

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

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

    {{-- Nuevo Proveedor (MODAL) --}}
    <div class="row mb-2">
        <div class="col col-form-label text-md-right">
            <a href="#" data-toggle="modal" data-target="#modalNuevoProveedor" title="Nuevo Proveedor">
                + Nuevo Proveedor
            </a>
        </div>
    </div>

    {{-- TABLA --}}
    <table class="table table-striped shadow-lg" id="MyTableProveedores">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Contacto</th>
                <th class="text-center">Dirección</th>
                <th class="text-center">Teléfono</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @if(isset($proveedores) && $proveedores->count())
                @foreach($proveedores as $prov)
                    <tr>
                        <td class="text-center">{{ $prov->id_proveedor }}</td>
                        <td class="text-center">{{ $prov->nombre }}</td>
                        <td class="text-center">{{ $prov->contacto }}</td>
                        <td class="text-center">{{ $prov->direccion }}</td>
                        <td class="text-center">{{ $prov->telefono }}</td>

                        <td class="text-center col-actions">

                            {{-- Editar (modal) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#modalEditarProveedor"
                                data-id="{{ $prov->id_proveedor }}"
                                data-nombre="{{ $prov->nombre }}"
                                data-contacto="{{ $prov->contacto }}"
                                data-direccion="{{ $prov->direccion }}"
                                data-telefono="{{ $prov->telefono }}"
                                title="Editar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </button>

                            {{-- Eliminar (modal) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#modalEliminarProveedor"
                                data-id="{{ $prov->id_proveedor }}"
                                data-nombre="{{ $prov->nombre }}"
                                title="Eliminar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                            </button>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center text-muted">No hay proveedores registrados</td>
                </tr>
            @endif
        </tbody>
    </table>

</div>


{{-- ================= MODAL: NUEVO PROVEEDOR ================= --}}
<div class="modal fade" id="modalNuevoProveedor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Nuevo Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('proveedores.guardar') }}" id="formNuevoProveedor">
          @csrf

          <div class="form-group">
            <label><b>Nombre</b></label>
            <input type="text" name="nombre" class="form-control" required>
          </div>

          <div class="form-group">
            <label><b>Contacto</b></label>
            <input type="text" name="contacto" class="form-control">
          </div>

          <div class="form-group">
            <label><b>Dirección</b></label>
            <input type="text" name="direccion" class="form-control">
          </div>

          <div class="form-group">
            <label><b>Teléfono</b></label>
            <input type="text" name="telefono" class="form-control">
          </div>

          <div class="row text-center mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    Guardar
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>


{{-- ================= MODAL: EDITAR PROVEEDOR ================= --}}
<div class="modal fade" id="modalEditarProveedor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('proveedores.actualizar') }}" id="formEditarProveedor">
          @csrf

          <input type="hidden" id="edit_id_proveedor" name="id_proveedor">

          <div class="form-group">
            <label><b>Nombre</b></label>
            <input type="text" id="edit_nombre" name="nombre" class="form-control" required>
          </div>

          <div class="form-group">
            <label><b>Contacto</b></label>
            <input type="text" id="edit_contacto" name="contacto" class="form-control">
          </div>

          <div class="form-group">
            <label><b>Dirección</b></label>
            <input type="text" id="edit_direccion" name="direccion" class="form-control">
          </div>

          <div class="form-group">
            <label><b>Teléfono</b></label>
            <input type="text" id="edit_telefono" name="telefono" class="form-control">
          </div>

          <div class="row text-center mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    Guardar
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>


{{-- ================= MODAL: ELIMINAR PROVEEDOR ================= --}}
<div class="modal fade" id="modalEliminarProveedor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar al proveedor?</p>
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

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>


{{-- SCRIPTS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Editar
    $('#modalEditarProveedor').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        $('#edit_id_proveedor').val(b.data('id'));
        $('#edit_nombre').val(b.data('nombre'));
        $('#edit_contacto').val(b.data('contacto'));
        $('#edit_direccion').val(b.data('direccion'));
        $('#edit_telefono').val(b.data('telefono'));
    });

    // Eliminar
    $('#modalEliminarProveedor').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);
        $('#nombreEliminarProveedor').text(b.data('nombre'));

        // DELETE /proveedores/{id}
        $('#formEliminarProveedor').attr('action', "{{ url('proveedores') }}/" + b.data('id'));
    });

});
</script>

@endsection

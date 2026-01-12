@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
    Listado de Proveedores
</h3>
@endsection

@section('panel')
<div class="table-responsive">



    <!-- Crear un Proveedor -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="{{ url('proveedores/nuevo') }}" data-toggle="tooltip" title="Nuevo Proveedor">
                + Nuevo Proveedor
            </a>
        </div>
    </div>


    <!-- TABLA -->
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
            @foreach($proveedores as $prov)
                <tr>
                    <td class="text-center">{{ $prov->id_proveedor }}</td>
                    <td class="text-center">{{ $prov->nombre }}</td>
                    <td class="text-center">{{ $prov->contacto }}</td>
                    <td class="text-center">{{ $prov->direccion }}</td>
                    <td class="text-center">{{ $prov->telefono }}</td>
                    

                    <td class="text-center col-actions">

                        <!-- Botón Editar -->
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#editarModal"
                            data-id="{{ $prov->id_proveedor }}"
                            data-nombre="{{ $prov->nombre }}"
                            data-contacto="{{ $prov->contacto }}"
                            data-telefono="{{ $prov->telefono }}">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </button>

                        <!-- Botón Eliminar -->
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#confirmarEliminarModal"
                            data-id="{{ $prov->id_proveedor }}"
                            data-nombre="{{ $prov->nombre }}">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


<!-- MODAL EDITAR -->
<div class="modal fade" id="editarModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('proveedores.actualizar') }}">
          @csrf
          <input type="hidden" id="id_proveedor" name="id_proveedor">

          <div class="form-group">
            <label for="nombre">Proveedor:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
          </div>

          <div class="form-group">
            <label for="contacto">Contacto:</label>
            <input type="text" id="contacto" name="contacto" class="form-control">
          </div>

          <div class="form-group">
            <label for="telefono">Teléfono:</label>
            <input type="text" id="telefono" name="telefono" class="form-control">
          </div>

          <div class="form-froup">
            <label for="dirección">Dirección:</label>
            <input type="text" id="direccion" name="direccion" class="form-control">
          </div>

          <div class="row text-center mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18"> Guardar
                </button>

                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18"> Cancelar
                </button>
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Proveedor</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar al proveedor <strong id="nombreEliminar"></strong>?</p>
      </div>

      <div class="modal-footer justify-content-center">
        <form id="formEliminar" method="POST" action="">
          @csrf
          @method('DELETE')

          <button type="submit" class="btn btn-primary">
            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
            Sí, eliminar
          </button>
        </form>

        <button type="button" class="btn btn-primary" data-dismiss="modal">
            <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18"> Cancelar
        </button>
      </div>

    </div>
  </div>
</div>

<!-- SCRIPTS -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Modal Editar
    $('#editarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#id_proveedor').val(button.data('id'));
        $('#nombre').val(button.data('nombre'));
        $('#contacto').val(button.data('contacto'));
        $('#telefono').val(button.data('telefono'));
    });

    // Modal Eliminar
    $('#confirmarEliminarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#nombreEliminar').text(button.data('nombre'));
        $('#formEliminar').attr('action', '/proveedores/' + button.data('id'));
    });

});
</script>

@endsection

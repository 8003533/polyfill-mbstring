@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
  {{-- Insertar imagen o icono --}}
    <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18"> 
    Listado de Áreas
    
</h3>
@endsection

@section('panel')
<div class="table-responsive">


    <!-- Crear una Nueva Área -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="{{ url('areas/nuevo') }}" data-toggle="tooltip" data-html="true" title="Nueva Área">
                + Nueva Área
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTableAreas">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($areas as $area)
                <tr>
                    <td class="text-center">{{ $area->id_areas }}</td>
                    <td class="text-center">{{ $area->nombre }}</td>
                    <td class="text-center">
                        @if ($area->estatus == 1)
                            <span>Activo</span>
                        @else
                            <span>Inactivo</span>
                        @endif
                    </td>
                    <td class="text-center col-actions">
                        
                        <!-- Botón Editar -->
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#editarModal"
                            data-id="{{ $area->id_areas }}"
                            data-nombre="{{ $area->nombre }}"
                            data-estatus="{{ $area->estatus }}">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </button>
                        
                        <!-- Botón Eliminar -->
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#confirmarEliminarModal"
                            data-id="{{ $area->id_areas }}"
                            data-nombre="{{ $area->nombre }}">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginación  --}}
<div class="d-flex justify-content-between align-items-center mt-3">

    {{-- Texto de registros --}}
    <div>
        Mostrando registros del {{ $areas->firstItem() }} al {{ $areas->lastItem() }}
        de un total de {{ $areas->total() }} registros
    </div>

    {{-- Paginación --}}
    <div>
        {{ $areas->appends(['area' => request('area')])->links('pagination::bootstrap-4') }}
    </div>

</div>
<!-- MODAL EDITAR ÁREA -->
<div class="modal fade" id="editarModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document"> 
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Área</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('areas.actualizar') }}">
          @csrf
          <input type="hidden" id="id_areas" name="id_areas">

          <div class="form-group">
            <label for="nombre">Área:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" required>
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

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Área</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar esta área <strong id="nombreEliminar"></strong>?</p>
      </div>

      <div class="modal-footer justify-content-center">
        <form id="formEliminar" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-primary"><img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
            Sí, eliminar</button>

        </form>
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                  <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                  <span>&nbsp;Cancelar</span>

                </button>

    </div>
  </div>
</div>

<!-- Scripts -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Modal Editar
    $('#editarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#id_areas').val(button.data('id'));
        $('#nombre').val(button.data('nombre'));
        $('#estatus').val(button.data('estatus'));
    });

    // Modal Eliminar
    $('#confirmarEliminarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#nombreEliminar').text(button.data('nombre'));
        $('#formEliminar').attr('action', '/areas/' + button.data('id'));
    });

});
</script>

@endsection

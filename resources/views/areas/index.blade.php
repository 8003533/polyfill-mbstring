@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
    Listado de Áreas
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

    <!-- Nueva Área (MODAL) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevaArea"
               data-toggle="tooltip"
               data-html="true"
               title="Nueva Área">
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
                        @if($area->estatus == 1)
                            <span>Activo</span>
                        @else
                            <span>Inactivo</span>
                        @endif
                    </td>

                    <td class="text-center col-actions">

                        {{-- EDITAR (MODAL) --}}
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#modalEditarArea"
                            data-id="{{ $area->id_areas }}"
                            data-nombre="{{ $area->nombre }}"
                            title="Actualizar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </button>

                        {{-- ELIMINAR (DELETE) (MODAL) --}}
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#modalEliminarArea"
                            data-id="{{ $area->id_areas }}"
                            data-nombre="{{ $area->nombre }}"
                            title="Borrar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>


                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



{{-- =========================
    MODAL: NUEVA ÁREA
========================= --}}
<div class="modal fade" id="modalNuevaArea" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">
            <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
            Nueva Área
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('areas.guardar') }}" id="formNuevaArea">
          @csrf

          <div class="form-group">
            <label for="new_nombre"><b>Área:</b></label>
            <input type="text"
                   id="new_nombre"
                   name="nombre"
                   class="form-control @error('nombre') is-invalid @enderror"
                   value="{{ old('nombre') }}"
                   maxlength="255"
                   required>
            @error('nombre')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
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
    MODAL: EDITAR ÁREA
========================= --}}
<div class="modal fade" id="modalEditarArea" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Área</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('areas.actualizar') }}" id="formEditarArea">
          @csrf

          <input type="hidden" id="edit_id_areas" name="id_areas">

          <div class="form-group">
            <label for="edit_nombre"><b>Área:</b></label>
            <input type="text"
                   id="edit_nombre"
                   name="nombre"
                   class="form-control"
                   maxlength="255"
                   required>
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
    MODAL: ELIMINAR ÁREA (DELETE)
========================= --}}
<div class="modal fade" id="modalEliminarArea" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Área</h5>
        {{-- botones --}}
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar esta área?</p>
        <strong id="nombreEliminarArea"></strong>
      </div>

      <div class="modal-footer justify-content-center">

        <form id="formEliminarArea" method="POST" action="">
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
    $('#modalEditarArea').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#edit_id_areas').val(button.data('id'));
        $('#edit_nombre').val(button.data('nombre'));
    });

    // Modal Eliminar: set action DELETE
    $('#modalEliminarArea').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');

        $('#nombreEliminarArea').text(nombre);
        $('#formEliminarArea').attr('action', "{{ url('areas') }}/" + id);
    });

});
</script>

@endsection

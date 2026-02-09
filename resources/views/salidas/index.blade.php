@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-up.svg') }}" width="18" height="18">
    Listado de Salidas
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

    <!-- Nueva Salida (MODAL) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevaSalida"
               data-toggle="tooltip"
               data-html="true"
               title="Nueva Salida">
                + Nueva Salida
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTableSalidas">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Folio</th>
                <th class="text-center">Motivo</th>
                <th class="text-center">Total utilizada</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salidas as $s)
                <tr>
                    <td class="text-center">{{ $s->id_salida }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($s->fecha)->format('Y-m-d') }}</td>
                    <td class="text-center">{{ $s->folio ?? '-' }}</td>
                    <td class="text-center">{{ $s->motivo ?? '-' }}</td>
                    <td class="text-center">{{ $s->total_utilizada ?? 0 }}</td>

                    <td class="text-center">
                        @if(($s->estatus ?? 1) == 1)
                            <span>Activo</span>
                        @else
                            <span>Inactivo</span>
                        @endif
                    </td>

                    <td class="text-center col-actions">

                        {{-- EDITAR (MODAL) --}}
                        <button type="button" class="btn"
                            data-toggle="modal"
                            data-target="#modalEditarSalida"
                            data-id="{{ $s->id_salida }}"
                            data-fecha="{{ \Carbon\Carbon::parse($s->fecha)->format('Y-m-d') }}"
                            data-folio="{{ $s->folio ?? '' }}"
                            data-motivo="{{ $s->motivo ?? '' }}"
                            data-estatus="{{ $s->estatus ?? 1 }}"
                            title="Actualizar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </button>

                        {{-- ELIMINAR (DELETE) (MODAL) --}}
                        <button type="button" class="btn"
                            data-toggle="modal"
                            data-target="#modalEliminarSalida"
                            data-id="{{ $s->id_salida }}"
                            data-folio="{{ $s->folio ?? '' }}"
                            title="Borrar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



{{-- =========================
    MODAL: NUEVA SALIDA
========================= --}}
<div class="modal fade" id="modalNuevaSalida" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">
            <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-up.svg') }}" width="18" height="18">
            Nueva Salida
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('salidas.guardar') }}" id="formNuevaSalida">
          @csrf

          <div class="form-group">
            <label><b>Fecha:</b></label>
            <input type="date" name="fecha"
                   class="form-control @error('fecha') is-invalid @enderror"
                   value="{{ old('fecha') }}" required>
            @error('fecha')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label><b>Folio:</b></label>
            <input type="text" name="folio"
                   class="form-control @error('folio') is-invalid @enderror"
                   value="{{ old('folio') }}" maxlength="100">
            @error('folio')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label><b>Motivo:</b></label>
            <input type="text" name="motivo"
                   class="form-control @error('motivo') is-invalid @enderror"
                   value="{{ old('motivo') }}" maxlength="255" required>
            @error('motivo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label><b>Estatus:</b></label>
            <select name="estatus" class="form-control" required>
                <option value="1" {{ old('estatus',1)==1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ old('estatus',1)==0 ? 'selected' : '' }}>Inactivo</option>
            </select>
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
    MODAL: EDITAR SALIDA
========================= --}}
<div class="modal fade" id="modalEditarSalida" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Salida</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('salidas.actualizar') }}" id="formEditarSalida">
          @csrf

          <input type="hidden" id="edit_id_salida" name="id_salida">

          <div class="form-group">
            <label><b>Fecha:</b></label>
            <input type="date" id="edit_fecha" name="fecha" class="form-control" required>
          </div>

          <div class="form-group">
            <label><b>Folio:</b></label>
            <input type="text" id="edit_folio" name="folio" class="form-control" maxlength="100">
          </div>

          <div class="form-group">
            <label><b>Motivo:</b></label>
            <input type="text" id="edit_motivo" name="motivo" class="form-control" maxlength="255" required>
          </div>

          <div class="form-group">
            <label><b>Estatus:</b></label>
            <select id="edit_estatus" name="estatus" class="form-control" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
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
    MODAL: ELIMINAR SALIDA (DELETE)
========================= --}}
<div class="modal fade" id="modalEliminarSalida" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Salida</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar esta salida?</p>
        <strong id="folioEliminarSalida"></strong>
      </div>

      <div class="modal-footer justify-content-center">

        <form id="formEliminarSalida" method="POST" action="">
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
    $('#modalEditarSalida').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        $('#edit_id_salida').val(button.data('id'));
        $('#edit_fecha').val(button.data('fecha'));
        $('#edit_folio').val(button.data('folio'));
        $('#edit_motivo').val(button.data('motivo'));
        $('#edit_estatus').val(String(button.data('estatus')));
    });

    // Modal Eliminar: set action DELETE
    $('#modalEliminarSalida').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var folio = button.data('folio');

        $('#folioEliminarSalida').text(folio ? folio : ('ID: ' + id));
        $('#formEliminarSalida').attr('action', "{{ url('salidas') }}/" + id);
    });

});
</script>

@endsection

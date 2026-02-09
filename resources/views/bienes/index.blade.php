@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box.svg') }}" width="18" height="18">
    Listado de Bienes
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

    <!-- Nuevo Bien (MODAL) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevoBien"
               data-toggle="tooltip"
               data-html="true"
               title="Nuevo Bien">
                + Nuevo Bien
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTableBienes">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Código</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Unidad</th>
                <th class="text-center">Categoría</th>
                <th class="text-center">Stock Min</th>
                <th class="text-center">Stock Max</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bienes as $bien)
                <tr>
                    <td class="text-center">{{ $bien->id_bien }}</td>
                    <td class="text-center">{{ $bien->codigo }}</td>
                    <td class="text-center">{{ $bien->nombre }}</td>
                    <td class="text-center">{{ $bien->unidad_nombre ?? '—' }}</td>
                    <td class="text-center">{{ $bien->categoria_nombre ?? '—' }}</td>
                    <td class="text-center">{{ $bien->stok_min }}</td>
                    <td class="text-center">{{ $bien->stok_max }}</td>

                    <td class="text-center col-actions">

                        {{-- EDITAR (MODAL) --}}
                        <button type="button" class="btn"
                            data-toggle="modal"
                            data-target="#modalEditarBien"
                            data-id="{{ $bien->id_bien }}"
                            data-codigo="{{ $bien->codigo }}"
                            data-nombre="{{ $bien->nombre }}"
                            data-id_unidad="{{ $bien->id_unidad }}"
                            data-id_categoria="{{ $bien->id_categoria }}"
                            data-stok_min="{{ $bien->stok_min }}"
                            data-stok_max="{{ $bien->stok_max }}"
                            title="Actualizar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </button>

                        {{-- ELIMINAR (DELETE) (MODAL) --}}
                        <button type="button" class="btn"
                            data-toggle="modal"
                            data-target="#modalEliminarBien"
                            data-id="{{ $bien->id_bien }}"
                            data-nombre="{{ $bien->nombre }}"
                            title="Borrar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="d-flex justify-content-between align-items-center mt-3">

        <div>
            Mostrando registros del {{ $bienes->firstItem() }} al {{ $bienes->lastItem() }}
            de un total de {{ $bienes->total() }} registros
        </div>

        <div>
            {{ $bienes->appends([
                'codigo' => request('codigo'),
                'nombre' => request('nombre'),
            ])->links('pagination::bootstrap-4') }}
        </div>

    </div>

</div>


{{-- =========================
    MODAL: NUEVO BIEN
========================= --}}
<div class="modal fade" id="modalNuevoBien" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">
            <img src="{{ asset('bootstrap-icons-1.5.0/box.svg') }}" width="18" height="18">
            Nuevo Bien
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('bienes.guardar') }}" id="formNuevoBien">
          @csrf

          <div class="form-group">
            <label for="new_codigo"><b>Código:</b></label>
            <input type="text"
                   id="new_codigo"
                   name="codigo"
                   class="form-control @error('codigo') is-invalid @enderror"
                   value="{{ old('codigo') }}"
                   maxlength="100"
                   required>
            @error('codigo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="new_nombre"><b>Nombre:</b></label>
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

          <div class="form-group">
            <label for="new_id_unidad"><b>Unidad:</b></label>
            <select id="new_id_unidad"
                    name="id_unidad"
                    class="form-control @error('id_unidad') is-invalid @enderror"
                    required>
                <option value="">Selecciona una unidad</option>
                @foreach($unidades as $u)
                    <option value="{{ $u->id_unidad }}" {{ old('id_unidad') == $u->id_unidad ? 'selected' : '' }}>
                        {{ $u->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_unidad')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="new_id_categoria"><b>Categoría:</b></label>
            <select id="new_id_categoria"
                    name="id_categoria"
                    class="form-control @error('id_categoria') is-invalid @enderror"
                    required>
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $c)
                    <option value="{{ $c->id_categoria }}" {{ old('id_categoria') == $c->id_categoria ? 'selected' : '' }}>
                        {{ $c->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_categoria')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="new_stok_min"><b>Stock Min:</b></label>
            <input type="number"
                   id="new_stok_min"
                   name="stok_min"
                   class="form-control @error('stok_min') is-invalid @enderror"
                   value="{{ old('stok_min') }}"
                   min="0"
                   step="1">
            @error('stok_min')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="new_stok_max"><b>Stock Max:</b></label>
            <input type="number"
                   id="new_stok_max"
                   name="stok_max"
                   class="form-control @error('stok_max') is-invalid @enderror"
                   value="{{ old('stok_max') }}"
                   min="0"
                   step="1">
            @error('stok_max')
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
    MODAL: EDITAR BIEN
========================= --}}
<div class="modal fade" id="modalEditarBien" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Bien</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('bienes.actualizar') }}" id="formEditarBien">
          @csrf

          <input type="hidden" id="edit_id_bien" name="id_bien">

          <div class="form-group">
            <label for="edit_codigo"><b>Código:</b></label>
            <input type="text" id="edit_codigo" name="codigo" class="form-control" maxlength="100" required>
          </div>

          <div class="form-group">
            <label for="edit_nombre"><b>Nombre:</b></label>
            <input type="text" id="edit_nombre" name="nombre" class="form-control" maxlength="255" required>
          </div>

          <div class="form-group">
            <label for="edit_id_unidad"><b>Unidad:</b></label>
            <select id="edit_id_unidad" name="id_unidad" class="form-control" required>
                <option value="">Selecciona una unidad</option>
                @foreach($unidades as $u)
                    <option value="{{ $u->id_unidad }}">{{ $u->nombre }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="edit_id_categoria"><b>Categoría:</b></label>
            <select id="edit_id_categoria" name="id_categoria" class="form-control" required>
                <option value="">Selecciona una categoría</option>
                @foreach($categorias as $c)
                    <option value="{{ $c->id_categoria }}">{{ $c->nombre }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="edit_stok_min"><b>Stock Min:</b></label>
            <input type="number" id="edit_stok_min" name="stok_min" class="form-control" min="0" step="1">
          </div>

          <div class="form-group">
            <label for="edit_stok_max"><b>Stock Max:</b></label>
            <input type="number" id="edit_stok_max" name="stok_max" class="form-control" min="0" step="1">
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
    MODAL: ELIMINAR BIEN (DELETE)
========================= --}}
<div class="modal fade" id="modalEliminarBien" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Bien</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar este bien?</p>
        <strong id="nombreEliminarBien"></strong>
      </div>

      <div class="modal-footer justify-content-center">

        <form id="formEliminarBien" method="POST" action="">
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
    $('#modalEditarBien').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        $('#edit_id_bien').val(button.data('id'));
        $('#edit_codigo').val(button.data('codigo'));
        $('#edit_nombre').val(button.data('nombre'));
        $('#edit_id_unidad').val(button.data('id_unidad'));
        $('#edit_id_categoria').val(button.data('id_categoria'));
        $('#edit_stok_min').val(button.data('stok_min'));
        $('#edit_stok_max').val(button.data('stok_max'));
    });

    // Modal Eliminar: set action DELETE
    $('#modalEliminarBien').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var nombre = button.data('nombre');

        $('#nombreEliminarBien').text(nombre);
        $('#formEliminarBien').attr('action', "{{ url('bienes') }}/" + id);
    });

});
</script>

@endsection

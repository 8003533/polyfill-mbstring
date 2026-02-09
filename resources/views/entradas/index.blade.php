@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-in-down.svg') }}" width="18" height="18">
    Listado de Entradas
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

    <!-- Nueva Entrada (MODAL) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevaEntrada"
               data-toggle="tooltip"
               data-html="true"
               title="Nueva Entrada">
                + Nueva Entrada
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTableEntradas">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Proveedor</th>
                <th class="text-center">Folio</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Total</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($entradas as $ent)
                @php
                    $proveedorNombre = $ent->proveedor_nombre ?? '';
                    $total = $ent->total_cantidad ?? 0;
                @endphp

                <tr>
                    <td class="text-center">{{ $ent->id_entrada }}</td>
                    <td class="text-center">{{ $proveedorNombre }}</td>
                    <td class="text-center">{{ $ent->folio }}</td>
                    <td class="text-center">{{ $ent->tipo }}</td>
                    <td class="text-center">{{ $ent->fecha }}</td>
                    <td class="text-center">{{ $total }}</td>

                    <td class="text-center col-actions">

                        {{-- EDITAR (MODAL) --}}
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#modalEditarEntrada"
                            data-id="{{ $ent->id_entrada }}"
                            data-idproveedor="{{ $ent->id_proveedor }}"
                            data-folio="{{ $ent->folio }}"
                            data-tipo="{{ $ent->tipo }}"
                            data-fecha="{{ \Carbon\Carbon::parse($ent->fecha)->format('Y-m-d') }}"
                            title="Actualizar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </button>

                        {{-- ELIMINAR (DELETE) (MODAL) --}}
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#modalEliminarEntrada"
                            data-id="{{ $ent->id_entrada }}"
                            data-proveedor="{{ $proveedorNombre }}"
                            title="Borrar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

  


{{-- =========================
    MODAL: NUEVA ENTRADA
========================= --}}
<div class="modal fade" id="modalNuevaEntrada" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">
            <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-in-down.svg') }}" width="18" height="18">
            Nueva Entrada
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('entradas.guardar') }}" id="formNuevaEntrada">
          @csrf

          <div class="form-group">
            <label><b>Proveedor:</b></label>
            <select name="id_proveedor" class="form-control @error('id_proveedor') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id_proveedor }}" {{ old('id_proveedor') == $prov->id_proveedor ? 'selected' : '' }}>
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_proveedor')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label><b>Folio:</b></label>
            <input type="text" name="folio" class="form-control" value="{{ old('folio') }}">
          </div>

          <div class="form-group">
            <label><b>Tipo:</b></label>
            <input type="text" name="tipo" class="form-control @error('tipo') is-invalid @enderror"
                   value="{{ old('tipo') }}" maxlength="100" required>
            @error('tipo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label><b>Fecha:</b></label>
            <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                   value="{{ old('fecha') }}" required>
            @error('fecha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <hr>

          <div class="form-group">
            <label><b>Bien:</b></label>
            <select name="id_bien" class="form-control @error('id_bien') is-invalid @enderror" required>
                <option value="">Seleccione</option>
                @foreach($bienes as $b)
                    <option value="{{ $b->id_bien }}" {{ old('id_bien') == $b->id_bien ? 'selected' : '' }}>
                        {{ $b->codigo }} - {{ $b->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_bien')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label><b>Cantidad:</b></label>
            <input type="number" name="cantidad" class="form-control @error('cantidad') is-invalid @enderror"
                   value="{{ old('cantidad') }}" min="1" required>
            @error('cantidad')
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
    MODAL: EDITAR ENTRADA
========================= --}}
<div class="modal fade" id="modalEditarEntrada" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Entrada</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('entradas.actualizar') }}" id="formEditarEntrada">
          @csrf

          <input type="hidden" id="edit_id_entrada" name="id_entrada">

          <div class="form-group">
            <label><b>Proveedor:</b></label>
            <select id="edit_id_proveedor" name="id_proveedor" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id_proveedor }}">{{ $prov->nombre }}</option>
                @endforeach
            </select>
          </div>

          <div class="form-group">
            <label><b>Folio:</b></label>
            <input type="text" id="edit_folio" name="folio" class="form-control">
          </div>

          <div class="form-group">
            <label><b>Tipo:</b></label>
            <input type="text" id="edit_tipo" name="tipo" class="form-control" required>
          </div>

          <div class="form-group">
            <label><b>Fecha:</b></label>
            <input type="date" id="edit_fecha" name="fecha" class="form-control" required>
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
    MODAL: ELIMINAR ENTRADA (DELETE)
========================= --}}
<div class="modal fade" id="modalEliminarEntrada" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Entrada</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar esta entrada del proveedor?</p>
        <strong id="proveedorEliminarEntrada"></strong>
      </div>

      <div class="modal-footer justify-content-center">

        <form id="formEliminarEntrada" method="POST" action="">
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
    $('#modalEditarEntrada').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        $('#edit_id_entrada').val(button.data('id'));
        $('#edit_folio').val(button.data('folio'));
        $('#edit_tipo').val(button.data('tipo'));
        $('#edit_fecha').val(button.data('fecha'));
        $('#edit_id_proveedor').val(String(button.data('idproveedor')));
    });

    // Modal Eliminar: set action DELETE
    $('#modalEliminarEntrada').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var proveedor = button.data('proveedor');

        $('#proveedorEliminarEntrada').text(proveedor);
        $('#formEliminarEntrada').attr('action', "{{ url('entradas') }}/" + id);
    });

});
</script>

@endsection

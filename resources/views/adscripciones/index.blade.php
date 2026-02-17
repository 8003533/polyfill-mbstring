@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
    Listado de Adscripciones
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

  <!-- Nueva adscripción  -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#" data-toggle="modal" data-target="#modalNuevaAdscripcion"
               data-toggle="tooltip" data-html="true" title="Nueva Adscripción">
                + Nueva Adscripción
            </a>
        </div>
    </div>

   <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTableAdscripciones">
        <thead>
            <tr>
                <th class="text-center">Descripción</th>
                <th class="text-center">Siglas</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @php
                $map = [
                    1 => 'Dirección General',
                    2 => 'Subdirección',
                    3 => 'Jefatura de Departamento',
                    4 => 'Coordinación',
                    5 => 'Área Administrativa',
                    6 => 'Recursos Humanos',
                    7 => 'Finanzas / Contabilidad',
                    8 => 'Sistemas / TI',
                    9 => 'Otra',
                ];
            @endphp

            @foreach($adscripciones as $adscripcion)
                <tr>
                    <td class="text-center">{{ $adscripcion->cdescripcion_adscripcion }}</td>
                    <td class="text-center">{{ $adscripcion->csiglas }}</td>
                    <td class="text-center">{{ $map[$adscripcion->iid_tipo_area] ?? 'Sin tipo' }}</td>
                    <td class="text-center">
                        @if($adscripcion->iestatus == 1)
                            <span>Activo</span>
                        @else
                            <span>Inactivo</span>
                        @endif
                    </td>

                    <td class="text-center col-actions">

                        @if($adscripcion->iestatus == 1)
                            {{-- Botón Editar (modal) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#editarModalAdscripcion"
                                data-id="{{ $adscripcion->iid_adscripcion }}"
                                data-descripcion="{{ $adscripcion->cdescripcion_adscripcion }}"
                                data-siglas="{{ $adscripcion->csiglas }}"
                                data-tipo="{{ $adscripcion->iid_tipo_area }}">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </button>

                            <!-- Botón Inhabilitar  -->
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#confirmarInhabilitarModal"
                                data-id="{{ $adscripcion->iid_adscripcion }}"
                                data-nombre="{{ $adscripcion->cdescripcion_adscripcion }}"
                                data-estatus="1">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                            </button>
                        @else
                           <!-- Botón Recuperar  -->
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#confirmarInhabilitarModal"
                                data-id="{{ $adscripcion->iid_adscripcion }}"
                                data-nombre="{{ $adscripcion->cdescripcion_adscripcion }}"
                                data-estatus="0">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </button>
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

 <!-- NUEVA ADSCRIPCIÓN -->

<div class="modal fade" id="modalNuevaAdscripcion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Nueva Adscripción</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('adscripciones.guardar') }}">
          @csrf

          <div class="form-group">
            <label for="cdescripcion_adscripcion"><b>Descripción:</b></label>
            <input type="text"
                   id="cdescripcion_adscripcion"
                   name="cdescripcion_adscripcion"
                   class="form-control @error('cdescripcion_adscripcion') is-invalid @enderror"
                   value="{{ old('cdescripcion_adscripcion') }}"
                   maxlength="300"
                   required>
            @error('cdescripcion_adscripcion')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="csiglas"><b>Siglas:</b></label>
            <input type="text"
                   id="csiglas"
                   name="csiglas"
                   class="form-control @error('csiglas') is-invalid @enderror"
                   value="{{ old('csiglas') }}"
                   maxlength="20">
            @error('csiglas')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="iid_tipo_area"><b>Tipo de Adscripción:</b></label>
            <select id="iid_tipo_area"
                    name="iid_tipo_area"
                    class="form-control @error('iid_tipo_area') is-invalid @enderror"
                    required>
              <option value="" disabled {{ old('iid_tipo_area') ? '' : 'selected' }}>-- Selecciona --</option>
              <option value="1" {{ old('iid_tipo_area')=='1'?'selected':'' }}>Dirección General</option>
              <option value="2" {{ old('iid_tipo_area')=='2'?'selected':'' }}>Subdirección</option>
              <option value="3" {{ old('iid_tipo_area')=='3'?'selected':'' }}>Jefatura de Departamento</option>
              <option value="4" {{ old('iid_tipo_area')=='4'?'selected':'' }}>Coordinación</option>
              <option value="5" {{ old('iid_tipo_area')=='5'?'selected':'' }}>Área Administrativa</option>
              <option value="6" {{ old('iid_tipo_area')=='6'?'selected':'' }}>Recursos Humanos</option>
              <option value="7" {{ old('iid_tipo_area')=='7'?'selected':'' }}>Finanzas / Contabilidad</option>
              <option value="8" {{ old('iid_tipo_area')=='8'?'selected':'' }}>Sistemas / TI</option>
              <option value="9" {{ old('iid_tipo_area')=='9'?'selected':'' }}>Otra</option>
            </select>
            @error('iid_tipo_area')
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

 <!-- EDITAR ADSCRIPCIÓN -->

<div class="modal fade" id="editarModalAdscripcion" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Adscripción</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('adscripciones.actualizar') }}">
          @csrf

          <input type="hidden" id="edit_iid_adscripcion" name="id_adscripcion">

          <div class="form-group">
            <label for="edit_cdescripcion_adscripcion"><b>Descripción:</b></label>
            <input type="text" id="edit_cdescripcion_adscripcion" name="cdescripcion_adscripcion" class="form-control" maxlength="300" required>
          </div>

          <div class="form-group">
            <label for="edit_csiglas"><b>Siglas:</b></label>
            <input type="text" id="edit_csiglas" name="csiglas" class="form-control" maxlength="20">
          </div>

          <div class="form-group">
            <label for="edit_iid_tipo_area"><b>Tipo de Adscripción:</b></label>
            <select id="edit_iid_tipo_area" name="iid_tipo_area" class="form-control" required>
                <option value="1">Dirección General</option>
                <option value="2">Subdirección</option>
                <option value="3">Jefatura de Departamento</option>
                <option value="4">Coordinación</option>
                <option value="5">Área Administrativa</option>
                <option value="6">Recursos Humanos</option>
                <option value="7">Finanzas / Contabilidad</option>
                <option value="8">Sistemas / TI</option>
                <option value="9">Otra</option>
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

    <!-- MODAL: INHABILITAR / RECUPERAR -->

<div class="modal fade" id="confirmarInhabilitarModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title" id="tituloAccionModal">Inhabilitar Adscripción</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p id="textoAccionModal"></p>
        <strong id="nombreAccion"></strong>
      </div>

      <div class="modal-footer justify-content-center">
        <a href="#" id="btnConfirmarAccion" class="btn btn-primary">
            <img id="iconoAccion" src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
            <span id="textoBtnAccion">Sí, inhabilitar</span>
        </a>

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

    //  Modal Editar
    $('#editarModalAdscripcion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        $('#edit_iid_adscripcion').val(button.data('id'));
        $('#edit_cdescripcion_adscripcion').val(button.data('descripcion'));
        $('#edit_csiglas').val(button.data('siglas'));
        $('#edit_iid_tipo_area').val(button.data('tipo'));
    });

    //  Modal Inhabilitar / Recuperar
    $('#confirmarInhabilitarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var id = button.data('id');
        var nombre = button.data('nombre');
        var estatus = button.data('estatus'); // 1 activo / 0 inactivo

        $('#nombreAccion').text(nombre);

        // Ruta
        $('#btnConfirmarAccion').attr('href', '/adscripciones/inhabilitar/' + id);

        if (estatus == 1) {
            $('#tituloAccionModal').text('Inhabilitar Adscripción');
            $('#textoAccionModal').text('¿Deseas inhabilitar esta adscripción?');
            $('#textoBtnAccion').text('Sí, inhabilitar');
            $('#iconoAccion').attr('src', "{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}");
        } else {
            $('#tituloAccionModal').text('Recuperar Adscripción');
            $('#textoAccionModal').text('¿Deseas recuperar esta adscripción?');
            $('#textoBtnAccion').text('Sí, recuperar');
            $('#iconoAccion').attr('src', "{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}");
        }
    });

    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

<!-- Reabrir modal NUEVO si hubo errores al guardar  -->
@if($errors->has('cdescripcion_adscripcion') || $errors->has('csiglas') || $errors->has('iid_tipo_area'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    $('#modalNuevaAdscripcion').modal('show');
});
</script>
@endif

@endsection

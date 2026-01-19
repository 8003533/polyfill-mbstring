@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
        Listado de Adscripciones
    </h4>
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

    {{-- Si hubo error de validación al guardar --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>Corrige los errores para continuar</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <div class="row">
        <div class="col col-form-label text-md-right">
            {{-- BOTÓN QUE ABRE MODAL --}}
            <button type="button" class="btn btn-link p-0" data-toggle="modal" data-target="#modalNuevaAdscripcion">
                + Nueva Adscripción
            </button>
        </div>
    </div>

    <table class="table table-striped shadow-lg" id="MyTableAdscripciones">
        <thead>
            <tr>
                <th class="text-center">Descripción de la Adscripción</th>
                <th class="text-center">Siglas</th>
                <th class="text-center">Tipo de Adscripción</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($adscripciones as $indice => $adscripcion)
                <tr>
                    <td class="text-center">{{ $adscripcion->cdescripcion_adscripcion }}</td>
                    <td class="text-center">{{ $adscripcion->csiglas }}</td>
                    <td class="text-center">{{ optional($adscripcion->tipoarea)->cdescripcion_tipo_area }}</td>
                    <td class="text-center col-actions">
                        @if ($adscripcion->iestatus == 1)
                            <a href="{{ route('adscripciones.editar', $adscripcion->iid_adscripcion) }}" data-toggle="tooltip" title="Actualizar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </a>

                            <a href="{{ route('adscripciones.inhabilitar', $adscripcion->iid_adscripcion) }}" data-toggle="tooltip" title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </a>
                        @else
                            <a href="{{ route('adscripciones.inhabilitar', $adscripcion->iid_adscripcion) }}" data-toggle="tooltip" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- MODAL NUEVA ADSCRIPCION --}}
<div class="modal fade" id="modalNuevaAdscripcion" tabindex="-1" role="dialog" aria-labelledby="modalNuevaAdscripcionLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">

      <form method="POST" action="{{ route('adscripciones.guardar') }}" id="formNuevaAdscripcion">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="modalNuevaAdscripcionLabel">
            <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
            Nueva Adscripción
          </h5>
          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        </div>

        <div class="modal-body">

          <div class="form-group">
            <label for="cdescripcion_adscripcion"><b>Descripción</b></label>
            <input type="text" class="form-control" id="cdescripcion_adscripcion" name="cdescripcion_adscripcion"
                   value="{{ old('cdescripcion_adscripcion') }}" maxlength="300" required>
          </div>

          <div class="form-group">
            <label for="csiglas">Siglas</label>
            <input type="text" class="form-control" id="csiglas" name="csiglas"
                   value="{{ old('csiglas') }}" maxlength="50">
          </div>

          <div class="form-group">
            <label for="iid_tipo_area"><b>Tipo de Adscripción</b></label>
            <select class="form-control" id="iid_tipo_area" name="iid_tipo_area" required>
              <option value="">Seleccione...</option>
              @foreach($tiposArea as $ta)
                <option value="{{ $ta->iid_tipo_area }}"
                    {{ (string)$ta->iid_tipo_area === (string)old('iid_tipo_area') ? 'selected' : '' }}>
                    {{ $ta->cdescripcion_tipo_area }}
                </option>
              @endforeach
            </select>
          </div>

        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

          <button type="submit" class="btn btn-primary">
            <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
            Guardar
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

{{-- Abrir modal automáticamente si hubo errores --}}
@if($errors->any())
<script>
document.addEventListener("DOMContentLoaded", function () {
    $('#modalNuevaAdscripcion').modal('show');
});
</script>
@endif

@endsection

@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/diagram-3.svg') }}" width="18" height="18">
        Listado de Puestos
    </h4>
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

    <!-- Nuevo Puesto (modal) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            {{--@altaPuesto--}}
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevoPuesto"
               data-toggle="tooltip"
               data-html="true"
               title="Nuevo Puesto">
                + Nuevo Puesto
            </a>
            {{--@endaltaPuesto--}}
        </div>
    </div>

    <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTablePuestos">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Descripción de Puesto</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($puestos as $puesto)
                <tr>
                    <td class="text-center">{{ $puesto->iid_puesto }}</td>
                    <td class="text-center">{{ $puesto->cdescripcion_puesto }}</td>

                    <td class="text-center col-actions">

                        @if($puesto->iestatus == 1)

                            {{-- Editar (modal) --}}
                            {{--@editaPuesto--}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#modalEditarPuesto"
                                data-id="{{ $puesto->iid_puesto }}"
                                data-descripcion="{{ $puesto->cdescripcion_puesto }}"
                                title="Actualizar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </button>
                            {{--@endeditaPuesto--}}

                            {{-- Inhabilitar (modal confirm) --}}
                            {{--@borraPuesto--}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#confirmarInhabilitarModalPuesto"
                                data-id="{{ $puesto->iid_puesto }}"
                                data-nombre="{{ $puesto->cdescripcion_puesto }}"
                                data-estatus="1"
                                title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                            </button>
                            {{--@endborraPuesto--}}

                        @else

                            {{-- Recuperar (modal confirm) --}}
                            {{--@borraPuesto--}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#confirmarInhabilitarModalPuesto"
                                data-id="{{ $puesto->iid_puesto }}"
                                data-nombre="{{ $puesto->cdescripcion_puesto }}"
                                data-estatus="0"
                                title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </button>
                            {{--@endborraPuesto--}}

                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>


{{-- =========================
    MODAL: NUEVO PUESTO
========================= --}}
<div class="modal fade" id="modalNuevoPuesto" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">
            <img src="{{ asset('bootstrap-icons-1.5.0/diagram-3.svg') }}" width="18" height="18">
            Nuevo Puesto
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ url('/puestos/guardar') }}" id="formNuevoPuesto">
          @csrf

          <div class="form-group">
            <label for="descripcion_puesto"><b>Descripción:</b></label>
            <input type="text"
                   id="descripcion_puesto"
                   name="descripcion_puesto"
                   class="form-control @error('descripcion_puesto') is-invalid @enderror"
                   value="{{ old('descripcion_puesto') }}"
                   maxlength="120"
                   required>
            @error('descripcion_puesto')
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
    MODAL: EDITAR PUESTO
========================= --}}
<div class="modal fade" id="modalEditarPuesto" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Puesto</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ url('/puestos/actualizar') }}" id="formEditarPuesto">
          @csrf

          <input type="hidden" id="edit_iid_puesto" name="id_puesto">

          <div class="form-group">
            <label for="edit_descripcion_puesto"><b>Descripción:</b></label>
            <input type="text"
                   id="edit_descripcion_puesto"
                   name="descripcion_puesto"
                   class="form-control"
                   maxlength="120"
                   required>
          </div>

          {{-- para distinguir edición vs toggle --}}
          <input type="hidden" name="noeditar" value="">

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
    MODAL: INHABILITAR / RECUPERAR
========================= --}}
<div class="modal fade" id="confirmarInhabilitarModalPuesto" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title" id="tituloAccionModalPuesto">Inhabilitar Puesto</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p id="textoAccionModalPuesto"></p>
        <strong id="nombreAccionPuesto"></strong>
      </div>

      <div class="modal-footer justify-content-center">

        <form method="POST" action="{{ url('/puestos/actualizar') }}" id="formAccionPuesto">
            @csrf
            <input type="hidden" name="id_puesto" id="accion_id_puesto">
            <input type="hidden" name="noeditar" value="disabled">

            <button type="submit" class="btn btn-primary">
                <img id="iconoAccionPuesto" src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                <span id="textoBtnAccionPuesto">Sí, inhabilitar</span>
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

    // Tooltips
    $('[data-toggle="tooltip"]').tooltip();

    // Modal Editar: llenar campos
    $('#modalEditarPuesto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#edit_iid_puesto').val(button.data('id'));
        $('#edit_descripcion_puesto').val(button.data('descripcion'));
    });

    // Modal Inhabilitar / Recuperar
    $('#confirmarInhabilitarModalPuesto').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var id = button.data('id');
        var nombre = button.data('nombre');
        var estatus = button.data('estatus'); // 1 activo / 0 inactivo

        $('#accion_id_puesto').val(id);
        $('#nombreAccionPuesto').text(nombre);

        if (estatus == 1) {
            $('#tituloAccionModalPuesto').text('Inhabilitar Puesto');
            $('#textoAccionModalPuesto').text('¿Deseas inhabilitar este puesto?');
            $('#textoBtnAccionPuesto').text('Sí, inhabilitar');
            $('#iconoAccionPuesto').attr('src', "{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}");
        } else {
            $('#tituloAccionModalPuesto').text('Recuperar Puesto');
            $('#textoAccionModalPuesto').text('¿Deseas recuperar este puesto?');
            $('#textoBtnAccionPuesto').text('Sí, recuperar');
            $('#iconoAccionPuesto').attr('src', "{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}");
        }
    });

});
</script>

{{-- Reabrir modal NUEVO si hubo errores al guardar --}}
@if($errors->has('descripcion_puesto'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    $('#modalNuevoPuesto').modal('show');
});
</script>
@endif

@endsection

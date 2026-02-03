@extends('layouts.app')

@section('titulo')
    <h3 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18">
        Listado de Administraciones
    </h3>
@endsection

@section('panel')
<div class="table-responsive">

     <!-- Mensaje éxito  -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

   <!-- Mensaje danger (duplicado u otros)  -->
    @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- Errores -->
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

    <!-- Nueva Administración  -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            {{--@altaAdministracion--}}
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevaAdministracion"
               data-toggle="tooltip"
               data-html="true"
               title="Nueva Administración">
                + Nueva Administración
            </a>
            {{--@endaltaAdministracion--}}
        </div>
    </div>

    <!-- Tabla  -->
    <table class="table table-striped shadow-lg" id="MyTableAdministraciones">
        <thead>
            <tr>
                <th class="text-center">Número</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($administraciones as $admin)
                <tr>
                    <td class="text-center">{{ $admin->iid_administracion }}</td>
                    <td class="text-center">{{ $admin->cdescripcion_administracion }}</td>

                    <td class="text-center col-actions">
                        @if($admin->iestatus == 1)

                            {{-- Editar (modal) --}}
                            {{--@editaAdministracion--}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#modalEditarAdministracion"
                                data-id="{{ $admin->iid_administracion }}"
                                data-descripcion="{{ $admin->cdescripcion_administracion }}"
                                title="Actualizar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </button>
                            {{--@endeditaAdministracion--}}

                            {{-- Inhabilitar (modal confirm) --}}
                            {{--@borraAdministracion--}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#confirmarInhabilitarModalAdministracion"
                                data-id="{{ $admin->iid_administracion }}"
                                data-nombre="{{ $admin->cdescripcion_administracion }}"
                                data-estatus="1"
                                title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                            </button>
                            {{--@endborraAdministracion--}}

                        @else

                            {{-- Recuperar (modal confirm) --}}
                            {{--@borraAdministracion--}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#confirmarInhabilitarModalAdministracion"
                                data-id="{{ $admin->iid_administracion }}"
                                data-nombre="{{ $admin->cdescripcion_administracion }}"
                                data-estatus="0"
                                title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </button>
                            {{--@endborraAdministracion--}}

                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>


<!-- =========================
    MODAL: NUEVA ADMINISTRACIÓN
========================= -->
<div class="modal fade" id="modalNuevaAdministracion" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">
            <img src="{{ asset('bootstrap-icons-1.5.0/folder-plus.svg') }}" width="18" height="18">
            Nueva Administración
        </h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ url('/administraciones/guardar') }}" id="formNuevaAdministracion">
          @csrf

          <div class="form-group">
            <label for="descripcion_administracion"><b>Descripción:</b></label>
            <input type="text"
                   id="descripcion_administracion"
                   name="descripcion_administracion"
                   class="form-control @error('descripcion_administracion') is-invalid @enderror"
                   value="{{ old('descripcion_administracion') }}"
                   maxlength="120"
                   required>
            @error('descripcion_administracion')
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
    MODAL: EDITAR ADMINISTRACIÓN
========================= --}}
<div class="modal fade" id="modalEditarAdministracion" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Administración</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ url('/administraciones/actualizar') }}" id="formEditarAdministracion">
          @csrf

          <input type="hidden" id="edit_iid_administracion" name="id_administracion">

          <div class="form-group">
            <label for="edit_descripcion_administracion"><b>Descripción:</b></label>
            <input type="text"
                   id="edit_descripcion_administracion"
                   name="descripcion_administracion"
                   class="form-control"
                   maxlength="120"
                   required>
          </div>
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
<div class="modal fade" id="confirmarInhabilitarModalAdministracion" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title" id="tituloAccionModalAdmin">Inhabilitar Administración</h5>
        <button type="button" class="close" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <p id="textoAccionModalAdmin"></p>
        <strong id="nombreAccionAdmin"></strong>
      </div>

      <div class="modal-footer justify-content-center">
        <form method="POST" action="{{ url('/administraciones/actualizar') }}" id="formAccionAdmin">
            @csrf
            <input type="hidden" name="id_administracion" id="accion_id_administracion">
            <input type="hidden" name="noeditar" value="disabled">

            <button type="submit" class="btn btn-primary">
                <img id="iconoAccionAdmin" src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                <span id="textoBtnAccionAdmin">Sí, inhabilitar</span>
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



    //  Modal Editar
    $('#modalEditarAdministracion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#edit_iid_administracion').val(button.data('id'));
        $('#edit_descripcion_administracion').val(button.data('descripcion'));
    });

    // Modal Inhabilitar / Recuperar
    $('#confirmarInhabilitarModalAdministracion').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        var id = button.data('id');
        var nombre = button.data('nombre');
        var estatus = button.data('estatus');

        $('#accion_id_administracion').val(id);
        $('#nombreAccionAdmin').text(nombre);

        if (estatus == 1) {
            $('#tituloAccionModalAdmin').text('Inhabilitar Administración');
            $('#textoAccionModalAdmin').text('¿Deseas inhabilitar esta administración?');
            $('#textoBtnAccionAdmin').text('Sí, inhabilitar');
            $('#iconoAccionAdmin').attr('src', "{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}");
        } else {
            $('#tituloAccionModalAdmin').text('Recuperar Administración');
            $('#textoAccionModalAdmin').text('¿Deseas recuperar esta administración?');
            $('#textoBtnAccionAdmin').text('Sí, recuperar');
            $('#iconoAccionAdmin').attr('src', "{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}");
        }
    });

});
</script>

{{-- Reabrir modal NUEVO si hubo errores al guardar --}}
@if($errors->has('descripcion_administracion'))
<script>
document.addEventListener("DOMContentLoaded", function () {
    $('#modalNuevaAdministracion').modal('show');
});
</script>
@endif

@endsection

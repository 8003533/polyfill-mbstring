@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18">
    Listado de Talleres
</h3>
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

    @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

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

    {{-- Nuevo Taller (MODAL) --}}
    <div class="row mb-2">
        <div class="col col-form-label text-md-right">
            <a href="#" data-toggle="modal" data-target="#modalNuevoTaller" title="Nuevo Taller">
                + Nuevo Taller
            </a>
        </div>
    </div>

    {{-- TABLA --}}
    <table class="table table-striped shadow-lg" id="MyTableTalleres">
        <thead>
            <tr>
                <th class="text-center">Número</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @if(isset($talleres) && count($talleres))
                @foreach($talleres as $taller)
                    <tr>
                        <td class="text-center">{{ $taller->iid_taller }}</td>
                        <td class="text-center">{{ $taller->cdescripcion_taller }}</td>

                        <td class="text-center col-actions">

                            {{-- Editar (modal) --}}
                            @if((int)$taller->iestatus === 1)
                                <button type="button" class="btn"
                                    data-toggle="modal"
                                    data-target="#modalEditarTaller"
                                    data-id="{{ $taller->iid_taller }}"
                                    data-descripcion="{{ $taller->cdescripcion_taller }}"
                                    title="Editar">
                                    <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                                </button>
                            @endif

                            {{-- Eliminar / Recuperar (modal) --}}
                            <button type="button" class="btn"
                                data-toggle="modal"
                                data-target="#modalEstadoTaller"
                                data-id="{{ $taller->iid_taller }}"
                                data-descripcion="{{ $taller->cdescripcion_taller }}"
                                data-estatus="{{ (int)$taller->iestatus }}"
                                title="{{ (int)$taller->iestatus === 1 ? 'Eliminar' : 'Recuperar' }}">
                                @if((int)$taller->iestatus === 1)
                                    <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                                @else
                                    <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="16" height="16">
                                @endif
                            </button>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center text-muted">No hay talleres registrados</td>
                </tr>
            @endif
        </tbody>
    </table>

</div>


{{-- ================= MODAL: NUEVO TALLER ================= --}}
<div class="modal fade" id="modalNuevoTaller" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Nuevo Taller</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('talleres.guardar') }}" id="formNuevoTaller">
          @csrf

          <div class="form-group">
            <label><b>Descripción</b></label>
            <input type="text" name="descripcion_taller" class="form-control"
                   value="{{ old('descripcion_taller') }}" required>
          </div>

          <div class="row text-center mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    Guardar
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>


{{-- ================= MODAL: EDITAR TALLER ================= --}}
<div class="modal fade" id="modalEditarTaller" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Taller</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('talleres.actualizar') }}" id="formEditarTaller">
          @csrf

          <input type="hidden" id="edit_id_taller" name="id_taller">
          <input type="hidden" name="noeditar" value="">

          <div class="form-group">
            <label><b>Descripción</b></label>
            <input type="text" id="edit_descripcion_taller" name="descripcion_taller" class="form-control" required>
          </div>

          <div class="row text-center mt-3">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    Guardar
                </button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
          </div>

        </form>
      </div>

    </div>
  </div>
</div>


{{-- ================= MODAL: ELIMINAR / RECUPERAR TALLER ================= --}}
<div class="modal fade" id="modalEstadoTaller" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title" id="tituloEstadoTaller">Cambiar estado</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body text-center">
        <p id="textoEstadoTaller">¿Deseas realizar esta acción?</p>
        <strong id="nombreEstadoTaller"></strong>
      </div>

      <div class="modal-footer justify-content-center">

        {{-- OJO: tu Controller usa actualizar_taller para borrar/recuperar cuando noeditar="disabled" --}}
        <form id="formEstadoTaller" method="POST" action="{{ route('talleres.actualizar') }}">
          @csrf
          <input type="hidden" id="estado_id_taller" name="id_taller">
          <input type="hidden" name="noeditar" value="disabled">

          <button type="submit" class="btn btn-primary" id="btnEstadoTaller">
            <img id="iconoEstadoTaller" src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
            <span id="textoBtnEstadoTaller">Sí, eliminar</span>
          </button>
        </form>

        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>


{{-- SCRIPTS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Editar
    $('#modalEditarTaller').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        $('#edit_id_taller').val(b.data('id'));
        $('#edit_descripcion_taller').val(b.data('descripcion'));
    });

    // Eliminar / Recuperar (mismo modal)
    $('#modalEstadoTaller').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        var id = b.data('id');
        var descripcion = b.data('descripcion');
        var estatus = parseInt(b.data('estatus')); // 1 activo, 0 inactivo

        $('#estado_id_taller').val(id);
        $('#nombreEstadoTaller').text(descripcion);

        if (estatus === 1) {
            // Eliminar
            $('#tituloEstadoTaller').text('Eliminar Taller');
            $('#textoEstadoTaller').text('¿Deseas eliminar el taller?');
            $('#textoBtnEstadoTaller').text('Sí, eliminar');
            $('#iconoEstadoTaller').attr('src', "{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}");
        } else {
            // Recuperar
            $('#tituloEstadoTaller').text('Recuperar Taller');
            $('#textoEstadoTaller').text('¿Deseas recuperar el taller?');
            $('#textoBtnEstadoTaller').text('Sí, recuperar');
            $('#iconoEstadoTaller').attr('src', "{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}");
        }
    });

    // Reabrir modal nuevo si hay errores
    @if($errors->any())
        $('#modalNuevoTaller').modal('show');
    @endif

});
</script>

@endsection

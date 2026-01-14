@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18">
        Listado de Administraciones
    </h4>
@endsection

@section('panel')
<div class="table-responsive">


 <!-- NUEVA ADMINISTRACION (MODAL EN INDEX) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <button class="btn btn-link"
                    data-toggle="modal"
                    data-target="#modalNuevaAdministracion">
                + Nueva Administracion
            </button>
        </div>
    </div>

 <!-- TABLA  -->
    <table class="table table-striped shadow-lg" id="MyTableAdministraciones">
        <thead>
            <tr>
                <th class="text-center">Número</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($administraciones as $indice=>$admin)
                <tr>
                    <td class="text-center">{{ $admin['iid_administracion'] }}</td>
                    <td class="text-center">{{ $admin['cdescripcion_administracion'] }}</td>

                    <td class="text-center col-actions">
                        @if ($admin->iestatus == 1)

                            {{-- EDITAR (MODAL) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#editarModal"
                                data-id="{{ $admin->iid_administracion }}"
                                data-descripcion="{{ $admin->cdescripcion_administracion }}">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </button>

                            {{-- INHABILITAR (MODAL) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#inhabilitarModal"
                                data-id="{{ $admin->iid_administracion }}"
                                data-descripcion="{{ $admin->cdescripcion_administracion }}">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </button>

                        @else
                            {{-- RECUPERAR (SE QUEDA COMO LINK, IGUAL AL TUYO) --}}
                            <a href="{{ url('administraciones/inhabilitar/'.$admin->iid_administracion) }}"
                               data-toggle="tooltip" data-html="true" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

<!-- MODAL NUEVA ADMINISTRACION  -->
    <div class="modal fade" id="modalNuevaAdministracion" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

          <div class="modal-header bg-light">
            <h5 class="modal-title">Nueva Administración</h5>
            <button type="button" class="close" data-dismiss="modal">
              <span>&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form method="POST" action="{{ url('/administraciones/guardar') }}">
                @csrf

                @php
                    $administracion = new \App\Models\Catalogos\Administracion();
                    $noeditar = '';
                @endphp

                @include('administraciones.datos_administracion')

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

<!-- MODAL EDITAR  -->
    <div class="modal fade" id="editarModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

          <div class="modal-header bg-light">
            <h5 class="modal-title">Editar Administración</h5>
            <button type="button" class="close" data-dismiss="modal">
              <span>&times;</span>
            </button>
          </div>

          <div class="modal-body">
            <form method="GET" id="formEditar" action="">
              <div class="form-group">
                <label>Administración:</label>
                <input type="text" id="descripcionEditar" class="form-control" disabled>
              </div>

              <div class="row text-center mt-3">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        Ir a Editar
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

 <!-- MODAL INHABILITAR  -->
    <div class="modal fade" id="inhabilitarModal" tabindex="-1" role="dialog">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

          <div class="modal-header bg-light">
            <h5 class="modal-title">Inhabilitar Administración</h5>
            <button type="button" class="close" data-dismiss="modal">
              <span>&times;</span>
            </button>
          </div>

          <div class="modal-body text-center">
            <p>¿Deseas inhabilitar esta administración <strong id="descripcionInhabilitar"></strong>?</p>
          </div>

          <div class="modal-footer justify-content-center">
            <form id="formInhabilitar" method="GET" action="">
              <button type="submit" class="btn btn-primary">
                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                Sí, inhabilitar
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

 <!-- SCRIPTS (EDITAR / INHABILITAR)  -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {

        // Modal Editar
        $('#editarModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var descripcion = button.data('descripcion');

            $('#descripcionEditar').val(descripcion);
            $('#formEditar').attr('action', '/administraciones/editar/' + id);
        });

        // Modal Inhabilitar
        $('#inhabilitarModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var descripcion = button.data('descripcion');

            $('#descripcionInhabilitar').text(descripcion);
            $('#formInhabilitar').attr('action', '/administraciones/inhabilitar/' + id);
        });

    });
    </script>

</div>
@endsection

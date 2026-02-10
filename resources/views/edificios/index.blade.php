@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
    Listado de Edificios
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

    <!-- Nuevo Edificio (MODAL) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevoEdificio"
               data-toggle="tooltip"
               data-html="true"
               title="Nuevo">
                + Nuevo Edificio
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTableEdificios">
        <thead>
            <tr>
                <th class="text-center">Número</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Administración</th>
                <th class="text-center">Dirección</th>
                <th class="text-center">Estatus</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($edificios as $e)
                @php
                    $adminNombre = $e->administracion->cdescripcion_administracion ?? '-';
                    $coloniaNombre = $e->colonia->cnombre_colonia ?? '-';
                    $alcaldiaNombre = $e->alcaldia->cnombre_alcaldia ?? '-';
                    $entidadNombre = $e->entidad->cnombre_entidad ?? 'Ciudad de México';
                    $cp = $e->cid_codigo_postal ?? '';

                    $dir = trim(($e->ccalle ?? '').' '.($e->cnumero_exterior ?? '').' '.($e->cnumero_interior ?? ''));
                    $dir .= ', '.$coloniaNombre.', '.$alcaldiaNombre.', '.$entidadNombre.', C.P. '.$cp;

                    $estatusTxt = ((int)$e->iestatus === 1) ? 'Activo' : 'Inactivo';
                @endphp

                <tr>
                    <td class="text-center">{{ $e->iid_edificio }}</td>
                    <td class="text-center">{{ $e->cnombre_edificio }}</td>
                    <td class="text-center">{{ $adminNombre }}</td>
                    <td class="text-center">{{ $dir }}</td>
                    <td class="text-center">{{ $estatusTxt }}</td>

                    <td class="text-center col-actions">

                        {{-- EDITAR (MODAL) --}}
                        <button type="button" class="btn"
                            data-toggle="modal"
                            data-target="#modalEditarEdificio"
                            data-id="{{ $e->iid_edificio }}"
                            data-administracion="{{ $e->iid_administracion }}"
                            data-nombre="{{ $e->cnombre_edificio }}"
                            data-calle="{{ $e->ccalle }}"
                            data-numext="{{ $e->cnumero_exterior }}"
                            data-numint="{{ $e->cnumero_interior }}"
                            data-cp="{{ $e->cid_codigo_postal }}"
                            data-colonia="{{ $e->iid_colonia }}"
                            data-alcaldia="{{ $e->iid_alcaldia }}"
                            data-alcaldianombre="{{ $alcaldiaNombre }}"
                            data-entidad="{{ $entidadCDMX['id'] }}"
                            data-entidadnombre="{{ $entidadCDMX['nombre'] }}"
                            data-lat="{{ $e->ilatitud }}"
                            data-lng="{{ $e->ilongitud }}"
                            title="Actualizar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </button>

                        {{-- ELIMINAR / RECUPERAR (MODAL) --}}
                        <button type="button" class="btn"
                            data-toggle="modal"
                            data-target="#modalEliminarEdificio"
                            data-id="{{ $e->iid_edificio }}"
                            data-nombre="{{ $e->cnombre_edificio }}"
                            data-estatus="{{ (int)$e->iestatus }}"
                            title="Borrar/Recuperar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>



{{-- =========================
    MODAL: NUEVO EDIFICIO
========================= --}}
<div class="modal fade" id="modalNuevoEdificio" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">
            <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
            Nuevo Edificio
        </h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('edificios.guardar') }}" id="formNuevoEdificio">
          @csrf

          {{-- Nombre --}}
          <div class="form-group">
            <label><b>Nombre:</b></label>
            <input type="text" name="nombre_edificio"
                   class="form-control @error('nombre_edificio') is-invalid @enderror"
                   value="{{ old('nombre_edificio') }}" maxlength="255" required>
            @error('nombre_edificio')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Administración --}}
          <div class="form-group">
            <label><b>Administración:</b></label>
            <select name="administracion" id="admin_new"
                    class="form-control @error('administracion') is-invalid @enderror" required>
              <option value="">Seleccione</option>
              @foreach($admins as $a)
                <option value="{{ $a->iid_administracion }}">
                    {{ $a->cdescripcion_administracion }}
                </option>
              @endforeach
            </select>
            @error('administracion')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Calle / nums --}}
          <div class="form-row">
            <div class="form-group col-md-6">
              <label><b>Calle:</b></label>
              <input type="text" name="calle" id="calle_new" class="form-control" value="{{ old('calle') }}">
            </div>

            <div class="form-group col-md-3">
              <label><b>Número exterior:</b></label>
              <input type="text" name="numero_exterior" id="numext_new" class="form-control" value="{{ old('numero_exterior') }}">
            </div>

            <div class="form-group col-md-3">
              <label><b>Número interior:</b></label>
              <input type="text" name="numero_interior" id="numint_new" class="form-control" value="{{ old('numero_interior') }}">
            </div>
          </div>

          {{-- CP --}}
          <div class="form-group">
            <label><b>Código Postal:</b></label>
            <select name="codigo_postal" id="cp_new"
                    class="form-control @error('codigo_postal') is-invalid @enderror" required>
              <option value="">Seleccione</option>
              @foreach($cps as $cp)
                <option value="{{ $cp->cid_codigo_postal }}">{{ $cp->cid_codigo_postal }}</option>
              @endforeach
            </select>
            @error('codigo_postal')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Colonia --}}
          <div class="form-group">
            <label><b>Colonia:</b></label>
            <select name="colonia" id="colonia_new"
                    class="form-control @error('colonia') is-invalid @enderror" required>
              <option value="">Seleccione</option>
            </select>
            @error('colonia')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          {{-- Alcaldía (readonly) --}}
          <div class="form-group">
            <label><b>Alcaldía:</b></label>
            <input type="text" id="alcaldia_nombre_new" class="form-control" readonly>
            <input type="hidden" name="alcaldia" id="alcaldia_new" value="">
          </div>

          {{-- Entidad (siempre CDMX) --}}
          <div class="form-group">
            <label><b>Entidad:</b></label>
            <input type="text" id="entidad_nombre_new" class="form-control" value="{{ $entidadCDMX['nombre'] }}" readonly>
            <input type="hidden" name="entidad" id="entidad_new" value="{{ $entidadCDMX['id'] }}">
          </div>

          {{-- Lat / Lng --}}
          <div class="form-row">
            <div class="form-group col-md-6">
              <label><b>Latitud:</b></label>
              <input type="text" name="latitud" class="form-control" value="{{ old('latitud') }}">
            </div>
            <div class="form-group col-md-6">
              <label><b>Longitud:</b></label>
              <input type="text" name="longitud" class="form-control" value="{{ old('longitud') }}">
            </div>
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
    MODAL: EDITAR EDIFICIO
========================= --}}
<div class="modal fade" id="modalEditarEdificio" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Editar Edificio</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body">
        <form method="POST" action="{{ route('edificios.actualizar') }}" id="formEditarEdificio">
          @csrf

          <input type="hidden" id="edit_id_edificio" name="id_edificio">

          <div class="form-group">
            <label><b>Nombre:</b></label>
            <input type="text" id="edit_nombre" name="nombre_edificio" class="form-control" maxlength="255" required>
          </div>

          <div class="form-group">
            <label><b>Administración:</b></label>
            <select id="edit_administracion" name="administracion" class="form-control" required>
              <option value="">Seleccione</option>
              @foreach($admins as $a)
                <option value="{{ $a->iid_administracion }}">{{ $a->cdescripcion_administracion }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label><b>Calle:</b></label>
              <input type="text" id="edit_calle" name="calle" class="form-control">
            </div>

            <div class="form-group col-md-3">
              <label><b>Número exterior:</b></label>
              <input type="text" id="edit_numext" name="numero_exterior" class="form-control">
            </div>

            <div class="form-group col-md-3">
              <label><b>Número interior:</b></label>
              <input type="text" id="edit_numint" name="numero_interior" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label><b>Código Postal:</b></label>
            <select id="edit_cp" name="codigo_postal" class="form-control" required>
              <option value="">Seleccione</option>
              @foreach($cps as $cp)
                <option value="{{ $cp->cid_codigo_postal }}">{{ $cp->cid_codigo_postal }}</option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label><b>Colonia:</b></label>
            <select id="edit_colonia" name="colonia" class="form-control" required>
              <option value="">Seleccione</option>
            </select>
          </div>

          <div class="form-group">
            <label><b>Alcaldía:</b></label>
            <input type="text" id="edit_alcaldia_nombre" class="form-control" readonly>
            <input type="hidden" name="alcaldia" id="edit_alcaldia">
          </div>

          <div class="form-group">
            <label><b>Entidad:</b></label>
            <input type="text" id="edit_entidad_nombre" class="form-control" value="{{ $entidadCDMX['nombre'] }}" readonly>
            <input type="hidden" name="entidad" id="edit_entidad" value="{{ $entidadCDMX['id'] }}">
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label><b>Latitud:</b></label>
              <input type="text" id="edit_lat" name="latitud" class="form-control">
            </div>
            <div class="form-group col-md-6">
              <label><b>Longitud:</b></label>
              <input type="text" id="edit_lng" name="longitud" class="form-control">
            </div>
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
    MODAL: ELIMINAR/RECUPERAR
========================= --}}
<div class="modal fade" id="modalEliminarEdificio" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Cambiar estatus</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body text-center">
        <p id="textoEliminarEdificio"></p>
        <strong id="nombreEliminarEdificio"></strong>
      </div>

      <div class="modal-footer justify-content-center">
        <form id="formEliminarEdificio" method="POST" action="">
          @csrf
          @method('DELETE')
          <button type="submit" class="btn btn-primary">
            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
            Confirmar
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

    // ✅ helper: cargar colonias/alcaldía por CP (para NEW y EDIT)
    function cargarPorCP(cp, $selectColonia, $alcaldiaHidden, $alcaldiaNombreInput, selectedColoniaId = null){
        if(!cp){
            $selectColonia.html('<option value="">Seleccione</option>');
            $alcaldiaHidden.val('');
            $alcaldiaNombreInput.val('');
            return;
        }

        $.ajax({
            url: "{{ route('edificios.busca_cp') }}",
            method: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                cp: cp
            },
            success: function(resp){
                // Colonias
                let html = '<option value="">Seleccione</option>';
                if(resp.exito === 1 && resp.listaColonia){
                    resp.listaColonia.forEach(function(c){
                        let sel = (selectedColoniaId && parseInt(selectedColoniaId) === parseInt(c.iid_colonia)) ? 'selected' : '';
                        html += `<option value="${c.iid_colonia}" ${sel}>${c.cnombre_colonia}</option>`;
                    });
                }
                $selectColonia.html(html);

                // Alcaldía
                if(resp.alcaldia){
                    $alcaldiaHidden.val(resp.alcaldia.iid_alcaldia);
                    $alcaldiaNombreInput.val(resp.alcaldia.cnombre_alcaldia);
                }else{
                    $alcaldiaHidden.val('');
                    $alcaldiaNombreInput.val('');
                }

                // Entidad siempre CDMX (ya está fija en inputs)
            }
        });
    }

    // ✅ NEW: al cambiar CP carga colonias + alcaldía
    $('#cp_new').on('change', function(){
        cargarPorCP(
            $(this).val(),
            $('#colonia_new'),
            $('#alcaldia_new'),
            $('#alcaldia_nombre_new'),
            null
        );
    });

    // ✅ EDIT: cuando abre modal, llenar campos y cargar CP->colonias
    $('#modalEditarEdificio').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        $('#edit_id_edificio').val(b.data('id'));
        $('#edit_administracion').val(String(b.data('administracion')));
        $('#edit_nombre').val(b.data('nombre'));
        $('#edit_calle').val(b.data('calle'));
        $('#edit_numext').val(b.data('numext'));
        $('#edit_numint').val(b.data('numint'));
        $('#edit_cp').val(String(b.data('cp')));

        $('#edit_lat').val(b.data('lat'));
        $('#edit_lng').val(b.data('lng'));

        // Alcaldía y entidad
        $('#edit_alcaldia').val(b.data('alcaldia'));
        $('#edit_alcaldia_nombre').val(b.data('alcaldianombre'));
        $('#edit_entidad').val(b.data('entidad'));
        $('#edit_entidad_nombre').val(b.data('entidadnombre'));

        // ✅ Cargar colonias del CP y seleccionar la colonia actual
        cargarPorCP(
            b.data('cp'),
            $('#edit_colonia'),
            $('#edit_alcaldia'),
            $('#edit_alcaldia_nombre'),
            b.data('colonia')
        );
    });

    // ✅ EDIT: si cambian CP en edición, recarga colonias/alcaldía
    $('#edit_cp').on('change', function(){
        cargarPorCP(
            $(this).val(),
            $('#edit_colonia'),
            $('#edit_alcaldia'),
            $('#edit_alcaldia_nombre'),
            null
        );
    });

    // ✅ ELIMINAR/RECUPERAR modal
    $('#modalEliminarEdificio').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        var id = b.data('id');
        var nombre = b.data('nombre');
        var estatus = parseInt(b.data('estatus')); // 1 activo / 0 inactivo

        $('#nombreEliminarEdificio').text(nombre);

        if(estatus === 1){
            $('#textoEliminarEdificio').text('¿Deseas INHABILITAR este edificio?');
        }else{
            $('#textoEliminarEdificio').text('¿Deseas RECUPERAR este edificio?');
        }

        $('#formEliminarEdificio').attr('action', "{{ url('edificios') }}/" + id);
    });

});
</script>

@endsection

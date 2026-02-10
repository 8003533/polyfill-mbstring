@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18">
        Ordenes de Servicio
    </h4>
@endsection

@section('panel')

    <div class="row">

            <div class="row">
                <div class="col-6" id="divorden">
                    <label for="orden" class="col-form-label text-md-right">Orden de servicio:</label>
                    <input type="text" id="orden" name="orden" class="form-control" data-target="#orden"
                           value="{{ old('orden',null) }}"/>
                </div>
            </div>

            <br>

            <div class="form-group form-row text-center">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/search.svg') }}" width="18" height="18">
                        <span>&nbsp;Buscar</span>
                    </button>
                </div>
            </div>

            <br>
            {{ csrf_field() }}

            <div class="form-group row justify-content-md-center">
                {{-- ✅ ARREGLADO: button type="button" para que NO se comporte como submit y sí abra el modal --}}
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#newOrdenModal">
                    <i class="fa fa-user-plus"></i> Nueva orden de servicio
                </button>
            </div>

            <br>
    </div>


<!-- =========================
        MODAL: NUEVA ORDEN
========================= -->
<div class="modal fade" id="newOrdenModal" tabindex="-1" role="dialog" aria-labelledby="newOrdenLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      {{-- ✅ action real para guardar --}}
      <form method="POST" action="{{ url('registro/guardar') }}" id="formOrdenServicio">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="newOrdenLabel">Registro de Orden de Servicio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <!-- Renglon: Folio (no editable) + Solicitud (fecha-hora) -->
          <div class="form-row mb-3">
            <div class="col-md-6">
              <label for="folio">Folio</label>
              {{-- ✅ folio se muestra pero se envía en hidden --}}
              <input type="text" class="form-control" id="folio" readonly>
              <input type="hidden" name="folio" id="folio_hidden">
            </div>

            <div class="col-md-6">
              <label for="fecha_solicitud">Solicitud (Fecha y Hora)</label>
              {{-- ✅ se muestra pero se envía en hidden --}}
              <input type="text" class="form-control" id="fecha_solicitud" readonly>
              <input type="hidden" name="fecha_solicitud" id="fecha_solicitud_hidden">
            </div>
          </div>

          <!-- Renglon: Conclusión alineado a la derecha -->
          <div class="form-row mb-3 justify-content-end">
            <div class="col-md-6">
              <label for="conclusion">Conclusión</label>
              {{-- ✅ manual en formato dd/mm/yy, HH:MM hrs --}}
              <input type="text" class="form-control" id="conclusion" name="conclusion"
                     placeholder="dd/mm/yy, HH:MM hrs">
            </div>
          </div>

          <!-- Catálogos: Área Solicitante, Solicitante, Taller -->
          <div class="form-row mb-3">

            <div class="col-md-4">
              <label for="area">Área Solicitante</label>
              <select id="area" name="area" class="form-control select2-modal" required>
                <option value="">Seleccione área</option>
                @foreach($administracion as $area)
                    <option value="{{ $area->iid_administracion }}">
                        {{ $area->cdescripcion_administracion }}
                    </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-4">
              <label for="solicitante">Solicitante</label>
              <select id="solicitante" name="solicitante" class="form-control select2-modal" required>
                <option value="">Seleccione solicitante</option>
                @foreach($personal_solicitante as $sol)
                  <option value="{{ $sol->iid_personal}}">
                    {{ $sol->cnombre_personal }} {{ $sol->cpaterno_personal }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-4">
              <label for="taller">Taller</label>
              <select id="taller" name="taller" class="form-control select2-modal" required>
                <option value="">Seleccione taller</option>
                @foreach($talleres as $taller)
                  <option value="{{ $taller->iid_taller}}">
                    {{ $taller->cdescripcion_taller}}
                  </option>
                @endforeach
              </select>
            </div>

          </div>

          <!-- Descripción del servicio -->
          <div class="form-group">
            <label for="descripcion_servicio">Descripción del servicio</label>
            <textarea id="descripcion_servicio" name="descripcion_servicio"
                      class="form-control" rows="4" required></textarea>
          </div>

          <!-- Personal / Cuadrilla -->
          <div class="form-group">
            <label for="personal_ids">Personal</label>
            {{-- ✅ MULTI solo en personal --}}
            <select id="personal_ids" name="personal_ids[]" class="form-control select2-modal" multiple>
              @foreach($personal_solicitante as $p)
                <option value="{{ $p->iid_personal}}">
                  {{ $p->cnombre_personal }} {{ $p->cpaterno_personal }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="form-group">
            <label for="cuadrilla">Cuadrilla</label>
            <select id="cuadrilla" name="cuadrilla" class="form-control select2-modal">
              <option value="">Seleccione cuadrilla</option>
              @foreach($cuadrilla as $c)
                <option value="{{ $c->iid_cuadrilla }}">{{ $c->cnombre_cuadrilla }}</option>
              @endforeach
            </select>
          </div>

          <!-- Observaciones -->
          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            {{-- ✅ nulo --}}
            <input type="text" id="observaciones" name="observaciones" class="form-control" value="">
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-plus"></i> Agregar
          </button>
        </div>

      </form>
    </div>
  </div>
</div>


{{-- =========================
    JS (sin cambiar estilos)
========================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    function pad(n){ return n < 10 ? '0' + n : n; }

    function formatNow(){
        const d = new Date();
        const dd = pad(d.getDate());
        const mm = pad(d.getMonth() + 1);
        const yy = String(d.getFullYear()).slice(-2);
        const HH = pad(d.getHours());
        const MI = pad(d.getMinutes());
        return `${dd}/${mm}/${yy}, ${HH}:${MI} hrs`;
    }

    // ✅ Cuando se abre el modal:
    $('#newOrdenModal').on('shown.bs.modal', function () {

        // Fecha solicitud automática
        const solicitud = formatNow();
        $('#fecha_solicitud').val(solicitud);
        $('#fecha_solicitud_hidden').val(solicitud);

        // Select2 dentro del modal (buscador catálogo)
        $(this).find('.select2-modal').select2({
            dropdownParent: $('#newOrdenModal'),
            width: '100%'
        });

        // Folio consecutivo por año (AJAX)
        $.get("{{ url('registro/folio-actual') }}", function(resp){
            if(resp && resp.folio){
                $('#folio').val(resp.folio);
                $('#folio_hidden').val(resp.folio);
            }
        });

    });

});
</script>

@endsection

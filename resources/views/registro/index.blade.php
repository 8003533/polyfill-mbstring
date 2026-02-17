@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18">
        Ordenes de Servicio
    </h4>
@endsection

@section('panel')

<div class="row">

    {{-- BUSCADOR (igual a tu diseño) --}}
    <form method="GET" action="{{ url('registro/index') }}" class="w-100">
        <div class="row">
            <div class="col-6" id="divorden">
                <label for="orden" class="col-form-label text-md-right">Orden de servicio:</label>
                <input type="text" id="orden" name="orden" class="form-control" data-target="#orden"
                       value="{{ request('orden', old('orden',null)) }}"/>
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
    </form>

    <br>

    {{ csrf_field() }}

    {{-- ✅ BOTÓN: debe ser button type="button" (NO submit) --}}
    <div class="form-group row justify-content-md-center w-100">
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

      <form method="POST" action="{{ route('registro.guardar') }}" id="formOrdenServicio">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="newOrdenLabel">Registro de Orden de Servicio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">

          {{-- Folio + Solicitud --}}
          <div class="form-row mb-3">
            <div class="col-md-6">
              <label for="folio">Folio</label>
              <input type="text" class="form-control" id="folio" readonly>
              <input type="hidden" name="folio" id="folio_hidden">
              <input type="hidden" name="anio" id="anio_hidden">
              <input type="hidden" name="consecutivo" id="consecutivo_hidden">
            </div>

            <div class="col-md-6">
              <label for="fecha_solicitud">Solicitud (Fecha y Hora)</label>
              <input type="text" class="form-control" id="fecha_solicitud" readonly>
              <input type="hidden" name="fecha_solicitud" id="fecha_solicitud_hidden">
            </div>
          </div>

          {{-- Conclusión manual --}}
          <div class="form-row mb-3 justify-content-end">
            <div class="col-md-6">
              <label for="conclusion">Conclusión</label>
              <input type="text" class="form-control" id="conclusion" name="conclusion"
                     placeholder="dd/mm/yy, HH:MM hrs">
            </div>
          </div>

          {{-- Catálogos con buscador --}}
          <div class="form-row mb-3">
            <div class="col-md-4">
              <label for="area">Área Solicitante</label>
              <select id="area" name="area" class="form-control select2-modal" required>
                <option value="">Buscar área...</option>
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
                <option value="">Buscar solicitante...</option>
                @foreach($personal_solicitante as $sol)
                  <option value="{{ $sol->iid_personal }}">
                    {{ $sol->cnombre_personal }} {{ $sol->cpaterno_personal }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="col-md-4">
              <label for="taller">Taller</label>
              <select id="taller" name="taller" class="form-control select2-modal" required>
                <option value="">Buscar taller...</option>
                @foreach($talleres as $taller)
                  <option value="{{ $taller->iid_taller }}">
                    {{ $taller->cdescripcion_taller }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          {{-- Descripción --}}
          <div class="form-group">
            <label for="descripcion_servicio">Descripción del servicio</label>
            <textarea id="descripcion_servicio" name="descripcion_servicio" class="form-control" rows="4" required></textarea>
          </div>

          {{-- Asignación (radio) --}}
          <div class="form-group">
              <label><b>Asignación</b></label>
              <div class="form-row">
                  <div class="col-md-6">
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="tipo_asignacion" id="asig_personal" value="personal" checked>
                          <label class="form-check-label" for="asig_personal">Personal</label>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="form-check">
                          <input class="form-check-input" type="radio" name="tipo_asignacion" id="asig_cuadrilla" value="cuadrilla">
                          <label class="form-check-label" for="asig_cuadrilla">Cuadrilla</label>
                      </div>
                  </div>
              </div>
          </div>

          {{-- Personal multi --}}
          <div class="form-group" id="box_personal">
            <label for="personal_ids">Personal (puede elegir más de uno)</label>
            <select id="personal_ids" name="personal_ids[]" class="form-control select2-modal" multiple>
              @foreach($personal_solicitante as $p)
                <option value="{{ $p->iid_personal }}">
                    {{ $p->cnombre_personal }} {{ $p->cpaterno_personal }}
                </option>
              @endforeach
            </select>
          </div>

          {{-- Cuadrilla single --}}
          <div class="form-group" id="box_cuadrilla" style="display:none;">
            <label for="cuadrilla">Seleccione cuadrilla</label>
            <select id="cuadrilla" name="cuadrilla" class="form-control select2-modal">
              <option value="">Seleccione cuadrilla</option>
              @foreach($cuadrilla as $c)
                <option value="{{ $c->iid_cuadrilla }}">{{ $c->cnombre_cuadrilla }}</option>
              @endforeach
            </select>
          </div>

          {{-- Observaciones nulo (solo editable en editar, aquí queda en blanco) --}}
          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <input type="text" id="observaciones" name="observaciones" class="form-control" value="" readonly>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-plus"></i> Agregar
          </button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cancelar
          </button>
        </div>

      </form>
    </div>
  </div>
</div>


{{-- =========================
    JS del Modal (coherente con requerimientos)
========================= --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    // =========================
    // Helpers para fecha/hora
    // =========================
    function pad(n){ return n < 10 ? '0' + n : n; }

    // UI: dd/mm/yy, HH:MM hrs
    function formatNowDisplay(){
        const d = new Date();
        const dd = pad(d.getDate());
        const mm = pad(d.getMonth() + 1);
        const yy = String(d.getFullYear()).slice(-2);
        const HH = pad(d.getHours());
        const MI = pad(d.getMinutes());
        return `${dd}/${mm}/${yy}, ${HH}:${MI} hrs`;
    }

    // DB: Y-m-d H:i:s
    function formatNowDB(){
        const d = new Date();
        const yyyy = d.getFullYear();
        const mm = pad(d.getMonth() + 1);
        const dd = pad(d.getDate());
        const HH = pad(d.getHours());
        const MI = pad(d.getMinutes());
        const SS = pad(d.getSeconds());
        return `${yyyy}-${mm}-${dd} ${HH}:${MI}:${SS}`;
    }

    // =========================
    // Select2 dentro del modal (buscador)
    // =========================
    function initSelect2Modal(){
        // Evita reinicialización duplicada (causa bugs raros)
        $('.select2-modal').each(function(){
            if ($(this).hasClass('select2-hidden-accessible')) {
                $(this).select2('destroy');
            }
        });

        $('.select2-modal').select2({
            dropdownParent: $('#newOrdenModal'),
            width: '100%'
        });
    }

    // =========================
    // Limpia el modal al abrir/cerrar
    // (esto evita que “se seleccione todo”)
    // =========================
    function resetModal(){
        $('#area').val('').trigger('change');
        $('#solicitante').val('').trigger('change');
        $('#taller').val('').trigger('change');

        // 🔥 Evita selección masiva:
        $('#personal_ids').val(null).trigger('change');
        $('#cuadrilla').val('').trigger('change');

        $('#descripcion_servicio').val('');
        $('#conclusion').val('');
        $('#observaciones').val('');

        $('#asig_personal').prop('checked', true).trigger('change');
    }

    // =========================
    // Muestra/oculta según radio
    // =========================
    function toggleAsignacion(){
        const tipo = $('input[name="tipo_asignacion"]:checked').val();

        if(tipo === 'cuadrilla'){
            $('#box_personal').hide();
            $('#box_cuadrilla').show();
            $('#personal_ids').val(null).trigger('change'); // limpia personal
        }else{
            $('#box_cuadrilla').hide();
            $('#box_personal').show();
            $('#cuadrilla').val('').trigger('change'); // limpia cuadrilla
        }
    }

    $(document).on('change', 'input[name="tipo_asignacion"]', toggleAsignacion);

    // =========================
    // Al abrir el modal:
    // - coloca solicitud automática (hoy/hora)
    // - pide el folio consecutivo por año al servidor
    // =========================
    $('#newOrdenModal').on('shown.bs.modal', function () {

        initSelect2Modal();
        resetModal();
        toggleAsignacion();

        // Solicitud automática (no editable)
        $('#fecha_solicitud').val(formatNowDisplay());
        $('#fecha_solicitud_hidden').val(formatNowDB());

        // Folio consecutivo por año
        $.get("{{ route('registro.folioActual') }}", function(resp){
            if(resp && resp.folio){
                $('#folio').val(resp.folio);
                $('#folio_hidden').val(resp.folio);
                $('#anio_hidden').val(resp.anio);
                $('#consecutivo_hidden').val(resp.consecutivo);
            }
        });

    });

    // Al cerrar, limpia todo
    $('#newOrdenModal').on('hidden.bs.modal', function () {
        resetModal();
    });

});
</script>

@endsection

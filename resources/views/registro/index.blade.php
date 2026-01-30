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
            <input type="text" id="orden" name="orden" class="form-control" data-target="#orden" value="{{ old('orden',null) }}"/>
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
        <a href="#" class="btn btn-success" data-toggle="modal" data-target="#newOrdenModal">
            <i class="fa fa-user-plus"></i> Nueva orden de pago
        </a>
    </div>

    <br>
</div>

<!-- Modal -->
<div class="modal fade" id="newOrdenModal" tabindex="-1" role="dialog" aria-labelledby="newOrdenLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">

      <form id="formOrdenServicio">
        @csrf

        <div class="modal-header">
          <h5 class="modal-title" id="newOrdenLabel">Registro de Orden de Servicio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">

          <!-- Folio consecutivo por año + fecha/hora -->
          <div class="form-row mb-3">
            <div class="col-md-6">
              <label for="folio">Folio</label>
              <input type="text" class="form-control" id="folio" name="folio" readonly>
              <!-- Guardar año y consecutivo -->
              <input type="hidden" id="anio_folio" name="anio_folio">
              <input type="hidden" id="consecutivo_folio" name="consecutivo_folio">
            </div>
            <div class="col-md-6">
              <label for="fecha_solicitud">Solicitud (Fecha y Hora)</label>
              <input type="text" class="form-control" id="fecha_solicitud" name="fecha_solicitud" readonly>
            </div>
          </div>

          <!-- Conclusión (editable con fecha y hora) -->
          <div class="form-row mb-3 justify-content-end">
            <div class="col-md-6">
              <label for="conclusion">Conclusión (Fecha y Hora)</label>
              <input type="datetime-local" class="form-control" id="conclusion" name="conclusion">
            </div>
          </div>

          <!-- Catálogos: Área Solicitante, Solicitante, Taller -->
          <div class="form-row mb-3">

            <div class="col-md-4">
              <label for="area">Área Solicitante</label>
              <select id="area" name="area" class="form-control select2-orden" required>
                <option value="">Buscar área...</option>
                @foreach($administracion as $area)
                  <option value="{{ $area->iid_administracion }}">{{ $area->cdescripcion_administracion }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-4">
              <label for="solicitante">Solicitante</label>
              <select id="solicitante" name="solicitante" class="form-control select2-orden" required>
                <option value="">Buscar solicitante...</option>
                @foreach($personal_solicitante as $sol)
                  <option value="{{ $sol->iid_personal }}">{{ $sol->cnombre_personal }} {{ $sol->cpaterno_personal }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-4">
              <label for="taller">Taller</label>
              <select id="taller" name="taller" class="form-control select2-orden" required>
                <option value="">Buscar taller...</option>
                @foreach($talleres as $taller)
                  <option value="{{ $taller->iid_taller }}">{{ $taller->cdescripcion_taller }}</option>
                @endforeach
              </select>
            </div>

          </div>

          <!-- Descripción del servicio -->
          <div class="form-group">
            <label for="descripcion_servicio">Descripción del servicio</label>
            <textarea id="descripcion_servicio" name="descripcion_servicio" class="form-control" rows="4" required></textarea>
          </div>

          <!-- Personal o cuadrilla -->
          <div class="form-group">
            <label for="personal">Personal / Cuadrilla</label>
            <select id="personal" name="personal" class="form-control select2-orden" required>
              <option value="">Buscar personal o cuadrilla...</option>
              @foreach($cuadrilla as $p)
                <option value="{{ $p->iid_cuadrilla }}">{{ $p->cnombre_cuadrilla }}</option>
              @endforeach
            </select>
          </div>

          <!-- Observaciones -->
          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <input type="text" id="observaciones" name="observaciones" class="form-control" readonly>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-plus"></i> Agregar
          </button>

          {{-- Cancelar NO debe ser submit --}}
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Cancelar
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<style>
  /* Para que el dropdown se vea encima del modal */
  .select2-container--open { z-index: 9999999; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

  // ===== Fecha y hora actual (formato YYYY-MM-DD HH:mm:ss) =====
  function fechaHoraActual() {
    const d = new Date();
    const yyyy = d.getFullYear();
    const MM = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    const HH = String(d.getHours()).padStart(2, '0');
    const mm = String(d.getMinutes()).padStart(2, '0');
    const ss = String(d.getSeconds()).padStart(2, '0');
    return `${yyyy}-${MM}-${dd} ${HH}:${mm}:${ss}`;
  }

  // ===== Consecutivo por año (reinicia cada año) usando localStorage =====
  function siguienteFolioPorAnio() {
    const anio = new Date().getFullYear();
    const key = `orden_servicio_consecutivo_${anio}`;

    let consecutivo = parseInt(localStorage.getItem(key) || '0', 10);
    consecutivo += 1;
    localStorage.setItem(key, String(consecutivo));

    // folio: YYYY/0001
    const folio = `${anio}/${String(consecutivo).padStart(4, '0')}`;
    return { anio, consecutivo, folio };
  }

  // Inicializar dentro del modal
  $('#newOrdenModal').on('shown.bs.modal', function () {

    // Fecha y hora automática (solicitud)
    const fecha = fechaHoraActual();
    const inputFecha = document.getElementById('fecha_solicitud');
    if (inputFecha) inputFecha.value = fecha;

    // Folio consecutivo por año
    const dataFolio = siguienteFolioPorAnio();
    const inputFolio = document.getElementById('folio');
    if (inputFolio) inputFolio.value = dataFolio.folio;

    // Guardar año y consecutivo en hidden
    const inputAnio = document.getElementById('anio_folio');
    const inputCons = document.getElementById('consecutivo_folio');
    if (inputAnio) inputAnio.value = dataFolio.anio;
    if (inputCons) inputCons.value = dataFolio.consecutivo;

    // ===== Select2 =====
    if (!(window.$ && $.fn.select2)) return;

    $('.select2-orden').each(function () {
      if ($(this).hasClass('select2-hidden-accessible')) {
        $(this).select2('destroy');
      }
    });

    $('.select2-orden').select2({
      width: '100%',
      dropdownParent: $('#newOrdenModal'),
      minimumResultsForSearch: 0,
      allowClear: true,
      language: {
        noResults: function () {
          return "No se encontraron resultados";
        },
        searching: function () {
          return "Buscando...";
        }
      }
    });
  });

  // destruir al cerrar
  $('#newOrdenModal').on('hidden.bs.modal', function () {
    if (!(window.$ && $.fn.select2)) return;

    $('.select2-orden').each(function () {
      if ($(this).hasClass('select2-hidden-accessible')) {
        $(this).select2('destroy');
      }
    });
  });

});
</script>

@endsection

@extends('layouts.app')

@section('titulo')
<h4 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18">
    Ordenes de Servicio
</h4>
@endsection

@section('panel')

<div class="row">
    <div class="col-6" id="divorden">
        <label for="orden" class="col-form-label text-md-right">Orden de servicio:</label>
        <input type="text" id="orden" name="orden" class="form-control" value="{{ old('orden', null) }}">
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

<div class="form-group row justify-content-md-center">
    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#newOrdenModal">
        <i class="fa fa-user-plus"></i> Nueva orden de pago
    </a>
</div>

<br>

<div class="modal fade" id="newOrdenModal" tabindex="-1" role="dialog" aria-labelledby="newOrdenLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form id="formOrdenServicio" method="POST" action="{{ route('registro.guardar') }}">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="newOrdenLabel">Registro de Orden de Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <label for="folio">Folio</label>
                            <input type="text" class="form-control" id="folio" name="folio" readonly>
                            <input type="hidden" id="anio_folio" name="anio_folio">
                            <input type="hidden" id="consecutivo_folio" name="consecutivo_folio">
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_solicitud">Solicitud (Fecha y Hora)</label>
                            <input type="text" class="form-control" id="fecha_solicitud" name="fecha_solicitud" readonly>
                        </div>
                    </div>

                    <div class="form-row mb-3 justify-content-end">
                        <div class="col-md-6">
                            <label for="conclusion">Conclusión (Fecha y Hora)</label>
                            <input type="datetime-local" class="form-control" id="conclusion" name="conclusion">
                        </div>
                    </div>

                    <div class="form-row mb-3">

                        <div class="col-md-4">
                            <label for="area">Área Solicitante</label>
                            <select id="area" name="area" class="form-control select2-orden" required>
                                <option value="">Buscar área...</option>
                                @foreach(($administracion ?? []) as $a)
                                    <option value="{{ $a->iid_administracion }}">{{ $a->cdescripcion_administracion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="solicitante">Solicitante</label>
                            <select id="solicitante" name="solicitante" class="form-control select2-orden" required>
                                <option value="">Buscar solicitante...</option>
                                @foreach(($personal_solicitante ?? []) as $s)
                                    <option value="{{ $s->iid_personal }}">
                                        {{ $s->cnombre_personal }} {{ $s->cpaterno_personal }} {{ $s->cmaterno_personal }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="taller">Taller</label>
                            <select id="taller" name="taller" class="form-control select2-orden" required>
                                <option value="">Buscar taller...</option>
                                @foreach(($talleres ?? []) as $t)
                                    <option value="{{ $t->iid_taller }}">{{ $t->cdescripcion_taller }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="descripcion_servicio">Descripción del servicio</label>
                        <textarea id="descripcion_servicio" name="descripcion_servicio" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Asignación</label>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="tipo_personal" name="tipo_asignacion" class="custom-control-input" value="personal" checked>
                                    <label class="custom-control-label" for="tipo_personal">Personal</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="tipo_cuadrilla" name="tipo_asignacion" class="custom-control-input" value="cuadrilla">
                                    <label class="custom-control-label" for="tipo_cuadrilla">Cuadrilla</label>
                                </div>
                            </div>
                        </div>

                        <br>

                        <div id="wrapSelectPersonal">
                            <label for="personal_multi" class="mb-1">Seleccione personal</label>
                            <select id="personal_multi" name="personal[]" class="form-control select2-orden" multiple required>
                                @foreach(($personal_catalogo ?? $personal_solicitante ?? []) as $p)
                                    <option value="{{ $p->iid_personal }}">
                                        {{ $p->cnombre_personal }} {{ $p->cpaterno_personal }} {{ $p->cmaterno_personal }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="wrapSelectCuadrilla" style="display:none;">
                            <label for="cuadrilla_multi" class="mb-1">Seleccione cuadrilla</label>
                            <select id="cuadrilla_multi" name="personal[]" class="form-control select2-orden" multiple disabled>
                                @foreach(($cuadrilla ?? []) as $c)
                                    <option value="{{ $c->iid_cuadrilla }}">{{ $c->cnombre_cuadrilla }}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="observaciones">Observaciones</label>
                        <input type="text" id="observaciones" name="observaciones" class="form-control" readonly>
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

<style>
.select2-container--open { z-index: 9999999; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    function solicitudAhora() {
        const d = new Date();
        const dd = String(d.getDate()).padStart(2, '0');
        const MM = String(d.getMonth() + 1).padStart(2, '0');
        const yyyy = d.getFullYear();
        const HH = String(d.getHours()).padStart(2, '0');
        const mm = String(d.getMinutes()).padStart(2, '0');
        return `${dd}/${MM}/${yyyy} ${HH}:${mm}`;
    }

    function siguienteFolioPorAnio() {
        const anio = new Date().getFullYear();
        const key = `orden_servicio_consecutivo_${anio}`;
        let consecutivo = parseInt(localStorage.getItem(key) || '0', 10) + 1;
        localStorage.setItem(key, String(consecutivo));
        return { anio, consecutivo, folio: `${anio}/${String(consecutivo).padStart(4, '0')}` };
    }

    function initSelect2() {
        if (!(window.$ && $.fn.select2)) return;

        $('.select2-orden').each(function () {
            if ($(this).hasClass('select2-hidden-accessible')) $(this).select2('destroy');
        });

        $('.select2-orden').select2({
            width: '100%',
            dropdownParent: $('#newOrdenModal'),
            minimumResultsForSearch: 0,
            closeOnSelect: false,
            allowClear: true,
            language: {
                noResults: () => "No se encontraron resultados",
                searching: () => "Buscando..."
            }
        });
    }

    function mostrarTipo(tipo) {
        const wrapP = document.getElementById('wrapSelectPersonal');
        const wrapC = document.getElementById('wrapSelectCuadrilla');
        const selP = document.getElementById('personal_multi');
        const selC = document.getElementById('cuadrilla_multi');

        if (tipo === 'personal') {
            wrapP.style.display = '';
            wrapC.style.display = 'none';
            selP.disabled = false;
            selP.required = true;
            selC.disabled = true;
            selC.required = false;
            if (window.$ && $.fn.select2) $('#cuadrilla_multi').val(null).trigger('change');
        } else {
            wrapP.style.display = 'none';
            wrapC.style.display = '';
            selC.disabled = false;
            selC.required = true;
            selP.disabled = true;
            selP.required = false;
            if (window.$ && $.fn.select2) $('#personal_multi').val(null).trigger('change');
        }
    }

    $('#newOrdenModal').on('shown.bs.modal', function () {
        const f = siguienteFolioPorAnio();
        document.getElementById('folio').value = f.folio;
        document.getElementById('anio_folio').value = f.anio;
        document.getElementById('consecutivo_folio').value = f.consecutivo;
        document.getElementById('fecha_solicitud').value = solicitudAhora();
        initSelect2();
        mostrarTipo('personal');
    });

    document.addEventListener('change', function (e) {
        if (e.target && e.target.name === 'tipo_asignacion') {
            mostrarTipo(e.target.value);
            initSelect2();
        }
    });

    document.getElementById('formOrdenServicio').addEventListener('submit', async function (e) {
        e.preventDefault();

        const form = e.target;
        const url = form.getAttribute('action');
        const fd = new FormData(form);

        const sol = document.getElementById('solicitante') ? document.getElementById('solicitante').value : '';
        if (!fd.get('solicitante') && sol) fd.set('solicitante', sol);

        try {
            const res = await fetch(url, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: fd
            });

            const data = await res.json();

            if (!res.ok) {
                alert('Error al guardar: ' + JSON.stringify(data));
                return;
            }

            alert('Guardado correctamente');
            if (window.$) $('#newOrdenModal').modal('hide');
            form.reset();

        } catch (err) {
            alert('Error al guardar: ' + err.message);
        }
    });

});
</script>

@endsection

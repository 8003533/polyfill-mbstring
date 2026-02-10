@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18">
        Ordenes de Servicio
    </h4>
@endsection

@section('panel')

<div class="container-fluid">

    {{-- BUSCADOR --}}
    <form method="GET" action="{{ url('registro/index') }}" id="formBuscarOrden">
        <div class="row align-items-end">
            <div class="col-md-6" id="divorden">
                <label for="orden" class="col-form-label">Orden de servicio:</label>
                <input type="text"
                       id="orden"
                       name="orden"
                       class="form-control"
                       value="{{ request('orden', old('orden')) }}"
                       placeholder="Buscar por folio / orden..." />
            </div>

            <div class="col-md-6 text-md-left mt-2 mt-md-0">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/search.svg') }}" width="18" height="18">
                    <span>&nbsp;Buscar</span>
                </button>
            </div>
        </div>
    </form>

    <hr>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p class="mb-1"><b>Corrige los errores para continuar</b></p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- BOTÓN MODAL --}}
    <div class="row justify-content-md-center mb-3">
        <button type="button" class="btn btn-success" id="btnNuevaOrden">
            <i class="fa fa-user-plus"></i> Nueva orden de servicio
        </button>
    </div>

</div>

{{-- MODAL --}}
<div class="modal fade" id="newOrdenModal" tabindex="-1" role="dialog" aria-labelledby="newOrdenLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">

            <form method="POST" action="{{ url('registro/guardar') }}" id="formOrdenServicio">
                @csrf

                <div class="modal-header">
                    <h5 class="modal-title" id="newOrdenLabel">Registro de Orden de Servicio</h5>

                    <button type="button" class="close" id="btnCerrarModalX" aria-label="Cerrar">
                        <span>&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="form-row mb-3">
                        <div class="col-md-6">
                            <label for="folio_view">Folio</label>
                            <input type="text" class="form-control" id="folio_view" readonly>
                            <input type="hidden" name="cfolio" id="folio">
                        </div>

                        <div class="col-md-6">
                            <label for="fecha_solicitud_view">Solicitud (Fecha y Hora)</label>
                            <input type="text" class="form-control" id="fecha_solicitud_view" readonly>
                            <input type="hidden" name="dfecha_solicitud" id="fecha_solicitud">
                        </div>
                    </div>

                    <div class="form-row mb-3 justify-content-end">
                        <div class="col-md-6">
                            <label for="dfecha_conclusion">Conclusión (Fecha y Hora)</label>
                            <input type="datetime-local" class="form-control" id="dfecha_conclusion" name="dfecha_conclusion">
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="col-md-4">
                            <label for="iid_administracion">Área Solicitante</label>
                            <select id="iid_administracion" name="iid_administracion" class="form-control select2-modal" required>
                                <option value="">Buscar área...</option>
                                @foreach($administracion as $a)
                                    <option value="{{ $a->iid_administracion }}">{{ $a->cdescripcion_administracion }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="iid_personal_solicitante">Solicitante</label>
                            <select id="iid_personal_solicitante" name="iid_personal_solicitante" class="form-control select2-modal" required>
                                <option value="">Buscar solicitante...</option>
                                @foreach($personal_solicitante as $p)
                                    <option value="{{ $p->iid_personal }}">
                                        {{ $p->cnombre_personal }} {{ $p->cpaterno_personal }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="iid_taller">Taller</label>
                            <select id="iid_taller" name="iid_taller" class="form-control select2-modal" required>
                                <option value="">Buscar taller...</option>
                                @foreach($talleres as $t)
                                    <option value="{{ $t->iid_taller }}">{{ $t->cdescripcion_taller }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cdescripcion_servicio">Descripción del servicio</label>
                        <textarea id="cdescripcion_servicio" name="cdescripcion_servicio" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="d-block"><b>Asignación</b></label>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_asignacion" id="asig_personal" value="personal">
                            <label class="form-check-label" for="asig_personal">Personal</label>
                        </div>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="tipo_asignacion" id="asig_cuadrilla" value="cuadrilla" checked>
                            <label class="form-check-label" for="asig_cuadrilla">Cuadrilla</label>
                        </div>
                    </div>

                    <div class="form-group" id="wrapPersonal" style="display:none;">
                        <label for="personal_ids">Seleccione personal (puede elegir más de uno)</label>
                        <select id="personal_ids" name="personal_ids[]" class="form-control select2-modal" multiple>
                            @foreach($personal_solicitante as $p)
                                <option value="{{ $p->iid_personal }}">
                                    {{ $p->cnombre_personal }} {{ $p->cpaterno_personal }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group" id="wrapCuadrilla">
                        <label for="cuadrilla_ids">Seleccione cuadrilla (puede elegir más de uno)</label>
                        <select id="cuadrilla_ids" name="cuadrilla_ids[]" class="form-control select2-modal" multiple>
                            @foreach($cuadrilla as $c)
                                <option value="{{ $c->iid_cuadrilla }}">{{ $c->cnombre_cuadrilla }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="cobservaciones">Observaciones</label>
                        <input type="text" id="cobservaciones" name="cobservaciones" class="form-control" value="" readonly>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Agregar</button>
                    <button type="button" class="btn btn-secondary" id="btnCancelarModal">Cancelar</button>
                </div>

            </form>

        </div>
    </div>
</div>

{{-- JS INLINE (no depende de @push) --}}
<script>
(function () {
    function pad(n){ return n < 10 ? '0' + n : n; }

    function formatNowView(){
        const d = new Date();
        return `${pad(d.getDate())}/${pad(d.getMonth()+1)}/${d.getFullYear()} ${pad(d.getHours())}:${pad(d.getMinutes())}`;
    }

    function formatNowDB(){
        const d = new Date();
        return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())} ${pad(d.getHours())}:${pad(d.getMinutes())}:00`;
    }

    function ready(fn){
        if (document.readyState !== 'loading') fn();
        else document.addEventListener('DOMContentLoaded', fn);
    }

    ready(function () {
        console.log('DEBUG libs => jQuery:', !!window.jQuery, 'Bootstrap5:', !!(window.bootstrap && bootstrap.Modal));

        const modalEl = document.getElementById('newOrdenModal');
        const btnNueva = document.getElementById('btnNuevaOrden');
        const btnX = document.getElementById('btnCerrarModalX');
        const btnCancelar = document.getElementById('btnCancelarModal');

        function openModal(){
            // BS5
            if (window.bootstrap && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(modalEl).show();
                return;
            }
            // BS4
            if (window.jQuery) {
                $('#newOrdenModal').modal('show');
                return;
            }
            alert('No está cargando Bootstrap JS. Revisa layouts.app');
        }

        function closeModal(){
            if (window.bootstrap && bootstrap.Modal) {
                bootstrap.Modal.getOrCreateInstance(modalEl).hide();
                return;
            }
            if (window.jQuery) {
                $('#newOrdenModal').modal('hide');
                return;
            }
        }

        btnNueva && btnNueva.addEventListener('click', openModal);
        btnX && btnX.addEventListener('click', closeModal);
        btnCancelar && btnCancelar.addEventListener('click', closeModal);

        function onModalShown(){
            // fecha solicitud
            $('#fecha_solicitud_view').val(formatNowView());
            $('#fecha_solicitud').val(formatNowDB());

            // select2
            if ($.fn && $.fn.select2) {
                $('#newOrdenModal').find('.select2-modal').select2({
                    dropdownParent: $('#newOrdenModal'),
                    width: '100%',
                    allowClear: true
                });
            } else {
                console.warn('Select2 NO cargado (esto no evita abrir el modal).');
            }

            // folio
            $.get("{{ url('registro/folio-actual') }}", function(resp){
                if(resp && resp.folio){
                    $('#folio_view').val(resp.folio);
                    $('#folio').val(resp.folio);
                }
            });

            // estado inicial
            $('#asig_cuadrilla').prop('checked', true);
            $('#wrapCuadrilla').show();
            $('#wrapPersonal').hide();
        }

        // evento mostrado
        if (window.jQuery) $('#newOrdenModal').on('shown.bs.modal', onModalShown);
        else modalEl.addEventListener('shown.bs.modal', onModalShown);

        // asignación
        $(document).on('change', '#asig_personal', function(){
            if(this.checked){
                $('#wrapPersonal').show();
                $('#wrapCuadrilla').hide();
                $('#cuadrilla_ids').val(null).trigger('change');
            }
        });

        $(document).on('change', '#asig_cuadrilla', function(){
            if(this.checked){
                $('#wrapCuadrilla').show();
                $('#wrapPersonal').hide();
                $('#personal_ids').val(null).trigger('change');
            }
        });
    });
})();
</script>

@endsection

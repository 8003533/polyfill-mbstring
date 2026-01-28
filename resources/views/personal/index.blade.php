@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/people.svg') }}" width="18" height="18">
        Listado de Personal
    </h4>
@endsection

@section('panel')
<div class="table-responsive">
    <form method="GET" action="{{ url('/personal/index') }}" id="formIndexPersonal">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>Corrige los errores para continuar</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col col-form-label text-md-right">
                <a href="#" data-toggle="modal" data-target="#modalNuevoPersonal" data-html="true" title="Nuevo">
                    + Nuevo Personal
                </a>
            </div>
        </div>

        <table class="table table-striped shadow-lg" id="MyTablePersonal">
            <thead>
                <tr>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Paterno</th>
                    <th class="text-center">Materno</th>
                    <th class="text-center">Puesto</th>
                    <th class="text-center">Adscripción</th>
                    <th class="text-center">Correo Electrónico</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($personal as $indice => $persona)

                    @php
                        $idPersonal = $persona->iid_personal
                            ?? $persona->id_personal
                            ?? $persona->iid_empleado_taller
                            ?? null;

                        $nombre   = $persona->cnombre_personal   ?? $persona->nombre_personal   ?? '';
                        $paterno  = $persona->cpaterno_personal  ?? $persona->cpaterno_personal  ?? '';
                        $materno  = $persona->cmaterno_personal  ?? $persona->cmaterno_personal  ?? '';
                        $puesto   = $persona->cdescripcion_puesto ?? '';
                        $adscrip  = $persona->cdescripcion_adscripcion ?? '';
                        $correo   = $persona->ccorreo_electronico ?? '';
                        $estatus  = (int)($persona->iestatus ?? 1);
                    @endphp

                    <tr>
                        <td class="text-center">{{ $nombre }}</td>
                        <td class="text-center">{{ $paterno }}</td>
                        <td class="text-center">{{ $materno }}</td>
                        <td class="text-center">{{ $puesto }}</td>
                        <td class="text-center">{{ $adscrip }}</td>
                        <td class="text-center">{{ $correo }}</td>

                        <td class="text-center col-actions">
                            @if ($idPersonal)
                                @if ($estatus === 1)
                                    <a href="{{ url('personal/editar/'.$idPersonal) }}" data-toggle="tooltip" data-html="true" title="Corrección de datos">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                                    </a>

                                    <a href="{{ url('personal/actualizar/'.$idPersonal) }}" data-toggle="tooltip" data-html="true" title="Actualizar Puesto y Adscripción">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/pencil.svg') }}" width="18" height="18">
                                    </a>

                                    <a href="{{ url('personal/inhabilitar/'.$idPersonal) }}" data-toggle="tooltip" data-html="true" title="Borrar">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                                    </a>
                                @else
                                    <a href="{{ url('personal/inhabilitar/'.$idPersonal) }}" data-toggle="tooltip" data-html="true" title="Recuperar">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                                    </a>
                                @endif
                            @else
                                <span class="text-danger">Sin ID</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </form>
</div>

{{-- =========================
     MODAL: NUEVO PERSONAL
     ========================= --}}
<div class="modal fade" id="modalNuevoPersonal" tabindex="-1" role="dialog" aria-labelledby="modalNuevoPersonalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ url('personal/guardar') }}">
                @csrf
                <input type="hidden" name="from_modal" value="1">

                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoPersonalLabel">
                        <img src="{{ asset('bootstrap-icons-1.5.0/people.svg') }}" width="18" height="18">
                        Nuevo Personal
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label>Paterno</label>
                            <input type="text" name="paterno" class="form-control" value="{{ old('paterno') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label>Materno</label>
                            <input type="text" name="materno" class="form-control" value="{{ old('materno') }}">
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-6">
                            <label>Correo Electrónico</label>
                            <input type="email" name="correo" class="form-control" value="{{ old('correo') }}">
                        </div>

                        <div class="col-md-6">
                            <label>Puesto</label>
                            <select name="id_puesto" id="id_puesto" class="form-control select2-personal">
                                <option value=""></option>
                                @foreach(($puestos ?? []) as $p)
                                    @php
                                        $idPuesto = $p->id_puesto ?? $p->iid_puesto ?? null;
                                        $descPuesto = $p->descripcion ?? $p->cdescripcion_puesto ?? $p->nombre ?? '';
                                    @endphp
                                    <option value="{{ $idPuesto }}" {{ old('id_puesto') == $idPuesto ? 'selected' : '' }}>
                                        {{ $descPuesto }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-md-12">
                            <label>Adscripción</label>
                            <select name="id_adscripcion" id="id_adscripcion" class="form-control select2-personal">
                                <option value=""></option>
                                @foreach(($adscripciones ?? []) as $a)
                                    @php
                                        $idAds = $a->id_adscripcion ?? $a->iid_adscripcion ?? null;
                                        $descAds = $a->descripcion ?? $a->cdescripcion_adscripcion ?? $a->nombre ?? '';
                                    @endphp
                                    <option value="{{ $idAds }}" {{ old('id_adscripcion') == $idAds ? 'selected' : '' }}>
                                        {{ $descAds }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    function initSelect2Personal() {
        if (!window.$) return;

        $('.select2-personal').select2({
            width: '100%',
            dropdownParent: $('#modalNuevoPersonal'),
            placeholder: 'Buscar...',
            allowClear: true
        });
    }

    // Inicializa cuando se abre el modal
    if (window.$) {
        $('#modalNuevoPersonal').on('shown.bs.modal', function () {
            initSelect2Personal();
        });
    }

    // Si vienes de POST con errores, reabre el modal y vuelve a init
    @if($errors->any() && old('from_modal') == '1')
        if (window.$ && $('#modalNuevoPersonal').length) {
            $('#modalNuevoPersonal').modal('show');
            setTimeout(initSelect2Personal, 200);
        }
    @endif

});
</script>

<style>
.select2-container { width: 100% !important; }
.select2-container .select2-selection--single {
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 1.5 !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: calc(2.25rem + 2px);
}
</style>

@endsection

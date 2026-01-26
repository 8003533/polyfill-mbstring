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
                <a href="{{ url('personal/nuevo') }}" data-toggle="tooltip" data-html="true" title="Nuevo">
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
                        // ✅ ID robusto: toma el que exista en tu SELECT
                        $idPersonal = $persona->iid_personal
                            ?? $persona->id_personal
                            ?? $persona->iid_empleado_taller
                            ?? null;

                        // ✅ Campos robustos: por si vienen sin "c" al inicio
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
@endsection

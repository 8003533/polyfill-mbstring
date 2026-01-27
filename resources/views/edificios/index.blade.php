@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
        Listado de Edificios
    </h4>
@endsection

@section('panel')
<div class="table-responsive">
    <form method="GET" action="{{ url('/edificios/index') }}" id="formIndexEdifcios">

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
                <a href="{{ url('edificios/nuevo') }}" data-toggle="tooltip" data-html="true" title="Nuevo">
                    + Nuevo Edificio
                </a>
            </div>
        </div>

        <table class="table table-striped shadow-lg" id="MyTableEdificios">
            <thead>
                <tr>
                    <th class="text-center">Número</th>
                    <th class="text-center">Nombre</th>
                    <th class="text-center">Administración</th>
                    <th class="text-center">Dirección</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @foreach($edificios as $indice => $edificio)

                    @php
                        // ✅ soporta si viene como array o como objeto
                        $idEdificio = is_array($edificio) ? ($edificio['iid_edificio'] ?? null) : ($edificio->iid_edificio ?? null);
                        $nombre     = is_array($edificio) ? ($edificio['cnombre_edificio'] ?? '') : ($edificio->cnombre_edificio ?? '');

                        // Relaciones seguras (pueden ser null)
                        $administracion = is_array($edificio) ? ($edificio['administracion'] ?? null) : ($edificio->administracion ?? null);
                        $colonia        = is_array($edificio) ? ($edificio['colonia'] ?? null) : ($edificio->colonia ?? null);
                        $alcaldia        = is_array($edificio) ? ($edificio['alcaldia'] ?? null) : ($edificio->alcaldia ?? null);
                        $entidad         = is_array($edificio) ? ($edificio['entidad'] ?? null) : ($edificio->entidad ?? null);

                        $adminNombre = is_array($administracion)
                            ? ($administracion['cdescripcion_administracion'] ?? '-')
                            : ($administracion->cdescripcion_administracion ?? '-');

                        $coloniaNombre = is_array($colonia)
                            ? ($colonia['cnombre_colonia'] ?? '-')
                            : ($colonia->cnombre_colonia ?? '-');

                        $alcaldiaNombre = is_array($alcaldia)
                            ? ($alcaldia['cnombre_alcaldia'] ?? '-')
                            : ($alcaldia->cnombre_alcaldia ?? '-');

                        $entidadNombre = is_array($entidad)
                            ? ($entidad['cnombre_entidad'] ?? '-')
                            : ($entidad->cnombre_entidad ?? '-');

                        $calle    = is_array($edificio) ? ($edificio['ccalle'] ?? '') : ($edificio->ccalle ?? '');
                        $numExt   = is_array($edificio) ? ($edificio['cnumero_exterior'] ?? '') : ($edificio->cnumero_exterior ?? '');
                        $numInt   = is_array($edificio) ? ($edificio['cnumero_interior'] ?? '') : ($edificio->cnumero_interior ?? '');
                        $cp       = is_array($edificio) ? ($edificio['cid_codigo_postal'] ?? '') : ($edificio->cid_codigo_postal ?? '');

                        $estatus  = is_array($edificio) ? (int)($edificio['iestatus'] ?? 1) : (int)($edificio->iestatus ?? 1);

                        $direccion = trim($calle.' '.$numExt.' '.$numInt);
                        $direccion .= ', '.$coloniaNombre.', '.$alcaldiaNombre.', '.$entidadNombre.', C.P. '.$cp;
                    @endphp

                    <tr>
                        <td class="text-center">{{ $idEdificio }}</td>
                        <td class="text-center">{{ $nombre }}</td>
                        <td class="text-center">{{ $adminNombre }}</td>
                        <td class="text-center">{{ $direccion }}</td>

                        <td class="text-center col-actions">
                            @if($idEdificio)
                                @if ($estatus === 1)
                                    <a href="{{ url('edificios/editar/'.$idEdificio) }}" data-toggle="tooltip" data-html="true" title="Actualizar">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                                    </a>

                                    <a href="{{ url('edificios/inhabilitar/'.$idEdificio) }}" data-toggle="tooltip" data-html="true" title="Borrar">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                                    </a>
                                @else
                                    <a href="{{ url('edificios/inhabilitar/'.$idEdificio) }}" data-toggle="tooltip" data-html="true" title="Recuperar">
                                        <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                                    </a>
                                @endif
                            @endif
                        </td>
                    </tr>

                @endforeach
            </tbody>
        </table>
    </form>
</div>
@endsection
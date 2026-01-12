@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18">
        Detalle de Salidas
    </h4>
@endsection

@section('panel')
<div class="table-responsive">
    <form method="GET" action="{{ url('/detalle_salida') }}" id="formIndexDetalleSalida">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>Corrige los errores para continuar</p>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        {{-- filtros opcionales --}}
    </form>

    <div class="row mb-2">
        <div class="col text-right">
            <a href="{{ url('/detalle_salida/nueva') }}" class="btn btn-success">
                <img src="{{ asset('bootstrap-icons-1.5.0/folder-plus.svg') }}" width="18" height="18">
                <span>&nbsp;Nuevo Detalle Salida</span>
            </a>
        </div>
    </div>

    <table class="table table-striped shadow-lg" id="MyTableDetalleSalida">
        <thead>
            <tr>
                <th class="text-center">Bien</th>
                <th class="text-center">Disponible</th>
                <th class="text-center">Solicitada</th>
                <th class="text-center">Utilizada</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($detalles as $detalle)
            <tr>
                <td class="text-center">{{ optional($detalle->bien)->codigo }}</td>
                <td class="text-center">{{ $detalle->cantidad_disponible }}</td>
                <td class="text-center">{{ $detalle->cantidad_solicitada }}</td>
                <td class="text-center">{{ $detalle->cantidad_utilizada }}</td>
                <td class="text-center col-actions">
                    @if ($detalle->iestatus == 1)
                        <a href="{{ url('detalle_salida/editar/'.$detalle->id_detalle_salida) }}" title="Editar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </a>
                        <a href="{{ url('detalle_salida/inhabilitar/'.$detalle->id_detalle_salida) }}" title="Inhabilitar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                        </a>
                    @else
                        <a href="{{ url('detalle_salida/inhabilitar/'.$detalle->id_detalle_salida) }}" title="Recuperar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

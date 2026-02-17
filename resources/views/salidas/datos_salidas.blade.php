@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-up.svg') }}" width="18" height="18">
    Detalle de Salida
</h3>
@endsection

@section('panel')
<div class="table-responsive">

    <div class="mb-3">
        <b>ID:</b> {{ $salida->id_salida }} &nbsp; | &nbsp;
        <b>Fecha:</b> {{ $salida->fecha }} &nbsp; | &nbsp;
        <b>Folio:</b> {{ $salida->folio ?? '-' }} &nbsp; | &nbsp;
        <b>Motivo:</b> {{ $salida->motivo ?? '-' }}
    </div>

    <table class="table table-striped shadow-lg">
        <thead>
            <tr>
                <th>Bien</th>
                <th class="text-center">Disponible</th>
                <th class="text-center">Utilizada</th>
            </tr>
        </thead>
        <tbody>
            @foreach($salida->detalles as $d)
                <tr>
                    <td>{{ $d->bien ? ($d->bien->codigo.' - '.$d->bien->nombre) : $d->id_bien }}</td>
                    <td class="text-center">{{ number_format($d->cantidad_disponible, 3) }}</td>
                    <td class="text-center">{{ number_format($d->cantidad_utilizada, 3) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="text-center mt-3">
        <a href="{{ route('salidas.index') }}" class="btn btn-primary">
            Regresar
        </a>
    </div>

</div>
@endsection

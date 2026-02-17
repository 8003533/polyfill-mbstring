@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-up.svg') }}" width="18" height="18">
    Editar Salida
</h3>
@endsection

@section('panel')
<div class="table-responsive">

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p>Corrige los errores para continuar</p>
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<form method="POST" action="{{ route('salidas.actualizar') }}">
@csrf

<input type="hidden" name="id_salida" value="{{ $salida->id_salida }}">

<div class="row">
    <div class="col-md-3">
        <label><b>Fecha</b></label>
        <input type="date" name="fecha" class="form-control" required value="{{ old('fecha', $salida->fecha) }}">
    </div>
    <div class="col-md-3">
        <label><b>Folio</b></label>
        <input type="text" name="folio" class="form-control" maxlength="255" value="{{ old('folio', $salida->folio) }}">
    </div>
    <div class="col-md-6">
        <label><b>Motivo</b></label>
        <input type="text" name="motivo" class="form-control" maxlength="255" value="{{ old('motivo', $salida->motivo) }}">
    </div>
</div>

<hr>

<h5>Detalle (solo lectura)</h5>
<table class="table table-bordered">
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
                <td class="text-center">{{ number_format($d->cantidad_disponible,3) }}</td>
                <td class="text-center">{{ number_format($d->cantidad_utilizada,3) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="text-center mt-3">
    <button type="submit" class="btn btn-primary">
        <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
        Guardar cambios
    </button>

    <a href="{{ route('salidas.index') }}" class="btn btn-primary">
        <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
        Cancelar
    </a>
</div>

</form>
</div>
@endsection

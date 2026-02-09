@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
    Eliminar Salida
</h3>
@endsection

@section('panel')
<div class="text-center">

    <p>¿Deseas eliminar la salida <b>#{{ $salida->id_salida }}</b>?</p>
    <p><b>Folio:</b> {{ $salida->folio ?? '-' }} | <b>Fecha:</b> {{ $salida->fecha }}</p>

    <form method="POST" action="{{ route('salidas.eliminar', $salida->id_salida) }}">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-primary">
            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
            Sí, eliminar
        </button>

        <a href="{{ route('salidas.index') }}" class="btn btn-primary">
            <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
            Cancelar
        </a>
    </form>

</div>
@endsection

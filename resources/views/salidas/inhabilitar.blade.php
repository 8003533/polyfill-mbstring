@extends('layouts.app')

@section('titulo')
Eliminar Salida
@endsection

@section('panel')

<form method="POST" action="{{ route('salidas.eliminar', $salida->id_salida) }}">
    @csrf
    @method('DELETE')

    <p class="text-center">
        ¿Deseas eliminar la salida <strong>#{{ $salida->id_salida }}</strong>?
    </p>

    <div class="text-center">
        <button class="btn btn-danger">Eliminar</button>
        <a href="{{ route('salidas.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

@endsection

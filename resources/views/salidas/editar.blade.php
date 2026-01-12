@extends('layouts.app')

@section('titulo')
Editar Salida
@endsection

@section('panel')

<form method="POST" action="{{ route('salidas.actualizar') }}">
    @csrf
    @method('PUT')

    <input type="hidden" name="id_salida" value="{{ $salida->id_salida }}">

    @include('salidas.datos_salidas')

    <div class="mt-4 text-center">
        <button class="btn btn-primary">Actualizar</button>
        <a href="{{ route('salidas.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</form>

@endsection

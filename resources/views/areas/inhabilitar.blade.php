@extends('layouts.app')

@section('titulo')
<h3 class="text-danger text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/x-circle.svg') }}" width="18" height="18">
    Inhabilitar Área
</h3>
@endsection

@section('panel')
<div class="container mt-4 text-center">
    <h5>¿Estás seguro que deseas inhabilitar el área?</h5>

    <p class="mt-3">
        <strong>ID:</strong> {{ $area->id_areas }}<br>
        <strong>Nombre:</strong> {{ $area->nombre }}
    </p>

    <form action="{{ route('areas.confirmainhabilitar', $area->id_areas) }}" method="POST">
        @csrf
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-danger">Inhabilitar</button>
        </div>
    </form>
</div>
@endsection

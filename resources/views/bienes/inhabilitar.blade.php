@extends('layouts.app')

@section('titulo')
<h3 class="text-danger text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/x-circle.svg') }}" width="18">
    Inhabilitar Bien
</h3>
@endsection

@section('panel')
<div class="container mt-4 text-center">
    <h5>¿Estás seguro que deseas inhabilitar este bien?</h5>

    <p class="mt-3">
        <strong>ID:</strong> {{ $bien->id_bien }}<br>
        <strong>Nombre:</strong> {{ $bien->nombre }}
    </p>

    <form action="{{ route('bienes.inhabiliar', $bien->id_bien) }}" method="POST">
        @csrf
        @method('DELETE')
        <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="{{ route('bienes.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-danger">Inhabilitar</button>
        </div>
    </form>
</div>
@endsection

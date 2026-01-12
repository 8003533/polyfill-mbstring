@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box.svg') }}" width="18" height="18">
    Datos de Entrada
</h3>
@endsection

@section('panel')
<div class="container mt-4">
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <td>{{ $entrada->id_entrada }}</td>
        </tr>
        <tr>
            <th>Folio</th>
            <td>{{ $entrada->folio }}</td>
        </tr>
        <tr>
            <th>Proveedor</th>
            <td>{{ $entrada->proveedor->nombre }}</td>
        </tr>
        <tr>
            <th>Fecha</th>
            <td>{{ $entrada->fecha }}</td>
        </tr>
        <tr>
            <th>Tipo</th>
            <td>{{ $entrada->tipo }}</td>
        </tr>
    </table>
    <a href="{{ route('entradas.index') }}" class="btn btn-primary">Regresar</a>
</div>
@endsection

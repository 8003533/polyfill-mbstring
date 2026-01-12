@extends('layouts.app')

@section('titulo')
<h3 class="text-success text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-seam.svg') }}" width="18" height="18">
    Datos del Bien
</h3>
@endsection

@section('panel')
<div class="container mt-4">
    <form action="{{ route('bienes.guardar') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="codigo" class="form-label">Código:</label>
            <input type="text" name="codigo" id="codigo" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="id_unidad" class="form-label">Unidad:</label>
            <select name="id_unidad" id="id_unidad" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($unidades as $unidad)
                    <option value="{{ $unidad->id_unidad }}">{{ $unidad->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría:</label>
            <select name="id_categoria" id="id_categoria" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}">{{ $categoria->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="row mb-3">
            <div class="col-6">
                <label for="stock_minimo" class="form-label">Stock Mínimo:</label>
                <input type="number" name="stock_minimo" id=_

@extends('layouts.app')

@section('titulo')
<h3 class="text-warning text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
    Editar Bien
</h3>
@endsection

@section('panel')
<div class="container mt-4">

    <form action="{{ route('bienes.actualizar') }}" method="POST">
        @csrf
        <input type="hidden" name="id_bien" value="{{ $bien->id_bien }}">

        <div class="mb-3">
            <label for="codigo" class="form-label">Código:</label>
            <input type="text" name="codigo" id="codigo" class="form-control" value="{{ $bien->codigo }}" required>
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $bien->nombre }}" required>
        </div>

        <div class="mb-3">
            <label for="id_unidad" class="form-label">Unidad:</label>
            <select name="id_unidad" id="id_unidad" class="form-control" required>
                <option value="">-- Seleccione --</option>
                @foreach($unidades as $unidad)
                    <option value="{{ $unidad->id_unidad }}" {{ $bien->id_unidad == $unidad->id_unidad ? 'selected' : '' }}>
                        {{ $unidad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría:</label>
            <select name="id_categoria" id="id_categoria" class="form-control" required>
                <option value="">-- Seleccione --</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}" {{ $bien->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="stock_minimo" class="form-label">Stock Mínimo:</label>
            <input type="number" name="stock_minimo" id="stock_minimo" class="form-control" value="{{ $bien->stock_minimo }}">
        </div>

        <div class="mb-3">
            <label for="stock_maximo" class="form-label">Stock Máximo:</label>
            <input type="number" name="stock_maximo" id="stock_maximo" class="form-control" value="{{ $bien->stock_maximo }}">
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('bienes.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-warning">Actualizar</button>
        </div>

    </form>
</div>
@endsection

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

        <!-- Hidden field para ID -->
        <input type="hidden" name="id_bien" value="{{ $bien->id_bien }}">

        <!-- Código -->
        <div class="mb-3">
            <label for="codigo" class="form-label">Código:</label>
            <input type="text" id="codigo" name="codigo" class="form-control" 
                   value="{{ old('codigo', $bien->codigo) }}" required>
        </div>

        <!-- Nombre -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control" 
                   value="{{ old('nombre', $bien->nombre) }}" required>
        </div>

        <!-- Unidad -->
        <div class="mb-3">
            <label for="id_unidad" class="form-label">Unidad:</label>
            <select id="id_unidad" name="id_unidad" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($unidades as $unidad)
                    <option value="{{ $unidad->id_unidad }}" 
                        {{ $bien->id_unidad == $unidad->id_unidad ? 'selected' : '' }}>
                        {{ $unidad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Categoría -->
        <div class="mb-3">
            <label for="id_categoria" class="form-label">Categoría:</label>
            <select id="id_categoria" name="id_categoria" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}" 
                        {{ $bien->id_categoria == $categoria->id_categoria ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Stock Mínimo -->
        <div class="mb-3">
            <label for="stock_minimo" class="form-label">Stock Mínimo:</label>
            <input type="number" id="stock_minimo" name="stock_minimo" class="form-control"
                   value="{{ old('stock_minimo', $bien->stock_minimo) }}" required>
        </div>

        <!-- Stock Máximo -->
        <div class="mb-3">
            <label for="stock_maximo" class="form-label">Stock Máximo:</label>
            <input type="number" id="stock_maximo" name="stock_maximo" class="form-control"
                   value="{{ old('stock_maximo', $bien->stock_maximo) }}" required>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('bienes.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-warning">
                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection

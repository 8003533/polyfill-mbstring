@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box.svg') }}" width="18" height="18">
    Nuevo Bien
</h3>
@endsection

@section('panel')
<div class="card shadow-lg p-4">

    <form method="POST" action="{{ route('bienes.guardar') }}">
        @csrf

        <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Unidad de Medida</label>
            <select name="id_unidad" class="form-control" required>
                <option value="">Pieza</option>
                <option value="">Caja</option>
                <option value="">Metro</option>
                <option value="">Paquete</option>
                @foreach($unidades as $unidad)
                    <option value="{{ $unidad->id_unidad }}">
                        {{ $unidad->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Categoría</label>
            <select name="id_categoria" class="form-control" required>
                <option value="">Seleccione</option>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id_categoria }}">
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Stock mínimo</label>
            <input type="number" name="stock_min" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Stock máximo</label>
            <input type="number" name="stock_max" class="form-control" required>
        </div>

        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">
                Guardar
            </button>

            <a href="{{ route('bienes.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
        </div>

    </form>

</div>
@endsection

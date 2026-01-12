@extends('layouts.app')

@section('titulo')
<h3 class="text-success text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
    Editar Área
</h3>
@endsection

@section('panel')
<div class="container mt-4">
    <form action="{{ route('areas.actualizar') }}" method="POST">
        @csrf
      
        <input type="hidden" name="id_areas" value="{{ $area->id_areas }}">

        <!-- Nombre del Área -->
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre del Área:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ old('nombre', $area->nombre) }}" required>
        </div>

        <!-- Estatus -->
        <div class="mb-3">
            <label for="estatus" class="form-label">Estatus:</label>
            <select id="estatus" name="estatus" class="form-control">
                <option value="1" {{ $area->estatus == 1 ? 'selected' : '' }}>Activo</option>
                <option value="0" {{ $area->estatus == 0 ? 'selected' : '' }}>Inactivo</option>
            </select>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('areas.index') }}" class="btn btn-secondary">
                Cancelar
            </a>
            <button type="submit" class="btn btn-primary">
                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
    {{ isset($area) ? 'Editar Área' : 'Nueva Área' }}
</h3>
@endsection

@section('panel')
<div class="container mt-4">

    <form action="{{ isset($area) ? route('areas.actualizar', $area->id) : route('areas.guardar') }}" method="POST">
        @csrf
        @if(isset($area))
            @method('PUT')
        @endif

        {{-- NOMBRE --}}
        <div class="mb-4">
            <label for="nombre" class="form-label">Nombre del Área:</label>
            <input 
                type="text" 
                name="nombre" 
                id="nombre" 
                class="form-control" 
                value="{{ old('nombre', $area->nombre ?? '') }}"
                required
            >
        </div>

        {{-- ESTATUS --}}
        <div class="mb-4">
            <label for="estatus" class="form-label">Estatus:</label>
            <select name="estatus" id="estatus" class="form-control" required>
                <option value="ACTIVO" 
                    {{ old('estatus', $area->estatus ?? 'ACTIVO') == 'ACTIVO' ? 'selected' : '' }}>
                    ACTIVO
                </option>
            </select>
        </div>

        {{-- BOTONES --}}
        <div class="row text-center">
            <div class="col-6">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    <span>&nbsp;Guardar</span>
                </button>
            </div>

            <div class="col-6">
                <a href="{{ url('/areas/index') }}">
                    <button type="button" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                        <span>&nbsp;Cerrar</span>
                    </button>
                </a>
            </div>
        </div>

    </form>

</div>
@endsection

@extends('layouts.app')

@section('titulo')
<h3 class="text-warning text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
    Editar Entrada
</h3>
@endsection

@section('panel')
<div class="container mt-4">
    <form action="{{ route('entradas.actualizar') }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden" name="id_entrada" value="{{ $entrada->id_entrada }}">

        <div class="mb-3">
            <label for="id_proveedor" class="form-label">Proveedor:</label>
            <select name="id_proveedor" id="id_proveedor" class="form-control" required>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id_proveedor }}" {{ $prov->id_proveedor == $entrada->id_proveedor ? 'selected' : '' }}>
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="folio" class="form-label">Folio:</label>
            <input type="text" name="folio" id="folio" class="form-control" value="{{ $entrada->folio }}" required>
        </div>

        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="{{ $entrada->fecha }}" required>
        </div>

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo:</label>
            <input type="text" name="tipo" id="tipo" class="form-control" value="{{ $entrada->tipo }}" required>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('entradas.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-warning">Actualizar</button>
        </div>
    </form>
</div>
@endsection

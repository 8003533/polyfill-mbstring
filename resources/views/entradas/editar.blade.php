@extends('layouts.app')

@section('titulo')
<h3 class="text-warning text-center">Editar Entrada</h3>
@endsection

@section('panel')
<div class="container mt-4">
    <form action="{{ route('entradas.actualizar') }}" method="POST">
        @csrf
        <input type="hidden" name="id" value="{{ $entrada->id_entrada }}">

        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="id_proveedor" class="form-control" required>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id_proveedor }}" {{ $entrada->id_proveedor == $prov->id_proveedor ? 'selected' : '' }}>
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
            @error('id_proveedor') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Folio</label>
            <input type="text" name="folio" class="form-control" value="{{ old('folio', $entrada->folio) }}">
            @error('folio') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ old('fecha', $entrada->fecha) }}" required>
            @error('fecha') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" value="{{ old('tipo', $entrada->tipo) }}" required>
            @error('tipo') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('entradas.index') }}" class="btn btn-primary">Cancelar</a>
            <button class="btn btn-warning">Actualizar</button>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('titulo')
<h3 class="text-success text-center">Nueva Entrada</h3>
@endsection

@section('panel')
<div class="container mt-4">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('entradas.crear') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="id_proveedor" class="form-control" required>
                <option value="" disabled selected>-- Selecciona --</option>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id_proveedor }}" {{ old('id_proveedor') == $prov->id_proveedor ? 'selected' : '' }}>
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Folio</label>
            <input type="text" name="folio" class="form-control" value="{{ old('folio') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" required value="{{ old('fecha') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" required value="{{ old('tipo') }}">
        </div>

        <hr>
        <h5 class="mb-3">Detalle de Entrada</h5>

        <div class="mb-3">
            <label class="form-label">Año</label>
            <input type="number" name="anio" class="form-control" required min="2000" max="2100"
                   value="{{ old('anio', date('Y')) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Bien</label>
            <select name="id_bien" class="form-control" required>
                <option value="" disabled selected>-- Selecciona --</option>
                @foreach($bienes as $bien)
                    <option value="{{ $bien->id_bien }}" {{ old('id_bien') == $bien->id_bien ? 'selected' : '' }}>
                        {{ $bien->codigo }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required min="1"
                   value="{{ old('cantidad') }}">
        </div>

        <div class="d-flex justify-content-between">
            <a class="btn btn-primary" href="{{ route('entradas.index') }}">Cancelar</a>
            <button type="submit" class="btn btn-success">Guardar</button>
        </div>
    </form>
</div>
@endsection

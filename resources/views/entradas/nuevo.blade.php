@extends('layouts.app')

@section('titulo')
<h3 class="text-success text-center">
    Nueva Entrada
</h3>
@endsection

@section('panel')
<div class="container mt-4">
    <form action="{{ url('entradas/crear.index') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Proveedor</label>
            <select name="id_proveedor" class="form-control" required>
                @foreach($proveedores as $prov)
                    <option value="{{ $prov->id_proveedor }}">
                        {{ $prov->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Folio</label>
            <input type="text" name="folio" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="date" name="fecha" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>

                <div class="mb-3">
            <label class="form-label">Cantidad</label>
            <input type="text" name="tipo" class="form-control" required>
        </div>

        

        <div class="d-flex justify-content-between">
            <a class="btn btn-primary">
                Cancelar
            </a>
            <button class="btn btn-success">
                Guardar
            </button>
        </div>
    </form>
</div>
@endsection
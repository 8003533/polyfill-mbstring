@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Catálogos</h1>

    <div class="row">
        <div class="col-md-3">
            <a href="{{ route('areas.index') }}" class="btn btn-primary btn-block mb-3">Áreas</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('bienes.index') }}" class="btn btn-primary btn-block mb-3">Bienes</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('proveedores.index') }}" class="btn btn-primary btn-block mb-3">Proveedores</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('entradas') }}" class="btn btn-primary btn-block mb-3">Entradas</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('salidas.index') }}" class="btn btn-primary btn-block mb-3">Salidas</a>
        </div>
        <div class="col-md-3">
            <a href="{{ route('unidades.index') }}" class="btn btn-primary btn-block mb-3">Unidades</a>
        </div>
    </div>
</div>
@endsection

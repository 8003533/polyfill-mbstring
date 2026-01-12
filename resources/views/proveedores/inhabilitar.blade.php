@extends('layouts.app')

@section('titulo')
<h4 class="text-primary-sin text-center">Inhabilitar Proveedor</h4>
@endsection

@section('panel')
<p>¿Seguro que deseas inhabilitar al proveedor <strong>{{ $proveedor->nombre }}</strong>?</p>

<form action="{{ route('proveedores.desactivar', $proveedor->id) }}" method="POST">
    @csrf
    @method('DELETE')

    <button class="btn btn-danger">Sí, inhabilitar</button>
</form>
@endsection

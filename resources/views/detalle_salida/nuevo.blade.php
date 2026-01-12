@extends('layouts.app')

@section('titulo')
    <img src="{{ asset('bootstrap-icons-1.5.0/folder-plus.svg') }}" width="18" height="18">
    Nuevo Detalle Salida
@endsection

@section('panel')
<form method="POST" action="{{ url('/detalle_salida/guardar') }}" id="formNuevoDetalleSalida">
    @csrf

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p>Corrige los errores para continuar</p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden("true")">&times;</span>
        </button>
    </div>
    @endif

    @include('detalle_salida.datos_detalle_salida')

    <div class="row text-center">
        <div class="col-6">
            <button id="btnGuardar" type="submit" class="btn btn-primary">
                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                <span>&nbsp;Guardar</span>
            </button>
        </div>
        <div class="col-6">
            <a href="{{ url('/detalle_salida') }}">
                <button type="button" class="btn btn-secondary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                    <span>&nbsp;Cancelar</span>
                </button>
            </a>
        </div>
    </div>
</form>
@endsection

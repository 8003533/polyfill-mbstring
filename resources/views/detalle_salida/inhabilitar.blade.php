@extends('layouts.app')

@section('titulo')
    @if ($detalle->iestatus == 1)
        Inhabilitar Detalle Salida
    @else
        Recuperar Detalle Salida
    @endif
@endsection

@section('panel')
<form method="POST" action="{{ url('/detalle_salida/actualizar') }}" id="formInhabilitarDetalleSalida">
    @csrf
    <input type="hidden" name="id_detalle_salida" id="id_detalle_salida" value="{{ $detalle->id_detalle_salida }}">
    <input type="hidden" name="noeditar" id="noeditar" value="{{ $noeditar ?? '' }}">

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p>Corrige los errores para continuar</p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss("alert") aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @include('detalle_salida.datos_detalle_salida')

    <div class="row text-center">
        <div class="col-6">
            <button type="submit" class="btn btn-primary">
                @if ($detalle->iestatus == 1)
                    <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                    <span>&nbsp;Inhabilitar</span>
                @else
                    <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                    <span>&nbsp;Recuperar</span>
                @endif
            </button>
        </div>
        <div class="col-6">
            <a href="{{ url('/detalle_salida') }}">
                <button type="button" class="btn btn-secondary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                    <span>&nbsp;Cerrar</span>
                </button>
            </a>
        </div>
    </div>
</form>
@endsection

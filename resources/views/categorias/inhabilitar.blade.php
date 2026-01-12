@extends('layouts.app')

@section('titulo')
    @if ($categoria->iestatus == 1)
        Inhabilitar Categoría
    @else
        Recuperar Categoría
    @endif
@endsection

@section('panel')
<form method="POST" action="{{ url('/categorias/actualizar') }}" id="formInhabilitarCategoria">
    @csrf
    <input type="hidden" name="id_categoria" id="id_categoria" value="{{ $categoria->id_categoria }}">
    <input type="hidden" name "noeditar" id="noeditar" value="{{ $noeditar ?? '' }}">

    @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p>Corrige los errores para continuar</p>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif

    @include('categorias.datos_categoria')

    <div class="row text-center">
        <div class="col-6">
            <button type="submit" class="btn btn-primary">
                @if ($categoria->iestatus == 1)
                    <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                    <span>&nbsp;Inhabilitar</span>
                @else
                    <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                    <span>&nbsp;Recuperar</span>
                @endif
            </button>
        </div>
        <div class="col-6">
            <a href="{{ url('/categorias') }}">
                <button type="button" class="btn btn-secondary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                    <span>&nbsp;Cerrar</span>
                </button>
            </a>
        </div>
    </div>
</form>
@endsection

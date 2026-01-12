@extends('layouts.app')

@section('titulo')
    Actualizar Categoría
@endsection

@section('panel')
<form method="POST" action="{{ url('/categorias/actualizar') }}" id="formEditarCategoria">
    @csrf
    <input type="hidden" name="id_categoria" id="id_categoria" value="{{ $categoria->id_categoria }}">
    <input type="hidden" name="noeditar" id="noeditar" value="{{ $noeditar ?? '' }}">

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
            <button id="btnActualizar" type="submit" class="btn btn-primary">
                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                <span>&nbsp;Actualizar</span>
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

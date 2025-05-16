@extends('layouts.app')

@section('titulo')
    Actualizar Adscripción
@endsection
@section('panel')
    <form method="POST" action="{{ url('/adscripciones/actualizar') }}" id="formEditarAdscripcion">
    	@csrf

        <input type="hidden" name="id_adscripcion" id="id_adscripcion" value="{{ $adscripcion->iid_adscripcion }}">
        <input type="hidden" name="noeditar"       id="noeditar"       value="{{ $noeditar }}">

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>Corrige los errores para continuar</p>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <!--Inputs de Adscripción-->
        @include('adscripciones.datos_adscripcion')
    
        <div class="row text-center">
            <div class="col-6">                        
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    <span>&nbsp;Actualizar</span>
                </button>
            </div>
            <div class="col-6">
                <a href="{{ url('/adscripciones/index') }}">
                <!--<button type="button" class="btn btn-primary" onClick="history.back()">-->
                    <button type="button" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                        <span>&nbsp;Cerrar</span>
                    </button>
                </a>
            </div>
        </div>
    </form>   
@endsection
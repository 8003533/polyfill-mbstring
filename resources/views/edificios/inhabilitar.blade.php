@extends('layouts.app')

@section('titulo')
    @if($edificio->iestatus == 1)
        Borrar Edificio
    @else
        Recuperar Edificio
    @endif
@endsection
@section('panel')
    <form method="POST" action="{{ url('/edificios/actualizar') }}" id="formInhabilitarEdificio">
    	@csrf

        <input type="hidden" name="id_edificio" id="id_edificio" value="{{ $edificio->iid_edificio }}">
        <input type="hidden" name="noeditar"    id="noeditar"    value="{{ $noeditar }}">

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
        <!--Inputs de Edificio-->
        @include('edificios.datos_edificio')
    
        <div class="row text-center">
            <div class="col-6">                        
                <button type="submit" class="btn btn-primary">
                    @if($edificio->iestatus == 1)
                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                        <span>&nbsp;Borrar</span>
                    @else
                        <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                        <span>&nbsp;Recuperar</span>
                    @endif
                </button>
            </div>
            <div class="col-6">
                <a href="{{ url('/edificios/index') }}">
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
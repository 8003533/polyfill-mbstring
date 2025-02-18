@extends('layouts.app')

@section('titulo')
    <img src="{{ asset('bootstrap-icons-1.5.0/building-add.svg') }}" width="18" height="18"> Nuevo Edificio
@endsection
@section('panel')
    <form method="POST" action="{{ url('/edificios/guardar') }}" id="formNuevoEdificio">
    	@csrf

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
                <button id="btnGuarda" type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    <span>&nbsp;Guardar</span>
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
@extends('layouts.app')

@section('titulo')
    Actualizar Personal
@endsection
@section('panel')
    <form method="POST" action="{{ url('/personal/actualizar') }}" id="formEditarPersonal">
    	@csrf

        <input type="hidden" name="id_personal" id="id_personal" value="{{ $personal->iid_personal }}">
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
        <!--Inputs de Personal-->
        @include('personal.datos_personal')
    
        <div class="row text-center">
            <div class="col-6">                        
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    <span>&nbsp;Actualizar</span>
                </button>
            </div>
            <div class="col-6">
                <a href="{{ url('/personal/index') }}">
                    <!--<button type="button" class="btn btn-primary" onClick="history.back()">-->
                    <button type="button" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                        <span>&nbsp;Cerrar</span>
                    </button>
                </button>
            </div>
        </div>
    </form>   
@endsection
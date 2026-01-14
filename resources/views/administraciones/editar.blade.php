@extends('layouts.app')

@section('titulo')
    Actualizar Administración
@endsection
@section('panel')
    <form method="POST" action="{{ url('/administraciones/actualizar') }}" id="formEditarAdministracion">
    	@csrf

        <input type="hidden" name="id_administracion" id="id_administracion" value="{{ $administracion->iid_administracion }}">
        <input type="hidden" name="noeditar"          id="noeditar"          value="{{ $noeditar }}">

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
        <!--Inputs de Administracion-->
        @include('administraciones.datos_administracion')
    
        <div class="row text-center">
            <div class="col-6">                        
                <button id="btnGuarda" type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    <span>&nbsp;Actualizar</span>
                </button>
            </div>
            <div class="col-6">
<button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#modalCerrar">
                <!--<button type="button" class="btn btn-primary" onClick="history.back()">-->
                    <button type="button" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                        <span>&nbsp;Cerrar</span>
                    </button>
                </a>
            </div>
        </div>
    </form>

    <div class="modal fade" id="modalActualizar" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Confirmar actualización</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <div class="modal-body">
                ¿Deseas guardar los cambios de esta administración?
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

                <button type="button" class="btn btn-primary" onclick="document.getElementById('formEditarAdministracion').submit();">
                    Sí, actualizar
                </button>
            </div>

        </div>
    </div>
</div>

@endsection
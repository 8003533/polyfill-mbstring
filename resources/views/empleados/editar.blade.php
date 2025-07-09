@extends('layouts.app')

@section('titulo')
    Actualizar Empleado de Taller
@endsection
@section('panel')
    <form method="POST" action="{{ url('/empleados/actualizar') }}" id="formEditarEmpleado">
    	@csrf

        <input type="hidden" name="id_empleado" id="id_empleado" value="{{ $empleado->iid_empleado_taller }}">
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
        <!--Inputs de Empleado-->
        @include('empleados.datos_empleado')
    
        <div class="row text-center">
            <div class="col-6">                        
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                    <span>&nbsp;Actualizar</span>
                </button>
            </div>
            <div class="col-6">
                <a href="{{ url('/empleados/index') }}">
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
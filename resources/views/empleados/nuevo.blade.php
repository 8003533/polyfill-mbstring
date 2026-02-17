@extends('layouts.app')

@section('titulo')
    <img src="{{ asset('bootstrap-icons-1.5.0/person-vcard-fill.svg') }}" width="18" height="18">
    Nuevo Empleado de Taller
@endsection

@section('panel')
<form method="POST" action="{{ route('empleados.guardar') }}" id="formNuevoEmpleado">
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

    {{-- Inputs de Empleado --}}
    @include('empleados.datos_empleado', [
        'empleado' => $empleado ?? null,
        'noeditar' => $noeditar ?? ''
    ])

    <div class="row text-center mt-3">
        <div class="col-6">
            <button type="submit" class="btn btn-primary">
                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
                <span>&nbsp;Guardar</span>
            </button>
        </div>

        <div class="col-6">
            <a href="{{ route('empleados.index') }}" class="btn btn-primary">
                <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
                <span>&nbsp;Cerrar</span>
            </a>
        </div>
    </div>
</form>
@endsection

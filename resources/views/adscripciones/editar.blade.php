@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/building.svg') }}" width="18" height="18">
        Editar Adscripción
    </h4>
@endsection

@section('panel')
<div class="container">

    {{-- Errores --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <p>Corrige los errores para continuar</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert">
                <span>&times;</span>
            </button>
        </div>
    @endif

    <form method="POST" action="{{ route('adscripciones.actualizar') }}">
        @csrf
        <input type="hidden" name="id_adscripcion" value="{{ $adscripcion->iid_adscripcion }}">

        {{-- Descripción --}}
        <div class="form-group">
            <label><b>Descripción</b></label>
            <input type="text"
                   name="cdescripcion_adscripcion"
                   class="form-control @error('cdescripcion_adscripcion') is-invalid @enderror"
                   value="{{ old('cdescripcion_adscripcion', $adscripcion->cdescripcion_adscripcion) }}"
                   maxlength="300"
                   required>
            @error('cdescripcion_adscripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Siglas --}}
        <div class="form-group">
            <label><b>Siglas</b></label>
            <input type="text"
                   name="csiglas"
                   class="form-control @error('csiglas') is-invalid @enderror"
                   value="{{ old('csiglas', $adscripcion->csiglas) }}"
                   maxlength="20">
            @error('csiglas')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tipo de Adscripción (igual que index) --}}
        <div class="form-group">
            <label><b>Tipo de Adscripción</b></label>
            <select name="iid_tipo_area"
                    class="form-control @error('iid_tipo_area') is-invalid @enderror"
                    required>
                <option value="" disabled hidden>-- Selecciona --</option>

                <option value="1" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='1'?'selected':'' }}>Dirección General</option>
                <option value="2" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='2'?'selected':'' }}>Subdirección</option>
                <option value="3" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='3'?'selected':'' }}>Jefatura de Departamento</option>
                <option value="4" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='4'?'selected':'' }}>Coordinación</option>
                <option value="5" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='5'?'selected':'' }}>Área Administrativa</option>
                <option value="6" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='6'?'selected':'' }}>Recursos Humanos</option>
                <option value="7" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='7'?'selected':'' }}>Finanzas / Contabilidad</option>
                <option value="8" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='8'?'selected':'' }}>Sistemas / TI</option>
                <option value="9" {{ old('iid_tipo_area', $adscripcion->iid_tipo_area)=='9'?'selected':'' }}>Otra</option>
            </select>
            @error('iid_tipo_area')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Botones --}}
        <div class="mt-3 text-right">
            <a href="{{ route('adscripciones.index') }}" class="btn btn-secondary">
                Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18">
                Guardar cambios
            </button>
        </div>

    </form>
</div>
@endsection

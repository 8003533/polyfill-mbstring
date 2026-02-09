@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-up.svg') }}" width="18" height="18">
    Nueva Salida
</h3>
@endsection

@section('panel')
<div class="table-responsive">

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <p>Corrige los errores para continuar</p>
        <ul class="mb-0">
            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
        </ul>
        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
    </div>
@endif

<form method="POST" action="{{ route('salidas.guardar') }}" id="formSalida">
@csrf

<div class="row">
    <div class="col-md-3">
        <label><b>Fecha</b></label>
        <input type="date" name="fecha" class="form-control" required value="{{ old('fecha', date('Y-m-d')) }}">
    </div>
    <div class="col-md-3">
        <label><b>Folio</b></label>
        <input type="text" name="folio" class="form-control" maxlength="255" value="{{ old('folio') }}">
    </div>
    <div class="col-md-6">
        <label><b>Motivo</b></label>
        <input type="text" name="motivo" class="form-control" maxlength="255" value="{{ old('motivo') }}">
    </div>
</div>

<hr>

{{-- Agregar detalle --}}
<div class="row align-items-end">
    <div class="col-md-6">
        <label><b>Bien</b></label>
        <select id="bienSelect" class="form-control">
            <option value="">-- Selecciona --</option>
            @foreach($bienes as $b)
                <option value="{{ $b->id_bien }}" data-text="{{ $b->codigo }} - {{ $b->nombre }}">
                    {{ $b->codigo }} - {{ $b->nombre }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label><b>Cantidad disponible</b></label>
        <input type="number" id="disponibleInput" class="form-control" min="0" step="0.001">
    </div>

    <div class="col-md-3">
        <label><b>Cantidad utilizada</b></label>
        <input type="number" id="utilizadaInput" class="form-control" min="0.001" step="0.001">
    </div>
</div>

<div class="row mt-2">
    <div class="col-md-12 text-right">
        <button type="button" id="btnAgregar" class="btn btn-primary">
            + Agregar al detalle
        </button>
    </div>
</div>

{{-- Tabla detalle visible --}}
<div class="mt-3">
    <table class="table table-bordered" id="tablaDetalle">
        <thead>
            <tr>
                <th>Bien</th>
                <th class="text-center">Disponible</th>
                <th class="text-center">Utilizada</th>
                <th class="text-center">Quitar</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <small class="text-muted">Aquí se muestra lo que estás creando antes de guardar.</small>
</div>

{{-- Inputs ocultos (se llenan con JS) --}}
<div id="inputsDetalle"></div>

<div class="text-center mt-3">
    <button type="submit" class="btn btn-primary">
        <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18" height="18">
        Guardar Salida
    </button>

    <a href="{{ route('salidas.index') }}" class="btn btn-primary">
        <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18">
        Cancelar
    </a>
</div>

</form>
</div>

<script>
$(function(){

    let idx = 0;

    $('#btnAgregar').on('click', function(){

        const idBien = $('#bienSelect').val();
        const bienTxt = $('#bienSelect option:selected').data('text');

        const disp = $('#disponibleInput').val();
        const util = $('#utilizadaInput').val();

        if(!idBien){
            alert('Selecciona un bien.');
            return;
        }
        if(disp === '' || parseFloat(disp) < 0){
            alert('Captura una cantidad disponible válida (>= 0).');
            return;
        }
        if(util === '' || parseFloat(util) <= 0){
            alert('Captura una cantidad utilizada válida (> 0).');
            return;
        }

        const rowId = 'row_'+idx;

        // Agregar fila a la tabla visible
        $('#tablaDetalle tbody').append(`
            <tr id="${rowId}">
                <td>${bienTxt}</td>
                <td class="text-center">${parseFloat(disp).toFixed(3)}</td>
                <td class="text-center">${parseFloat(util).toFixed(3)}</td>
                <td class="text-center">
                    <button type="button" class="btn btn-sm btn-danger btnQuitar" data-row="${rowId}" data-idx="${idx}">X</button>
                </td>
            </tr>
        `);

        // Agregar inputs ocultos para enviar al controlador
        $('#inputsDetalle').append(`
            <input type="hidden" name="id_bien[]" id="id_bien_${idx}" value="${idBien}">
            <input type="hidden" name="cantidad_disponible[]" id="disp_${idx}" value="${disp}">
            <input type="hidden" name="cantidad_utilizada[]" id="util_${idx}" value="${util}">
        `);

        idx++;

        // Limpiar inputs
        $('#bienSelect').val('');
        $('#disponibleInput').val('');
        $('#utilizadaInput').val('');
    });

    // Quitar fila del detalle y sus inputs
    $(document).on('click', '.btnQuitar', function(){
        const row = $(this).data('row');
        const i = $(this).data('idx');
        $('#'+row).remove();
        $('#id_bien_'+i).remove();
        $('#disp_'+i).remove();
        $('#util_'+i).remove();
    });

});
</script>

@endsection

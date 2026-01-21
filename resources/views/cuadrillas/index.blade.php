@extends('layouts.app')

@section('titulo')
<h4 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/people-fill.svg') }}" width="18">
    Listado de Cuadrillas
</h4>
@endsection

@section('panel')
<div class="table-responsive">

{{-- Mensajes --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button class="close" data-dismiss="alert">&times;</button>
</div>
@endif

@if(session('danger'))
<div class="alert alert-danger alert-dismissible fade show">
    {{ session('danger') }}
    <button class="close" data-dismiss="alert">&times;</button>
</div>
@endif

{{-- Botón nuevo --}}
<div class="row">
    <div class="col text-md-right">
        <a href="#" data-toggle="modal" data-target="#modalNuevaCuadrilla">
            + Nueva Cuadrilla
        </a>
    </div>
</div>

{{-- Tabla --}}
<table class="table table-striped shadow-lg" id="MyTableCuadrillas">
<thead>
<tr>
    <th class="text-center">ID</th>
    <th class="text-center">Descripción</th>
    <th class="text-center">Acciones</th>
</tr>
</thead>
<tbody>
@foreach($cuadrillas as $c)
<tr>
    <td class="text-center">{{ $c->iid_cuadrilla }}</td>
    <td class="text-center">{{ $c->cnombre_cuadrilla }}</td>
    <td class="text-center">

        @if($c->iestatus==1)

        <button class="btn"
            data-toggle="modal"
            data-target="#modalEditarCuadrilla"
            data-id="{{ $c->iid_cuadrilla }}"
            data-nombre="{{ $c->cnombre_cuadrilla }}"
            title="Editar">
            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="16">
        </button>

        <button class="btn"
            data-toggle="modal"
            data-target="#modalAccionCuadrilla"
            data-id="{{ $c->iid_cuadrilla }}"
            data-nombre="{{ $c->cnombre_cuadrilla }}"
            data-estatus="1"
            title="Borrar">
            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16">
        </button>

        @else

        <button class="btn"
            data-toggle="modal"
            data-target="#modalAccionCuadrilla"
            data-id="{{ $c->iid_cuadrilla }}"
            data-nombre="{{ $c->cnombre_cuadrilla }}"
            data-estatus="0"
            title="Recuperar">
            <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="16">
        </button>

        @endif

    </td>
</tr>
@endforeach
</tbody>
</table>
</div>

{{-- ================= MODAL NUEVA ================= --}}
<div class="modal fade" id="modalNuevaCuadrilla">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">

<form method="POST" action="{{ url('/cuadrillas/guardar') }}">
@csrf

<div class="modal-header bg-light">
    <h5 class="modal-title">Nueva Cuadrilla</h5>
    <button class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <label><b>Nombre:</b></label>
    <input type="text" name="nombre_cuadrilla" class="form-control" required>
</div>

<div class="modal-footer justify-content-center">
    <button class="btn btn-primary">Guardar</button>
    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
</div>

</form>
</div>
</div>
</div>

{{-- ================= MODAL EDITAR ================= --}}
<div class="modal fade" id="modalEditarCuadrilla">
<div class="modal-dialog modal-dialog-centered modal-lg">
<div class="modal-content">

<form method="POST" action="{{ url('/cuadrillas/actualizar') }}">
@csrf
<input type="hidden" name="id_cuadrilla" id="edit_id_cuadrilla">
<input type="hidden" name="noeditar" value="">

<div class="modal-header bg-light">
    <h5 class="modal-title">Editar Cuadrilla</h5>
    <button class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body">
    <label><b>Nombre:</b></label>
    <input type="text" name="nombre_cuadrilla" id="edit_nombre_cuadrilla" class="form-control" required>
</div>

<div class="modal-footer justify-content-center">
    <button class="btn btn-primary">Guardar</button>
    <button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
</div>

</form>
</div>
</div>
</div>

{{-- ================= MODAL ACCIÓN ================= --}}
<div class="modal fade" id="modalAccionCuadrilla">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">

<div class="modal-header bg-light">
    <h5 class="modal-title" id="tituloAccionCuadrilla"></h5>
    <button class="close" data-dismiss="modal">&times;</button>
</div>

<div class="modal-body text-center">
    <p id="textoAccionCuadrilla"></p>
    <strong id="nombreAccionCuadrilla"></strong>
</div>

<div class="modal-footer justify-content-center">

<form method="POST" action="{{ url('/cuadrillas/actualizar') }}">
@csrf
<input type="hidden" name="id_cuadrilla" id="accion_id_cuadrilla">
<input type="hidden" name="noeditar" value="disabled">

<button class="btn btn-primary" id="btnAccionCuadrilla"></button>
</form>

<button class="btn btn-secondary" data-dismiss="modal">Cancelar</button>

</div>
</div>
</div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script>
$('#modalEditarCuadrilla').on('show.bs.modal', function(e){
    let b = $(e.relatedTarget);
    $('#edit_id_cuadrilla').val(b.data('id'));
    $('#edit_nombre_cuadrilla').val(b.data('nombre'));
});

$('#modalAccionCuadrilla').on('show.bs.modal', function(e){
    let b = $(e.relatedTarget);
    let id = b.data('id');
    let nombre = b.data('nombre');
    let est = b.data('estatus');

    $('#accion_id_cuadrilla').val(id);
    $('#nombreAccionCuadrilla').text(nombre);

    if(est == 1){
        $('#tituloAccionCuadrilla').text('Inhabilitar Cuadrilla');
        $('#textoAccionCuadrilla').text('¿Deseas inhabilitar esta cuadrilla?');
        $('#btnAccionCuadrilla').text('Sí, inhabilitar');
    }else{
        $('#tituloAccionCuadrilla').text('Recuperar Cuadrilla');
        $('#textoAccionCuadrilla').text('¿Deseas recuperar esta cuadrilla?');
        $('#btnAccionCuadrilla').text('Sí, recuperar');
    }
});
</script>

@endsection

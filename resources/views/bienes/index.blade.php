@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box.svg') }}" width="18">
    Listado de Bienes
</h3>
@endsection

@section('panel')
<div class="table-responsive">

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert">&times;</button>
</div>
@endif

<div class="row mb-2">
    <div class="col text-md-right">
        <a href="#" data-toggle="modal" data-target="#modalNuevoBien">+ Nuevo Bien</a>
    </div>
</div>

<table class="table table-striped shadow-lg">
<thead>
<tr>
    <th>ID</th>
    <th>Código</th>
    <th>Nombre</th>
    <th>Unidad</th>
    <th>Categoría</th>
    <th>Stok Min</th>
    <th>Stok Max</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
@foreach($bienes as $b)
<tr>
    <td>{{ $b->id_bien }}</td>
    <td>{{ $b->codigo }}</td>
    <td>{{ $b->nombre }}</td>
    <td>{{ $b->unidad_nombre }}</td>
    <td>{{ $b->categoria_nombre }}</td>
    <td>{{ $b->stok_min }}</td>
    <td>{{ $b->stok_max }}</td>
    <td>
        <button class="btn"
            data-toggle="modal"
            data-target="#modalEditarBien"
            data-id="{{ $b->id_bien }}"
            data-codigo="{{ $b->codigo }}"
            data-nombre="{{ $b->nombre }}"
            data-unidad="{{ $b->id_unidad }}"
            data-categoria="{{ $b->id_categoria }}"
            data-stokmin="{{ $b->stok_min }}"
            data-stokmax="{{ $b->stok_max }}">
            ✏️
        </button>

        <button class="btn"
            data-toggle="modal"
            data-target="#modalEliminarBien"
            data-id="{{ $b->id_bien }}"
            data-nombre="{{ $b->nombre }}">
            🗑️
        </button>
    </td>
</tr>
@endforeach
</tbody>
</table>

{{ $bienes->links('pagination::bootstrap-4') }}

</div>

{{-- MODAL NUEVO --}}
<div class="modal fade" id="modalNuevoBien">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<form method="POST" action="{{ route('bienes.guardar') }}">
@csrf
<div class="modal-header"><h5>Nuevo Bien</h5></div>
<div class="modal-body">
<input name="codigo" class="form-control mb-2" placeholder="Código" required>
<input name="nombre" class="form-control mb-2" placeholder="Nombre" required>

<select name="id_unidad" class="form-control mb-2" required>
<option value="">Unidad</option>
@foreach($unidades as $u)
<option value="{{ $u->id_unidad }}">{{ $u->nombre }}</option>
@endforeach
</select>

<select name="id_categoria" class="form-control mb-2" required>
<option value="">Categoría</option>
@foreach($categorias as $c)
<option value="{{ $c->id_categoria }}">{{ $c->nombre }}</option>
@endforeach
</select>

<input type="number" name="stok_min" class="form-control mb-2" placeholder="Stok Min">
<input type="number" name="stok_max" class="form-control mb-2" placeholder="Stok Max">
</div>
<div class="modal-footer">
<button class="btn btn-primary">Guardar</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
</div>
</form>
</div>
</div>
</div>

{{-- MODAL EDITAR --}}
<div class="modal fade" id="modalEditarBien">
<div class="modal-dialog modal-lg modal-dialog-centered">
<div class="modal-content">
<form method="POST" action="{{ route('bienes.actualizar') }}">
@csrf
<input type="hidden" name="id_bien" id="e_id">
<div class="modal-body">
<input id="e_codigo" name="codigo" class="form-control mb-2">
<input id="e_nombre" name="nombre" class="form-control mb-2">
<select id="e_unidad" name="id_unidad" class="form-control mb-2">
@foreach($unidades as $u)
<option value="{{ $u->id_unidad }}">{{ $u->nombre }}</option>
@endforeach
</select>
<select id="e_categoria" name="id_categoria" class="form-control mb-2">
@foreach($categorias as $c)
<option value="{{ $c->id_categoria }}">{{ $c->nombre }}</option>
@endforeach
</select>
<input id="e_stokmin" name="stok_min" class="form-control mb-2">
<input id="e_stokmax" name="stok_max" class="form-control mb-2">
</div>
<div class="modal-footer">
<button class="btn btn-primary">Guardar</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
</div>
</form>
</div>
</div>
</div>

{{-- MODAL ELIMINAR --}}
<div class="modal fade" id="modalEliminarBien">
<div class="modal-dialog modal-dialog-centered">
<div class="modal-content">
<form method="POST" id="formEliminar">
@csrf @method('DELETE')
<div class="modal-body text-center">
<p>¿Eliminar <strong id="nombreEliminar"></strong>?</p>
</div>
<div class="modal-footer">
<button class="btn btn-danger">Eliminar</button>
<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
</div>
</form>
</div>
</div>
</div>

<script>
$('#modalEditarBien').on('show.bs.modal', e=>{
let b=$(e.relatedTarget);
$('#e_id').val(b.data('id'));
$('#e_codigo').val(b.data('codigo'));
$('#e_nombre').val(b.data('nombre'));
$('#e_unidad').val(b.data('unidad'));
$('#e_categoria').val(b.data('categoria'));
$('#e_stokmin').val(b.data('stokmin'));
$('#e_stokmax').val(b.data('stokmax'));
});

$('#modalEliminarBien').on('show.bs.modal', e=>{
let b=$(e.relatedTarget);
$('#nombreEliminar').text(b.data('nombre'));
$('#formEliminar').attr('action','/bienes/'+b.data('id'));
});
</script>

@endsection

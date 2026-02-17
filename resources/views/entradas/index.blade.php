@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-in-down.svg') }}" width="18" height="18">
    Listado de Entradas
</h3>
@endsection

@section('panel')
<div class="table-responsive">

    {{-- Mensaje éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Mensaje danger --}}
    @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    {{-- Errores --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>Corrige los errores para continuar</p>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    <!-- Nueva Entrada (MODAL) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#"
               data-toggle="modal"
               data-target="#modalNuevaEntrada"
               data-toggle="tooltip"
               data-html="true"
               title="Nueva Entrada">
                + Nueva Entrada
            </a>
        </div>
    </div>

    <!-- Tabla -->
    <table class="table table-striped shadow-lg" id="MyTableEntradas">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Proveedor</th>
                <th class="text-center">Folio</th>
                <th class="text-center">Tipo</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Total</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($entradas as $ent)
                @php
                    $proveedorNombre = $ent->proveedor_nombre ?? '';
                    $total = $ent->total_cantidad ?? 0;
                @endphp

                <tr>
                    <td class="text-center">{{ $ent->id_entrada }}</td>
                    <td class="text-center">{{ $proveedorNombre }}</td>
                    <td class="text-center">{{ $ent->folio }}</td>
                    <td class="text-center">{{ $ent->tipo }}</td>
                    <td class="text-center">{{ $ent->fecha }}</td>
                    <td class="text-center">{{ $total }}</td>

    <td class="text-center col-actions">

        <!-- EDITAR -->
        <button class="btn"
            data-toggle="modal"
            data-target="#editarModal"
            data-id="{{ $ent->id_entrada }}"
            data-proveedor="{{ $ent->proveedor->nombre ?? '' }}"
            data-folio="{{ $ent->folio }}"
            data-cantidad="{{ $ent->cantidad }}"
            data-fecha="{{ $ent->fecha_entrada }}"
        >
            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18">
        </button>

        <!-- ELIMINAR -->
        <button class="btn"
            data-toggle="modal"
            data-target="#confirmarEliminarModal"
            data-id="{{ $ent->id_entrada }}"
            data-proveedor="{{ $ent->proveedor->nombre ?? '' }}"
        >
            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16">
        </button>

    </td>
</tr>
@endforeach
</tbody>

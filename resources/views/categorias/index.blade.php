@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18">
        Listado de Categorías
    </h4>
@endsection

@section('panel')
<div class="table-responsive">
    <form method="GET" action="{{ url('/categorias') }}" id="formIndexCategorias">
        @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>Corrige los errores para continuar</p>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="row">
            <div class="col-6" id="divnombre_categoria">
                <label for="nombre" class="col-form-label text-md-right">Nombre Categoría:</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                    value="{{ old('nombre', null) }}" />
            </div>
        </div>
        <br>
        <div class="form-group form-row text-center">
            <div class="col-12">
                <button type="submit" class="btn btn-primary">
                    <img src="{{ asset('bootstrap-icons-1.5.0/search.svg') }}" width="18" height="18">
                    <span>&nbsp;Buscar</span>
                </button>
            </div>
        </div>
    </form>

    <div class="row mb-2">
        <div class="col text-right">
            <a href="{{ url('/categorias/nueva') }}" class="btn btn-success">
                <img src="{{ asset('bootstrap-icons-1.5.0/folder-plus.svg') }}" width="18" height="18">
                <span>&nbsp;Nueva Categoría</span>
            </a>
        </div>
    </div>

    <table class="table table-striped shadow-lg" id="MyTableCategorias">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categorias as $categoria)
            <tr>
                <td class="text-center">{{ $categoria->id_categoria }}</td>
                <td class="text-center">{{ $categoria->nombre }}</td>
                <td class="text-center">{{ $categoria->descripcion }}</td>
                <td class="text-center col-actions">
                    @if ($categoria->iestatus == 1)
                        <a href="{{ url('categorias/editar/'.$categoria->id_categoria) }}" title="Editar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </a>
                        <a href="{{ url('categorias/inhabilitar/'.$categoria->id_categoria) }}" title="Inhabilitar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                        </a>
                    @else
                        <a href="{{ url('categorias/inhabilitar/'.$categoria->id_categoria) }}" title="Recuperar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                        </a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

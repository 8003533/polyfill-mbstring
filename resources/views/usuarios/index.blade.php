@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary text-center">
        <img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18">
        Listado de Usuarios
    </h4>
@endsection

@section('panel')
<div class="table-responsive">
    <form method="GET" action="{{ url('/usuarios') }}" id="formIndexUsuarios">
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
            <div class="col-6" id="divnombre_usuario">
                <label for="nombre" class="col-form-label text-md-right">Nombre de Usuario:</label>
                <input type="text" id="nombre" name="nombre" class="form-control"
                    value="{{ old('nombre', null) }}" />
            </div>
            <div class="col-6" id="divpersonal_usuario">
                <label for="id_personal" class="col-form-label text-md-right">Personal:</label>
                <select id="id_personal" name="id_personal" class="form-control">
                    <option value="">-- Todos --</option>
                    @foreach ($personal as $p)
                    <option value="{{ $p->id_personal }}"
                        @if (old('id_personal') == $p->id_personal) selected @endif>
                        {{ $p->nombre }}
                    </option>
                    @endforeach
                </select>
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
            <a href="{{ url('/usuarios/nueva') }}" class="btn btn-success">
                <img src="{{ asset('bootstrap-icons-1.5.0/folder-plus.svg') }}" width="18" height="18">
                <span>&nbsp;Nuevo Usuario</span>
            </a>
        </div>
    </div>

    <table class="table table-striped shadow-lg" id="MyTableUsuarios">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nombre Usuario</th>
                <th class="text-center">Personal</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
            <tr>
                <td class="text-center">{{ $usuario->id_usuario }}</td>
                <td class="text-center">{{ $usuario->nombre }}</td>
                <td class="text-center">{{ optional($usuario->personal)->nombre }}</td>
                <td class="text-center col-actions">
                    @if ($usuario->iestatus == 1)
                        <a href="{{ url('usuarios/editar/'.$usuario->id_usuario) }}" title="Editar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </a>
                        <a href="{{ url('usuarios/inhabilitar/'.$usuario->id_usuario) }}" title="Inhabilitar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                        </a>
                    @else
                        <a href="{{ url('usuarios/inhabilitar/'.$usuario->id_usuario) }}" title="Recuperar">
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

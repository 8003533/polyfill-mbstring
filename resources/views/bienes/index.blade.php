@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box.svg') }}" width="18" height="18">
    Listado de Bienes
</h3>
@endsection

@section('panel')
<div class="table-responsive">



    <!-- nueva area -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="{{ route('bienes.nuevo') }}" data-toggel="tooltip" data-html="true" tittel="Nueva Bien">
              + Nuevo Bien </a>
        </div>
    </div>

    <!-- TABLA -->
    <table class="table table-striped shadow-lg" id="MyTableBienes">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Código</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Unidad</th>
                <th class="text-center">Categoría</th>
                <th class="text-center">Stock Min</th>
                <th class="text-center">Stock Max</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($bienes as $bien)
                <tr>
                    <td class="text-center">{{ $bien->id_bien }}</td>
                    <td class="text-center">{{ $bien->codigo }}</td>
                    <td class="text-center">{{ $bien->nombre }}</td>
                    <td class="text-center">{{ $bien->unidad->nombre ?? '-' }}</td>
                    <td class="text-center">{{ $bien->categoria->nombre ?? '-' }}</td>
                    <td class="text-center">{{ $bien->stock_minimo }}</td>
                    <td class="text-center">{{ $bien->stock_maximo }}</td>

                    <td class="text-center col-actions">
                        <!-- Botón Editar -->
                        <a href="{{ route('bienes.editar', $bien->id_bien) }}" class="btn">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </a>

                        <!-- Botón Eliminar -->
                        <form method="POST" action="{{ route('bienes.inhabilitar', $bien->id_bien) }}" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


@endsection

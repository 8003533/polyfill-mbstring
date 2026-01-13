@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box.svg') }}" width="18" height="18">
    Listado de Bienes
</h3>
@endsection

@section('panel')
<div class="table-responsive">

    <!-- NUEVO BIEN -->
    <div class="row mb-2">
        <div class="col col-form-label text-md-right">
            <a href="{{ route('bienes.nuevo') }}"
               data-toggle="tooltip"
               title="Nuevo Bien">
                + Nuevo Bien
            </a>
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
        @if(isset($bienes) && $bienes->count())
            @foreach($bienes as $bien)
                <tr>
                    <td class="text-center">{{ $bien->id_bien }}</td>
                    <td class="text-center">{{ $bien->codigo }}</td>
                    <td class="text-center">{{ $bien->nombre }}</td>
                    <td class="text-center">{{ $bien->unidad->nombre ?? '-' }}</td>
                    <td class="text-center">{{ $bien->categoria->nombre ?? '-' }}</td>
                    <td class="text-center">{{ $bien->stock_min }}</td>
                    <td class="text-center">{{ $bien->stock_max }}</td>

                    <td class="text-center col-actions">

                        <!-- EDITAR -->
                        <a href="{{ route('bienes.editar', $bien->id_bien) }}"
                           class="btn"
                           data-toggle="tooltip"
                           title="Editar">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}"
                                 width="18" height="18">
                        </a>

                        <!-- ELIMINAR -->
                        <form method="POST"
                              action="{{ route('bienes.eliminar', $bien->id_bien) }}"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="btn"
                                    data-toggle="tooltip"
                                    title="Eliminar"
                                    onclick="return confirm('¿Deseas eliminar este bien?')">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}"
                                     width="16" height="16">
                            </button>
                        </form>

                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="8" class="text-center text-muted">
                    No hay bienes registrados
                </td>
            </tr>
        @endif
        </tbody>
    </table>

    <!-- PAGINACIÓN -->
    @if(isset($bienes))
        <div class="mt-3 d-flex justify-content-end">
            {{ $bienes->links('pagination::bootstrap-4') }}
        </div>
    @endif

</div>
@endsection

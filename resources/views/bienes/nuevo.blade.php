@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box.svg') }}" width="18" height="18">
    Listado de Bienes
</h3>
@endsection

@section('panel')
<div class="table-responsive">

    <!-- BUSCADOR -->
    <form method="GET" action="{{ url('/bienes/index') }}" id="formIndexBienes">
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <p>Corrige los errores para continuar</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <div class="row">
            <div class="col-6">
                <label for="buscar" class="col-form-label text-md-right">Buscar Bien:</label>
                <input type="text" id="buscar" name="buscar" class="form-control"
                       value="{{ request('buscar') }}">
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

    <!-- Crear un Bien -->
    <div class="row mb-2">
        <div class="col col-form-label text-md-right">
            <a href="{{ url('bienes/nuevo') }}" data-toggle="tooltip" title="Nuevo Bien">
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
                        <a href="{{ url('bienes/editar/' . $bien->id_bien) }}" class="btn">
                            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                        </a>

                        <!-- Botón Eliminar -->
                        <button class="btn"
                            data-toggle="modal"
                            data-target="#confirmarEliminarModal"
                            data-id="{{ $bien->id_bien }}"
                            data-nombre="{{ $bien->nombre }}">
                            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                        </button>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div>
            Mostrando registros del {{ $bienes->firstItem() }} al {{ $bienes->lastItem() }}
            de un total de {{ $bienes->total() }} registros
        </div>

        <div>
            {{ $bienes->appends(['buscar' => request('buscar')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<!-- MODAL ELIMINAR -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-light">
        <h5 class="modal-title">Eliminar Bien</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>

      <div class="modal-body text-center">
        <p>¿Deseas eliminar el bien <strong id="nombreEliminar"></strong>?</p>
      </div>

      <div class="modal-footer justify-content-center">
        <form id="formEliminar" method="POST" action="">
          @csrf
          @method('DELETE')

          <button type="submit" class="btn btn-primary">
            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
            Sí, eliminar
          </button>
        </form>

        <button type="button" class="btn btn-primary" data-dismiss="modal">
            <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18" height="18"> Cancelar
        </button>
      </div>

    </div>
  </div>
</div>

<!-- SCRIPTS -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Modal Eliminar
    $('#confirmarEliminarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        $('#nombreEliminar').text(button.data('nombre'));
        $('#formEliminar').attr('action', '/bienes/' + button.data('id'));
    });

});
</script>

@endsection

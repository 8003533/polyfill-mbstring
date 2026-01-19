@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-in-down.svg') }}" width="18" height="18">
    Listado de Entradas
</h3>
@endsection

@section('panel')
<div class="table-responsive">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Nueva Entrada -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="{{ route('entradas.nuevo') }}" data-toggle="tooltip" title="Nueva Entrada">
                + Nueva Entrada
            </a>
        </div>
    </div>

    <!-- TABLA -->
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
            <tr>
                <td class="text-center">{{ $ent->id_entrada }}</td>
                <td class="text-center">{{ $ent->proveedor->nombre ?? '' }}</td>
                <td class="text-center">{{ $ent->folio }}</td>
                <td class="text-center">{{ $ent->tipo }}</td>
                <td class="text-center">{{ $ent->fecha }}</td>
                <td class="text-center">{{ $ent->total_cantidad ?? 0 }}</td>

                <td class="text-center col-actions">

                    <!-- EDITAR -->
                    <button class="btn"
                        data-toggle="modal"
                        data-target="#editarModal"
                        data-id="{{ $ent->id_entrada }}"
                        data-idproveedor="{{ $ent->id_proveedor }}"
                        data-folio="{{ $ent->folio }}"
                        data-tipo="{{ $ent->tipo }}"
                        data-fecha="{{ $ent->fecha }}"
                    >
                        <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                    </button>

                    <!-- ELIMINAR -->
                    <button class="btn"
                        data-toggle="modal"
                        data-target="#confirmarEliminarModal"
                        data-id="{{ $ent->id_entrada }}"
                        data-proveedor="{{ $ent->proveedor->nombre ?? '' }}"
                    >
                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>

    </table>
</div>


<!-- MODAL EDITAR -->
<div class="modal fade" id="editarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Editar Entrada</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('entradas.actualizar') }}">
                    @csrf

                    <input type="hidden" id="id_entrada_edit" name="id_entrada">

                    <div class="form-group">
                        <label>Proveedor:</label>
                        <select id="id_proveedor_edit" name="id_proveedor" class="form-control" required>
                            @foreach($proveedores as $prov)
                                <option value="{{ $prov->id_proveedor }}">{{ $prov->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Folio:</label>
                        <input type="text" id="folio_edit" name="folio" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Tipo:</label>
                        <input type="text" id="tipo_edit" name="tipo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha:</label>
                        <input type="date" id="fecha_edit" name="fecha" class="form-control" required>
                    </div>

                    <div class="row text-center mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18"> Guardar
                            </button>

                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18"> Cancelar
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


<!-- MODAL ELIMINAR -->
<div class="modal fade" id="confirmarEliminarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Eliminar Entrada</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body text-center">
                <p>¿Deseas eliminar la entrada del proveedor <strong id="proveedorEliminar"></strong>?</p>
            </div>

            <div class="modal-footer justify-content-center">
                <form id="formEliminar" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16">
                        Sí, eliminar
                    </button>
                </form>

                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18">
                    Cancelar
                </button>
            </div>

        </div>
    </div>
</div>


<!-- SCRIPTS -->
<script>
document.addEventListener('DOMContentLoaded', function () {

    // EDITAR
    $('#editarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        $('#id_entrada_edit').val(button.data('id'));
        $('#folio_edit').val(button.data('folio'));
        $('#tipo_edit').val(button.data('tipo'));
        $('#fecha_edit').val(button.data('fecha'));
        $('#id_proveedor_edit').val(button.data('idproveedor'));
    });

    // ELIMINAR
    $('#confirmarEliminarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        $('#proveedorEliminar').text(button.data('proveedor'));
        $('#formEliminar').attr('action', '/entradas/' + button.data('id'));
    });

});
</script>

@endsection

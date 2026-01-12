@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-in-down.svg') }}" width="18" height="18">
    Listado de Entradas
</h3>
@endsection

@section('panel')
<div class="table-responsive">



    <!-- Nueva Entrada -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="{{ url('entradas.nuevo') }}" data-toggle="tooltip" title="Nueva Entrada">
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
                <th class="text-center">Bien</th>
                <th class="text-center">Cantidad</th>
                <th class="text-center">Fecha Entrada</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($entradas as $ent)
            <tr>
                <td class="text-center">{{ $ent->id_entrada }}</td>
                <td class="text-center">{{ $ent->proveedor->nombre }}</td>
                <td class="text-center">{{ $ent->bien->descripcion }}</td>
                <td class="text-center">{{ $ent->cantidad }}</td>
                <td class="text-center">{{ $ent->fecha_entrada }}</td>

                <td class="text-center col-actions">

                    <!-- EDITAR -->
                    <button class="btn"
                        data-toggle="modal"
                        data-target="#editarModal"
                        data-id="{{ $ent->id_entrada }}"
                        data-proveedor="{{ $ent->proveedor->nombre }}"
                        data-bien="{{ $ent->bien->descripcion }}"
                        data-cantidad="{{ $ent->cantidad }}"
                        data-fecha="{{ $ent->fecha_entrada }}"
                    >
                        <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}"
                             width="18" height="18">
                    </button>

                    <!-- ELIMINAR -->
                    <button class="btn"
                        data-toggle="modal"
                        data-target="#confirmarEliminarModal"
                        data-id="{{ $ent->id_entrada }}"
                        data-proveedor="{{ $ent->proveedor->nombre }}"
                    >
                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}"
                             width="16" height="16">
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>


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

                    <input type="hidden" id="id_entrada" name="id_entrada">

                    <div class="form-group">
                        <label>Proveedor:</label>
                        <input type="text" id="proveedor_edit" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label>Bien:</label>
                        <input type="text" id="bien_edit" class="form-control" disabled>
                    </div>

                    <div class="form-group">
                        <label>Cantidad:</label>
                        <input type="number" id="cantidad_edit" name="cantidad" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Fecha Entrada:</label>
                        <input type="date" id="fecha_edit" name="fecha_entrada" class="form-control" required>
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
                <p>¿Deseas eliminar la entrada del proveedor <strong id="provEliminar"></strong>?</p>
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

        $('#id_entrada').val(button.data('id'));
        $('#proveedor_edit').val(button.data('proveedor'));
        $('#bien_edit').val(button.data('bien'));
        $('#cantidad_edit').val(button.data('cantidad'));
        $('#fecha_edit').val(button.data('fecha'));
    });

    // ELIMINAR
    $('#confirmarEliminarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        $('#provEliminar').text(button.data('proveedor'));
        $('#formEliminar').attr('action', '/entradas/' + button.data('id'));
    });

});
</script>

@endsection

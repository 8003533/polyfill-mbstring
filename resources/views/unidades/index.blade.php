@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/rulers.svg') }}" width="18" height="18">
    Listado de Unidades
</h3>
@endsection

@section('panel')
<div class="table-responsive">

    {{-- Mensajes --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

    @if(session('danger'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    @endif

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

    <!-- Nueva Unidad (MODAL) -->
    <div class="row">
        <div class="col col-form-label text-md-right">
            <a href="#" data-toggle="modal" data-target="#modalNuevaUnidad" title="Nueva Unidad">
                + Nueva Unidad
            </a>
        </div>
    </div>

    <!-- TABLA UNIDADES -->
    <table class="table table-striped shadow-lg" id="MyTableUnidades">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Nombre</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($unidades as $uni)
            <tr>
                <td class="text-center">{{ $uni->id_unidad }}</td>
                <td class="text-center">{{ $uni->nombre }}</td>
                <td class="text-center">{{ $uni->descripcion }}</td>

                <td class="text-center col-actions">

                    <!-- EDITAR -->
                    <button class="btn"
                        data-toggle="modal"
                        data-target="#editarModal"
                        data-id="{{ $uni->id_unidad }}"
                        data-nombre="{{ $uni->nombre }}"
                        data-descripcion="{{ $uni->descripcion }}"
                        title="Editar">
                        <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}"
                             width="18" height="18">
                    </button>

                    <!-- ELIMINAR -->
                    <button class="btn"
                        data-toggle="modal"
                        data-target="#confirmarEliminarModal"
                        data-id="{{ $uni->id_unidad }}"
                        data-nombre="{{ $uni->nombre }}"
                        title="Eliminar">
                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}"
                             width="16" height="16">
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Paginación --}}
    <div class="mt-3 d-flex justify-content-end">
        {{ $unidades->appends(['nombre' => request('nombre')])->links('pagination::bootstrap-4') }}
    </div>

</div>


<!-- MODAL NUEVA UNIDAD -->
<div class="modal fade" id="modalNuevaUnidad" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Nueva Unidad</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('unidades.guardar') }}">
                    @csrf

                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="row text-center mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18">
                                Guardar
                            </button>

                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18">
                                Cancelar
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


<!-- MODAL EDITAR -->
<div class="modal fade" id="editarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Editar Unidad</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('unidades.actualizar') }}">
                    @csrf

                    <input type="hidden" id="id_unidad" name="id_unidad">

                    <div class="form-group">
                        <label>Nombre:</label>
                        <input type="text" id="nombre_edit" name="nombre" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Descripción:</label>
                        <textarea id="descripcion_edit" name="descripcion" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="row text-center mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18">
                                Guardar
                            </button>

                            <button type="button" class="btn btn-primary" data-dismiss="modal">
                                <img src="{{ asset('bootstrap-icons-1.5.0/x-lg.svg') }}" width="18">
                                Cancelar
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
                <h5 class="modal-title">Eliminar Unidad</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body text-center">
                <p>¿Deseas eliminar la unidad <strong id="unidadEliminar"></strong>?</p>
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

        $('#id_unidad').val(button.data('id'));
        $('#nombre_edit').val(button.data('nombre'));
        $('#descripcion_edit').val(button.data('descripcion'));
    });

    // ELIMINAR
    $('#confirmarEliminarModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);

        $('#unidadEliminar').text(button.data('nombre'));
        $('#formEliminar').attr('action', "{{ url('unidades') }}/" + button.data('id'));
    });

});
</script>

@endsection

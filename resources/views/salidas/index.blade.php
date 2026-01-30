@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-up.svg') }}" width="18" height="18">
    Listado de Salidas
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

    {{-- Nueva Salida (modal) --}}
    <div class="row mb-2">
        <div class="col col-form-label text-md-right">
            <a href="#" data-toggle="modal" data-target="#modalNuevaSalida" title="Nueva Salida">
                + Nueva Salida
            </a>
        </div>
    </div>

    {{-- TABLA --}}
    <table class="table table-striped shadow-lg" id="MyTableSalidas">
        <thead>
            <tr>
                <th class="text-center">ID</th>
                <th class="text-center">Folio</th>
                <th class="text-center">Motivo</th>
                <th class="text-center">Fecha</th>
                <th class="text-center">Bien</th>
                <th class="text-center">Disponible</th>
                <th class="text-center">Utilizada</th>
                <th class="text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @if(isset($salidas) && $salidas->count())
                @foreach($salidas as $sal)
                    @php
                        // DER: tasalidas 1:N detalle_salida
                        $det = $sal->detalles->first();

                        $idDetalle = $det->id_detalle_salida ?? '';
                        $idBien    = $det->id_bien ?? '';

                        $bienCodigo = $det->bien->codigo ?? '';
                        $bienNombre = $det->bien->nombre ?? '';
                        $bienTexto  = trim($bienCodigo . ' - ' . $bienNombre, ' -');

                        $disp = $det->cantidad_disponible ?? '';
                        $util = $det->cantidad_utilizada ?? '';
                    @endphp

                    <tr>
                        <td class="text-center">{{ $sal->id_salida }}</td>
                        <td class="text-center">{{ $sal->folio }}</td>
                        <td class="text-center">{{ $sal->motivo }}</td>
                        <td class="text-center">{{ $sal->fecha }}</td>
                        <td class="text-center">{{ $bienTexto }}</td>
                        <td class="text-center">{{ $disp }}</td>
                        <td class="text-center">{{ $util }}</td>

                        <td class="text-center col-actions">

                            {{-- EDITAR (modal) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#modalEditarSalida"
                                data-id="{{ $sal->id_salida }}"
                                data-iddetalle="{{ $idDetalle }}"
                                data-folio="{{ $sal->folio }}"
                                data-motivo="{{ $sal->motivo }}"
                                data-fecha="{{ $sal->fecha }}"
                                data-idbien="{{ $idBien }}"
                                data-utilizada="{{ $util }}"
                                title="Editar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </button>

                            {{-- ELIMINAR (modal) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#modalEliminarSalida"
                                data-id="{{ $sal->id_salida }}"
                                data-folio="{{ $sal->folio }}"
                                title="Eliminar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                            </button>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="8" class="text-center text-muted">No hay salidas registradas</td>
                </tr>
            @endif
        </tbody>
    </table>

    {{-- Paginación --}}
    @if(isset($salidas))
        <div class="mt-2">
            {{ $salidas->links() }}
        </div>
    @endif
</div>


{{-- ================= MODAL: NUEVA SALIDA ================= --}}
<div class="modal fade" id="modalNuevaSalida" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Nueva Salida</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('salidas.guardar') }}">
                    @csrf

                    <div class="form-group">
                        <label><b>Fecha:</b></label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><b>Folio:</b></label>
                        <input type="text" name="folio" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><b>Motivo:</b></label>
                        <input type="text" name="motivo" class="form-control">
                    </div>

                    <hr>

                    <div class="form-group">
                        <label><b>Bien:</b></label>
                        <select name="id_bien" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($bienes as $b)
                                <option value="{{ $b->id_bien }}">
                                    {{ $b->codigo }} - {{ $b->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><b>Cantidad utilizada:</b></label>
                        <input type="number" name="cantidad_utilizada" class="form-control" step="0.01" min="0.01" required>
                    </div>

                    <div class="row text-center mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18"> Guardar
                            </button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


{{-- ================= MODAL: EDITAR SALIDA ================= --}}
<div class="modal fade" id="modalEditarSalida" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Editar Salida</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ route('salidas.actualizar') }}">
                    @csrf

                    <input type="hidden" id="edit_id_salida" name="id_salida">
                    <input type="hidden" id="edit_id_detalle_salida" name="id_detalle_salida">

                    <div class="form-group">
                        <label><b>Fecha:</b></label>
                        <input type="date" id="edit_fecha" name="fecha" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><b>Folio:</b></label>
                        <input type="text" id="edit_folio" name="folio" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><b>Motivo:</b></label>
                        <input type="text" id="edit_motivo" name="motivo" class="form-control">
                    </div>

                    <hr>

                    <div class="form-group">
                        <label><b>Bien:</b></label>
                        <select id="edit_id_bien" name="id_bien" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($bienes as $b)
                                <option value="{{ $b->id_bien }}">
                                    {{ $b->codigo }} - {{ $b->nombre }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><b>Cantidad utilizada:</b></label>
                        <input type="number" id="edit_utilizada" name="cantidad_utilizada" class="form-control" step="0.01" min="0.01" required>
                    </div>

                    <div class="row text-center mt-3">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <img src="{{ asset('bootstrap-icons-1.5.0/save.svg') }}" width="18"> Guardar
                            </button>

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Cancelar
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>


{{-- ================= MODAL: ELIMINAR SALIDA ================= --}}
<div class="modal fade" id="modalEliminarSalida" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Eliminar Salida</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body text-center">
                <p>¿Deseas eliminar la salida con folio <strong id="folioEliminar"></strong>?</p>
            </div>

            <div class="modal-footer justify-content-center">
                <form id="formEliminarSalida" method="POST" action="">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16">
                        Sí, eliminar
                    </button>
                </form>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Cancelar
                </button>
            </div>

        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    // EDITAR
    $('#modalEditarSalida').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        $('#edit_id_salida').val(b.data('id'));
        $('#edit_id_detalle_salida').val(b.data('iddetalle'));

        $('#edit_folio').val(b.data('folio'));
        $('#edit_motivo').val(b.data('motivo'));
        $('#edit_fecha').val(b.data('fecha'));

        $('#edit_id_bien').val(String(b.data('idbien')));
        $('#edit_utilizada').val(b.data('utilizada'));
    });

    // ELIMINAR
    $('#modalEliminarSalida').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        $('#folioEliminar').text(b.data('folio'));
        $('#formEliminarSalida').attr('action', "{{ url('salidas/eliminar') }}/" + b.data('id'));
    });

});
</script>

@endsection

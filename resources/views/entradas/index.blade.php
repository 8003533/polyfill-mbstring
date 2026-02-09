@extends('layouts.app')

@section('titulo')
<h3 class="text-primary-sin text-center">
    <img src="{{ asset('bootstrap-icons-1.5.0/box-arrow-in-down.svg') }}" width="18" height="18">
    Listado de Entradas
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

    {{-- Nueva Entrada (modal) --}}
    <div class="row mb-2">
        <div class="col col-form-label text-md-right">
            <a href="#" data-toggle="modal" data-target="#modalNuevaEntrada" title="Nueva Entrada">
                + Nueva Entrada
            </a>
        </div>
    </div>

    {{-- TABLA --}}
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
            @if(isset($entradas) && $entradas->count())
                @foreach($entradas as $ent)
                    @php
                        // Compatible con DER por JOIN o por relación Eloquent (si existe)
                        $proveedorNombre = $ent->proveedor_nombre
                            ?? ($ent->proveedor->nombre ?? '');

                        // Total idealmente viene del Controller: SUM(detalle_entrada.cantidad)
                        $total = $ent->total_cantidad
                            ?? ($ent->total ?? ($ent->cantidad_total ?? 0));
                    @endphp

                    <tr>
                        <td class="text-center">{{ $ent->id_entrada }}</td>
                        <td class="text-center">{{ $proveedorNombre }}</td>
                        <td class="text-center">{{ $ent->folio }}</td>
                        <td class="text-center">{{ $ent->tipo }}</td>
                        <td class="text-center">{{ $ent->fecha }}</td>
                        <td class="text-center">{{ $total }}</td>

                        <td class="text-center col-actions">

                            {{-- EDITAR (modal) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#modalEditarEntrada"
                                data-id="{{ $ent->id_entrada }}"
                                data-idproveedor="{{ $ent->id_proveedor }}"
                                data-folio="{{ $ent->folio }}"
                                data-tipo="{{ $ent->tipo }}"
                                data-fecha="{{ \Carbon\Carbon::parse($ent->fecha)->format('Y/m/d') }}"

                                title="Editar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </button>

                            {{-- ELIMINAR (modal) --}}
                            <button class="btn"
                                data-toggle="modal"
                                data-target="#modalEliminarEntrada"
                                data-id="{{ $ent->id_entrada }}"
                                data-proveedor="{{ $proveedorNombre }}"
                                title="Eliminar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16" height="16">
                            </button>

                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="7" class="text-center text-muted">No hay entradas registradas</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>


{{-- ================= MODAL: NUEVA ENTRADA ================= --}}
<div class="modal fade" id="modalNuevaEntrada" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Nueva Entrada</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                {{-- DER: tcentradas (id_proveedor, folio, tipo, fecha) --}}
                {{-- DER: detalle_entrada (id_entrada, id_bien, cantidad) --}}
                <form method="POST" action="{{ url('entradas/crear') }}" id="formNuevaEntrada">
                    @csrf

                    <div class="form-group">
                        <label><b>Proveedor:</b></label>
                        <select name="id_proveedor" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($proveedores as $prov)
                                <option value="{{ $prov->id_proveedor }}">{{ $prov->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><b>Folio:</b></label>
                        <input type="text" name="folio" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><b>Tipo:</b></label>
                        <input type="text" name="tipo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><b>Fecha:</b></label>
                        <input type="date" name="fecha" class="form-control" required>
                    </div>


                    {{-- DETALLE (detalle_entrada) --}}

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
                        <label><b>Cantidad:</b></label>
                        <input type="number" name="cantidad" class="form-control" min="1" required>
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


{{-- ================= MODAL: EDITAR ENTRADA ================= --}}
<div class="modal fade" id="modalEditarEntrada" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Editar Entrada</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body">
                <form method="POST" action="{{ url('entradas/actualizar') }}" id="formEditarEntrada">
                    @csrf
                    <input type="hidden" id="edit_id_entrada" name="id_entrada">

                    <div class="form-group">
                        <label><b>Proveedor:</b></label>
                        <select id="edit_id_proveedor" name="id_proveedor" class="form-control" required>
                            <option value="">Seleccione</option>
                            @foreach($proveedores as $prov)
                                <option value="{{ $prov->id_proveedor }}">{{ $prov->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label><b>Folio:</b></label>
                        <input type="text" id="edit_folio" name="folio" class="form-control">
                    </div>

                    <div class="form-group">
                        <label><b>Tipo:</b></label>
                        <input type="text" id="edit_tipo" name="tipo" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label><b>Fecha:</b></label>
                        <input type="date" id="edit_fecha" name="fecha" class="form-control" required>
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


{{-- ================= MODAL: ELIMINAR ENTRADA ================= --}}
<div class="modal fade" id="modalEliminarEntrada" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header bg-light">
                <h5 class="modal-title">Eliminar Entrada</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>

            <div class="modal-body text-center">
                <p>¿Deseas eliminar la entrada del proveedor?</p>
                <strong id="proveedorEliminar"></strong>
            </div>

            <div class="modal-footer justify-content-center">
                <form id="formEliminarEntrada" method="POST" action="">
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
    $('#modalEditarEntrada').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        $('#edit_id_entrada').val(b.data('id'));
        $('#edit_folio').val(b.data('folio'));
        $('#edit_tipo').val(b.data('tipo'));
        $('#edit_fecha').val(b.data('fecha'));
        $('#edit_id_proveedor').val(String(b.data('idproveedor')));
    });

    // ELIMINAR
    $('#modalEliminarEntrada').on('show.bs.modal', function (event) {
        var b = $(event.relatedTarget);

        $('#proveedorEliminar').text(b.data('proveedor'));

        // DELETE /entradas/{id}
        $('#formEliminarEntrada').attr('action', "{{ url('entradas') }}/" + b.data('id'));
    });

});
</script>

@endsection

<tbody>
@foreach($entradas as $ent)
<tr>
    <td class="text-center">{{ $ent->id_entrada }}</td>
    <td class="text-center">{{ $ent->proveedor->nombre ?? '-' }}</td>
    <td class="text-center">{{ $ent->folio }}</td>
    <td class="text-center">{{ $ent->cantidad }}</td>
    <td class="text-center">{{ $ent->fecha_entrada }}</td>

    <td class="text-center col-actions">

        <!-- EDITAR -->
        <button class="btn"
            data-toggle="modal"
            data-target="#editarModal"
            data-id="{{ $ent->id_entrada }}"
            data-proveedor="{{ $ent->proveedor->nombre ?? '' }}"
            data-folio="{{ $ent->folio }}"
            data-cantidad="{{ $ent->cantidad }}"
            data-fecha="{{ $ent->fecha_entrada }}"
        >
            <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18">
        </button>

        <!-- ELIMINAR -->
        <button class="btn"
            data-toggle="modal"
            data-target="#confirmarEliminarModal"
            data-id="{{ $ent->id_entrada }}"
            data-proveedor="{{ $ent->proveedor->nombre ?? '' }}"
        >
            <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="16">
        </button>

    </td>
</tr>
@endforeach
</tbody>

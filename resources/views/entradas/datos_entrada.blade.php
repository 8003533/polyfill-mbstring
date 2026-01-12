<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <td>{{ $entrada->id_entrada }}</td>
    </tr>
    <tr>
        <th>Proveedor</th>
        <td>{{ $entrada->proveedor->nombre }}</td>
    </tr>
    <tr>
        <th>Fecha</th>
        <td>{{ $entrada->fecha->format('d/m/Y') }}</td>
    </tr>
</table>

<h5>Bienes</h5>
<table class="table">
    <thead>
        <tr>
            <th>Bien</th>
            <th>Cantidad</th>
        </tr>
    </thead>
    <tbody>
        @foreach($entrada->detalles as $det)
        <tr>
            <td>{{ $det->bien->nombre }}</td>
            <td>{{ $det->cantidad }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

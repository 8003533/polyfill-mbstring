<div class="row">
    <div class="col-3" id="divbien_det_salida">
        <label for="id_bien" class="col-form-label text-md-right">Bien:</label>
        <select id="id_bien" name="id_bien" class="form-control" required {{ $noeditar ?? '' }}>
            <option value="">-- Seleccione Bien --</option>
            @foreach ($bienes as $bien)
                <option value="{{ $bien->id_bien }}"
                    @if (old('id_bien', isset($detalle) ? $detalle->id_bien : '') == $bien->id_bien) selected @endif>
                    {{ $bien->codigo }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-3" id="divcantidad_disponible">
        <label for="cantidad_disponible" class="col-form-label text-md-right">Disponible:</label>
        <input type="number" id="cantidad_disponible" name="cantidad_disponible" class="form-control"
            value="{{ old('cantidad_disponible', isset($detalle) ? $detalle->cantidad_disponible : '') }}"
            min="0" required {{ $noeditar ?? '' }}/>
    </div>
    <div class="col-3" id="divcantidad_solicitada">
        <label for="cantidad_solicitada" class="col-form-label text-md-right">Solicitada:</label>
        <input type="number" id="cantidad_solicitada" name="cantidad_solicitada" class="form-control"
            value="{{ old('cantidad_solicitada', isset($detalle) ? $detalle->cantidad_solicitada : '') }}"
            min="0" required {{ $noeditar ?? '' }}/>
    </div>
    <div class="col-3" id="divcantidad_utilizada">
        <label for="cantidad_utilizada" class="col-form-label text-md-right">Utilizada:</label>
        <input type="number" id="cantidad_utilizada" name="cantidad_utilizada" class="form-control"
            value="{{ old('cantidad_utilizada', isset($detalle) ? $detalle->cantidad_utilizada : '') }}"
            min="0" required {{ $noeditar ?? '' }}/>
    </div>
</div>
<br>

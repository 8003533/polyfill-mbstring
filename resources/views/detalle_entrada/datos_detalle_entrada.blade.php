<div class="row">
    <div class="col-4" id="diventrada_detalle">
        <label for="id_entrada" class="col-form-label text-md-right">Entrada:</label>
        <select id="id_entrada" name="id_entrada" class="form-control" required {{ $noeditar ?? '' }}>
            <option value="">-- Seleccione Entrada --</option>
            @foreach ($entradas as $ent)
                <option value="{{ $ent->id_entrada }}"
                    @if (old('id_entrada', isset($detalle) ? $detalle->id_entrada : '') == $ent->id_entrada) selected @endif>
                    {{ $ent->folio }} — {{ $ent->fecha }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-4" id="divbien_detalle">
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
    <div class="col-4" id="divcantidad_detalle">
        <label for="cantidad" class="col-form-label text-md-right">Cantidad:</label>
        <input type="number" id="cantidad" name="cantidad" class="form-control"
            value="{{ old('cantidad', isset($detalle) ? $detalle->cantidad : '') }}"
            min="0" required {{ $noeditar ?? '' }}/>
    </div>
</div>
<br>

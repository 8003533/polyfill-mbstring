<div class="row">
    <div class="col-md-4">
        <label>Fecha</label>
        <input type="date" name="fecha" class="form-control"
            value="{{ old('fecha', $salida->fecha ?? '') }}" required>
    </div>

    <div class="col-md-4">
        <label>Destino</label>
        <input type="text" name="destino" class="form-control"
            value="{{ old('destino', $salida->destino ?? '') }}">
    </div>

    <div class="col-md-4">
        <label>Referencia</label>
        <input type="text" name="referencia" class="form-control"
            value="{{ old('referencia', $salida->referencia ?? '') }}">
    </div>
</div>

<div class="mt-3">
    <label>Observaciones</label>
    <textarea name="observaciones" class="form-control">{{ old('observaciones', $salida->observaciones ?? '') }}</textarea>
</div>

<div class="mb-4">
    <label for="descripcion_administracion" class="form-label">
        Descripción:
    </label>

    <input 
        type="text"
        id="descripcion_administracion"
        name="descripcion_administracion"
        class="form-control"
        maxlength="120"
        required
        value="{{ old('descripcion_administracion', $administracion->cdescripcion_administracion ?? '') }}"
        {{ $noeditar ?? '' }}
    >
</div>

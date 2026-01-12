<div class="row">
    <div class="col-6" id="divnombre_categoria">
        <label for="nombre" class="col-form-label text-md-right">Nombre Categoría:</label>
        <input type="text" id="nombre" name="nombre" class="form-control"
            value="{{ old('nombre', isset($categoria) ? $categoria->nombre : '') }}"
            maxlength="100" required {{ $noeditar ?? '' }}/>
    </div>
    <div class="col-6" id="divdescripcion_categoria">
        <label for="descripcion" class="col-form-label text-md-right">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" class="form-control"
            value="{{ old('descripcion', isset($categoria) ? $categoria->descripcion : '') }}"
            maxlength="255" required {{ $noeditar ?? '' }}/>
    </div>
</div>
<br>

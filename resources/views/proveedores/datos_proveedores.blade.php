<div class="row">
    <div class="col-4" id="divnombre_proveedor">
        <label for="nombre" class="col-form-label text-md-right">Nombre Proveedor:</label>
        <input type="text" id="nombre" name="nombre" class="form-control"
            value="{{ old('nombre', isset($proveedor) ? $proveedor->nombre : '') }}"
            maxlength="150" required {{ $noeditar ?? '' }}/>
    </div>
    <div class="col-4" id="divcontacto_proveedor">
        <label for="contacto" class="col-form-label text-md-right">Contacto:</label>
        <input type="text" id="contacto" name="contacto" class="form-control"
            value="{{ old('contacto', isset($proveedor) ? $proveedor->contacto : '') }}"
            maxlength="150" required {{ $noeditar ?? '' }}/>
    </div>
    <div class="col-4" id="divtelefono_proveedor">
        <label for="telefono" class="col-form-label text-md-right">Teléfono:</label>
        <input type="text" id="telefono" name="telefono" class="form-control"
            value="{{ old('telefono', isset($proveedor) ? $proveedor->telefono : '') }}"
            maxlength="30" required {{ $noeditar ?? '' }}/>
    </div>
</div>
<br>

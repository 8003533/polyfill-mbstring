                <div class="row">
                    <div class="col" id="divnombrepuesto">
                        <label for="descripcion_puesto" class="col-form-label text-md-right">Descripción del Puesto:</label>
                        <input type="text" onkeypress="return textnumber(event);" id="descripcion_puesto" name="descripcion_puesto" class="form-control" data-target="#descripcion_puesto" value="{{ $puesto->cdescripcion_puesto }}" maxlength="200" required {{ $noeditar }}/>
                    </div>
                </div>
                <br>
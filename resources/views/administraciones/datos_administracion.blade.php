                <div class="row">
                    <div class="col-9" id="divdescripcion">
                        <label for="descripcion_administracion" class="col-form-label text-md-right">Descripción:</label>
                        <input type="text" id="descripcion_administracion" name="descripcion_administracion" class="form-control" data-target="#descripcion_administracion" value="{{ $administracion->cdescripcion_administracion }}" maxlength="120" required {{ $noeditar }}/>
                    </div>
                </div>
                <br>
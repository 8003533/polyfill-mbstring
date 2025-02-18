                <div class="row">
                    <div class="col-9" id="divtaller">
                        <label for="descripcion_taller" class="col-form-label text-md-right">Descripción:</label>
                        <input type="text" id="descripcion_taller" name="descripcion_taller" class="form-control" data-target="#descripcion_taller" value="{{ $taller->cdescripcion_taller }}" maxlength="50" required {{ $noeditar }}/>
                    </div>
                </div>
                <br>
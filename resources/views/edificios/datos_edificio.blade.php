                <div class="row">
                    <div class="col-9" id="divdescripcion">
                        <label for="descripcion_destino" class="col-form-label text-md-right">Descripción:</label>
                        <input type="text" id="descripcion_destino" name="descripcion_destino" class="form-control" data-target="#descripcion_destino" value="{{ $destino->cdescripcion_destino }}" maxlength="100" required {{ $noeditar }}/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-6" id="divcalle">
                        <label for="calle_destino" class="col-form-label text-md-right">Calle:</label>
                        <input type="text" id="calle_destino" name="calle_destino" class="form-control" data-target="#calle_destino" value="{{ $destino->ccalle_destino }}" maxlength="100" required {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divnumeroext">
                        <label for="numero_exterior_destino" class="col-form-label text-md-right">Número Exterior:</label>
                        <input type="text" id="numero_exterior_destino" name="numero_exterior_destino" class="form-control" data-target="#numero_exterior_destino" value="{{ $destino->cnumero_exterior_destino }}" maxlength="15" required {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divnumeroint">
                        <label for="numero_interior_destino" class="col-form-label text-md-right">Número Exterior:</label>
                        <input type="text" id="numero_interior_destino" name="numero_interior_destino" class="form-control" data-target="#numero_interior_destino" value="{{ $destino->cnumero_interior_destino }}" maxlength="15" {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divcodpost">
                        <label for="codigo_postal" class="col-form-label text-md-right">Código Postal:</label>
                        <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" min="1" maxlength="5" id="codigo_postal" name="codigo_postal" class="form-control m-bot15" value="{{ $destino->cid_codigo_postal }}" required {{ $noeditar }}>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col" id="divcolonia">
                        <label for="colonia" class="col-form-label text-md-right">Colonia:</label>
                        <select class="form-control m-bot15" id="colonia" name="colonia" required {{ $noeditar }}>
                            <option value="0">Escriba un Código Postal...</option>
                            @if($destino->iid_colonia>0)
                                <option value="{{ $destino->iid_colonia }}" selected>{{ $destino->colonia->cnombre_colonia }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col" id="divalcaldia">
                        <label for="alcaldia" class="col-form-label text-md-right">Alcaldía:</label>
                        <select class="form-control m-bot15" id="alcaldia" name="alcaldia" required {{ $noeditar }}>
                            <option value="0">Escriba un Código Postal...</option>
                            @if($destino->iid_alcaldia>0)
                                <option value="{{ $destino->iid_alcaldia }}" selected>{{ $destino->alcaldia->cnombre_alcaldia }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col" id="diventidad">
                        <label for="entidad" class="col-form-label text-md-right">Entidad:</label>
                        <select class="form-control m-bot15" id="entidad" name="entidad" {{ $noeditar }}>
                            <option value="9">Ciudad de México</option>
                        </select>
                    </div>
                </div>
                <br>
                <center><div id="validaDomicilio"></div></center>
                <br>
                <div class="row">
                    <div class="col-4" id="divlatitud">
                        <label for="latitud" class="col-form-label text-md-right">Latitud:</label>
                        <input type="text" id="latitud" name="latitud" class="form-control" data-target="#latitud" value="{{ $destino->ilatitud }}" onkeypress="return numberonly(event);" maxlength="10" {{ $noeditar }}/>
                    </div>
                    <div class="col-4" id="divlongitud">
                        <label for="longitud" class="col-form-label text-md-right">Longitud:</label>
                        <input type="text" id="longitud" name="longitud" class="form-control" data-target="#longitud" value="{{ $destino->ilongitud }}" onkeypress="return numberonly(event);" maxlength="10" {{ $noeditar }}/>
                    </div>
                </div>
                <br>
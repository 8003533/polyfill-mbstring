                <div class="row">
                    <div class="col-6" id="divdescripcion">
                        <label for="nombre_edificio" class="col-form-label text-md-right">Nombre:</label>
                        <input type="text" id="nombre_edificio" name="nombre_edificio" class="form-control" data-target="#nombre_edificio" value="{{ $edificio->cnombre_edificio }}" maxlength="100" required {{ $noeditar }}/>
                    </div>
                    <div class="col-6" id="divadministracion">
                        <label for="administracion" class="col-form-label text-md-right">Administración:</label>
                        <select class="form-control m-bot15" id="administracion" name="administracion" required {{ $noeditar }}>
                            <option value="">Elija una Administración...</option>
                            @foreach($admins as $indice=>$adm)
                                @if($adm->iid_administracion==$edificio->iid_administracion)
                                    <option value="{{$adm->iid_administracion}}" selected>{{$adm->cdescripcion_administracion}}</option>
                                @else
                                    <option value="{{$adm->iid_administracion}}" >{{$adm->cdescripcion_administracion}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-6" id="divcalle">
                        <label for="calle" class="col-form-label text-md-right">Calle:</label>
                        <input type="text" id="calle" name="calle" class="form-control" data-target="#calle" value="{{ $edificio->ccalle }}" maxlength="100" required {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divnumeroext">
                        <label for="numero_exterior" class="col-form-label text-md-right">Número Exterior:</label>
                        <input type="text" id="numero_exterior" name="numero_exterior" class="form-control" data-target="#numero_exterior" value="{{ $edificio->cnumero_exterior }}" maxlength="15" required {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divnumeroint">
                        <label for="numero_interior" class="col-form-label text-md-right">Número Exterior:</label>
                        <input type="text" id="numero_interior" name="numero_interior" class="form-control" data-target="#numero_interior" value="{{ $edificio->cnumero_interior }}" maxlength="15" {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divcodpost">
                        <label for="codigo_postal" class="col-form-label text-md-right">Código Postal:</label>
                        <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" min="1" maxlength="5" id="codigo_postal" name="codigo_postal" class="form-control m-bot15" value="{{ $edificio->cid_codigo_postal }}" required {{ $noeditar }}>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col" id="divcolonia">
                        <label for="colonia" class="col-form-label text-md-right">Colonia:</label>
                        <select class="form-control m-bot15" id="colonia" name="colonia" required {{ $noeditar }}>
                            <option value="0">Escriba un Código Postal...</option>
                            @if($edificio->iid_colonia>0)
                                <option value="{{ $edificio->iid_colonia }}" selected>{{ $edificio->colonia->cnombre_colonia }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col" id="divalcaldia">
                        <label for="alcaldia" class="col-form-label text-md-right">Alcaldía:</label>
                        <select class="form-control m-bot15" id="alcaldia" name="alcaldia" required {{ $noeditar }}>
                            <option value="0">Escriba un Código Postal...</option>
                            @if($edificio->iid_alcaldia>0)
                                <option value="{{ $edificio->iid_alcaldia }}" selected>{{ $edificio->alcaldia->cnombre_alcaldia }}</option>
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
                        <input type="text" id="latitud" name="latitud" class="form-control" data-target="#latitud" value="{{ $edificio->ilatitud }}" onkeypress="return numberonly(event);" maxlength="10" {{ $noeditar }}/>
                    </div>
                    <div class="col-4" id="divlongitud">
                        <label for="longitud" class="col-form-label text-md-right">Longitud:</label>
                        <input type="text" id="longitud" name="longitud" class="form-control" data-target="#longitud" value="{{ $edificio->ilongitud }}" onkeypress="return numberonly(event);" maxlength="10" {{ $noeditar }}/>
                    </div>
                </div>
                <br>
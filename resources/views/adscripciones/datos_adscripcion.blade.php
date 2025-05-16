                <div class="row">
                    <div class="col" id="divnombreadscripcion">
                        <label for="descripcion_adscripcion" class="col-form-label text-md-right">Descripción de la Adscripcion:</label>
                        <input type="text" id="descripcion_adscripcion" name="descripcion_adscripcion" class="form-control" data-target="#descripcion_adscripcion" value="{{ $adscripcion->cdescripcion_adscripcion }}" maxlength="300" required {{ $noeditar }}/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col" id="divsiglasadscripcion">
                        <label for="siglas" class="col-form-label text-md-right">Siglas de la Adscripcion:</label>
                        <input type="text" onkeypress="return textnumber(event);" id="siglas" name="siglas" class="form-control" data-target="#siglas" value="{{ $adscripcion->csiglas }}" maxlength="20" {{ $noeditar }}/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col" id="divtipodoc">
                        <label for="tipo_adscripcion" class="col-form-label text-md-right">Tipo de Adscripción:</label>
                        <select class="form-control m-bot15" id="tipo_adscripcion" name="tipo_adscripcion" required {{ $noeditar }}>
                            <option value="">Elija un Tipo de Adscripción...</option>
                            @foreach($listTipoArea as $indice=>$tipo_area)
                                @if($tipo_area->iid_tipo_area==$adscripcion->iid_tipo_area)
                                    <option value="{{$tipo_area->iid_tipo_area}}" selected>{{$tipo_area->cdescripcion_tipo_area}}</option>
                                @else
                                    <option value="{{$tipo_area->iid_tipo_area}}">{{$tipo_area->cdescripcion_tipo_area}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
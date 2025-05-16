                <div class="row">
                    <div class="col" id="divnombrepersonal">
                        <label for="nombre_personal" class="col-form-label text-md-right">Nombre:</label>
                        <input type="text" onkeypress="return textonly(event);" id="nombre_personal" name="nombre_personal" class="form-control" data-target="#nombre_personal" value="{{ $personal->cnombre_personal }}" maxlength="50" required {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divpaternopersonal">
                        <label for="paterno_personal" class="col-form-label text-md-right">Apellido Paterno:</label>
                        <input type="text" onkeypress="return textonly(event);" id="paterno_personal" name="paterno_personal" class="form-control" data-target="#paterno_personal" value="{{ $personal->cpaterno_personal }}" maxlength="50" required {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divmaternopersonal">
                        <label for="materno_personal" class="col-form-label text-md-right">Apellido Materno:</label>
                        <input type="text" onkeypress="return textonly(event);" id="materno_personal" name="materno_personal" class="form-control" data-target="#materno_personal" value="{{ $personal->cmaterno_personal }}" maxlength="50" required {{ $noeditar }}/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col" id="divbuscarpuesto">
                        <label for="busca_puesto" class="col-form-label text-md-right">Buscar Puesto:</label>
                        <input type="text" onkeypress="return textnumber(event);" id="busca_puesto" name="busca_puesto" class="form-control" data-target="#busca_puesto" value="" maxlength="200" {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divbuscaradscripcion">
                        <label for="busca_adscripcion" class="col-form-label text-md-right">Buscar Adscripción:</label>
                        <input type="text" onkeypress="return textnumber(event);" id="busca_adscripcion" name="busca_adscripcion" class="form-control" data-target="#busca_adscripcion" value="" maxlength="300" {{ $noeditar }}/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col" id="divpuesto">
                        <label for="puesto" class="col-form-label text-md-right"><b>Puesto:</b></label>
                        <select class="form-control m-bot15" id="puesto" name="puesto" required {{ $noeditar }}>
                            <option value="">Elija un Puesto, Capture un Puesto en Buscar Puesto, o Capture un Nuevo Puesto...</option>
                            @foreach($listPuestos as $indice=>$psto)
                                @if($psto->iid_puesto==$personal->iid_puesto)
                                    <option value="{{$psto->iid_puesto}}" selected>{{$psto->cdescripcion_puesto}}</option>
                                @else
                                    <option value="{{$psto->iid_puesto}}">{{$psto->cdescripcion_puesto}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col" id="divadscripcion">
                        <label for="adscripcion" class="col-form-label text-md-right"><b>Adscripción:</b></label>
                        <select class="form-control m-bot15" id="adscripcion" name="adscripcion" required {{ $noeditar }}>
                            <option value="">Elija una Adscripción, Capture una Adscripción en Buscar Adscripción, o Capture una Nueva Adscripción...</option>
                            @foreach($listAdscrips as $indice=>$adscrip)
                                @if($adscrip->iid_adscripcion==$personal->iid_adscripcion)
                                    <option value="{{$adscrip->iid_adscripcion}}" selected>{{$adscrip->cdescripcion_adscripcion}}</option>
                                @else
                                    <option value="{{$adscrip->iid_adscripcion}}">{{$adscrip->cdescripcion_adscripcion}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col" id="divnuevopuesto">
                        <label for="nuevo_puesto" class="col-form-label text-md-right">Nuevo Puesto:</label>
                        <input type="text" onkeypress="return textnumber(event);" id="nuevo_puesto" name="nuevo_puesto" class="form-control" data-target="#nuevo_puesto" value="" maxlength="200" {{ $noeditar }}/>
                    </div>
                    <div class="col" id="divnuevaadscripcion">
                        <label for="nueva_adscripcion" class="col-form-label text-md-right">Nueva Adscripción:</label>
                        <input type="text" onkeypress="return textnumber(event);" id="nueva_adscripcion" name="nueva_adscripcion" class="form-control" data-target="#nueva_adscripcion" value="" maxlength="300" {{ $noeditar }}/>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-6">
                        <label for="correo_electronico" class="col-form-label text-md-right">Correo electrónico:</label>
                        <input id="correo_electronico" type="email" class="form-control @error('correo_electronico') is-invalid @enderror" name="correo_electronico" value="{{ $personal->ccorreo_electronico }}" required autocomplete="email" autofocus {{ $noeditar }}/>

                        @error('correo_electronico')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <br>
                <center><div id="validaPuestoAdsc"></div></center>
                <br>
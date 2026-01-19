@php
    $empleado = $empleado ?? null;
    $noeditar = $noeditar ?? '';
@endphp

<div class="row">
    <div class="col" id="divnombreempleado">
        <label for="nombre_empleado" class="col-form-label text-md-right">Nombre:</label>
        <input type="text" onkeypress="return textonly(event);" id="nombre_empleado" name="nombre_empleado"
               class="form-control" data-target="#nombre_empleado"
               value="{{ old('nombre_empleado', optional($empleado)->cnombre_empleado_taller) }}"
               maxlength="50" required {{ $noeditar }}/>
    </div>

    <div class="col" id="divpaternoempleado">
        <label for="paterno_empleado" class="col-form-label text-md-right">Apellido Paterno:</label>
        <input type="text" onkeypress="return textonly(event);" id="paterno_empleado" name="paterno_empleado"
               class="form-control" data-target="#paterno_empleado"
               value="{{ old('paterno_empleado', optional($empleado)->cpaterno_empleado_taller) }}"
               maxlength="50" required {{ $noeditar }}/>
    </div>

    <div class="col" id="divmaternoempleado">
        <label for="materno_empleado" class="col-form-label text-md-right">Apellido Materno:</label>
        <input type="text" onkeypress="return textonly(event);" id="materno_empleado" name="materno_empleado"
               class="form-control" data-target="#materno_empleado"
               value="{{ old('materno_empleado', optional($empleado)->cmaterno_empleado_taller) }}"
               maxlength="50" required {{ $noeditar }}/>
    </div>
</div>

<br>

<div class="row">
    <div class="col" id="divbuscarpuesto">
        <label for="busca_puesto" class="col-form-label text-md-right">Buscar Puesto:</label>
        <input type="text" onkeypress="return textnumber(event);" id="busca_puesto" name="busca_puesto"
               class="form-control" data-target="#busca_puesto"
               value="{{ old('busca_puesto') }}"
               maxlength="200" {{ $noeditar }}/>
    </div>

    <div class="col" id="divbuscaradscripcion">
        <label for="busca_adscripcion" class="col-form-label text-md-right">Buscar Adscripción:</label>
        <input type="text" onkeypress="return textnumber(event);" id="busca_adscripcion" name="busca_adscripcion"
               class="form-control" data-target="#busca_adscripcion"
               value="{{ old('busca_adscripcion') }}"
               maxlength="300" {{ $noeditar }}/>
    </div>
</div>

<br>

<div class="row">
    <div class="col" id="divpuesto">
        <label for="puesto" class="col-form-label text-md-right"><b>Puesto:</b></label>
        <select class="form-control m-bot15" id="puesto" name="puesto" required {{ $noeditar }}>
            <option value="">Elija un Puesto, Capture un Puesto en Buscar Puesto, o Capture un Nuevo Puesto...</option>
            @foreach($listPuestos as $psto)
                <option value="{{ $psto->iid_puesto }}"
                    {{ (string)$psto->iid_puesto === (string)old('puesto', optional($empleado)->iid_puesto) ? 'selected' : '' }}>
                    {{ $psto->cdescripcion_puesto }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col" id="divadscripcion">
        <label for="adscripcion" class="col-form-label text-md-right"><b>Adscripción:</b></label>
        <select class="form-control m-bot15" id="adscripcion" name="adscripcion" required {{ $noeditar }}>
            <option value="">Elija una Adscripción, Capture una Adscripción en Buscar Adscripción, o Capture una Nueva Adscripción...</option>
            @foreach($listAdscrips as $adscrip)
                <option value="{{ $adscrip->iid_adscripcion }}"
                    {{ (string)$adscrip->iid_adscripcion === (string)old('adscripcion', optional($empleado)->iid_adscripcion) ? 'selected' : '' }}>
                    {{ $adscrip->cdescripcion_adscripcion }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<br>

<div class="row">
    <div class="col" id="divnuevopuesto">
        <label for="nuevo_puesto" class="col-form-label text-md-right">Nuevo Puesto:</label>
        <input type="text" onkeypress="return textnumber(event);" id="nuevo_puesto" name="nuevo_puesto"
               class="form-control" data-target="#nuevo_puesto"
               value="{{ old('nuevo_puesto') }}"
               maxlength="200" {{ $noeditar }}/>
    </div>

    <div class="col" id="divnuevaadscripcion">
        <label for="nueva_adscripcion" class="col-form-label text-md-right">Nueva Adscripción:</label>
        <input type="text" onkeypress="return textnumber(event);" id="nueva_adscripcion" name="nueva_adscripcion"
               class="form-control" data-target="#nueva_adscripcion"
               value="{{ old('nueva_adscripcion') }}"
               maxlength="300" {{ $noeditar }}/>
    </div>
</div>

<br>

<div class="row">
    <div class="col" id="divtaller">
        <label for="taller" class="col-form-label text-md-right"><b>Taller:</b></label>
        <select class="form-control m-bot15" id="taller" name="taller" required {{ $noeditar }}>
            <option value="">Elija un Taller...</option>
            @foreach($listTalleres as $tllr)
                <option value="{{ $tllr->iid_taller }}"
                    {{ (string)$tllr->iid_taller === (string)old('taller', optional($empleado)->iid_taller) ? 'selected' : '' }}>
                    {{ $tllr->cdescripcion_taller }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col" id="divcuadrilla">
        <label for="cuadrilla" class="col-form-label text-md-right"><b>Cuadrilla:</b></label>
        <select class="form-control m-bot15" id="cuadrilla" name="cuadrilla" required {{ $noeditar }}>
            <option value="">Elija una Cuadrilla...</option>
            @foreach($listCuadrillas as $cdrll)
                <option value="{{ $cdrll->iid_cuadrilla }}"
                    {{ (string)$cdrll->iid_cuadrilla === (string)old('cuadrilla', optional($empleado)->iid_cuadrilla) ? 'selected' : '' }}>
                    {{ $cdrll->cnombre_cuadrilla }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<br>

<div class="row">
    <div class="col-md-6">
        <label for="correo_electronico" class="col-form-label text-md-right">Correo electrónico:</label>
        <input id="correo_electronico" type="email"
               class="form-control @error('correo_electronico') is-invalid @enderror"
               name="correo_electronico"
               value="{{ old('correo_electronico', optional($empleado)->ccorreo_electronico) }}"
               required autocomplete="email" autofocus {{ $noeditar }}/>

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

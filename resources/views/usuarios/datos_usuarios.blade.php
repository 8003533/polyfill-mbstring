<div class="row">
    <div class="col-6" id="divpersonal_usuario">
        <label for="id_personal" class="col-form-label text-md-right">Personal:</label>
        <select id="id_personal" name="id_personal" class="form-control" required {{ $noeditar ?? '' }}>
            <option value="">-- Seleccione Personal --</option>
            @foreach ($personal as $p)
                <option value="{{ $p->id_personal }}"
                    @if (old('id_personal', isset($usuario) ? $usuario->id_personal : '') == $p->id_personal) selected @endif>
                    {{ $p->nombre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-6" id="divnombre_usuario">
        <label for="nombre" class="col-form-label text-md-right">Nombre de Usuario:</label>
        <input type="text" id="nombre" name="nombre" class="form-control"
            value="{{ old('nombre', isset($usuario) ? $usuario->nombre : '') }}"
            maxlength="100" required {{ $noeditar ?? '' }}/>
    </div>
</div>
<br>

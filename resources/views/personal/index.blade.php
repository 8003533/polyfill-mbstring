@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center"><img src="{{ asset('bootstrap-icons-1.5.0/people.svg') }}" width="18" height="18"> Listado de Personal</h4>
@endsection

@section('panel')
    <div class="table-responsive">
        <form method="GET" action="{{ url('/personal/index') }}" id="formIndexPersonal">
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <p>Corrige los errores para continuar</p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-6" id="divpersonal">
                    <label for="nombre" class="col-form-label text-md-right">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" class="form-control" data-target="#nombre" value="{{ old('nombre',null) }}"/>
                </div>
            </div>
            <br>
            <div class="form-group form-row text-center">
                <div class="col-12">                        
                    <button type="submit" class="btn btn-primary">
                        <img src="{{ asset('bootstrap-icons-1.5.0/search.svg') }}" width="18" height="18">
                        <span>&nbsp;Buscar</span>
                    </button>
                </div>
             </div>
        </form>
        <div class="row">
            <div class="col col-form-label text-md-right">
                {{--@altaPersonal--}}
                    <a href="{{ url('personal/nuevo') }}" data-toggle="tooltip" data-html="true" title="Nuevo">
                        + Nuevo Personal
                    </a>
                {{--@endaltaPersonal--}}
            </div>
        </div>
        <table class="table table-striped shadow-lg" id="MyTablePersonal">
          <thead>
            <tr>
                <th class="text-center">Nombre</th>
                <th class="text-center">Paterno</th>
                <th class="text-center">Materno</th>
                <th class="text-center">Puesto</th>
                <th class="text-center">Adscripción</th> 
                <th class="text-center">Correo Electrónico</th> 
                <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($personal as $indice=>$persona)
                <tr>
                    <td class="text-center">{{ $persona->cnombre_personal }}</td>
                    <td class="text-center">{{ $persona->cpaterno_personal }}</td>
                    <td class="text-center">{{ $persona->cmaterno_personal }}</td>
                    <td class="text-center">{{ $persona->cdescripcion_puesto }}</td>
                    <td class="text-center">{{ $persona->cdescripcion_adscripcion }}</td>
                    <td class="text-center">{{ $persona->ccorreo_electronico }}</td>
                    <td class="text-center col-actions">
                    @if ($persona->iestatus == 1)
                        {{--@editaPersonal--}}
                            <a href="{{ url('personal/editar/'.$persona->iid_personal) }}" data-toggle="tooltip" data-html="true" title="Corrección de datos">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </a>
                            <a href="{{ url('personal/actualizar/'.$persona->iid_personal) }}" data-toggle="tooltip" data-html="true" title="Actualizar Puesto y Adscripción">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil.svg') }}" width="18" height="18">
                            </a>
                        {{--@endeditaPersonal
                        @borraPersonal--}}
                            <a href="{{ url('personal/inhabilitar/'.$persona->iid_personal) }}" data-toggle="tooltip" data-html="true" title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraPersonal--}}
                    @else
                        {{--@borraPersonal--}}
                            <a href="{{ url('personal/inhabilitar/'.$persona->iid_personal) }}" data-toggle="tooltip" data-html="true" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraPersonal--}}
                    @endif
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection
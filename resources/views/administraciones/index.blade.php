@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center"><img src="{{ asset('bootstrap-icons-1.5.0/folder-fill.svg') }}" width="18" height="18"> Listado de Administraciones</h4>
@endsection

@section('panel')
    <div class="table-responsive">
        <form method="GET" action="{{ url('/administraciones/index') }}" id="formIndexAdministraciones">
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
                <div class="col-6" id="divadministracion">
                    <label for="administracion" class="col-form-label text-md-right">Administración:</label>
                    <input type="text" id="administracion" name="administracion" class="form-control" data-target="#administracion" value="{{ old('administracion',null) }}"/>
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
                {{--@altaAdministracion--}}
                    <a href="{{ url('administraciones/nueva') }}" data-toggle="tooltip" data-html="true" title="Nueva">
                        + Nueva Administracion
                    </a>
                {{--@endaltaAdministracion--}}
            </div>
        </div>
        <table class="table table-striped shadow-lg" id="MyTableAdministraciones">
          <thead>
            <tr>
                <th class="text-center">Número</th>
                <th class="text-center">Descripción</th>
                <th class="text-center no-export">Acciones</th>

            </tr>
          </thead>
          <tbody>
            @foreach($administraciones as $indice=>$admin)
                <tr>
                    <td class="text-center">{{ $admin['iid_administracion'] }}</td>
                    <td class="text-center">{{ $admin['cdescripcion_administracion'] }}</td>
                    <td class="text-center col-actions">
                    @if ($admin->iestatus == 1)
                        {{--@editaAdministracion--}}
                            <a href="{{ url('administraciones/editar/'.$admin->iid_administracion) }}" data-toggle="tooltip" data-html="true" title="Actualizar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endeditaAdministracion
                        @borraAdministracion--}}
                            <a href="{{ url('administraciones/inhabilitar/'.$admin->iid_administracion) }}" data-toggle="tooltip" data-html="true" title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraAdministracion--}}
                    @else
                        {{--@borraAdministracion--}}
                            <a href="{{ url('administraciones/inhabilitar/'.$admin->iid_administracion) }}" data-toggle="tooltip" data-html="true" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraAdministracion--}}
                    @endif
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection

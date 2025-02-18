@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center"><img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18"> Listado de Talleres</h4>
@endsection

@section('panel')
    <div class="table-responsive">
        <form method="GET" action="{{ url('/talleres/index') }}" id="formIndexTalleres">
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
                <div class="col-6" id="divtaller">
                    <label for="taller" class="col-form-label text-md-right">Taller:</label>
                    <input type="text" id="taller" name="taller" class="form-control" data-target="#taller" value="{{ old('taller',null) }}"/>
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
                {{--@altaTaller--}}
                    <a href="{{ url('talleres/nuevo') }}" data-toggle="tooltip" data-html="true" title="Nuevo">
                        + Nuevo Taller
                    </a>
                {{--@endaltaTaller--}}
            </div>
        </div>
        <table class="table table-striped shadow-lg" id="MyTableTalleres">
          <thead>
            <tr>
                <th class="text-center">Número</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acciones</th>
            </tr>
          </thead>
          <tbody>
            @foreach($talleres as $indice=>$taller)
                <tr>
                    <td class="text-center">{{ $taller['iid_taller'] }}</td>
                    <td class="text-center">{{ $taller['cdescripcion_taller'] }}</td>
                    <td class="text-center col-actions">
                    @if ($taller->iestatus == 1)
                        {{--@editaTaller--}}
                            <a href="{{ url('talleres/editar/'.$taller->iid_taller) }}" data-toggle="tooltip" data-html="true" title="Actualizar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/pencil-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endeditaTaller
                        @borraTaller--}}
                            <a href="{{ url('talleres/inhabilitar/'.$taller->iid_taller) }}" data-toggle="tooltip" data-html="true" title="Borrar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/trash-fill.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraTaller--}}
                    @else
                        {{--@borraTaller--}}
                            <a href="{{ url('talleres/inhabilitar/'.$taller->iid_taller) }}" data-toggle="tooltip" data-html="true" title="Recuperar">
                                <img src="{{ asset('bootstrap-icons-1.5.0/check-lg.svg') }}" width="18" height="18">
                            </a>
                        {{--@endborraTaller--}}
                    @endif
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
    </div>
@endsection
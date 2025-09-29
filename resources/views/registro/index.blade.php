@extends('layouts.app')

@section('titulo')
    <h4 class="text-primary-sin text-center"><img src="{{ asset('bootstrap-icons-1.5.0/wrench-adjustable.svg') }}" width="18" height="18"> Ordenes de Servicio</h4>
@endsection

@section('panel')

    <div class="row">
            
            <div class="row">
                <div class="col-6" id="divorden">
                    <label for="orden" class="col-form-label text-md-right">Orden de servicio:</label>
                    <input type="text" id="orden" name="orden" class="form-control" data-target="#orden" value="{{ old('orden',null) }}"/>
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

            <br>
            {{ csrf_field() }}
            <div class="form-group row justify-content-md-center">
                <a href="#" class="btn btn-success" data-toggle="modal" data-target="#newOrdenModal">
                     <i class="fa fa-user-plus"></i> Nueva orden de pago
                </a>
            </div>
            <br>
    </div>

<!-- Modal -->
<div class="modal fade" id="newOrdenModal" tabindex="-1" role="dialog" aria-labelledby="newOrdenLabel">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <form id="formOrdenServicio">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="newOrdenLabel">Registro de Orden de Servicio</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <!-- Renglon: Folio (no editable) + Solicitud (fecha-hora) -->
          <div class="form-row mb-3">
            <div class="col-md-6">
              <label for="folio">Folio</label>
              <input type="text" class="form-control" id="folio" name="folio" readonly>
            </div>
            <div class="col-md-6">
              <label for="fecha_solicitud">Solicitud (Fecha y Hora)</label>
              <input type="text" class="form-control" id="fecha_solicitud" name="fecha_solicitud" readonly>
            </div>
          </div>

          <!-- Renglon: Conclusión alineado a la derecha -->
          <div class="form-row mb-3 justify-content-end">
            <div class="col-md-6">
              <label for="conclusion">Conclusión</label>
              <input type="text" class="form-control" id="conclusion" name="conclusion" readonly>
            </div>
          </div>

          <!-- Catálogos: Área Solicitante, Solicitante, Taller -->
          <div class="form-row mb-3">
            <div class="col-md-4">
              <label for="area">Área Solicitante</label>
              <select id="area" name="area" class="js-example-basic-multiple" required>
                <option value="">Seleccione área</option>
                    @foreach($administracion as $area)
                <option value="{{ $area->iid_administracion }}">{{ $area->cdescripcion_administracion }}</option>
                    @endforeach
              </select>

            </div>

          <div class="col-md-4">
              <label for="solicitante">Solicitante</label>
              <select id="solicitante" name="solicitante" class="form-control" required>
                <option value="">Seleccione solicitante</option>
                @foreach($personal_solicitante as $sol)
                  <option value="{{ $sol->iid_personal}}">{{ $sol->cnombre_personal }} {{ $sol->cpaterno_personal }}</option>
                @endforeach
              </select>
         </div>

         <div class="col-md-4">
              <label for="taller">Taller</label>
              <select id="taller" name="taller" class="form-control" required>
                <option value="">Seleccione taller</option>
                @foreach($talleres as $taller)
                  <option value="{{ $taller->iid_taller}}">{{ $taller->cdescripcion_taller}}</option>
                @endforeach
              </select>
            </div>
          </div>

          <!-- Descripción del servicio -->
          <div class="form-group">
            <label for="descripcion_servicio">Descripción del servicio</label>
            <textarea id="descripcion_servicio" name="descripcion_servicio" class="form-control" rows="4" required></textarea>
          </div>
        
          <!-- Personal o cuadrilla -->
          <div class="form-group">
            <label for="personal">Personal / Cuadrilla</label>
            <select id="personal" name="personal" class="form-control" required>
              <option value="">Seleccione personal o cuadrilla</option>
              @foreach($cuadrilla as $p)
                <option value="{{ $p->iid_cuadrilla }}">{{ $p->cnombre_cuadrilla }}</option>
              @endforeach
            </select>
          </div>
          
          <!-- Observaciones -->
          <div class="form-group">
            <label for="observaciones">Observaciones</label>
            <input type="text" id="observaciones" name="observaciones" class="form-control" readonly>
          </div>

        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">
            <i class="fa fa-plus"></i> Agregar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Salida actualizada correctamente</h1>

    <a href="{{ route('salidas.editar') }}" class="btn btn-primary">Regresar</a>
</div>
@endsection

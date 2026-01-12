@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Salida actualizada correctamente</h1>

    <a href="{{ route('salidas.index') }}" class="btn btn-primary">Regresar</a>
</div>
@endsection

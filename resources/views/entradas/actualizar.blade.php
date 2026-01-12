@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Entrada actualizada correctamente</h1>

    <a href="{{ route('entradas.index') }}" class="btn btn-primary">Regresar</a>
</div>
@endsection

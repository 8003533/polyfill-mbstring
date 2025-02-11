@extends('layouts.app')

@section('titulo')
    Cambiar contraseña Paso 1 de 3
@endsection
@section('panel')
    <div class="mb-4 text-sm text-gray-600">
        {{-- __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') --}}
        Olvidaste tu contraseña. No hay problema. Escribe tu correo electrónico y te enviamos el enlace para que escribas una nueva.
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="block">
            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
        </div>

        <div class="flex items-center justify-end mt-4 offset-md-2">
            <button class="btn btn-primary">
                {{ __('Email Password Reset Link') }}
            </button>
        </div>
    </form>
@endsection

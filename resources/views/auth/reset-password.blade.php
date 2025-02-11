@extends('layouts.app')

@section('titulo')
    Cambiar contraseña Paso 3 de 3
@endsection
@section('panel')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="block">
            <label for="email" class="col-md-2 col-form-label text-md-right">{{ __('Email') }}</label>
            <input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />
        </div>

        <div class="mt-4">
            <label for="password" class="col-md-2 col-form-label text-md-right">{{ __('Password') }}</label>
            <input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
        </div>

        <div class="mt-4">
            <label for="password_confirmation" class="col-md-2 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <button class="btn btn-primary">
                {{ __('Reset Password') }}
            </button>
        </div>
    </form>
@endsection
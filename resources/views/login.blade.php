@extends('layout')

@section('content')
    <h1>Iniciar sesión</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <label>Correo <input type="email" name="email" value="{{ old('email') }}" required autofocus></label>
        <label>Contraseña <input type="password" name="password" required></label>
        @error('email') <p class="error">{{ $message }}</p> @enderror
        <button>Entrar</button>
    </form>
@endsection

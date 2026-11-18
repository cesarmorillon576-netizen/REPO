@extends('layout')

@section('content')
    <h1>Verificación</h1>
    <p>Te enviamos un código de 6 dígitos por correo.</p>
    <form method="POST" action="{{ route('verificar') }}">
        @csrf
        <label>Código <input name="codigo" inputmode="numeric" autocomplete="one-time-code" maxlength="6" required autofocus></label>
        @error('codigo') <p class="error">{{ $message }}</p> @enderror
        <button>Verificar</button>
    </form>
@endsection

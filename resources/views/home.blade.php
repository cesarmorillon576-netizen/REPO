@extends('layout')

@section('content')
    <h1>Hola, {{ auth()->user()->name }}</h1>
    <p>Sesión iniciada como {{ auth()->user()->email }}.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button>Cerrar sesión</button>
    </form>
@endsection

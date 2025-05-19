@extends('layouts.app')

@section('content')
    @auth
        <span class="text-sm text-gray-700">Hola, {{ Auth::user()->name }}</span>
    @endauth
    <p>Este es el contenido que va entre la cabecera y el pie.</p>
@endsection

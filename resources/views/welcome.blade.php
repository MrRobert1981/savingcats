@extends('layouts.app')

@section('content')
    @auth
        <div style="height: 20px;">
            <span class="text-sm text-gray-700">Hola, {{ Auth::user()->name }}</span>
        </div>
    @endauth
    @guest
        <div style="height: 20px;">
        </div>
    @endguest
    <div class="container my-4">
        <div class="row">
            @for ($i = 1; $i <= 14; $i++)
                <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4 d-flex flex-column align-items-center">
                    <div class="ratio ratio-1x1 w-100">
                        <img src="https://images.unsplash.com/photo-1703783049515-867d492baa81?q=80&w=2047&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="Imagen {{ $i }}" class="img-fluid rounded">
                    </div>
                    <button class="btn btn-primary mt-2 w-100">Botón {{ $i }}</button>
                </div>
            @endfor
        </div>
    </div>
@endsection

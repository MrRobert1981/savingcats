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
        @if (empty($cats) || $cats->isEmpty())
            <p class="text-center text-muted">No hay gatos para mostrar.</p>
        @else
            <div class="row">
                @foreach ($cats as $cat)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4 d-flex flex-column align-items-center">
                        <p class="fw-bold text-primary fs-5 mb-1">{{ $cat->name }}</p>
                        <div class="ratio ratio-1x1 w-100">
                            <img src="{{ asset('storage/' . $cat->image_path) }}" alt="Imagen de un gato"
                                class="img-fluid rounded">
                        </div>
                        @if ($are_adopted)
                            @if ($cat->adoption_date)
                                <p class="text-muted small mb-0">
                                    {{ $cat->sex === 'female' ? 'Adoptada' : 'Adoptado' }}
                                    ({{ \Carbon\Carbon::parse($cat->adoption_date)->format('d/m/Y') }})
                                </p>
                            @endif
                        @else
                            <button class="btn btn-primary mt-2 w-100">
                                @auth
                                    @if (Auth::user()->isAdmin())
                                        Editar
                                    @else
                                        Adoptar
                                    @endif
                                @endauth
                                @guest
                                    Adoptar
                                @endguest
                            </button>
                        @endif


                    </div>
                @endforeach
            </div>
        @endif



    </div>
@endsection

@extends('layouts.app')

@section('content')

    <div class="container my-4">
        @if (empty($cats) || $cats->isEmpty())
            <p class="text-center text-muted fs-4 mb-5">No hay gatos que mostrar.</p>
            <img src="{{ asset('storage/images/no_cats.png') }}" alt="No hay gatos" class="img-fluid d-block mx-auto mb-4"
                style="max-height: 300px;">

                @else
            <div class="row">
                @foreach ($cats as $cat)
                    <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4 d-flex flex-column align-items-center">
                        <p class="fw-bold text-primary fs-5 mb-1">{{ $cat->name }}</p>
                        <div class="ratio ratio-1x1 w-100">
                            <img src="{{ asset('storage/' . $cat->image_path) }}" alt="Imagen de un gato" class="img-fluid rounded">
                        </div>
                        @if ($are_adopted)
                            @if ($cat->adoption_date)
                                <p class="text-muted small mb-0">
                                    {{ $cat->sex === 'female' ? 'Adoptada' : 'Adoptado' }}
                                    ({{ \Carbon\Carbon::parse($cat->adoption_date)->format('d/m/Y') }})
                                </p>
                            @endif
                        @else
                            @auth
                                @if (Auth::user()->isAdmin())

                                    <form id="form_edit_delete{{ $cat->id }}" class="w-100" method="POST">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $cat->id }}">

                                        <div class="d-flex gap-2 mt-3">
                                            <button type="submit"
                                                onclick="changeAction('form_edit_delete{{ $cat->id }}','{{ url('/cats/edit') }}')"
                                                class="btn btn-primary w-75">
                                                Editar
                                            </button>
                                            <button type="button"
                                                onclick="changeAction('form_edit_delete{{ $cat->id }}','{{ url('/cats/destroy') }}',true)"
                                                class="btn btn-danger w-25">
                                                <i class="bi bi-trash-fill text-white"></i>
                                            </button>
                                        </div>
                                    </form>


                                @else
                                    <form action="{{ url('/cats/show') }}" method="POST" style="width: 100%;">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $cat->id }}">
                                        <button type="submit" class="btn btn-primary mt-2 w-100">Adoptar</button>
                                    </form>
                                @endif
                            @endauth
                            @guest
                                <form action="{{ url('/cats/guestAdoption') }}" method="POST" style="width: 100%;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary mt-2 w-100">Adoptar</button>
                                </form>
                            @endguest
                        @endif


                    </div>
                @endforeach
            </div>
        @endif



    </div>
@endsection
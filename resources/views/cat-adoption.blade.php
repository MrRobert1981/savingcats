@extends('layouts.app')

@section('content')
    <div style="height: 20px;"></div>
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-4 mx-auto text-center">
                <img src="{{ asset('storage/' . $cat->image_path) }}" alt="Imagen de gato"
                    class="img-fluid rounded shadow-sm mb-3" />

                <div class="text-start px-2">
                    <p class="mb-1">
                        <strong>Nombre:</strong>
                        <span class="text-muted">{{ $cat->name }}</span>
                    </p>

                    <p class="mb-1">
                        <strong>Edad:</strong>
                        <span class="text-muted">{{ $ageString }}</span>
                    </p>

                    <p class="mb-1">
                        <strong>Sexo:</strong>
                        <span class="text-muted">{{ $cat->sex === 'female' ? 'Hembra' : 'Macho' }}</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container" style="margin-bottom: 20px;">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>{{ $windowTitle }}</h4>
                    </div>
                    <div class="card-body">

                        <form action="{{ url('/adoption-application/store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                            <input type="hidden" name="cat_id" value="{{ $cat->id }}">

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ Auth::user()->name }}" required disabled>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" name="email" id="email" class="form-control"
                                    value="{{ Auth::user()->email }}" required disabled>
                            </div>

                            <div class="mb-3">
                                <label for="contact_phone" class="form-label">Teléfono</label>
                                <input type="number" name="contact_phone" id="contact_phone" class="form-control" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">{{ $submitButtonText }}</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
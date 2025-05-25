@extends('layouts.app')

@section('content')
    <div style="height: 20px;"></div>
    <div class="container">



        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="d-flex justify-content-center mb-4">
                    @if (!$isNew)
                        <div class="ratio ratio-1x1 w-50">
                            <img src="{{ asset('storage/' . $cat->image_path) }}" alt="Imagen de un gato"
                                class="img-fluid rounded">
                        </div>
                    @endif
                </div>

                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>{{ $windowTitle }}</h4>
                    </div>
                    <div class="card-body">
                        @if ($isNew)
                            <form action="{{ url('/cats/store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                        @else
                                <form action="{{ url('/cats/update') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $cat->id }}">
                            @endif

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nombre</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                        value="{{ !$isNew ? $cat->name : '' }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="date_of_birth" class="form-label">Fecha de nacimiento</label>
                                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-control"
                                        value="{{ !$isNew ? $cat->date_of_birth : '' }}"
                                        max="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                </div>

                                <div class=" mb-3">
                                    <label for="sex" class="form-label">Sexo</label>
                                    <select name="sex" id="sex" class="form-select" required>
                                        <option value="male" {{ !$isNew && $cat->sex->name === 'male' ? 'selected' : '' }}>Macho
                                        </option>
                                        <option value="female" {{ !$isNew && $cat->sex->name === 'female' ? 'selected' : '' }}>
                                            Hembra
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="image_path" class="form-label">Fotografía
                                        {{ !$isNew ? ' (opcional)' : '' }}</label>
                                    <input type="file" name="image_path" id="image_path" class="form-control"
                                        accept=".jpg,.jpeg" {{ $isNew ? 'required' : '' }}>
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
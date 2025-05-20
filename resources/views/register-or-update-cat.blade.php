@extends('layouts.app')

@section('content')
    <div style="height: 20px;"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card shadow">
                    <div class="card-header text-center">
                        <h4>Registrar un nuevo gato</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/cats/store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" name="name" id="name" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="date_of_birth" class="form-label">Fecha de nacimiento</label>
                                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="sex" class="form-label">Sexo</label>
                                <select name="sex" id="sex" class="form-select" required>
                                    <option value="male">Macho</option>
                                    <option value="female">Hembra</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="image_path" class="form-label">Fotografía</label>
                                <input type="file" name="image_path" id="image_path" class="form-control"
                                    accept=".jpg,.jpeg" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Registrar gato</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

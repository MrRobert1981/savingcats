@extends('layouts.app')

@section('content')
    <div style="height: 20px;"></div>
    @if (empty($applications) || $applications->isEmpty())
        <p class="text-center text-muted fs-4 mb-5">No hay solicitudes que mostrar.</p>
        <img src="{{ asset('storage/images/no_applicatios.png') }}" alt="No hay gatos" class="img-fluid d-block mx-auto mb-4"
            style="max-height: 300px;">
    @else
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-sm-10 col-md-8 col-lg-6 col-xl-6">
                    @foreach ($applications as $application)
                        <div class="card mb-3 shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">Solicitud #{{ $application->id }}</h5>

                                <p class="mb-1">
                                    <strong>Gato:</strong>
                                    <span class="text-muted">{{ $application->cat->name }}</span>
                                </p>

                                <p class="mb-1">
                                    <strong>Fecha de solicitud:</strong>
                                    <span
                                        class="text-muted">{{ \Carbon\Carbon::parse($application->date_application)->format('d/m/Y') }}</span>
                                </p>

                                @if (Auth::user()->isAdmin())
                                    <p class="mb-1">
                                        <strong>Solicitante:</strong>
                                        <span class="text-muted">{{ $application->user->name }}</span>
                                    </p>
                                    <p class="mb-1">
                                        <strong>Correo electrónico:</strong>
                                        <span class="text-muted">{{ $application->user->email }}</span>
                                    </p>
                                @endif
                                <p class="mb-1">
                                    <strong>Teléfono de contacto:</strong>
                                    <span class="text-muted">{{ $application->contact_phone }}</span>
                                </p>
                                @if (Auth::user()->isAdmin())
                                    <form action="{{ route('adoption-applications.update', $application->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="adoptionStatus" value="">

                                        <button type="submit" class="btn btn-success"
                                            onclick="this.form.adoptionStatus.value='accepted'">
                                            Aceptar
                                        </button>

                                        <button type="submit" class="btn btn-danger"
                                            onclick="this.form.adoptionStatus.value='rejected'">
                                            Rechazar
                                        </button>
                                    </form>
                                @else
                                    <p class="mb-1">
                                        <strong>Estado:</strong><span
                                            class="badge @if($application->adoptionStatus->name === 'pending') bg-warning @elseif($application->adoptionStatus->name === 'accepted') bg-success @else bg-danger @endif">
                                            {{ ucfirst($applicationStatuses[$application->adoptionStatus->name]) }} </span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

@endsection
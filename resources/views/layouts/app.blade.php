<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Saving Cats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/style.css')

    <script>
        function ajustarEspaciado() {
            const header = document.getElementById('header');
            const mainContent = document.getElementById('mainContent');

            const alturaHeader = header.offsetHeight;
            mainContent.style.marginTop = alturaHeader + 'px';
        }

        // Ajusta al cargar y si cambian tamaños (como en un resize)
        window.addEventListener('load', function () {
            ajustarEspaciado();

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonColor: '#3085d6'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '{{ session('error') }}',
                    confirmButtonColor: '#d33'
                });
            @endif


            @if (session('info'))
                Swal.fire({
                    icon: 'info',
                    title: 'Información',
                    text: @json(session('info')),
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#3085d6'
                });
            @endif

            @if (session('warning'))
                Swal.fire({
                    icon: 'warning',
                    title: 'Advertencia',
                    text: @json(session('warning')),
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#f0ad4e'
                });
            @endif
            
        });
        window.addEventListener('resize', ajustarEspaciado);

    </script>

</head>

<body>
    <header>
        <div class="sticky-header" id="header">
            <div id="webHeader">
                <div id="webSiteTitleContainer">
                    <h1 id="webSiteTitle">Saving cats</h1>
                    <h1 id="backgroundWebSiteTitle">Saving cats</h1>
                </div>
            </div>

            <nav class="navbar navbar-expand-lg">
                <div class="container-fluid">
                    <!-- Botón hamburguesa a la derecha -->
                    <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto left-links">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/') }}">En adopción</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('/cats/adopted') }}">Adoptados</a>
                            </li>
                            @auth
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/adoption-application/index') }}">Solicitudes</a>
                                </li>
                                @if (Auth::user()->isAdmin())
                                    <li class="nav-item">
                                        <form method="POST" action="{{ url('/cats/create') }}">
                                            @csrf
                                            <button style="display: inline;" class="nav-link" type="submit">
                                                Registrar gato
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            @endauth
                        </ul>

                        <ul class="navbar-nav ms-auto right-links">
                            @guest
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                                </li>
                            @endguest
                            @auth
                                <li class="nav-item">
                                    <a href="" class="nav-link no-hover">Hola, {{ explode(' ', Auth::user()->name)[0] }}</a>
                                </li>
                                <li class="nav-item">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button style="display: inline;" class="nav-link" type="submit">
                                            Cerrar sesión
                                        </button>
                                    </form>
                                </li>
                            @endauth

                        </ul>
                    </div>
                </div>
            </nav>

        </div>
    </header>

    <main id="mainContent">
        @yield('content') <!-- Aquí va el contenido de cada página -->
    </main>

    <footer class="bg-corporate-orange text-white text-center py-3">
        © Saving Cats - Todos los derechos reservados
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const navbar = document.getElementById('navbarNav');
            if (navbar) {
                navbar.style.visibility = 'visible';
            }
        });
    </script>
</body>

</html>
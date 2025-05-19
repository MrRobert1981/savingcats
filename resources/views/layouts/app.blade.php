<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Saving Cats</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite('resources/css/inicio.css')
</head>

<body>
    <header>
        <div class="sticky-header">
            <div id="webHeader">
                <div id="webSiteTitleContainer">
                    <h1 id="webSiteTitle">Saving cats</h1>
                    <h1 id="backgroundWebSiteTitle">Saving cats</h1>
                </div>
            </div>
            <div id="divNav">
                <nav>
                    <ul>
                        <li><a href="#">En adopción</a></li>
                        <li><a href="#">Adoptados</a></li>
                    </ul>
                    <ul>
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Iniciar sesión</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Registrarse</a>
                            </li>
                        @endguest
                        @auth
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit">Cerrar sesión</button>
                                </form>
                            </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <main>
        @yield('content') <!-- Aquí va el contenido de cada página -->
    </main>

    <footer>
        <!-- Aquí tu pie fijo -->
        <p>© 2025 Mi Aplicación</p>
    </footer>
</body>

</html>

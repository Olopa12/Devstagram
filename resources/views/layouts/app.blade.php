<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @stack('styles')
        <title>DevStagram - @yield('titulo')</title>
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')

        @livewireStyles
    </head>
    <body>
        <!-- --------------------------------------------------------- -->
        <!-- Header: Navegación principal -->
        <!-- --------------------------------------------------------- -->
        <header class="p-5 border-b bg-white shadow" >
            <div class="container mx-auto md:flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-3xl font-black">
                    Devstagram
                </a>  

                <!-- Navegación para usuarios autenticados -->
                @auth
                    <nav class="flex gap-4 items-center">
                        <!-- Enlace Crear post -->
                        <a class="flex items-center gap-2 bg-white border p-2 text-gray-600 
                        rounded text-sm uppercase font-bold cursor-pointer"
                        href="{{ route('post.create') }}">
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z" />
                          </svg>
                           Crear
                        </a>

                        <!-- Formulario de búsqueda de usuarios -->
                        @livewire('buscar-usuarios')

                        <!-- Enlace a perfil de usuario -->
                        <a class="font-bold text-gray-600 text-sm" 
                        href="{{ route('post.index', auth()->user()->username) }}">
                        Hola: <span class="font-normal"> {{ auth()->user()->username }}</span>
                        </a>

                        <!-- Formulario de cierre de sesión -->
                        <form method="POST" action=" {{ route('logout') }} ">
                            @csrf
                            <button type="submit" href="{{ route('logout') }}" class="font-bold uppercase 
                            text-gray-600 text-sm">Cerrar Sessión</button>
                        </form>
                    </nav>
                @endauth

                <!-- Navegación para invitados (no autenticados) -->
                @guest
                    <nav class="flex gap-4 items-center">
                        <a class="font-bold uppercase text-gray-600 
                        text-sm" href="{{ route('login') }}">Login</a>

                        <a href="{{ route('register') }}" class="font-bold uppercase text-gray-600 
                        text-sm">Crear Cuenta</a>
                    </nav>
                @endguest

            </div>
        </header>

        <!-- --------------------------------------------------------- -->
        <!-- Main: Contenido principal de la página -->
        <!-- --------------------------------------------------------- -->
        <main class="container mx-auto mt-10">
            <!-- Título de sección dinámica -->
            <h2 class="font-black text-center text-3xl mb-10">
                @yield('titulo')
            </h2>

            <!-- Sección de contenido dinámico -->
            @yield('contenido')
        </main>
            
        <!-- --------------------------------------------------------- -->
        <!-- Footer: Pie de página -->
        <!-- --------------------------------------------------------- -->
        <footer class=" text-center p-5 text-gray-500 font-bold uppercase">
            DEVSTAGRAM - TODOS LOS DERECHOS RESERVADOS 
            {{ now()->year}}
            
        </footer>

        <!-- Scripts externos y stacks personalizados -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @stack('scripts')
        @livewireScripts
    </body>

</html>
        
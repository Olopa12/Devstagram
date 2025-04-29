@extends('layouts.app')

@section('titulo')
    Inicia Sessión en Devstagram
@endsection

@section('contenido')
    {{-- --------------------------------------------------------- --}}
    {{-- Contenedor principal: Imagen y formulario de login --}}
    {{-- --------------------------------------------------------- --}}
    <div class=" md:flex md:gap-10 md:items-center">
        {{-- Imagen ilustrativa --}}
        <div class=" md:w-6/12 p-5">
            <img  src="{{ asset('img/registrar.jpg')}}" alt="Imagen Registro de Usuarios"/>
        </div>

        {{-- Formulario de login --}}
        <div class=" md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                {{-- Mensajes de sesión --}}
                @if (session('mensaje'))
                    <p class=" bg-red-500 text-white my-2 rounded-lg text-sm p-2
                    text-center"> {{ session('mensaje')}} </p>
                @endif

                {{-- Campo Email --}}
                <div class="mb-5">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">
                        Email
                    </label>

                    <input 
                        id = "email"
                        name = "email"
                        type = "text"
                        placeholder = "Tu Email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500
                        @enderror"
                        value="{{ old('email') }}"
                    />

                    @error('email')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                        text-center">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Campo Contraseña --}}
                <div class="mb-5">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">
                        Contraseña
                    </label>

                    <input 
                        id = "password"
                        name = "password"
                        type = "password"
                        placeholder = "Contraseña de Registro"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500
                        @enderror"
                    />

                    @error('password')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                        text-center">{{ str_replace( 'password', 'Contraseña', $message) }}</p>
                    @enderror
                </div>

                {{-- Checkbox recordar sesión --}}
                <div class="mb-5">
                    <input type="checkbox" name="remember">
                    <label class=" text-gray-500 font-bold text-sm">Mantener mi session abierta</label>
                </div>

                {{-- Botón Iniciar sesión --}}
                <input
                    type="submit"
                    value="Inciar Sessión"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
                    uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
            
        </div>
    </div>
@endsection
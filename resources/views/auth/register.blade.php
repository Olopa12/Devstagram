@extends('layouts.app')

@section('titulo')
    Inicia Sesión en Devstagram
@endsection

@section('contenido')
    {{-- --------------------------------------------------------- --}}
    {{-- Contenedor principal con imagen y formulario --}}
    {{-- --------------------------------------------------------- --}}
    <div class=" md:flex md:gap-10 md:items-center">
        {{-- Imagen ilustrativa --}}
        <div class=" md:w-6/12 p-5">
            <img  src="{{ asset('img/login.jpg')}}" alt="Imagen login de Usuarios"/>
        </div>

        {{-- Formulario de registro --}}
        <div class=" md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf
                {{-- Campo Nombre --}}
                <div class="mb-5">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">
                        Nombre
                    </label>

                    <input 
                        id = "name"
                        name = "name"
                        type = "text"
                        placeholder = "Tu nombre"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500
                        @enderror"
                        value="{{ old('name') }}"
                    />

                    @error('name')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                        text-center">{{ str_replace( 'name', 'Nombre', $message) }}</p>
                    @enderror
                </div>

                {{-- Campo Usuario --}}
                <div class="mb-5">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">
                        Usuario
                    </label>

                    <input 
                        id = "username"
                        name = "username"
                        type = "text"
                        placeholder = "Tu nombre de Usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500
                        @enderror"
                        value="{{ old('username') }}"
                    />

                    @error('username')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                        text-center">{{ str_replace( 'username', 'Usuario', $message) }}</p>
                    @enderror
                </div>

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

                {{-- Campo Confirmar Contraseña --}}
                <div class="mb-5">
                    <label for="password_confirmation" class="mb-2 block uppercase 
                    text-gray-500 font-bold">
                        Repetir Contraseña
                    </label>

                    <input 
                        id = "password_confirmation"
                        name = "password_confirmation"
                        type = "password"
                        placeholder = "Repetir Contraseña"
                        class="border p-3 w-full rounded-lg @error('password_confirmation')
                         border-red-500
                        @enderror"
                    />

                    @error('password_confirmation')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                        text-center">{{ str_replace( 'password confirmation', 'Repetir Contraseña', 
                        $message) }}</p>
                    @enderror
                </div>

                {{-- Botón de envío --}}
                <input
                    type="submit"
                    value="Crear Cuenta"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
                    uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
            
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    {{-- --------------------------------------------------------- --}}
    {{-- Sección perfil: imagen, estadísticas y acciones --}}
    {{-- --------------------------------------------------------- --}}
    <div class='flex justify-center'>
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            {{-- Imagen de perfil --}}
            <div class="w-8/12 lg:w-6/12 px-5">
                <img src="{{ 
                    $user->imagen 
                        ? asset('perfiles') . '/' . $user->imagen 
                        :  asset('img/usuario.svg') }}" 
                    alt="imagen usuario"
                    class="rounded-full"
                    />
            </div>

            {{-- Datos y botones --}}
            <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center 
            md:justify-center md:items-start py-10">
                {{-- Nombre de usuario y edición (si es su propio perfil) --}}
                <div class="flex items-center gap-2">
                    <p class="text-gray-700 text-2xl">{{ $user->username }}</p>
                    @auth
                        @if ($user->id === auth()->user()->id)
                            {{-- Enlace para editar perfil --}}
                            <a href="{{ route('perfil.index') }}"
                                class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>                              
                            </a>
                        @endif
                    @endauth
                </div>
                    
                    {{-- Estadísticas: seguidores, siguiendo, posts --}}
                    <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                        {{ $user->followers->count() }}
                        <span class="font-normal"> @choice('Seguidor|Seguidores', $user->followers->count())</span>
                    </p>

                    <p class="text-gray-800 text-sm mb-3 font-bold">
                        {{ $user->followings->count() }}
                        <span class="font-normal"> Siguiendo</span>
                    </p>

                    <p class="text-gray-800 text-sm mb-3 font-bold">
                        {{ $user->posts->count() }}
                        <span class="font-normal"> Posts</span>
                    </p>

                    {{-- Botones seguir/dejar de seguir (si no es su propio perfil) --}}
                    @auth
                        @if ($user->id != auth()->user()->id)
                            @if (!$user->siguiendo(auth()->user()))
                                <form action="{{ route('users.follow', $user) }}" method="POST">
                                    @csrf
                                    <input type="submit" 
                                    class="bg-blue-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Seguir">
                                </form>
                            @else
                                <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" 
                                    class="bg-red-600 text-white uppercase rounded-lg px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Dejar de Seguir">
                                </form>
                            @endif
                        @endif
                    @endauth
                
            </div>
        </div>
    </div>

    {{-- --------------------------------------------------------- --}}
    {{-- Sección de publicaciones del usuario --}}
    {{-- --------------------------------------------------------- --}}
    <section class="container mx-auto mt-10 p-5">
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
        <x-listar-post :posts="$posts" /> 
    </section>

@endsection
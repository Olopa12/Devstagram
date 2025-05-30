@extends('layouts.app')

@section('titulo')
    {{ $post->titulo }}
@endsection

@section('contenido')
    {{-- --------------------------------------------------------- --}}
    {{-- Contenedor principal: imagen y detalles del post --}}
    {{-- --------------------------------------------------------- --}}
    <div class="container mx-auto md:flex">
        {{-- Sección de imagen y descripción --}}
        <div class="md:w-1/2 p-5">
            {{-- Imagen del post --}}
            <img src="{{ asset('uploads') . '/' . $post->imagen }}" 
            alt="Imagen del post {{ $post->titulo }}">

            {{-- Descripción del post --}}
            <p class="mt-5">
                {{ $post->descripcion }}
            </p>
            
            {{-- Likes y formulario para dar/quitar like --}}
            <div class="p-3 flex items-center gap-4">
                @auth   

                    @if (($post)->checkLike(auth()->user()))
                        {{-- Formulario para eliminar like --}}
                        <form method="POST" action="{{ route('posts.likes.destroy', $post) }}">
                            @method('DELETE')
                            @csrf
                            <div class="my-4">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="black" 
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                    
                                </button>
                            </div>
                        </form>
                    @else
                        {{-- Formulario para agregar like --}}
                        <form method="POST" action="{{ route('posts.likes.store', $post) }}">
                            @csrf
                            <div class="my-4">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="white" 
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                    
                                </button>
                            </div>
                        </form>
                    @endif
                        
                @endauth

                {{-- Contador de likes --}}
                <p class="font-bold">{{ $post->likes->count() }} 
                    <span class="font-normal">Likes</span>
                </p>
            </div>

            {{-- Nombre de usuario y fecha --}}
            <div>
                <p class="font-bold">{{ $post->user->username }}</p>
                <p class="tetxt-sm text-gray-500">
                    {{ $post->created_at->diffForHumans() }}
                </p>
            </div>

            {{-- Botón eliminar post (solo autor) --}}
            @auth
                @if ($post->user_id === auth()->user()->id)
                    <form id="form-eliminar-post" method="POST" action="{{ route('posts.destroy', $post) }}">
                        @method('DELETE')
                        @csrf
                        <input 
                            type="submit" 
                            value="Eliminar Publicación"
                            class="bg-red-500 hover:bg-red-600 p-2 rounded text-white mt-4 cursor-pointer"
                        />
                    </form>
                @endif         
            @endauth
            
        </div>

        {{-- --------------------------------------------------------- --}}
        {{-- Sección de comentarios --}}
        {{-- --------------------------------------------------------- --}}
        <div class="md:w-1/2 p-5">
            <div class="shadow bg-white p-5 mb-5">

                @auth
                    {{-- Formulario para agregar nuevo comentario --}}
                    <p class="text-xl font-bold text-center mb-4">Agrega un nuevo comentario</p>

                    {{-- Mensaje de éxito --}}
                    @if(session('mensaje'))
                        <div class="bg-green-500 p2 rounded-lg mb-6 text-white text-center uppercase
                        font-bold">
                            {{ session('mensaje') }}
                        </div>
                    @endif

                    {{-- Formulario de comentario --}}
                    <form action="{{ route('comentarios.store', ['post' => $post, 'user' => $user]) }}" 
                        method="POST">
                        @csrf
                        <div class="mb-5">
                            <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">
                                Añade un comentario
                            </label>
        
                            <textarea 
                                id = "comentario"
                                name = "comentario"
                                placeholder = "Agrega un comentario"
                                class="border p-3 w-full rounded-lg @error('comentario') border-red-500
                                @enderror"
                            >{{ old('comentario')}}</textarea>
                            
        
                            @error('comentario')
                                <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                                text-center">{{ str_replace( 'comentario', 'Comentario', $message) }}</p>
                            @enderror
                        </div>

                        <input
                            type="submit"
                            value="Publicar"
                            class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
                            uppercase font-bold w-full p-3 text-white rounded-lg"
                        />
                    </form>
                @endauth

                {{-- Listado de comentarios existentes --}}
                <div class="bg-white shadow mb-5 max-h-96 overflow-scroll">
                    @if ($post->comentarios->count())
                        @foreach ($post->comentarios as $comentario)
                            <div class="p-5 border-gray-300 border-b">
                                <a href="{{ route('post.index', $comentario->user)}}" class="font-bold ">
                                    {{ $comentario->user->username }}
                                </a>
                                <p>{{ $comentario->comentario }}</p>
                                <p class="text-sm text-gray-500">{{ $comentario->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    @else
                        <p class="p-10 text-center">No Hay Comentarios Aún</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Script para confirmación de eliminación de post --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formEliminar = document.getElementById('form-eliminar-post');

            formEliminar.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡Esta acción no se puede deshacer!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        formEliminar.submit();
                    }
                })
            });
        });
    </script>
@endpush

@push('scripts')
    {{-- Script para mostrar alertas de éxito --}}
    @if (session('mensaje'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: '¡Éxito!',
                    text: "{{ session('mensaje') }}",
                    icon: 'success',
                    confirmButtonText: 'Ok'
                });
            });
        </script>
    @endif
@endpush
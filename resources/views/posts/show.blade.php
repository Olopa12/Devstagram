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
                    <livewire:like-post :post="$post"/>            
                @endauth
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
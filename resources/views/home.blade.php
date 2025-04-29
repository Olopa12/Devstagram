@extends('layouts.app')

@section('titulo')
    Pagina principal
@endsection

@section('contenido')
    {{-- --------------------------------------------------------- --}}
    {{-- Sección de posts: grid de publicaciones o mensaje vacío --}}
    {{-- --------------------------------------------------------- --}}
    @if ($posts->count())
        {{-- Grid responsivo de posts --}}
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                <div>
                    {{-- Enlace al detalle del post con imagen --}}
                    <a href="{{ route('posts.show', ['post' => $post, 'user' => $post->user]) }}">
                        <img src="{{ asset('uploads') . '/' . $post->imagen }}" 
                        alt="Imagen del post {{ $post->titulo }}">
                    </a>

                    {{-- Contador de likes y comentarios --}}
                    <div class="p-3">
                        <p>{{ $post->likes->count() }} Likes</p>
                        <p>{{ $post->comentarios->count() }} Comentarios</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginación --}}
        <div class="my-10">
            {{ $posts->links() }}
        </div>
    @else
        {{-- Mensaje cuando no hay posts --}}
        <p class="text-center">
            No hay posts aún. Sigue a alguien para ver sus publicaciones.
        </p>
    @endif

@endsection
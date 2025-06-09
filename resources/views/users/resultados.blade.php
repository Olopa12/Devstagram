@extends('layouts.app')

@section('titulo', 'Resultados de búsqueda')

@section('contenido')
    {{-- Título con estilo --}}
    <h2 class="text-2xl font-extrabold mb-6 text-center text-sky-700">
        Resultados para: <span class="italic">"{{ $termino }}"</span>
    </h2>

    @if($usuarios->count())
        {{-- Lista de usuarios con estilos y sombras --}}
        <ul class="max-w-xl mx-auto bg-white rounded-lg shadow divide-y divide-gray-200">
            @foreach($usuarios as $usuario)
                <li class="flex items-center gap-4 p-4 hover:bg-sky-50 transition-colors cursor-pointer">
                    {{-- Enlace al perfil del usuario --}}
                    <a href="{{ route('post.index', $usuario->username) }}" class="flex items-center gap-4 w-full text-gray-800">
                        {{-- Imagen de perfil --}}
                        <div>
                            <img src="{{ 
                                $usuario->imagen 
                                    ? asset('perfiles') . '/' . $usuario->imagen 
                                    : asset('img/usuario.svg') }}" 
                                alt="imagen usuario"
                                class="w-12 h-12 rounded-full object-cover flex-shrink-0"
                                />
                        </div>
                        
                        {{-- Información del usuario --}}
                        <div>
                            {{-- Nombre --}}
                            <p class="font-semibold text-lg leading-tight">
                                {{ $usuario->name }}
                            </p>
                            {{-- Username con estilo gris y más pequeño --}}
                            <p class="text-sm text-gray-500">
                                @<span>{{ $usuario->username }}</span>
                            </p>
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        {{-- Paginación centrada debajo de la lista --}}
        <div class="max-w-xl mx-auto mt-6">
            {{ $usuarios->links() }}
        </div>
    @else
        {{-- Mensaje cuando no hay resultados --}}
        <p class="text-center text-gray-600 text-lg mt-10">
            No se encontraron usuarios para "<span class="italic">{{ $termino }}</span>".
        </p>
    @endif
@endsection

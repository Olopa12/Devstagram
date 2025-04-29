@extends('layouts.app')

@section('titulo')
    Crear una nueva Publicación
@endsection

@push('styles')
    <!-- Dropzone CSS para subida de imágenes -->
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" 
    type="text/css" />
@endpush

@section('contenido')
    {{-- --------------------------------------------------------- --}}
    {{-- Contenedor principal: dropzone y formulario de publicación --}}
    {{-- --------------------------------------------------------- --}}
    <div class="md:flex md:items-center">
        {{-- Sección Dropzone para subir imagen --}}
        <div class="md:w-1/2 px-10">
            <form action='{{ route('imagenes.store') }}' method="POST" enctype="multipart/form-data" 
            id='dropzone' class="dropzone border-dashed border-2 w-full h-96 
            rounded flex flex-col justify-center items-center">@csrf</form>
        </div>

        {{-- Formulario de datos de la publicación --}}
        <div class="md:w-1/2 p-10 bg-white rounded-lg shadow-xl mt-10 md:mt-0">
            <form action="{{ route('posts.store') }}" method="POST" novalidate>
                @csrf
                {{-- Campo Título --}}
                <div class="mb-5">
                    <label for="titulo" class="mb-2 block uppercase text-gray-500 font-bold">
                        Titulo
                    </label>

                    <input 
                        id = "titulo"
                        name = "titulo"
                        type = "text"
                        placeholder = "Titulo de la Publicación"
                        class="border p-3 w-full rounded-lg @error('titulo') border-red-500
                        @enderror"
                        value="{{ old('titulo') }}"
                    />

                    @error('titulo')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                        text-center">{{ str_replace( 'titulo', 'Titulo', $message) }}</p>
                    @enderror
                </div>

                {{-- Campo Descripción --}}
                <div class="mb-5">
                    <label for="descripcion" class="mb-2 block uppercase text-gray-500 font-bold">
                        Descripción
                    </label>

                    <textarea 
                        id = "descripcion"
                        name = "descripcion"
                        placeholder = "Descripción de la Publicación"
                        class="border p-3 w-full rounded-lg @error('descripcion') border-red-500
                        @enderror"
                    >{{ old('descripcion')}}</textarea>
                    

                    @error('descripcion')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                        text-center">{{ str_replace( 'descripcion', 'Descripción', $message) }}</p>
                    @enderror
                </div>

                {{-- Campo Imagen Oculta --}}
                <div>
                    <input 
                        name="imagen"
                        type="hidden"
                        value="{{ old('imagen') }}"
                    >
                    @error('imagen')
                        <p class="bg-red-500 text-white my-2 rounded-lg text-sm p-2
                        text-center">{{ str_replace( 'imagen', 'Imagen', $message) }}</p>
                    @enderror
                </div>

                {{-- Botón Publicar --}}
                <input
                    type="submit"
                    value="Publicar"
                    class="bg-sky-600 hover:bg-sky-700 transition-colors cursor-pointer 
                    uppercase font-bold w-full p-3 text-white rounded-lg"
                />
            </form>
        </div>
        
    </div>
@endsection
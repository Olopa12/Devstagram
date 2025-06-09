<form wire:submit.prevent="buscarCompleto" class="relative w-full max-w-xs sm:max-w-sm md:max-w-md lg:max-w-lg">
    {{-- Campo de búsqueda responsivo --}}
    <input 
        type="text" 
        placeholder="Buscar usuarios..." 
        wire:model="search"
        class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm w-full focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
        aria-label="Buscar usuarios"
        wire:input='buscarParciales'
    />

    {{-- Icono de búsqueda --}}
    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" 
             viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M21 21l-4.35-4.35M17 11a6 6 0 11-12 0 6 6 0 0112 0z" />
        </svg>
    </div>

    {{-- Resultados: menú desplegable responsivo --}}
    @if(!empty($resultados))
        <ul class="absolute z-50 mt-1 w-full bg-white border border-gray-300 rounded-lg shadow-lg text-sm max-h-60 overflow-y-auto">
            @foreach($resultados as $usuario)
                <li class="p-2 hover:bg-sky-100 transition-colors duration-200">
                    <a href="{{ route('post.index', $usuario->username) }}" class="block text-gray-700 truncate">
                        <strong>{{ $usuario->name }}</strong> <span class="text-gray-500">({{ $usuario->username }})</span>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif
</form>

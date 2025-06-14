<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

/**
 * Componente Livewire para la búsqueda dinámica de usuarios.
 * 
 * Permite buscar usuarios por nombre o username en tiempo real
 * y redirigir a una búsqueda completa cuando se desea.
 */
class BuscarUsuarios extends Component
{
    /** @var string Texto ingresado en el campo de búsqueda */
    public $search = '';

    /** @var \Illuminate\Database\Eloquent\Collection Lista de resultados filtrados */
    public $resultados = [];

    /**
     * Realiza una búsqueda parcial si el texto ingresado tiene al menos 2 caracteres.
     * 
     * Si se cumplen las condiciones, busca coincidencias en la base de datos por nombre o username,
     * y guarda los primeros 5 resultados en la propiedad $resultados.
     * 
     * Si el texto ingresado es menor a 2 caracteres, vacía los resultados.
     */
    public function buscarParciales()
    {
        if (strlen($this->search) >= 2) {
            $this->resultados = User::where('name', 'like', '%' . $this->search . '%')
                                    ->orWhere('username', 'like', '%' . $this->search . '%')
                                    ->limit(5)
                                    ->get();
        } else {
            $this->resultados = [];
        }
    }

    /**
     * Redirige a la ruta de búsqueda completa pasando el término como parámetro.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function buscarCompleto()
    {
        logger('Redireccionando a: ' . $this->search);
        if (strlen($this->search) < 1) 
        {
            $this->resultados = [];
            return;
        } 
        
        return redirect()->route('buscar.usuarios', ['search' => $this->search]);
    }

    /**
     * Renderiza la vista asociada al componente.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.buscar-usuarios');
    }
}

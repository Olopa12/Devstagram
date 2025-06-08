<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ListarPost extends Component
{
    /**
     * Colección de posts que se mostrarán en el componente.
     *
     * @var mixed
     */
    public $posts;
    
    /**
     * Crea una nueva instancia del componente ListarPost.
     *
     * @param mixed $posts  Colección de publicaciones a pasar al componente
     */
    public function __construct($posts)
    {
        $this->posts = $posts;
    }

    /**
     * Obtiene la vista que representa el componente.
     *
     * @return View|Closure|string  La vista Blade o contenido renderizado
     */
    public function render(): View|Closure|string
    {
        return view('components.listar-post');
    }
}

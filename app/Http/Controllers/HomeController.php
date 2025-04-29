<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * Class HomeController
 *
 * Controlador invocable encargado de mostrar el feed de publicaciones
 * de los usuarios que el usuario autenticado sigue.
 *
 * @package App\Http\Controllers
 */
class HomeController extends Controller
{
    /**
     * Muestra la lista de posts recientes de usuarios seguidos.
     *
     * @return \Illuminate\View\View  Vista con el listado de posts paginados
     */
    public function __invoke()
    {
        // Obtener los IDs de los usuarios que el usuario autenticado sigue
        $ids = auth()->user()->followings->pluck('id')->toArray();

        // Consultar posts de esos usuarios, ordenados por fecha descendente, paginados
        $posts =    Post::whereIn('user_id', $ids)->latest()->paginate(20);

        // Retornar la vista 'home' con los posts obtenidos
        return view('home', ['posts' => $posts]);
    }
}

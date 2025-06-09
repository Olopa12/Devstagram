<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * Class BusquedaController
 *
 * Controlador encargado de manejar la búsqueda de usuarios
 * según un término proporcionado por el usuario.
 */
class BusquedaController extends Controller
{
    /**
     * Muestra los resultados de la búsqueda de usuarios.
     *
     * @param  Request  $request  Objeto que contiene los datos de la petición HTTP
     * @return \Illuminate\View\View  Vista con los usuarios encontrados y el término buscado
     */
    public function index(Request $request)
    {
        $termino = $request->input('search');

        $usuarios = User::where('username', 'like', "%$termino%")
                        ->orWhere('name', 'like', "%$termino%")
                        ->paginate(10);

        return view('users.resultados', [
            'usuarios' => $usuarios,
            'termino' => $termino
        ]);
    }
}

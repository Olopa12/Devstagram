<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

/**
 * Class FollowerController
 *
 * Controlador encargado de manejar las relaciones de seguimiento
 * entre usuarios: seguir y dejar de seguir a otro usuario.
 */
class FollowerController extends Controller
{
    /**
     * Agrega al usuario autenticado como seguidor del usuario dado.
     *
     * @param  User  $user  Usuario que será seguido
     * @return \Illuminate\Http\RedirectResponse  Redirige de vuelta a la vista anterior
     */
    public function store(User $user)
    {
        // Adjuntar la relación: el usuario autenticado sigue al usuario dado
        $user->followers()->attach(auth()->user()->id);

        // Redirigir de vuelta a la página previa
        return back();
    }

    /**
     * Elimina al usuario autenticado de la lista de seguidores del usuario dado.
     *
     * @param  User  $user  Usuario al que se dejará de seguir
     * @return \Illuminate\Http\RedirectResponse  Redirige de vuelta a la vista anterior
     */
    public function destroy(User $user)
    {
        // Desvincular la relación: el usuario autenticado deja de seguir al usuario
        $user->followers()->detach(auth()->user()->id);

        // Redirigir de vuelta a la página previa
        return back();
    }
}

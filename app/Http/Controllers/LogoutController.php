<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LogoutController
 *
 * Controlador encargado de manejar el cierre de sesión de los usuarios.
 */
class LogoutController extends Controller
{
    /**
     * Cierra la sesión del usuario autenticado.
     *
     * @return \Illuminate\Http\RedirectResponse  Redirige a la ruta de login
     */
    public function store()
    {
        // Eliminar la sesión de autenticación
        Auth::logout();

        // Redirigir al formulario de inicio de sesión
        return redirect()->route('login');
    }
}

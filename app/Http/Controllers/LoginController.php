<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class LoginController
 *
 * Controlador encargado de mostrar el formulario de inicio de sesión
 * y procesar la autenticación de usuarios.
 */
class LoginController extends Controller
{
    /**
     * Muestra el formulario de login.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Retorna la vista ubicada en resources/views/auth/login.blade.php
        return view('auth.login');
    }

    /**
     * Procesa los datos de inicio de sesión y autentica al usuario.
     *
     * @param  Request  $request  Instancia de la petición HTTP con credenciales
     * @return \Illuminate\Http\RedirectResponse  Redirige a la página de posts o retorna con error
     */
    public function store(Request $request)
    {
        // Validar que el email sea un formato válido y la contraseña no esté vacía
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // Intentar autenticación con las credenciales proporcionadas
        if (! Auth::attempt($request->only('email', 'password'), $request->remember)) {
            // Si falla, redirige de vuelta con mensaje de error en sesión
            return back()->with('mensaje', 'Credenciales Incorrectas');
        }

        // Autenticación exitosa, redirige al perfil del usuario autenticado
        return redirect()->route('post.index', auth()->user()->username);
    }
}

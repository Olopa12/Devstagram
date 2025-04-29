<?php

namespace App\Http\Controllers;
//posible errro recrear en caso de fallos
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class RegisterController
 *
 * Controlador encargado de mostrar el formulario de registro
 * y de procesar el alta de nuevos usuarios.
 */
class RegisterController extends Controller
{
    /**
     * Muestra la vista con el formulario de registro.
     *
     * @return \Illuminate\View\View  Vista del formulario de registro
     */
    public function index() 
    {
        // Retornar la vista ubicada en resources/views/auth/register.blade.php
        return view('auth.register');
    }

    /**
     * Valida los datos y crea un nuevo usuario en la base de datos.
     *
     * @param  Request  $request  Instancia de la petición HTTP con datos del registro
     * @return \Illuminate\Http\RedirectResponse  Redirige al dashboard del usuario registrado
     */
    public function store(Request $request)
    {
        // Convertir el username a slug para evitar caracteres inválidos
        $request->request->add(['username' => Str::slug( $request->username )]);

        // Validar los datos de entrada
        $request->validate([
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20|not_in:editar-perfil',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:5'
        ]);

        // Crear el usuario con los datos validados y contraseña hasheada
        User::create([
            'name' => $request->name,
            'username' => Str::slug( $request->username ),
            'email' => $request->email,
            'password' => Hash::make( $request->password )
        ]);

        // Autenticar al usuario recién registrado
        Auth::attempt($request->only('email', 'password'));

        // Redirigir al listado de posts del usuario autenticado
        return redirect()->route('post.index', auth()->user()->username);
    }
}

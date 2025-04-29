<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Comentario;
use Illuminate\Http\Request;

/**
 * Class ComentarioController
 *
 * Controlador responsable de manejar la creación de comentarios
 * en las publicaciones de los usuarios.
 */
class ComentarioController extends Controller
{
    /**
     * Almacena un nuevo comentario en un post.
     *
     * @param  \Illuminate\Http\Request  $request  Datos de la petición HTTP
     * @param  User  $user  Usuario propietario de la publicación
     * @param  Post  $post  Publicación a la que se añade el comentario
     * @return \Illuminate\Http\RedirectResponse  Redirección de vuelta a la vista anterior con mensaje
     */
    public function store(Request $request, User $user, Post $post)
    {
        // Validar que el campo 'comentario' esté presente y no exceda 255 caracteres
        $request->validate([
            'comentario' => 'required|max:255',
        ]);

        // Crear el comentario asociado al usuario autenticado y al post especificado
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        // Redirigir de vuelta con un mensaje de éxito
        return back()->with('mensaje', 'Comentario relizado correctamente');
    }
}

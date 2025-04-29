<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

/**
 * Class LikeController
 *
 * Controlador encargado de manejar la funcionalidad de "me gusta" en publicaciones,
 * permitiendo agregar y eliminar likes.
 */
class LikeController extends Controller
{
    /**
     * Agrega un "like" de parte del usuario autenticado a la publicación indicada.
     *
     * @param  Request  $request  Instancia de la petición HTTP que contiene información del usuario
     * @param  Post     $post     Publicación a la que se le agrega el like
     * @return \Illuminate\Http\RedirectResponse  Redirige de vuelta a la vista anterior
     */
    public function store(Request $request, Post $post)
    {
        // Crear relación de like entre el usuario y la publicación
        $post->likes()->create([
            'user_id' => $request->user()->id
        ]);

        // Redirigir de vuelta a la página previa
        return back();
    }

    /**
     * Elimina el "like" que el usuario autenticado había dado a la publicación.
     *
     * @param  Request  $request  Instancia de la petición HTTP que contiene información del usuario
     * @param  Post     $post     Publicación de la que se elimina el like
     * @return \Illuminate\Http\RedirectResponse  Redirige de vuelta a la vista anterior
     */
    public function destroy(Request $request, Post $post)
    {
        // Buscar y eliminar el registro de like para el usuario y la publicación especificada
        $request->user()->likes()
                ->where('post_id', $post->id)
                ->delete();

        // Redirigir de vuelta a la página previa
        return back();
    }
}

<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

/**
 * Class PostPolicy
 *
 * Policy para controlar las acciones permitidas sobre el modelo Post.
 *
 * @package App\Policies
 */
class PostPolicy
{

    /**
     * Determina si un usuario puede eliminar una publicación.
     *
     * @param  User  $user  Usuario autenticado intentando realizar la acción
     * @param  Post  $post  Publicación a evaluar
     * @return bool          True si el usuario es propietario del post, false en caso contrario
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

 
}

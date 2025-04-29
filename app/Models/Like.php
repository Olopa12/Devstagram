<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Like
 *
 * Representa el registro de un "me gusta" dado por un usuario a una publicación.
 *
 * @package App\Models
 *
 * @property int $id           Identificador único del like
 * @property int $user_id      ID del usuario que dio el like
 * @property int $post_id      ID de la publicación a la que se dio el like
 * @property \Illuminate\Support\Carbon|null $created_at  Fecha de creación
 * @property \Illuminate\Support\Carbon|null $updated_at  Fecha de última actualización
 */
class Like extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden asignarse de manera masiva.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
    ];
}

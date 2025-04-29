<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Comentario
 *
 * Representa un comentario dejado por un usuario en una publicación.
 *
 * @package App\Models
 *
 * @property int    $id          Identificador único del comentario
 * @property int    $user_id     ID del usuario que crea el comentario
 * @property int    $post_id     ID de la publicación comentada
 * @property string $comentario  Texto del comentario
 * @property \Illuminate\Support\Carbon|null $created_at  Fecha de creación
 * @property \Illuminate\Support\Carbon|null $updated_at  Fecha de última actualización
 */
class Comentario extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden asignarse de manera masiva.
     *
     * @var array<string>
     */
    protected $fillable = [
        'user_id',
        'post_id',
        'comentario'
    ];

    /**
     * Obtiene el usuario que creó el comentario.
     *
     * Relación inversa de uno a muchos con User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

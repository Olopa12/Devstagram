<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Post
 *
 * Representa una publicación creada por un usuario en la plataforma.
 *
 * @package App\Models
 *
 * @property int    $id          Identificador único de la publicación
 * @property string $titulo      Título de la publicación
 * @property string $descripcion Descripción o contenido de la publicación
 * @property string $imagen      Nombre del archivo de imagen asociado
 * @property int    $user_id     ID del usuario que creó la publicación
 * @property \Illuminate\Support\Carbon|null $created_at  Fecha de creación
 * @property \Illuminate\Support\Carbon|null $updated_at  Fecha de última actualización
 */
class Post extends Model
{
    use HasFactory;

    /**
     * Atributos que pueden asignarse masivamente.
     *
     * @var array<string>
     */
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    /**
     * Relación: Post pertenece a un Usuario.
     *
     * Selecciona solo los campos name y username del usuario.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        // Obtiene el usuario propietario de la publicación
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    /**
     * Relación: Post tiene muchos Comentarios.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comentarios()
    {
        // Devuelve todos los comentarios asociados a este post
        return $this->hasMany(Comentario::class);
    }

    /**
     * Relación: Post tiene muchos Likes.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        // Devuelve todos los likes asociados a este post
        return $this->hasMany(Like::class);
    }

    /**
     * Verifica si un usuario específico ya le dio "like" a este post.
     *
     * @param  User  $user  Usuario a verificar
     * @return bool         True si el usuario ya dio like, false en caso contrario
     */
    public function checkLike(User $user)
    {
        // Recorre la colección de likes cargados y busca coincidencia
        return $this->likes->contains('user_id', $user->id);
    }
}

